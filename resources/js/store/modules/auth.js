import Cookies from "js-cookie";

const state = () => ({
  user: Cookies.get("user")
    ? JSON.parse(Cookies.get("user"))
    : { name: "", email: "" },
  token: "",
});

const mutations = {
  setUser(state, data) {
    state.user = data;
    Cookies.set("user", JSON.stringify(data));
  },
  setToken(state, data) {
    state.token = data;
    Cookies.set("token");
  },
};

export default {
  namespaced: true,
  state,
  mutations,
};
