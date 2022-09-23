<template>
    <div
        class="modal fade"
        id="ModalKavling"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ kav != null ? "Edit" : "Tambah" }} Kavling
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div
                        class="alert alert-primary alert-dismissible show fade"
                    >
                        <div class="alert-body">

                            Satuan Panjang dan Lebar yang digunakan adalah
                            <Strong>Meter</Strong>
                        </div>
                    </div>
                    <form class="form-row">
                        <div class="form-group col-lg-6">
                            <label>Blok</label>
                            <!-- <input
                                v-model="kavling.block"
                                ref="formkavling"
                                type="text"
                                class="form-control"
                                placeholder="Blok Kavling"
                            /> -->
                            <select
                                class="form-control"
                                v-model="kavling.block"
                            >
                                <option selected disabled value="">
                                    Pilih Blok Kavling
                                </option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                                <option value="J">J</option>
                                <option value="K">K</option>
                                <option value="L">L</option>
                                <option value="M">M</option>
                                <option value="N">N</option>
                                <option value="O">O</option>
                                <option value="P">P</option>
                                <option value="Q">Q</option>
                                <option value="R">R</option>
                                <option value="S">S</option>
                                <option value="T">T</option>
                                <option value="U">U</option>
                                <option value="V">V</option>
                                <option value="W">W</option>
                                <option value="X">X</option>
                                <option value="Y">Y</option>
                                <option value="Z">Z</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Nomor Kavling</label>
                            <input
                                v-model="kavling.numberKavling"
                                ref="formkavling"
                                type="text"
                                class="form-control"
                                placeholder="Nomor Kavling"
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Lebar Muka Kavling (M)</label>
                            <input
                                v-model="kavling.widthKavling"
                                ref="formkavling"
                                type="text"
                                class="form-control"
                                placeholder="Lebar Muka Kavling"
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Panjang Kavling (M)</label>
                            <input
                                v-model="kavling.lengthKavling"
                                ref="formkavling"
                                type="text"
                                class="form-control"
                                placeholder="Panjang Kavling"
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Panjang Kavling 2 (M)</label>
                            <input
                                v-model="kavling.lengthKavling"
                                ref="formkavling"
                                type="text"
                                class="form-control"
                                placeholder="Panjang Kavling 2"
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Luas Kavling (M<sup>2</sup>)</label>
                            <input
                                v-model="kavling.areaKavling"
                                ref="formkavling"
                                type="text"
                                class="form-control"
                                placeholder="Luas Kavling"
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Luas Bangunan (M<sup>2</sup>)</label>
                            <input
                                v-model="kavling.areaBuilding"
                                ref="formkavling"
                                type="text"
                                class="form-control"
                                placeholder="Luas Bangunan"
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Tipe Rumah</label>
                            <select
                                class="form-control"
                                v-model="kavling.houseTypeId"
                            >
                                <option selected disabled value="">
                                    Pilih Tipe Rumah
                                </option>

                                <option
                                    :value="house.id"
                                    :key="house"
                                    v-for="house in houses"
                                >
                                    {{ house.houseType }}
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Batal
                    </button>
                    <button
                        @click="kav != null ? update() : create()"
                        :class="{ 'disabled btn-progress': isSubmit }"
                        type="button"
                        class="btn btn-primary"
                    >
                        {{ kav != null ? "Simpan" : "Tambah" }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import iziToast from "izitoast";

export default {
    props: {
        kav: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            houses: [],
            kavling: {
                id: "",
                block: "",
                houseType: "",
                numberKavling: "",
                widthKavling: "",
                lengthKavling: "",
                areaKavling: "",
                areaBuilding: "",
            },
            isSubmit: false,
        };
    },
    watch: {
        kav(newVal, oldVal) {
            if (newVal != null) {
                this.kavling = newVal;
            }
        },
    },
    computed: {
        successMessage() {
            return iziToast.success({
                title: "Berhasil",
                message:
                    "Kavling Berhasil Di " +
                    (this.kav != null ? "Edit" : "Tambah"),
                position: "topRight",
            });
        },
    },
    mounted() {
        this.getHouses();
        //   this.showKav()
    },

    methods: {
        hideModal() {
            $("#ModalKavling").hide("modal");
            $('div').removeClass('modal-backdrop');
        },
        reset() {
            this.kavling = {
                id: "",
                block: "",
                houseTypeId: "",
                numberKavling: "",
                widthKavling: "",
                lengthKavling: "",
                areaKavling: "",
                areaBuilding: "",
            };
        },
        showKav() {
            console.log(this.kav);
        },
        getHouses() {
            const self = this;
            self.$store.dispatch("getData", ["house-type"]).then((res) => {
                self.houses = res.data;
            });
        },
        update() {
            this.isSubmit = true;
            this.isLoading = true;
            const self = this;
            const url = [
                "kavling",
                this.kavling.id,
                {
                    block: this.kavling.block,
                    house_type_id: this.kavling.houseTypeId,
                    number_kavling: this.kavling.numberKavling,
                    width_kavling: this.kavling.widthKavling,
                    length_kavling: this.kavling.lengthKavling,
                    areaKavling: this.kavling.areaKavling,
                    areaBuilding: this.kavling.areaBuilding,
                },
            ];
            self.$store
                .dispatch("updateData", url)
                .then((res) => {
                    this.isSubmit = false;
                    this.$emit("onSuccess", res);
                    this.hideModal();
                    this.successMessage;
                })
                .catch((err) => {
                    this.isSubmit = false;
                    this.reset();
                    let messages = err.response.data.meta.message;
                    Object.entries(messages).forEach(([key, value]) => {
                        iziToast.warning({
                            title: "Peringatan",
                            message: value,
                            position: "topRight",
                        });
                    });
                });
        },
        create() {
            this.isSubmit = true;
            this.isLoading = true;
            const self = this;
            const url = [
                "kavling",
                {
                    block: this.kavling.block,
                    house_type_id: this.kavling.houseTypeId,
                    number_kavling: this.kavling.numberKavling,
                    width_kavling: this.kavling.widthKavling,
                    length_kavling: this.kavling.lengthKavling,
                    areaKavling: this.kavling.areaKavling,
                    areaBuilding: this.kavling.areaBuilding,
                },
            ];
            self.$store
                .dispatch("postData", url)
                .then((res) => {
                    this.isSubmit = false;
                    this.reset();
                    this.$emit("onSuccess", res);
                    this.hideModal();
                    this.successMessage;
                })
                .catch((err) => {
                    this.isSubmit = false;
                    let messages = err.response.data.meta.message;
                    Object.entries(messages).forEach(([key, value]) => {
                        iziToast.warning({
                            title: "Peringatan",
                            message: value,
                            position: "topRight",
                        });
                    });
                });
        },
    },
};
</script>
<style lang=""></style>
