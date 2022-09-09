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
    {
        path: '/contractor/:id/edit/',
        component: () => import('../../pages/contractors/CreateEditContractor.vue'),
        props : true
    }
]
