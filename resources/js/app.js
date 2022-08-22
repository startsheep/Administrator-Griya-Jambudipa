import { createApp } from "vue";
import "./bootstrap";
import Cookie from "js-cookie";
import App from "./App.vue";
import Auth from "./Auth.vue";
import router from "./router";
import store from "./store";

import izitoast from "izitoast";
import VueSweetalert2 from 'vue-sweetalert2';
import  CKEditor from "@ckeditor/ckeditor5-vue";
// import 'izitoast/dist/css/iziToast.min.css';

// import Summernote from 'summernote';


import "../css/app.css";


import { bindAll } from "lodash";

// const compo =;
// const app = new Vue({
if(!Cookie.get("user") && !Cookie.get('token')){
} else {
}
createApp(Auth).use(router).use(store).use(izitoast).mount("#auth");
createApp(App).use(router).use(store).use(VueSweetalert2).use(CKEditor).mount("#app");




// app.mount("#app");
