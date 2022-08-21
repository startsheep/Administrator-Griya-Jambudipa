import { createStore } from "vuex";
import action from "./services/action";
import auth from "./modules/auth";
import employee from "./modules/employees/employee";
import customer from "./modules/customer/customer";

const store = createStore({
    modules: {
        action,
        auth,
        employee,
        customer,
    },
});

export default store;
