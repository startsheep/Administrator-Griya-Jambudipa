<template>
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
                    <li>
                        <a
                            href="#"
                            data-toggle="search"
                            class="nav-link nav-link-lg d-sm-none"
                            ><i class="fas fa-search"></i
                        ></a>
                    </li>
                </ul>
            </form>
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
                                userImage == null
                                    ? '/assets/images/avatar/avatar-2.png'
                                    : '/storage/' + userImage.documentPath
                            "
                            class="rounded-circle mr-1"
                            height="30"
                        />
                        <div class="d-sm-none d-lg-inline-block profile-name">
                            Halo , {{ username }}
                        </div></a
                    >
                    <div class="dropdown-menu dropdown-menu-right">
                        <router-link
                            to="/profile"
                            class="dropdown-item has-icon"
                        >
                            <i class="far fa-user"></i> Profil
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
export default {
    data() {
        return {
            user: this.userCookie,
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
    methods: {
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
    },
};
</script>
<style lang=""></style>
