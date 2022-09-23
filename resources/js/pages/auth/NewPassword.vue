<template>
  <div class="container-fluid bg-dark">
    <div
      class="row d-flex align-items-center justify-content-center"
      style="height: 100vh"
    >
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="card">
          <div class="card-body">
            <img
              src="../../../../public/assets/images/logo.png"
              class="img-fluid rounded mx-auto d-block"
              style="width: 60%"
            />
            <h6 class="text-center mb-3">Setel Ulang Sandi</h6>
            <div class="form-group">
              <label>Sandi Baru</label>
              <div class="input-group">
                <InputPassword
                  :showPassword="showPassword"
                  :value="newPass"
                  v-model="newPass"
                />
                <div class="input-group-append">
                  <span @click="hidePassword" class="btn btn-primary">
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
                <label>Konfirmasi Sandi Baru</label>
              <div class="input-group">
                <InputPassword
                  :showPassword="showPassword"
                  :value="confirmPass"
                  v-model="confirmPass"
                />
                <div class="input-group-append">
                  <span @click="hidePassword" class="btn btn-primary">
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
          </div>
          <div class="card-footer">
            <button
              @click="checkValidPassword()"
              class="btn btn-primary btn-block"
              :disabled="isLoading || newPass.length < 1"
            >
              Atur Ulang
            </button>
            <button
              @click="$router.push('/auth/login')"
              class="btn btn-danger btn-block"
            >
              Kembali
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import InputPassword from "../../components/InputPassword.vue";
import iziToast from "izitoast";
export default {
  data() {
    return {
      isLoading: false,
      newPass: "",
      confirmPass: "",
      showPassword: false,
    };
  },
  computed: {
    getParamsEmail() {
      return this.$route.href.split("?")[1].split("&");
    },
    getEmail() {
      return this.$route.href.split("?")[1].split("&")[1].split("=")[1];
    },
    getToken() {
      return this.$route.href.split("?")[1].split("&")[0].split("=")[1];
    },
  },
  methods: {
    hidePassword() {
      this.showPassword = !this.showPassword;
    },
    setPassword(event) {
      this.newPass = event;
    },
    setConfirmPassword(event) {
      this.confirmPass = event;
    },
    checkValidPassword() {
      const self = this;
      let isValid = false;
      if (this.newPass) {
        if (self.newPass.length < 8) {
          iziToast.error({
            title: "Galat",
            message: "Password minimal 8 karakter",
            position: "topRight",
          });
        } else {
          if (self.confirmPass !== self.newPass) {
            iziToast.error({
              title: "Galat",
              message: "Password tidak sama",
              position: "topRight",
            });
          }else{
            this.doReset()
          }
        }
      }
    },

    doReset() {
      this.isLoading = true;
      const url = [
        "auth/new-password",
        // getParamsEmail,
        {
          password: this.newPass,
          confirm_password: this.confirmPass,
          email: this.getEmail,
          token: this.getToken,
        },
      ];

      this.$store
        .dispatch("postData", url)
        .then((res) => {
            iziToast.success({
                title: "Berhasil",
                message: "Password berhasil diubah",
                position: "topRight",
                onOpened: ()=>{
                    this.$router.push("/auth/login")
                },
            });
          this.isLoading = false;
        })
        .catch((err) => {
          this.$swal.fire({
            icon: "warning",
            title: "Coba Lagi",
            text: "token kadaluarsa, coba kirim email kembali",
            confirmButtonText:'Kirim Ulang',
          }).then(() => {
            this.$router.push("/auth/reset-password");
          });
        });

      setTimeout(() => {
        this.isLoading = false;
      }, 1);
    },
  },
  components: { InputPassword },
};
</script>
<style>
</style>
