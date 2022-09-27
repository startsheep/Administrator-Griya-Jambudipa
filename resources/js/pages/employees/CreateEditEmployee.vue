<template>
    <section class="section">
        <div class="section-header">
            <h1>{{ id ? "Simpan" : "Tambah" }} Data Pegawai</h1>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="card" style="width: 80%">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <form class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="name">Nama Lengkap</label>
                                <input
                                    v-model="employee.name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Nama Lengkap"
                                />
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Jenis Pegawai</label>
                                <select
                                    v-model="employee.type_emp"
                                    class="form-control form-control"
                                >
                                    <option value="1">Pegawai Tetap</option>
                                    <option value="0">
                                        Pegawai Tidak Tetap
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Jabatan</label>
                                <select
                                    v-model="employee.position_id"
                                    class="form-control form-control"
                                >
                                    <option
                                        v-for="position in positions"
                                        :key="position.id"
                                        :value="position.id"
                                    >
                                        {{ position.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Email</label>
                                <input
                                    v-model="employee.email"
                                    type="text"
                                    class="form-control"
                                    placeholder="Email"
                                />
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Nomor Telepon</label>
                                <input
                                    v-model="employee.phone"
                                    type="number"
                                    class="form-control"
                                    placeholder="Nomor Telepon"
                                />
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Jenis Kelamin</label>
                                <select
                                    v-model="employee.gender"
                                    class="form-control form-control"
                                >
                                    <option value="L">Laki-Laki</option>

                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Alamat</label>
                                <textarea
                                    v-model="employee.address"
                                    class="form-control"
                                    rows="1"
                                    style="height: 100px"
                                ></textarea>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Tanggal Masuk</label>
                                <input
                                    v-model="employee.entry_date"
                                    type="date"
                                    class="form-control"
                                />
                            </div>

                            <div class="custom-file form-group col-lg-6">
                                <input
                                    @change="selectImage"
                                    type="file"
                                    class="custom-file-input"
                                />
                                <label
                                    class="custom-file-label"
                                    for="customFile"
                                    >Pilih Foto</label
                                >
                            </div>
                            <div class="custom-file form-group col-lg-6">
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
                        </form>
                        <div class="row">
                            <div class="col-lg-6">
                                <h6>Foto :</h6>
                                <PreviewImage :previewImage="previewImage" />
                            </div>
                            <div class="col-lg-6">
                                <div
                                    v-for="document in employee.document"
                                    :key="document"
                                    class="badge badge-primary m-1 p-2"
                                >
                                    {{ document.name }}
                                    <i
                                        class="fas fa-times sortable"
                                        @click="removeDocument(document)"
                                    ></i>
                                </div>
                                <div
                                    v-for="document in employee.oldDocument"
                                    :key="document"
                                    class="badge badge-primary m-1 p-2"
                                >
                                    {{ document.documentName }}
                                    <i
                                        class="fas fa-times sortable"
                                        @click="removeOldDocument(document)"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button
                            :class="{ 'disabled btn-progress': isSubmit }"
                            @click="id ? updateEmployee() : createEmployee()"
                            class="btn btn-primary btn-block"
                            type="button"
                        >
                            {{ id ? "Simpan" : "Tambah" }}
                        </button>
                        <button
                            @click="back"
                            class="btn btn-danger btn-block"
                            type="button"
                            :disabled="isSubmit ?? false"
                        >
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import iziToast from "izitoast";
import moment from "moment";
import PreviewImage from "../../components/PreviewImage.vue";

export default {
    props: ["id"],
    data() {
        return {
            idEmp: "",
            employee: {
                name: "",
                email: "",
                position_id: "",
                type_emp: "",
                entry_date: "",
                phone: "",
                address: "",
                gender: "",
                image: "",
                document: [],
                oldDocument: []
            },
            defaultImage:
                "../../../../public/assets/images/avatar/avatar-1.png",
            previewImage: "",
            positions: [],
            isSubmit: false,
            isLoading: false,
        };
    },
    mounted: function () {
        this.getPositions();
        if (this.id) {
            this.showEmployee();
        }
    },
    computed: {
        formData() {
            const fieldData = new FormData();
            if (this.id) {
                fieldData.append("id", this.id);
                fieldData.append("_method", "PUT");
            }
            fieldData.append("name", this.employee.name);
            fieldData.append("email", this.employee.email);
            fieldData.append("position_id", this.employee.position_id);
            fieldData.append("type_emp", this.employee.type_emp);
            fieldData.append("entry_date", this.employee.entry_date);
            fieldData.append("phone", this.employee.phone);
            fieldData.append("address", this.employee.address);
            fieldData.append("gender", this.employee.gender);
            //   fieldData.append("documents", this.employee.document);
            this.employee.document.forEach((document, index) =>
                fieldData.append("documents[" + index + "]", document)
            );
            if (this.employee.image) {
                fieldData.append("image", this.employee.image);
            }
            return fieldData;
        },
    },
    methods: {
        back() {
            this.$router.back();
        },
        removeDocument(document) {
            this.employee.document.splice(
                this.employee.document.indexOf(document),
                1
            );
        },
        removeOldDocument(document) {
            this.employee.oldDocument.splice(
                this.employee.oldDocument.indexOf(document),
                1
            );
        },
        checkExtension(file) {
            const allowedExtensions = ["image/jpg", "image/png", "image/jpeg"];
            const extension = file.type;
            if (allowedExtensions.includes(extension)) {
                return true;
            } else {
                return false;
            }
        },
        checkIsDocument(file) {
            const allowedExtensions = [
                "image/jpg",
                "image/png",
                "image/jpeg",
                "application/pdf",
                "application/msword",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            ];
            const extension = file.type;
            if (allowedExtensions.includes(extension)) {
                return true;
            } else {
                return false;
            }
        },
        selectDocuments(e) {
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                if (this.checkIsDocument(files[i])) {
                    this.employee.document.push(files[i]);
                } else {
                    iziToast.warning({
                        title: "Peringatan",
                        message: "File harus berupa dokumen",
                        position: "topRight",
                    });
                }
            }
        },
        selectImage(e) {
            const file = e.target.files[0];
            if (this.checkExtension(file)) {
                this.employee.image = file;
                this.previewImage = URL.createObjectURL(file);
            } else {
                iziToast.warning({
                    title: "Peringatan",
                    message: "File harus berformat jpg, png, jpeg",
                    position: "topRight",
                });
            }
        },
        getPositions() {
            const self = this;
            self.$store.dispatch("getData", ["position"]).then((response) => {
                self.positions = response.data;
            });
        },
        createEmployee() {
            const self = this;
            this.isSubmit = true;
            this.isLoading = true;
            let type = "postDataUploadEmployee";
            let fieldData = this.formData;
            self.$store
                .dispatch(type, fieldData, "employee")
                .then((res) => {
                    this.isSubmit = false;
                    this.isLoading = false;
                    this.$router.back();
                    iziToast.success({
                        title: "Berhasil",
                        message: "Data berhasil ditambahkan",
                        position: "topRight",
                    });
                })
                .catch((err) => {
                    this.isSubmit = false;
                    this.isLoading = false;
                    let meta = err.response.data.meta;
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
        showEmployee() {
            const self = this;
            self.$store
                .dispatch("getData", ["/employee/" + self.id])
                .then((response) => {
                    this.previewImage = "/storage/" + response.data.image;
                    self.employee.name = response.data.name;
                    self.employee.email = response.data.email;
                    self.employee.position_id = response.data.positionId;
                    self.employee.type_emp = response.data.status;
                    self.employee.entry_date = moment(response.data.entryDate).format(
                        "YYYY-MM-DD"
                    );
                    self.employee.phone = response.data.phone;
                    self.employee.address = response.data.address;
                    self.employee.gender = response.data.gender;
                    response.data.document.forEach((document) => {
                        self.employee.oldDocument.push(document);
                    });
                });
        },
        updateEmployee() {
            const self = this;
            this.isSubmit = true;
            this.isLoading = true;
            let type = "updateDataUploadEmployee";
            const fieldData = this.formData;
            self.$store
                .dispatch(type, fieldData, ["employee/" + self.id])
                .then((res) => {
                    this.isSubmit = false;
                    this.isLoading = false;
                    this.$router.back();
                    iziToast.success({
                        title: "Berhasil",
                        message: "Data berhasil diubah",
                        position: "topRight",
                    });
                })
                .catch((err) => {
                    this.isSubmit = false;
                    this.isLoading = false;
                    let meta = err.response.data.meta;
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
    components: { PreviewImage },
};
</script>
