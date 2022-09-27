// const auth = [
//     {
//         path: "/auth/login",
//         name: "Login",
//         component: import("../../pages/auth/Login.vue"),
//         meta: {
//             middleware: "guest",
//         },
//     },
// ];

// export default auth;

export default [{
        path: '/auth/login',
        component: () => import('../../pages/auth/Login.vue'),
        meta: {
            middleware: 'guest',
        }
    },
    {
        path: '/auth/reset-password',
        component: () => import('../../pages/auth/ResetPassword.vue'),
        meta: {
            middleware: 'guest',
        }
    },
    {
        path: '/auth/new-password',
        component: () => import('../../pages/auth/NewPassword.vue'),
        props: true,
    }
]
