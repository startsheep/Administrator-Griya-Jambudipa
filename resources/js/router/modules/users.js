export default [
    {
        path: "/users",
        name: "Users",
        component: () => import("../../pages/users/Users.vue"),
        meta: {
            title: "Users",
        },
    },
];
