<template>
    <div class="container-fluid bg-dark">
        <div
            class="row d-flex align-items-center justify-content-center"
            style="height: 100vh"
        >
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card position-relative">
                        <LoadingComponent v-if="isLoading"/>
                    <div class="card-body">
                        <img
                            src="../../../../public/assets/images/logo.png"
                            class="img-fluid rounded mx-auto d-block"
                            style="width: 60%"
                            onerror="this.null; this.src='/assets/images/logo.png'"
                            id="logo"
                        />
                        <h6 class="text-center mb-3 mt-3">Silahkan Masuk</h6>
                        <form
                            class="needs-validation"
                            @submit.prevent="login"
                            novalidate=""
                        >
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    v-model="user.email"
                                    type="email"
                                    class="form-control"
                                    placeholder="Email address"
                                    autofocus
                                />
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label"
                                        >Sandi</label
                                    >
                                    <div class="float-right">
                                        <router-link
                                            to="/auth/reset-password"
                                            class="text-small"
                                        >
                                            <span> Lupa Sandi?</span>
                                        </router-link>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input
                                        v-model="user.password"
                                        :type="
                                            showPassword ? 'text' : 'password'
                                        "
                                        class="form-control"
                                        required
                                        placeholder="Enter sandi anda"
                                    />
                                    <div class="input-group-append">
                                        <span
                                            @click="hidePassword"
                                            class="btn btn-primary"
                                        >
                                            <i
                                                :class="
                                                    showPassword
                                                        ? 'fa-solid fa-eye-low-vision fa-md'
                                                        : 'fa-solid fa-eye fa-md'
                                                "
                                            ></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-6">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-lg btn-block"
                                    tabindex="4"
                                >
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// import cookie
import Cookie from "js-cookie";
import iziToast from "izitoast";
import LoadingComponent from "../../components/LoadingComponent.vue";
export default {
    components:{
      LoadingComponent
    },
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
            isLoading: false,
            showPassword: false,
            error: [],
            // showPassword: false,
        };
    },
    computed: {},
    methods: {
        hidePassword() {
            this.showPassword = !this.showPassword;
        },
        login() {
            this.isLoading=true,
            this.$store
                .dispatch("postData", ["auth/login", this.user])
                .then((response) => {
                    Cookie.set("token", response.data.token);
                    Cookie.set("user", JSON.stringify(response.data.user));
                    iziToast.success({
                        title: "Berhasil",
                        message: "Masuk dashboard",
                        position: "topCenter",
                        timeOut: 2000,
                        onOpened: () => {
                            window.location.replace("/");
                        },
                    });
                    // this.$router.go()
                })
                .catch((error) => {
                    this.isLoading = false,
                    iziToast.error({
                        title: "Galat",
                        message: "Periksa Email dan Sandi",
                        position: "topCenter",
                    });

                    // this.error = error.response.data
                });
        },
    },
};
</script>
