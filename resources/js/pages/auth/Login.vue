<template>
    <section class="section">
        <div class="container m-auto">
            <div class="row">
                <div
                    class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4"
                >
                    <br />
                    <br />
                    <br />
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <img
                                        src="../../../../public/assets/images/logo.png"
                                        class="img-fluid rounded mx-auto d-block"
                                        alt=""
                                    />
                                    <h4 class="text-center">Log in</h4>
                                </div>
                            </div>
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
                                        <label
                                            for="password"
                                            class="control-label"
                                            >Password</label
                                        >
                                        <div class="float-right">
                                            <a
                                                href="auth-forgot-password.html"
                                                class="text-small"
                                            >
                                                Forgot Password?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <input
                                            v-model="user.password"
                                            :type="
                                                showPassword
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            class="form-control"
                                            required
                                            placeholder="Enter your password"
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
                                <div class="form-group">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-lg btn-block"
                                        tabindex="4"
                                    >
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="simple-footer">Copyright &copy; freel 2022</div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
// import cookie
import Cookie from "js-cookie";
import iziToast from "izitoast";
export default {
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
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
                    iziToast.error({
                        title: "Gagal",
                        message: "Periksa Email dan Password",
                        position: "topCenter",
                    });

                    // this.error = error.response.data
                });
        },
    },
};
</script>
