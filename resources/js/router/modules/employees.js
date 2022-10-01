export default [
    {
        path: "/employees",
        name: "Employees",
        component: () => import("../../pages/employees/Employees.vue"),
        meta: {
            title: "Employees",

        }
    },
    {
        path: '/employee/create',
        component: () => import('../../pages/employees/CreateEditEmployee.vue'),
    },
    {
        path: '/employee/:id/edit',
        component: () => import('../../pages/employees/CreateEditEmployee.vue'),
        props: true
    },

]
