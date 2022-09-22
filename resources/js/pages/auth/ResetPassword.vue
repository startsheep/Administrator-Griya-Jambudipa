<template>
  <div class="container-fluid bg-dark">
    <div
      class="row d-flex align-items-center justify-content-center"
      style="height: 100vh"
    >
      <!-- Create Loading circle-->
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="card">
          <div class="card-body">
            <div v-if="!isSuccess">
              <img
                src="../../../../public/assets/images/logo.png"
                class="img-fluid rounded mx-auto d-block"
                style="width: 60%"
              />

              <h6 v-if="!isLoading" class="text-center mx-4 mt-3">
                Masukkan email Anda dan kami akan mengirimkan tautan untuk kembali ke akun Anda
              </h6>
              <h6 v-else class="text-center mx-3 mt-3">Mohon Tunggu 🙏</h6>

              <div class="form-group">
                <label>Email</label>
                <input
                  v-model="email"
                  type="email"
                  class="form-control"
                  placeholder="Masukan Email"
                />
              </div>
            </div>
            <div v-else>
              <img
                src="../../../../public/assets/images/success-email.gif"
                class="img-fluid rounded mx-auto d-block"
                style="width: 60%"
              />
              <h6 class="text-center mb-3">Email Berhasil Terkirim ,Cek Email Anda</h6>
            </div>
          </div>
          <div class="card-footer" v-if="!isSuccess">
            <button
              @click="sendEmail"
              class="btn btn-primary btn-block"
              v-if="!isLoading"
            >
              Kirim
            </button>
            <button
              v-else
              class="btn btn-primary btn-block"
              type="button"
              disabled
            >
              <span
                class="spinner-border spinner-border-sm"
                role="status"
                aria-hidden="true"
              ></span>
              <span class="sr-only">Loading...</span>
            </button>

            <button @click="$router.back" class="btn btn-danger btn-block">
              Kembali
            </button>
          </div>
          <div class="card-footer" v-else>
            <a
              href="https://mail.google.com/mail"
              target="_blank"
              class="btn btn-primary btn-block"
              :disabled="isLoading"
            >
              Periksa Email
            </a>
            <button @click="$router.back" class="btn btn-danger btn-block">
              Kembali
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      email: "",
      isLoading: false,
      isSuccess: false,
    };
  },
  watch: {
    $route(to, from) {
      if (to) {
        this.isSuccess = false;
      }
    },
  },
  methods: {
    sendEmail() {
      const url = [
        "auth/reset-password",
        {
          email: this.email,
        },
      ];

      this.isLoading = true;
      this.$store.dispatch("postData", url).then((res) => {
        if (res.meta) {
          if (res.meta.statusCode == 400) {
            this.$swal.fire({
              title: "Perhatian",
              text: res.meta.message.email[0],
              icon: "warning",
              confirmButtonText: "Coba Lagi",
            });
            this.isLoading = false;
          }
        } else {
          setTimeout(() => {
              this.isSuccess = true;
              this.isLoading = false;
          }, 2000);
        }
      });
    },
  },
};
</script>
<style>
</style>
