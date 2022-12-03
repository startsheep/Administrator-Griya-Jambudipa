<template>
    <div class="collapse" id="formDeposit">
        <div class="row d-flex justify-content-center">
            <div class="card" style="width: 80%">
                <!-- <LoadingComponent v-if="isLoading" /> -->
                <div class="card-header">
                    <h4>Formulir Pembayaran {{ idEmployee }}</h4>
                </div>
                <div class="card-body">
                    <div v-if="payment" class="row">
                        <div class="col-lg-4">
                            <div class="custom-box">
                                <strong>Nama: </strong>
                                <span>{{ payment.customer.name }}</span>
                            </div>
                            <div class="custom-box">
                                <strong>Telepon: </strong>
                                <span>{{ payment.customer.phone }}</span>
                            </div>

                            <div class="custom-box">
                                <strong>Blok / Kavling: </strong>
                                <span
                                    >{{ payment.block.block }} -
                                    {{ payment.block.numberKavling }}</span
                                >
                            </div>
                            <div class="custom-box">
                                <strong>Tipe Rumah: </strong>
                                <span>{{
                                    payment.block.houseType.houseType
                                }}</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex">
                                <div class="custom-box mr-4">
                                    <strong>Total Pembayaran: </strong>
                                    <span>{{
                                        formatRupiah(
                                            payment.block.houseType.price
                                        )
                                    }}</span>
                                </div>
                                <div class="custom-box">
                                    <strong>Sisa Pembayaran: </strong>
                                    <span>{{
                                        formatRupiah(payment.reminderPayment)
                                    }}</span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>Uang Masuk</label>
                                    <InputCurrency
                                        v-model="budget"
                                        :value="budget"
                                    />
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Jenis Pembayaran</label>
                                    <select
                                        class="form-control"
                                        v-model="payment.type"
                                    >
                                        <option value="Cash Keras">
                                            Cash Keras
                                        </option>
                                        <option value="Cash Bertahap">
                                            Cash Bertahap
                                        </option>
                                        <option value="KPR">KPR</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <div class="custom-file form-group">
                                        <input
                                            @change="selectDocuments"
                                            type="file"
                                            class="custom-file-input"
                                            multiple
                                        />
                                        <label class="custom-file-label"
                                            >Pilih Dokumen</label
                                        >
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <div
                                        v-for="document in documents"
                                        :key="document"
                                        class="badge badge-primary m-1 p-2"
                                    >
                                        {{ document.name }}
                                        <i
                                            class="fas fa-times sortable"
                                            @click="removeDocument(document)"
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button
                        class="btn btn-primary btn-block"
                        @click="createPayment()"
                        :class="{ 'disabled btn-progress': isLoading }"
                    >
                        Simpan
                    </button>
                    <button
                        data-toggle="collapse"
                        data-target="#formDeposit"
                        class="btn btn-danger btn-block"
                        type="button"
                        @click="resetForm()"
                        :disabled="isLoading"
                    >
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.custom-box {
    margin-bottom: 5px;
}
</style>
<script>
import Utils from "../../store/services/utils";
import InputCurrency from "../../components/InputCurrency.vue";
import Cookie from "js-cookie";
import LoadingComponent from "../../components/LoadingComponent.vue";
import iziToast from "izitoast";
export default {
    props: ["id"],
    data() {
        return {
            payment: null,
            //   selectedKavling: '',
            budget: "",
            documents: [],
            idPayment : null,
            isLoading: false,
        };
    },


watch: {
    id: function (val) {
        this.idPayment = val;
    },
    idPayment: function (val) {
        if(val != null){
            this.getPayment(val);
        }
    },
    deep: true,

},
mounted() {
    this.idPayment = this.id;
    if(this.idPayment != null){
        this.getPayment(this.idPayment);
    }
},
    computed: {
        formData() {
            const formData = new FormData();
            formData.append("customer_id", this.payment.customer.id);
            //   formData.append("employee_id", this.payment.employeeId);
            formData.append("kavling_id", this.payment.block.id);
            formData.append("type", this.payment.type);

            if (this.budget) {
                formData.append("price", Utils.currencyToNumber(this.budget));
            }

            this.documents.forEach((document, index) => {
                formData.append("documents[" + index + "]", document);
            });
            return formData;
        },
    },
    methods: {
        removeDocument(doc) {
            this.documents.splice(this.documents.indexOf(doc), 1);
        },
        formatRupiah(num) {
            return Utils.formatRupiah(num, "Rp.");
        },
        checkIsDocument(file) {
            return Utils.checkIsDocument(file);
        },

        selectDocuments(e) {
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                if (this.checkIsDocument(files[i])) {
                    this.documents.push(files[i]);
                } else {
                    iziToast.warning({
                        title: "Peringatan",
                        message: "File harus berupa dokumen",
                        position: "topRight",
                    });
                }
            }
        },
        getPayment(id) {
            const self = this;
            self.$store.dispatch("showData", ["payment/" + id,[]]).then((res) => {
                this.payment = res.data;
            });
        },
        createPayment() {
            const self = this;
            let type = "postDataUploadPayment";
            this.isLoading = true;
            self.$store
                .dispatch(type, this.formData, "payment")
                .then((res) => {
                    this.$emit("onSuccess");
                    $("#formDeposit").collapse("hide");
                    this.isLoading = false;
                    this.resetForm();
                })
                .catch((err) => {
                    let messages = err.response.data.meta.message;
                    Object.entries(messages).forEach(([key, value]) => {
                        iziToast.warning({
                            title: "Peringatan",
                            message: value,
                            position: "topRight",
                        });
                    });
                    this.isLoading = false;
                });
        },
        resetForm() {
            console.log("reset");
            this.idPayment = null;
            // this.payment = null;
            this.budget = "";
            this.documents = [];
        },
    },
    components: { InputCurrency, LoadingComponent },
};
</script>
