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

export default [
{
    path: '/auth/login',
    component: () => import('../../pages/auth/Login.vue'),
    meta: {
        middleware: 'guest',
    }
},
]
