export default [{
        path: "/type-house",
        component: () => import("../../pages/type-house/House.vue"),
    },
    {
        name: "detail-type-house",

        path: "/type-house/:id/detail",
        component: () => import("../../pages/type-house/DetailTypeHouse.vue"),
        props: true,
    }

]
