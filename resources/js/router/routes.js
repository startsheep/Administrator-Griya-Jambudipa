import auth from "./services/auth";
import Dashboard from "../pages/Dashboard.vue";
import Employees from "../pages/employees/Employees.vue";

const routes = [
    ...auth,
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
        meta: {
            title: "Dashboard",
            middleware: "auth",
        },
    },
     {
        path: "/employees",
        name: "Employees",
        component: Employees,
        meta: {
            title: "Employees",
        }
     }
];

export default routes;
