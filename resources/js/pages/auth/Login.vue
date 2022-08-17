<template >
    <section class="section ">

      <div class="container m-auto">

        <div class="row ">

          <div
            class="
              col-12 col-sm-8
              offset-sm-2
              col-md-6
              offset-md-3
              col-lg-6
              offset-lg-3
              col-xl-4
              offset-xl-4
            "
          >
          <br>
          <br>
          <br>
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
                <div class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input
                      v-model="user.email"
                      type="email"
                      class="form-control"
                      tabindex="1"
                      required
                      autofocus
                    />
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label"
                        >Password</label
                      >
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <div class="input-group">
                      <input
                        v-model="user.password"
                        type="password"
                        class="form-control"
                        tabindex="2"
                        required
                      />
                      <div class="input-group-append">
                        <span class="btn btn-primary">
                          <i class="fa-solid fa-eye"></i>
                        </span>
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox"></div>
                  </div>
                  <div class="form-group">
                    <button
                      @click="login"
                      type="submit"
                      class="btn btn-primary btn-lg btn-block"
                      tabindex="4"
                    >
                      Login
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="simple-footer">
              <!-- {{-- Copyright &copy; Stisla 2018 --}} -->
            </div>
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
      error: [],
      // showPassword: false,
    };
  },
  computed: {
    showPassword() {
      //    return this.showPassword;
    },
  },
  methods: {
    // hidePassword(){

    // },
    login() {
      this.$store
        .dispatch("postData", ["auth/login", this.user])
        .then((response) => {
          console.log(response);
          Cookie.set("token", response.data.token);
          Cookie.set("user", JSON.stringify(response.data.user));
          iziToast.success({
            title: "Berhasil",
            message: "Masuk dashboard",
            position: "topCenter",
            timeOut: 2000,
            onOpened: ()=>{
                window.location.replace("/");
            }
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
