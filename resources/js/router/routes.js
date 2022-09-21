import auth from "./services/auth";
import employee from "./modules/employees";
import dashboard from "./modules/dashboard";
import customer from "./modules/customer";
import companyProfile from "./modules/company_profile";
import house from "./modules/type-house";
import user from "./modules/users";
import kavling from "./modules/kavling";
import contractor from "./modules/contractor";
import payment from "./modules/payment";
import transaction from "./modules/transaction";
import BasicPrice from "./modules/basic_price";
import jobs from "./modules/job";
import profile from "./modules/profile";

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
    ...transaction,
    ...BasicPrice,
    ...dashboard,
    ...jobs,
    ...profile,
    {
        path: "/",
        component: () => import("../pages/dashboard/Dashboard.vue"),
    },
];

export default routes;
