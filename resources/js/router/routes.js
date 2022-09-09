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
import building from "./modules/building";
import transaction from "./modules/transaction";
import land from "./modules/land";

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
    ...building,
    ...transaction,
    ...land,
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
