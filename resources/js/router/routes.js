import auth from "./services/auth";
import Home from "../pages/Home.vue";

const routes = [
    ...auth,
    {
        path: "/",
        name: "Home",
        component: Home,
        meta: {
            title: "Home",
            middleware: "auth",
        },
    },
];

export default routes;
