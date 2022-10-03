<template>
    <section class="section">
        <div class="section-header">
            <h1>Tipe Rumah</h1>
        </div>
        <div class="row">
            <div class="col-12 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ isFormEdit ? "Edit" : "Tambah" }} Tipe Rumah</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Tipe</label>
                                <input
                                    ref="formHouse"
                                    v-model="house.type"
                                    type="text"
                                    class="form-control"
                                    placeholder="Tipe"
                                />
                            </div>

                            <div class="form-group">
                                <label>Harga</label>
                                <InputCurrency
                                    :value="house.price"
                                    v-model="house.price"
                                />
                            </div>
                            <div class="form-group">
                                <SummerNote
                                    ref="formHouse"
                                    v-model="house.description"
                                />
                                <!-- <textarea class="form-control" cols="80" rows="1"></textarea> -->
                            </div>
                            <div class="form-group custom-file">
                                <label class="custom-file-label">Gambar</label>
                                <input
                                    multiple
                                    type="file"
                                    @change="selectImages"
                                    class="form-control custom-file-input"
                                    placeholder="Image"
                                />
                            </div>
                        </form>

                        <div class="row d-flex justify-content-center">
                            <div
                                v-for="(image, index) in previewImages"
                                :key="image"
                                class="d-flex justify-content-end mr-1 mb-1"
                                style="width: 100px; height: 100px"
                            >
                                <span
                                    @click="removeItem(index)"
                                    class="badge badge-primary position-absolute cursor"
                                    >&times;</span
                                >
                                <img
                                    :src="image"
                                    alt=""
                                    class="img-thumbnail"
                                    style="
                                        object-fit: cover;
                                        width: 100px;
                                        height: 100px;
                                    "
                                />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button
                            :class="{ 'disabled btn-progress': isSubmit }"
                            @click="isFormEdit ? editHouse() : createHouse()"
                            class="btn btn-primary btn-block"
                        >
                            {{ isFormEdit ? "Simpan" : "Tambah" }}
                        </button>
                        <button
                            @click="reset()"
                            class="btn btn-danger btn-block"
                            :disabled="isSubmit"
                        >
                            Batal
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Rumah</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <ButtonsExport :printData="false" />
                            </div>
                            <div class="col-lg-4">
                                <input
                                    v-on:keyup="search"
                                    v-model="name"
                                    class="form-control"
                                    placeholder="Search"
                                />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Tipe</th>
                                        <!-- <th width="35%">Deskripsi</th> -->
                                        <th width="25%">Harga</th>
                                        <th width="10% " class="text-center">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="position-relative" v-auto-animate>
                                    <LoadingComponent v-if="isLoading" />
                                    <tr
                                        v-for="(house, index) in houses"
                                        :key="house.id"
                                    >
                                        <td class="text-center">
                                            <!-- calculate iteration then page number-->
                                            {{ iteration(index) }}
                                        </td>
                                        <td>
                                            <span> {{ house.houseType }}</span>
                                        </td>
                                        <!-- <td>
                      <div v-html="house.description"></div>
                    </td> -->
                                        <td>
                                            <span>
                                                {{
                                                    formatRupiah(house.price)
                                                }}</span
                                            >
                                        </td>
                                        <td class="align-middle text-center">
                                            <Actions
                                                @update="getHouse(house.id)"
                                                @delete="deleteHouse(house.id)"
                                                toggleDetail="modal"
                                                targetDetail="#detailTypeHouse"
                                                @detail="
                                                    detailTypeHouse(
                                                        houses[index]
                                                    )
                                                "
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <Pagination
                            :currentPage="pagination.currentPage"
                            :rowsTotal="pagination.total"
                            :lastPage="pagination.lastPage"
                            @onPageChange="onPageChange($event)"
                        />
                        <ModalCreate />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <DetailTypeHouse :detailHouse="detailHouse" />
</template>
<script>
import iziToast from "izitoast";
import LoadingComponent from "../../components/LoadingComponent.vue";
import Pagination from "../../components/Pagination.vue";
import ModalCreate from "./ModalCreate.vue";
import SummerNote from "../../components/SummerNote.vue";
import DetailImage from "../../components/DetailImage.vue";
import Utils from "../../store/services/utils";
import DetailTypeHouse from "./DetailTypeHouse.vue";
import ButtonsExport from "../../components/ButtonsExport.vue";
import InputCurrency from "../../components/InputCurrency.vue";
import Actions from "../../components/Actions.vue";

