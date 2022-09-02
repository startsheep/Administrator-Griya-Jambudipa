import { createStore } from "vuex";
import action from "./services/action";
import auth from "./modules/auth";
import employee from "./modules/employees/employee";
import customer from "./modules/customer/customer";
import companyProfile from "./modules/company_profile/company_profile";
import house from "./modules/type-house/typeHoues";
import user from "./modules/user/user";
import contractor from "./modules/contractor/contractor"

const store = createStore({
    modules: {
        action,
        auth,
        employee,
        customer,
        companyProfile,
        house,
        user,
        contractor,
    },
});

export default store;
