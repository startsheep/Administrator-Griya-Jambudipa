export default [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('../../pages/dashboard/Dashboard.vue'),
    },
    {
        path: '/dashboard/kavling',
        name: 'List Kavling',
        component: () => import('../../pages/dashboard/KavlingHasPerson.vue'),

    }
]
