<template>
    <section class="section profile">
        <div class="section-header">
            <h4>Profil</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Gambar</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="form-group" v-if="previewImage">
                            <img
                                :src="previewImage"
                                class="rounded-circle profile-widget-picture"
                                width="200"
                                height="200"
                            />
                        </div>
                        <div v-else>
                            <img
                                :src="'/storage/' + user.image?.documentPath"
                                :alt="user.name"
                                onerror="this.onerror = null; this.src
                        = '/assets/images/avatar/avatar-2.png';"
                                class="rounded-circle profile-widget-picture"
                                width="200"
                                height="200"
                            />
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="custom-file form-group">
                            <input
                                type="file"
                                class="custom-file-input"
                                id="image"
                                :disabled="isSubmit"
                                @change="uploadImage"
                                :class="{ 'disabled file-progress': isSubmit }"
                            />
                            <label class="custom-file-label" for="customFile"
                                >Pilih gambar</label
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <form class="card" @submit.prevent="handleSubmit">
                    <div class="card-header">
                        <h4 class="card-title">Edit Profil</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="text"
                                id="email"
                                disabled
                                class="form-control"
                                v-model="user.email"
                            />
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input
                                type="text"
                                id="name"
                                class="form-control"
                                v-model="form.name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="phone">No Telepon</label>
                            <input
                                type="text"
                                id="phone"
                                class="form-control"
                                v-model="form.phone"
                            />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button
                            class="btn btn-primary"
                            style="width: 100%"
                            :class="{ 'disabled btn-progress': isSubmit }"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
import Cookies from "js-cookie";
import iziToast from "izitoast";

export default {
    data() {
        return {
            user: {},
            form: {
                name: "",
                phone: "",
            },
            isSubmit: false,
            previewImage: null,
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        uploadImage(e) {
            let files = e.target.files[0];
            const fieldData = new FormData();
            this.previewImage = URL.createObjectURL(files);
            this.form.image = files;

            fieldData.append("_method", "PUT");
            fieldData.append("image", this.form.image);
            fieldData.append("id", this.user.id);

            this.isSubmit = true;
            this.$store
                .dispatch("updateDataUploadUser", fieldData, [
                    "user/" + this.user.id,
                ])
                .then((result) => {
                    this.isSubmit = false;
                    location.reload();
                    iziToast.success({
                        title: "Berhasil",
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
                            title: "Peringatan",
                            message: value,
                            position: "topRight",
                        });
                    });
                });
        },
        getData() {
            let user = JSON.parse(Cookies.get("user"));

            this.$store
                .dispatch("showData", ["user/show-email/" + user.email, []])
                .then((result) => {
                    this.user = result.data;
                    this.form.name = result.data.name;
                    this.form.phone = result.data.phone;
                });
        },
        handleSubmit() {
            this.isSubmit = true;
            this.$store
                .dispatch("updateData", ["user", this.user.id, this.form])
                .then((result) => {
                    this.isSubmit = false;
                    location.reload();
                    iziToast.success({
                        title: "Berhasil",
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

<style>
.profile .disabled {
    background-color: #141d3e !important;
    opacity: 0.7;
}

.file-progress {
    position: relative;
    background-image: url(data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJsb2FkZXItMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQogd2lkdGg9IjQwcHgiIGhlaWdodD0iNDBweCIgdmlld0JveD0iMCAwIDUwIDUwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MCA1MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggZmlsbD0iI2ZmZiIgZD0iTTQzLjkzNSwyNS4xNDVjMC0xMC4zMTgtOC4zNjQtMTguNjgzLTE4LjY4My0xOC42ODNjLTEwLjMxOCwwLTE4LjY4Myw4LjM2NS0xOC42ODMsMTguNjgzaDQuMDY4YzAtOC4wNzEsNi41NDMtMTQuNjE1LDE0LjYxNS0xNC42MTVjOC4wNzIsMCwxNC42MTUsNi41NDMsMTQuNjE1LDE0LjYxNUg0My45MzV6Ij4NCjxhbmltYXRlVHJhbnNmb3JtIGF0dHJpYnV0ZVR5cGU9InhtbCINCiAgYXR0cmlidXRlTmFtZT0idHJhbnNmb3JtIg0KICB0eXBlPSJyb3RhdGUiDQogIGZyb209IjAgMjUgMjUiDQogIHRvPSIzNjAgMjUgMjUiDQogIGR1cj0iMC42cyINCiAgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiLz4NCjwvcGF0aD4NCjwvc3ZnPg0K);
    background-position: center;
    background-repeat: no-repeat;
    background-size: 30px;
    color: transparent !important;
    pointer-events: none;
}
</style>
