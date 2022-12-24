import {
    createApp
} from "vue";
import "./bootstrap";
import Cookie from "js-cookie";
import {
    abilitiesPlugin
} from "@casl/vue";
import ability from "./store/services/abilities"
import App from "./App.vue";
import Auth from "./Auth.vue";
import router from "./router";
import store from "./store";
import VueApexCharts from "vue3-apexcharts";
import izitoast from "izitoast";
import VueSweetalert2 from 'vue-sweetalert2';
import CKEditor from "@ckeditor/ckeditor5-vue";
import {
    autoAnimatePlugin
} from '@formkit/auto-animate/vue'
import VueEasyLightbox from "vue-easy-lightbox";
import 'vue-easy-lightbox/dist/external-css/vue-easy-lightbox.css'
import "../css/app.css";



import {
    bindAll
} from "lodash";

// const compo =;
// const app = new Vue({
if (!Cookie.get("user") && !Cookie.get('token')) {} else {

}
createApp(Auth).use(router).use(store).use(izitoast).use(VueSweetalert2).use(VueApexCharts).mount("#auth");
createApp(App).use(router).use(store).use(VueEasyLightbox).use(VueSweetalert2).use(CKEditor).use(abilitiesPlugin, ability, {
    useGlobalProperties: true
}).use(autoAnimatePlugin).mount("#app");




// app.mount("#app");