export default {
    data() {
        return {
            detailHouse: {},
            houses: [],
            house: {
                type: "",
                description: "",
                price: "",
                images: [],
            },
            isLoading: false,
            previewImages: [],
            detailImage: [],
            name: "",
            order_direction: "asc",
            isSubmit: false,
            isFormEdit: false,
            //Pagination
            pagination: {
                total: 0,
                perPage: 5,
                currentPage: 1,
                lastPage: 0,
                page: 0,
            },
        };
    },
    mounted() {
        this.getHouses();
    },
    computed: {
        formData() {
            const fieldData = new FormData();
            fieldData.append("house_type", this.house.type);
            fieldData.append("price", Utils.currencyToNumber(this.house.price));
            fieldData.append("description", this.house.description);
            if (this.house.images.length > 0) {
                this.house.images.forEach((image, index) => {
                    fieldData.append("images[" + index + "]", image);
                });
            }
            if (this.isFormEdit) {
                fieldData.append("id", this.house.id);
                fieldData.append("_method", "PUT");
            }

            // fieldData.append('image' , self.house.image)
            return fieldData;
        },
    },
    methods: {
        detailTypeHouse(data) {
            this.detailHouse = data;
        },
        reset() {
            this.house = {
                type: "",
                description: "",
                price: "",
                images: [],
            };
            this.previewImages = [];
            this.detailImage = [];
            this.isFormEdit = false;
        },
        getEditorValue(event) {
            this.house.description = event;
        },
        showDetail(img) {
            this.detailImage = img;
        },
        formatRupiah(value) {
            return Utils.formatRupiah(value, "Rp. ");
        },
        parseDescription(html) {
            return Utils.parseHtmlFromEditor(html);
        },
        removeItem(index) {
            if (this.isFormEdit) {
                this.house.images.splice(index, 1);
                this.previewImages.splice(index, 1);
            } else {
                this.previewImages.splice(index, 1);
            }
        },
        iteration(index) {
            return (
                (this.pagination.currentPage - 1) * this.pagination.perPage +
                index +
                1
            );
        },
        checkExtension(file) {
            const allowedExtensions = [
                "image/jpg",
                "image/png",
                "image/jpeg",
                "pdf",
            ];
            // const fileExtension = file.split(".").pop().toLowerCase();
            if (allowedExtensions.includes(file.type)) {
                return true;
            } else {
                return false;
            }
        },

        selectImages(e) {
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                if (this.checkExtension(files[i])) {
                    this.house.images.push(files[i]);
                    this.previewImages.push(URL.createObjectURL(files[i]));
                    console.log(this.previewImage);
                } else {
                    iziToast.warning({
                        title: "Peringatan",
                        message: "File harus berupa gambar",
                        position: "topRight",
                    });
                }
            }
        },
        updatePreviewImage(images) {
            this.previewImages = [];
            for (let i = 0; i < images.length; i++) {
                this.previewImages.push("/storage/" + images[i].documentPath);
            }
        },

        getHouse(id) {
            const self = this;
            this.isFormEdit = true;
            this.houses.filter(function (house) {
                if (house.id == id) {
                    // console.log(house.document.path)
                    self.house.type = house.houseType;
                    self.house.description = house.description;
                    self.house.price = house.price;
                    self.house.id = house.id;
                    self.house.images = house.document;
                    self.updatePreviewImage(house.document);
                    // this.house = house;
                }
            });
        },
        getHouses() {
            const self = this;
            this.isLoading = true;
            const params = [
                `name=${this.name}`,
                // `position=${this.name}`,
                `order_by=positions.id`,
                `order_direction=${this.order_direction}`,
                `page=${this.pagination.page}`,
                `per_page=${this.pagination.perPage}`,
            ].join("&");
            self.$store
                .dispatch("getData", ["house-type", params])
                .then((res) => {
                    self.houses = res.data;
                    self.pagination.total = res.meta.total;
                    self.pagination.currentPage = res.meta.currentPage;
                    self.pagination.lastPage = res.meta.lastPage;

                    this.isLoading = false;
                });
        },
        createHouse() {
            // console.log(this.$refs.formHouse)
            const self = this;
            let type = "postDataUploadHouse";
            const fieldData = self.formData;
            this.isSubmit = true;
            self.$store
                .dispatch(type, fieldData, "type-house")
                .then((response) => {
                    this.isSubmit = false;
                    iziToast.success({
                        title: "Berhasil",
                        message: "Data berhasil ditambahkan",
                        position: "topRight",
                    });
                    self.getHouses();
                    self.reset();
                })
                .catch((error) => {
                    this.isSubmit = false;
                    let messages = error.response.data.meta.message;
                    Object.entries(messages).forEach(([key, value]) => {
                        iziToast.warning({
                            title: "Peringatan",
                            message: value,
                            position: "topRight",
                        });
                    });
                });
        },
        editHouse(id) {
            this.isFormEdit = true;
            const self = this;
            let type = "updateDataUploadHouse";
            const fieldData = self.formData;
            this.isSubmit = true;
            self.$store
                .dispatch(type, fieldData, "type-house/" + id)
                .then((response) => {
                    this.isSubmit = false;
                    this.getHouses();
                    iziToast.success({
                        title: "Berhasil",
                        message: "Data berhasil diubah",
                        position: "topRight",
                    });
                    self.reset();
                })
                .catch((error) => {
                    this.isSubmit = false;
                    let messages;
                    if (messages) {
                        messages = error.response.data.meta.message;
                        Object.entries(messages).forEach(([key, value]) => {
                            iziToast.warning({
                                title: "Peringatan",
                                message: value,
                                position: "topRight",
                            });
                        });
                        self.getHouses();
                    }

                    this.reset();
                });
        },

        deleteHouse(id) {
            const self = this;
            this.$swal
                .fire({
                    title: "Yakin ?",
                    text: "Data akan dihapus",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        self.isLoading = true;
                        self.$store
                            .dispatch("deleteData", ["house-type", id])
                            .then((response) => {
                                iziToast.success({
                                    title: "Berhasil",
                                    message: "Data berhasil dihapus",
                                    position: "topRight",
                                });
                                self.isLoading = false;
                                this.getHouses();
                            });
                    }
                });
        },
        onPageChange(page) {
            this.pagination.page = page;
            this.getHouses();
        },
    },

    components: {
        LoadingComponent,
        Pagination,
        ModalCreate,
        SummerNote,
        DetailImage,
        DetailTypeHouse,
        ButtonsExport,
        InputCurrency,
        Actions,
    },
};
</script>
