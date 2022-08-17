import routes from "./routes";
import {
    createRouter,
    createWebHistory
} from "vue-router";
import Cookies from "js-cookie";

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "text-primary",
});

router.beforeEach(async (to, from, next) => {
    const token = Cookies.get("token");
    if (to.meta.middleware === "auth") {
        if (!token) {
            window.location.replace('/auth/login')
            // next("/auth/login");
        } else {
            next();
        }
    }

    if (to.meta.middleware === "guest") {
        if (token) {
            window.location.replace('/')
        } else {
            next();
        }
    }
    next();

});

export default router;
