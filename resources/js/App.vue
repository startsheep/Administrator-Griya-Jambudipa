<template>
    <router-view></router-view>
</template>

<script>
import Cookie from "js-cookie";
export default {
    watch: {
        "$route.params.search": {
            handler: function (search) {
                this.$store
                    .dispatch("postData", ["/user/authenticated", {}])
                    .then((response) => {
                        this.users = JSON.parse(Cookie.get("user"));
                    })
                    .catch((error) => {
                        this.error = error.response.data;
                        Cookie.remove("token");
                        Cookie.remove("user");
                        // window.location.replace("/auth/login");
                    });

                // if (Cookie.get("token") == undefined) {
                //     window.location.replace("/auth/login");
                // }
                this.users = JSON.parse(Cookie.get("user"));
            },
            deep: true,
            immediate: true,
        },
    },
};
</script>

<style></style>
