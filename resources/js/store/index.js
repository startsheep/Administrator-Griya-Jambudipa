import { createStore } from "vuex";
import action from "./services/action";
import auth from "./modules/auth";
import employee from "./modules/employee";

const store = createStore({
    modules: {
        action,
        auth,
        employee,
    },
});

export default store;
