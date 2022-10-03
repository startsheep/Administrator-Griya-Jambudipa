<template>
    <LoadingComponent v-if="isLoading" />
    <div class="navbar bg-white" style="position: sticky; top: 0; z-index: 999">
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li>
                        <a
                            href="#"
                            data-toggle="sidebar"
                            class="nav-link nav-link-lg"
                            ><i class="fas fa-bars"></i
                        ></a>
                    </li>
                </ul>
            </form>
            <div class="mr-3">
                <button class="btn btn-sm btn-success">Admin Panel</button>
            </div>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
                    <a
                        href="#"
                        data-toggle="dropdown"
                        class="nav-link dropdown-toggle nav-link-lg nav-link-user"
                    >
                        <img
                            alt="image"
                            :src="
                                userData.image == null
                                    ? '/assets/images/avatar/avatar-2.png'
                                    : '/storage/' + userData.image.documentPath
                            "
                            onerror="this.onerror = null; this.src
                        = '/assets/images/avatar/avatar-2.png';"
                            class="rounded-circle mr-1"
                            height="30"
                        />
                        <div class="d-sm-none d-lg-inline-block profile-name">
                            {{ userData.name }}
                        </div></a
                    >
                    <div class="dropdown-menu dropdown-menu-right">
                        <router-link
                            to="/profile"
                            class="dropdown-item has-icon"
                        >
                            <i class="far fa-user"></i> Profil
                        </router-link>
                        <router-link
                            to="/change-password"
                            class="dropdown-item has-icon"
                        >
                            <i class="fas fa-key"></i> Ubah Password
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <a
                            @click="logout"
                            class="dropdown-item has-icon text-danger"
                            style="cursor: pointer"
                        >
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
import LoadingComponent from "./LoadingComponent.vue";

export default {
    data() {
        return {
            user: this.userCookie,
            userData: {},
            isLoading: false,
        };
    },
    computed: {
        username() {
            return JSON.parse(this.userCookie).name;
        },
        userImage() {
            return JSON.parse(this.userCookie).image;
        },
        userCookie() {
            return Cookie.get("user");
        },
    },
    mounted() {
        this.getUser();
    },
    methods: {
        getUser() {
            let user = JSON.parse(Cookie.get("user"));

            this.$store
                .dispatch("showData", ["user/show-email/" + user.email, []])
                .then((result) => {
                    this.userData = result.data;
                });
        },
        logout() {
            this.isLoading = true;
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
                    this.isLoading = false;
                    Cookie.remove("token");
                    Cookie.remove("user");
                    window.location.replace("/auth/login");
                    // this.$router.push('/admin/login')
                });
        },
    },
    components: {
        LoadingComponent,
    },
};
</script>
<style lang=""></style>
