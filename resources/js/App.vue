<template>
  <div class="main-wrapper main-wrapper-1">
    <Navbar />
    <Sidebar />
    <div class="main-content">
      <router-view></router-view>
    </div>
    <footer class="main-footer ">
      <div class="footer-left">
        Copyright &copy; 2022
        <div class="bullet"></div>
        Created By <a href="https://github.com/startsheep/" target="_blank">Griya Jambudipa</a>
      </div>
      <!-- <div class="footer-right">2.3.0</div> -->
    </footer>
  </div>
</template>

<script>
import Cookie from "js-cookie";
import Navbar from "./components/Navbar.vue";
import Sidebar from "./components/Sidebar.vue";
export default {
  watch: {
    "$route.params.search": {
      handler: function (search) {
        this.$store
          .dispatch("postData", ["/auth/check", {}])
          .then((response) => {
            this.users = JSON.parse(Cookie.get("user"));
          })
          .catch((error) => {
            this.error = error.response.data;
            Cookie.remove("token");
            Cookie.remove("user");
          });

        if (!Cookie.get("token")) {
          window.location.replace("/auth/login");
        }
      },
      deep: true,
      immediate: true,
    },
  },
  components: { Navbar, Sidebar },
};
</script>

<style></style>
