<template>
    <div
        class="modal fade"
        id="formPassword"
        tabindex="-1"
        role="dialog"
        aria-labelledby="formPasswordLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formPasswordLabel">
                        Edit Sandi {{ name }}
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
                            <label for="password">Sandi</label>
                            <input
                                type="password"
                                class="form-control"
                                v-model="form.password"
                                id="password"
                            />
                        </div>
                        <div class="form-group">
                            <label for="confirm_password"
                                >Konfirmasi Sandi</label
                            >
                            <input
                                type="password"
                                class="form-control"
                                v-model="form.confirm_password"
                                id="confirm_password"
                            />
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
    props: ["id", "name"],
    data() {
        return {
            form: {
                password: "",
                confirm_password: "",
            },
        };
    },

    methods: {
        handleSubmit() {
            let url = [
                "user/change-password",
                this.id,
                {
                    password: this.form.password,
                    confirm_password: this.form.confirm_password,
                },
            ];

            this.$store
                .dispatch("updateData", url)
                .then((result) => {
                    this.deleteModal();
                    this.emptyForm();
                    this.$emit("onSuccess", result);
                    iziToast.success({
                        title: "Berhasil",
                        message: "Data berhasil diubah",
                        position: "topRight",
                    });
                })
                .catch((err) => {
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
        deleteModal() {
            $("#formPassword").modal("hide");
        },
        emptyForm() {
            this.form.password = "";
            this.form.confirm_password = "";
        },
    },
};
</script>

<style></style>
