<template>
    <section class="section">
        <div class="section-header"></div>
        <div class="card">
            <LoadingComponent v-if="isLoading" />
            <div class="card-profil-header"></div>
            <div class="card-header d-flex justify-content-end">
                <button
                    class="btn btn-success"
                    data-toggle="modal"
                    data-target="#editCompanyModal"
                    @click="getProfile"
                >
                    Ubah
                </button>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="hero-head">
                        <div class="logo">
                            <img
                                data-toggle="modal"
                                data-target="#detailImage"
                                :src="
                                    profile.logo
                                        ? 'storage/' + profile.logo
                                        : '/assets/images/logo.png'
                                "
                                alt=""
                                style="width: 100%"
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
                <table
                    class="table d-flex justify-content-around flex-column flex-sm-row"
                    style="width: 100%"
                >
                    <tr>
                        <th>Email</th>
                        <th>:</th>
                        <th>{{ profile.email }}</th>
                    </tr>
                    <tr>
                        <th>No Telp</th>
                        <th>:</th>
                        <th>{{ profile.phone }}</th>
                    </tr>
                </table>
                <div class="text-center mt-5">
                    {{ profile.address }}
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </section>
    <LightBox
        :image="
            profile.logo ? 'storage/' + profile.logo : '/assets/images/logo.png'
        "
    >
    </LightBox>
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
                            :class="{ disabled: isSubmit }"
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
import Logic from "../../store/modules/company_profile/logic";

export default Logic;
</script>

<style>
/* .modal-backdrop {
    position: fixed;
    height: 100vh;
    width: 100vw;
    top: 0;
    left: 0;
    z-index: 999;
    background-color: black;
}

.modal-backdrop.fade {
    opacity: 0;
    display: none;
}

.modal-backdrop.show {
    opacity: 0.5;
    display: none;
} */

/* .main-wrapper-1 .card .card-profil-header {
    margin-left: -30px;
    margin-right: -30px;
    margin-top: -10px;
    border-radius: 0;
    border-top: 1px solid #f9f9f9;
    padding-left: 35px;
    padding-right: 35px;
} */

/* .card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    margin-top: 10px;
} */
</style>
