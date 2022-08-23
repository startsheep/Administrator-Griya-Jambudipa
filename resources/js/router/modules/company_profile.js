export default [
    {
        path: "/company_profile",
        name: "Company Profile",
        component: () =>
            import("../../pages/company_profile/CompanyProfile.vue"),
        meta: {
            title: "Company Profile",
        },
    },
];
