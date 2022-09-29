export default [
    {
        path: "/customers",
        name: "customers",
        component: () => import("../../pages/customers/Customers.vue"),
        meta: {
            title: "Customers",
            middleware: "Staff"
        }
    },
    {
        path: '/customer/create',
        component: () => import('../../pages/customers/CreateEditCustomer.vue'),
    },
    {
        path: '/customer/:id/edit/',
        component: () => import('../../pages/customers/CreateEditCustomer.vue'),
        props : true

    }
]
