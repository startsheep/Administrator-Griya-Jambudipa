import { createStore } from "vuex";
import action from "./services/action";
import auth from "./modules/auth";

const store = createStore({
    modules: {
        action,
        auth,
    },
});

export default store;
