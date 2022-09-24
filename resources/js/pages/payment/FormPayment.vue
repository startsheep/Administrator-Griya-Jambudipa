<template>
    <div class="collapse" id="formCreate">
        <div class="row d-flex justify-content-center">
            <div class="card" style="width: 80%">
                <div class="card-header">
                    <h4>Formulir Pembayaran</h4>
                </div>
                <!-- <LoadingComponent v-if="isLoading" /> -->
                <div class="card-body">
                    <div
                        class="alert alert-primary alert-dismissible show fade mb-4"
                    >
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>×</span>
                            </button>
                            <b>Info!</b> Form ini merupakan untuk Penyetoran /
                            Pembayaran Customer
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="row">
                            <div
                                class="col"
                                :class="{ 'col-12': !selectedCustomer }"
                            >
                                <div class="form-group">
                                    <label>Nama</label>
                                    <select
                                        @change="selectCustomer(this)"
                                        ref="fieldCustomer"
                                        class="form-control"
                                        v-model="payment.customerId"
                                    >
                                        <option
                                            :key="customer.id"
                                            v-for="customer in customers"
                                            :value="customer.id"
                                        >
                                            {{ customer.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div v-if="selectedCustomer" class="form-group">
                                    <label>Blok / Kavling </label>
                                    <select
                                        class="form-control"
                                        @change="getHouse"
                                        v-model="selectedKavling"
                                    >
                                        <option
                                            v-for="kavling in customerKavling"
                                            :value="kavling.kavling"
                                            :key="kavling"
                                        >
                                            {{ kavling.kavling.block }} -
                                            {{ kavling.kavling.numberKavling }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-if="house">
                            <div class="col">
                                <!-- <div class="form-group">
                            <label>Referral</label>
                            <select class="form-control" v-model="payment.type">
                                <option value="Cash Keras">G0323J-Ahmad</option>
                                <option value="Cash Keras">G0323J-Ahmad</option>
                                <option value="Cash Keras">G0323J-Ahmad</option>
                            </select>
                          </div> -->
                            </div>
                            <div class="col m-auto">
                                <div
                                    class="box d-flex justify-content-start mb-2"
                                >
                                    <div class="mr-5">
                                        <span> Tipe Rumah : </span>
                                        <Span>
                                            {{ house.houseType }}
                                        </Span>
                                    </div>
                                    <div>
                                        <span> Harga : </span>
                                        <Span>
                                            {{ formatRupiah(house.price) }}
                                        </Span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Jenis Pembayaram</label>
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
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Uang Masuk</label>
                                    <InputCurrency
                                        :value="payment.price"
                                        v-model="payment.price"
                                    />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="custom-file form-group">
                                    <input
                                        @change="selectDocuments"
                                        type="file"
                                        class="custom-file-input"
                                        multiple
                                    />
                                    <label
                                        class="custom-file-label"
                                        for="customFile"
                                        >Pilih Dokumen</label
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <span class="d-block">Dokumen</span>
                                <div
                                    v-for="document in payment.documents"
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
                <div class="card-body">
                    <button
                        class="btn btn-primary btn-block"
                        @click="createPayment()"
                        :class="{ 'disabled btn-progress': isSubmit }"
                    >
                        Simpan
                    </button>
                    <button
                        data-toggle="collapse"
                        data-target="#formCreate"
                        class="btn btn-danger btn-block"
                        @click="resetForm"
                        :disabled="isSubmit"
                    >
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Cookie from "js-cookie";
import InputCurrency from "../../components/InputCurrency.vue";
import Utils from "../../store/services/utils";
import iziToast from "izitoast";
import LoadingComponent from "../../components/LoadingComponent.vue";

export default {
    data() {
        return {
            payment: {
                id: "",
                customerId: "",
                employeeId: "",
                type: "",
                price: "",
                documents: [],
            },
            customers: [],
            previewImages: [],
            customerKavling: [],
            house: null,
            selectedCustomer: null,
            selectedKavling: null,
            house: null,
            isLoading: false,
            isSubmit: false,
        };
    },
    watch: {
        // watch selected kavling for change
    },
    computed: {
        submit() {
            this.$emit("onSubmit", [this.payment, this.selectedKavling]);
        },
        idEmployee() {
            return Cookie.get("id");
        },
        formData() {
            const formData = new FormData();
            formData.append("customer_id", this.payment.customerId);
            formData.append("employee_id", this.payment.employeeId);
            if (this.selectedKavling) {
                formData.append("kavling_id", this.selectedKavling.id);
            }

            formData.append("type", this.payment.type);
            formData.append(
                "price",
                Utils.currencyToNumber(this.payment.price)
            );
            this.payment.documents.forEach((document, index) => {
                formData.append("documents[" + index + "]", document);
            });
            return formData;
        },
    },
    mounted() {
        this.getCustomers();
    },

    methods: {
        removeDocument(dov) {
            this.payment.documents = this.payment.documents.filter(
                (document) => document !== dov
            );
        },
        formatRupiah(value) {
            return Utils.formatRupiah(value, "Rp. ");
        },
        checkIsDocument(file) {
            return Utils.checkIsDocument(file);
        },

        selectDocuments(e) {
            const files = e.target.files;

            for (let i = 0; i < files.length; i++) {
                if (this.checkIsDocument(files[i])) {
                    this.payment.documents.push(files[i]);
                } else {
                    iziToast.warning({
                        title: "Peringatan",
                        message: "File harus berupa dokumen",
                        position: "topRight",
                    });
                }
            }
        },

        createPayment() {
            const self = this;
            let type = "postDataUploadPayment";
            this.isLoading = true;
            this.isSubmit = true;
            self.$store
                .dispatch(type, this.formData, "payment")
                .then((res) => {
                    this.$emit("onSuccess");
                    $("#formCreate").collapse("hide");
                    this.resetForm();
                    this.isLoading = false;
                    this.isSubmit = false;
                })
                .catch((err) => {
                    let messages = err.response.data.meta.message;
                    Object.entries(messages).forEach(([key, value]) => {
                        iziToast.warning({
                            title: "Peringatan",
                            message: value,
                            position: "topRight",
                        });
                        this.isLoading = false;
                        this.isSubmit = false;
                    });
                });
        },
        selectCustomer() {
            this.customers.filter((cs) => {
                if (cs.id == this.$refs["fieldCustomer"].value) {
                    this.selectedCustomer = cs;
                }
            });
            this.getKavling(this.selectedCustomer.id);
        },
        showNameCustomer(id) {
            let name = "";
            this.customers.forEach((customer) => {
                if (customer.id == id) {
                    name = customer.name;
                }
            });
            return name;
        },

        getHouse() {
            this.$store
                .dispatch("getData", [
                    "house-type/" + this.selectedKavling.houseTypeId,
                ])
                .then((res) => {
                    this.house = res.data;
                });
        },
        getCustomers() {
            const self = this;
            self.$store.dispatch("getData", ["customer"]).then((res) => {
                self.customers = res.data;
            });
        },
        getKavling(id) {
            const self = this;
            self.$store
                .dispatch("getData", ["kavling/check/" + id])
                .then((res) => {
                    this.customerKavling = res.data;
                });
        },
        resetForm() {
            this.payment = {
                id: "",
                customerId: "",
                employeeId: "",
                type: "",
                price: "",
                documents: [],
            };
            this.selectedCustomer = null;
            this.selectedKavling = null;
            this.house = null;
        },
    },
    components: { InputCurrency, LoadingComponent },
};
</script>
<style></style>
