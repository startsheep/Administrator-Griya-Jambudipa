export default [
    {
        path: "/jobs",
        name: "Jobs",
        component: () => import("../../pages/whole-job/Jobs.vue"),
    },
    {
        path: "/payment-jobs",
        name: "Payment Jobs",
        component: () => import("../../pages/whole-job/PaymentJobs.vue"),
    },
]
