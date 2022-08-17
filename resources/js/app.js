import { createApp } from "vue";
// import Vue from "vue";
import "./bootstrap";

import App from "./App.vue";
import Auth from "./Auth.vue";
import router from "./router";
import store from "./store";

// const compo =;

createApp(App).use(router).use(store).mount("#app");
// const app = new Vue({
//     components: { App, Auth },
//     el: "#app",
//     router,
//     store,
// });
