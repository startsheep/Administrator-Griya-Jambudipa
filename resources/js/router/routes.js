import auth from "./services/auth";
import employee from "./modules/employees";
import Dashboard from "../pages/Dashboard.vue";
import customer from './modules/customer'

const routes = [
    ...auth,
...employee,
...customer,
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
         }
     },

];

export default routes;
