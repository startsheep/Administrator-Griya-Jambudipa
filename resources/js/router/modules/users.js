export default [
    {
        path: "/users",
        name: "Users",
        component: () => import("../../pages/users/Users.vue"),
        meta: {
            title: "Users",
        },
    },
    {
        path: "/users/:id",
        name: "User Activity",
        component: () => import("../../pages/users/Activity.vue"),
        props: true,
        meta: {
            title: "User Activity",

        },
    },
];
