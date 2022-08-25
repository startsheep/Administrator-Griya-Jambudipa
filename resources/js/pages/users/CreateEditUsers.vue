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
                        <div class="form-group" v-if="previewLogo">
                            <img :src="previewLogo" style="width: 100%" />
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input
                                type="file"
                                class="form-control"
                                id="image"
                                @change="uploadImage"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Kembali
                        </button>
                        <button type="submit" class="btn btn-primary">
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
    props: ["id"],
    data() {
        return {
            form: {
                image: null,
                name: "",
                email: "",
                phone: "",
            },
            previewLogo: null,
            isLoading: false,
        };
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

            return fieldData;
        },
    },
    methods: {
        uploadImage(e) {
            let files = e.target.files[0];
            this.previewLogo = URL.createObjectURL(files);
            this.form.image = files;
        },
        handleSubmit() {
            let fieldData = this.formData;
            let type = "postDataUploadUser";
            this.isLoading = true;

            this.$store
                .dispatch(type, fieldData, "user")
                .then((result) => {
                    this.isLoading = false;

                    this.deleteModal();

                    iziToast.success({
                        title: "Success",
                        message: "Data berhasil ditambah",
                        position: "topRight",
                    });

                    this.$emit("close", this);
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
        },
        deleteModal() {
            $("#formUserModal").modal("hide");
        },
    },
};
</script>

<style></style>
