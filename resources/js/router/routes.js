import auth from "./services/auth";
import employee from "./modules/employees";
import Dashboard from "../pages/Dashboard.vue";
import customer from "./modules/customer";
import companyProfile from "./modules/company_profile";
import house from "./modules/type-house";
import user from "./modules/users";

const routes = [
    ...auth,
    ...employee,
    ...customer,
    ...companyProfile,
    ...house,
    ...user,
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard,
        meta: {
            title: "Dashboard",
            middleware: "auth",
        },
    },
    {
        path: "/customers",
        name: "customers",
        component: () => import("../pages/customers/Customers.vue"),
        meta: {
            title: "Customers",
        },
    },
];

export default routes;
