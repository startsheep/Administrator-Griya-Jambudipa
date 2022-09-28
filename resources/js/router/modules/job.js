export default [
    {
        path: "/jobs",
        name: "Jobs",
        children:[
            {
                path: '/jobs/house/',
                name: 'Job House',
                component: () => import("../../pages/whole-job/WholeJobs.vue"),
            },
            {
                path: '/jobs/facility',
                name: 'Job Facility',
                component: () => import("../../pages/whole-job/WholeJobs.vue"),
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
