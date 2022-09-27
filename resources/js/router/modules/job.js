export default [
    {
        path: "/jobs",
        name: "Jobs",
        children:[
            {
                path: '/jobs/house/',
                component: () => import("../../pages/whole-job/JobHouse.vue"),
            },
            {
                path: '/jobs/facility',
                component: () => import("../../pages/whole-job/JobFacility.vue"),
            },
        ]
    },
     {
         path: '/job/:id/detail',
         component: () => import("../../pages/whole-job/DetailJob.vue"),
         props: true
     },
    // {
    //     path: "/payment-jobs",
    //     name: "Payment Jobs",
    //     component: () => import("../../pages/whole-job/PaymentJobs.vue"),
    // },
]
