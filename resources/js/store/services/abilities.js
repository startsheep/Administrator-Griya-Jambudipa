import { defineAbility } from "@casl/ability";
import Cookies from "js-cookie";

export default defineAbility((can) => {
    if (Cookies.get("user") !== undefined) {
        const user = JSON.parse(Cookies.get("user"));
        can(["create"], "User");
    }
});
