<template>
    <router-view />
</template>

<script>
import axios from "axios";

export default {
    mounted() {
        this.loadProfile();
    },
    methods: {
        loadProfile() {
            axios.get("/api/company-profile").then((result) => {
                let logo = "/storage/" + result.data.data.logo;

                document.title = result.data.data.name;
                document.querySelector("link#logo").href = logo;
                document.querySelector("img#logo").src = logo;
            });
        },
    },
};
</script>

<style></style>
