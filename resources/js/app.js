import { createApp } from "vue";
import "./bootstrap";
import Cookie from "js-cookie";
import App from "./App.vue";
import Auth from "./Auth.vue";
import router from "./router";
import store from "./store";

import izitoast from "izitoast";
import VueSweetalert2 from 'vue-sweetalert2';


// import css
import "../css/app.css";
// import "../../public/assets/js/script.js";
// import "../../public/assets/js/stisla";

import { bindAll } from "lodash";

// const compo =;
// const app = new Vue({
if(!Cookie.get("user") && !Cookie.get('token')){
} else {
}
createApp(Auth).use(router).use(store).use(izitoast).mount("#auth");
createApp(App).use(router).use(store).use(VueSweetalert2).mount("#app");




// app.mount("#app");
