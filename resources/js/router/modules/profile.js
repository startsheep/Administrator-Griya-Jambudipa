export default [
    {
        path: "/profile",
        name: "Profile",
        component: () => import("../../pages/profile/Profile.vue"),
    },
    {
        path: "/change-password",
        name: "Change Password",
        component: () => import("../../pages/profile/ChangePassword.vue"),
    },
];
