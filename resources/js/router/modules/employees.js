export default [
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
