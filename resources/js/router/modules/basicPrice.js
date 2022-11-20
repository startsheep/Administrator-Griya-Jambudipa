export default [
    {
        path: "/basic-price-building",
        name: "Building",
        component: () => import("../../pages/land/BasicPrice.vue"),
    },
    {
        path: "/basic-price-land",
        name: "Land",
        component: () => import("../../pages/land/BasicPrice.vue"),
    },
];
