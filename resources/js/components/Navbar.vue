<template >


 <div class="navbar bg-white" style="position:sticky; top: 0; z-index:999;">
      <nav class="navbar  navbar-expand-lg main-navbar" >
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg "><i class="fas fa-bars "></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../../../public/assets/images/avatar/avatar-2.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block profile-name">Halo , {{ username }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in 5 min ago</div>
              <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a @click="logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
</div>
</template>
<script>
import Cookie from "js-cookie";
export default {
    data(){
        return {
            user : this.userCookie
        }
    },
    computed:{
        username(){
            return this.user
        },
        userCookie(){
            return Cookie.get('user');
        }
    },
    methods:{

        logout() {
            axios
                .post(
                    "/auth/logout",
                    {},
                    {
                        headers: {
                            Authorization: "Bearer " + Cookie.get("token"),
                        },
                    }
                )
                .then(() => {
                    Cookie.remove("token");
                    Cookie.remove("user");
                    window.location.replace("/auth/login");
                    // this.$router.push('/admin/login')
                });
        },
    }
}
</script>
<style lang="">

</style>
