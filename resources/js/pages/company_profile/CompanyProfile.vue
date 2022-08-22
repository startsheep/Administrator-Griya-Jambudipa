<template>
    <CircleLoader v-if="isLoading" />
    <div class="card">
        <div class="card-header d-flex justify-content-end">
            <button
                class="btn btn-success"
                data-toggle="modal"
                data-target="#editCompanyModal"
            >
                Ubah
            </button>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="hero-head">
                    <div class="logo">
                        <img
                            :src="
                                profile.logo
                                    ? 'storage/' + profile.logo
                                    : '/assets/images/logo.png'
                            "
                            alt=""
                            height="284"
                        />
                    </div>
                    <h2 class="text-center text-dark my-3 text-uppercase">
                        {{ profile.name }}
                    </h2>
                    <div class="link text-center">
                        <p>{{ profile.url }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="row justify-content-between font-weight-bold">
                        <div class="col-lg-4">Email</div>
                        <div class="col-lg-3">:</div>
                        <div class="col-lg-5">{{ profile.email }}</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row justify-content-between font-weight-bold">
                        <div class="col-lg-4">No Telp</div>
                        <div class="col-lg-3">:</div>
                        <div class="col-lg-5">{{ profile.phone }}</div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                {{ profile.address }}
            </div>
        </div>
        <div class="card-footer"></div>
    </div>

    <div
        class="modal fade"
        id="editCompanyModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="editCompanyModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompanyModalLabel">
                        Edit Data Perusahaan
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
                <form @submit.prevent="createProfile">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Perusahaan</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                v-model="form.name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="email">Email Perusahaan</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                v-model="form.email"
                            />
                        </div>
                        <div class="form-group">
                            <label for="phone">No Telp Perusahaan</label>
                            <input
                                type="text"
                                class="form-control"
                                id="phone"
                                v-model="form.phone"
                            />
                        </div>
                        <div class="form-group">
                            <label for="url">URL Perusahaan</label>
                            <input
                                type="text"
                                class="form-control"
                                id="url"
                                v-model="form.url"
                            />
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat Perusahaan</label>
                            <textarea
                                class="form-control"
                                id="address"
                                style="height: 75px"
                                v-model="form.address"
                            ></textarea>
                        </div>
                        <div class="form-group" v-if="previewLogo">
                            <img :src="previewLogo" style="width: 100%" />
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo Perusahaan</label>
                            <input
                                type="file"
                                class="form-control"
                                id="logo"
                                @change="uploadLogo"
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
import CircleLoader from "../../components/CircleLoader.vue";

export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                phone: "",
                url: "",
                address: "",
                logo: null,
            },
            previewLogo: null,
            profile: [],
            isLoading: false,
            isSubmit: false,
        };
    },
    mounted() {
        this.getProfile();
    },
    computed: {
        formData() {
            const fieldData = new FormData();
            fieldData.append("id", this.profile.id);
            fieldData.append("_method", "PUT");
            fieldData.append("name", this.form.name);
            fieldData.append("email", this.form.email);
            fieldData.append("phone", this.form.phone);
            fieldData.append("url", this.form.url);
            fieldData.append("address", this.form.address);
            fieldData.append("logo", this.form.logo);

            return fieldData;
        },
    },
    methods: {
        getProfile() {
            const self = this;
            self.isLoading = false;

            self.$store
                .dispatch("getData", ["company-profile"])
                .then((response) => {
                    self.profile = response.data;
                    self.isLoading = false;
                });
        },
        uploadLogo(e) {
            let files = e.target.files[0];
            this.previewLogo = URL.createObjectURL(files);
            this.form.logo = files;
        },
        createProfile() {
            const self = this;
            let fieldData = this.formData;
            let type = "updateDataUploadCompanyProfile";

            self.$store
                .dispatch(type, fieldData, [
                    "company-profile/" + self.profile.id,
                ])
                .then((result) => {
                    this.isSubmit = false;
                    this.$router.back();
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
        },
    },
    components: {
        CircleLoader,
    },
};
</script>

<style></style>
