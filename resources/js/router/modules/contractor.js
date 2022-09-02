export default [
    {
        path: "/contractor",
        name: "Contractor",
        component: () => import("../../pages/contractors/Contractors.vue"),
        meta: {
            title: "Contractor",
        }
    },
    {
        path: '/contractor/create',
        component: () => import('../../pages/contractors/CreateEditContractor.vue'),
    },
]