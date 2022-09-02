import auth from "./services/auth";
import employee from "./modules/employees";
import Dashboard from "../pages/Dashboard.vue";
import customer from "./modules/customer";
import companyProfile from "./modules/company_profile";
import house from "./modules/type-house";
import user from "./modules/users";
import kavling from "./modules/kavling";
import contractor from "./modules/contractor";
import payment from "./modules/payment";

const routes = [
    ...auth,
    ...employee,
    ...customer,
    ...companyProfile,
    ...house,
    ...kavling,
    ...user,
    ...contractor,
    ...payment,
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard,
        meta: {
            title: "Dashboard",
            middleware: "auth",
        },
    },
];

export default routes;
