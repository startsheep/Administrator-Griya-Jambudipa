<template>
    <div
        class="modal fade"
        id="formUserModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="formUserModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formUserModalLabel">
                        {{ id ? "Edit Akun Pengguna" : "Tambah Akun Pengguna" }}
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="emptyForm()"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="handleSubmit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.name"
                                id="name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.email"
                                id="email"
                            />
                        </div>
                        <div class="form-group">
                            <label for="phone">No Telp</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.phone"
                                id="phone"
                            />
                        </div>
                        <div class="form-group" v-if="previewImage">
                            <img :src="previewImage" style="width: 100%" />
                        </div>
                        <div class="custom-file form-group">
                            <input
                                type="file"
                                class="custom-file-input"
                                id="image"
                                @change="uploadImage"
                            />
                            <label class="custom-file-label" for="customFile"
                                >Pilih gambar</label
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            @click="emptyForm()"
                        >
                            Kembali
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            :class="{ 'disabled btn-progress': isSubmit }"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import iziToast from "izitoast";

export default {
    props: {
        id: {
            type: String,
            default: "",
        },
        user: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            form: {
                image: null,
                name: "",
                email: "",
                phone: "",
            },
            previewImage: null,
            isLoading: false,
            isSubmit: false,
        };
    },
    watch: {
        user(user) {
            user.document.forEach((item) => {
                this.previewImage = "/storage/" + item.documentPath;
            });
            this.form.name = user.name;
            this.form.email = user.email;
            this.form.phone = user.phone;
        },
    },
    computed: {
        formData() {
            const fieldData = new FormData();
            fieldData.append("name", this.form.name);
            fieldData.append("email", this.form.email);
            fieldData.append("phone", this.form.phone);

            if (this.form.image) {
                fieldData.append("image", this.form.image);
            }

            if (this.user && this.id) {
                fieldData.append("_method", "PUT");
                fieldData.append("id", this.id);
            }

            return fieldData;
        },
    },
    methods: {
        uploadImage(e) {
            let files = e.target.files[0];
            this.previewImage = URL.createObjectURL(files);
            this.form.image = files;

            $(".custom-file-label").addClass("selected").html(files.name);
        },
        handleSubmit() {
            let fieldData = this.formData;
            this.isLoading = true;
            this.isSubmit = true;
            if (this.user && this.id) {
                this.$store
                    .dispatch("updateDataUploadUser", fieldData, [
                        "user/" + this.id,
                    ])
                    .then((result) => {
                        this.isLoading = false;
                        this.isSubmit = false;

                        this.deleteModal();
                        this.emptyForm();
                        this.$emit("onSuccess", result);
                        iziToast.success({
                            title: "Success",
                            message: "Data berhasil diubah",
                            position: "topRight",
                        });
                    })
                    .catch((err) => {
                        this.isSubmit = false;
                        let meta = err.response.data.meta;
                        let messages = err.response.data.meta.message;
                        Object.entries(messages).forEach(([key, value]) => {
                            iziToast.warning({
                                title: "Warning",
                                message: value,
                                position: "topRight",
                            });
                        });
                    });
            } else {
                this.$store
                    .dispatch("postDataUploadUser", fieldData, "user")
                    .then((result) => {
                        this.isLoading = false;
                        this.isSubmit = false;

                        this.deleteModal();
                        this.emptyForm();

                        iziToast.success({
                            title: "Success",
                            message: "Data berhasil ditambah",
                            position: "topRight",
                        });

                        this.$emit("onSuccess", this);
                    })
                    .catch((err) => {
                        this.isSubmit = false;
                        let meta = err.response.data.meta;
                        let messages = err.response.data.meta.message;
                        Object.entries(messages).forEach(([key, value]) => {
                            iziToast.warning({
                                title: "Warning",
                                message: value,
                                position: "topRight",
                            });
                        });
                    });
            }
        },
        deleteModal() {
            $("#formUserModal").modal("hide");
        },
        emptyForm() {
            this.form.name = "";
            this.form.email = "";
            this.form.phone = "";
            this.form.image = null;
            this.previewImage = null;
            $(".custom-file-label").addClass("selected").html("Pilih gambar");
        },
    },
};
</script>

<style></style>
