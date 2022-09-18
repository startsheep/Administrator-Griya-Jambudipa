export default [
    {
        path: "/jobs",
        name: "Jobs",
        children:[
            {
                path: '/jobs/house',
                component: () => import("../../pages/whole-job/JobHouse.vue"),
            },
            {
                path: '/jobs/facility',
                // component: () => import("../../pages/whole-job/PaymentJobs.vue"),
            },
        ]
    },
    // {
    //     path: "/payment-jobs",
    //     name: "Payment Jobs",
    //     component: () => import("../../pages/whole-job/PaymentJobs.vue"),
    // },
]
