<template>
    <section class="section profile">
        <div class="section-header">
            <h4>Ubah Password</h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form class="card" @submit.prevent="handleSubmit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="oldPassword">Password Lama</label>
                            <input
                                type="password"
                                id="oldPassword"
                                class="form-control"
                                v-model="form.oldPassword"
                            />
                        </div>
                        <div class="form-group">
                            <label for="newPassword">Password Baru</label>
                            <input
                                type="password"
                                id="newPassword"
                                class="form-control"
                                v-model="form.newPassword"
                            />
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword"
                                >Konfirmasi Password</label
                            >
                            <input
                                type="password"
                                id="confirmPassword"
                                class="form-control"
                                v-model="form.confirmPassword"
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
                oldPassword: "",
                newPassword: "",
                confirmPassword: "",
            },
            isSubmit: false,
        };
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            let user = JSON.parse(Cookies.get("user"));

            this.$store
                .dispatch("showData", ["user/show-email/" + user.email, []])
                .then((result) => {
                    this.user = result.data;
                });
        },
        handleSubmit() {
            this.isSubmit = true;
            this.$store
                .dispatch("updateData", [
                    "user/change-password",
                    this.user.id,
                    this.form,
                ])
                .then((result) => {
                    this.form.oldPassword = "";
                    this.form.newPassword = "";
                    this.form.confirmPassword = "";
                    this.isSubmit = false;
                    iziToast.success({
                        title: "Success",
                        message: "Data berhasil diubah",
                        position: "topRight",
                    });
                })
                .catch((err) => {
                    this.isSubmit = false;
                    let meta = err.response.data.meta;
                    if (meta) {
                        let messages = err.response.data.meta.message;
                        Object.entries(messages).forEach(([key, value]) => {
                            iziToast.warning({
                                title: "Warning",
                                message: value,
                                position: "topRight",
                            });
                        });
                    } else {
                        iziToast.warning({
                            title: "Warning",
                            message: err.response.data.message,
                            position: "topRight",
                        });
                    }
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
