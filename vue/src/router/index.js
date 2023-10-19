import { createRouter, createWebHistory } from "vue-router";
import Project from "../pages/Project.vue";
import ProjectView from "../pages/ProjectView.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import DefaultLayout from "../components/DefaultLayout.vue";
import AuthLayout from "../components/AuthLayout.vue";
import store from "../store/index.js";
import middlewarePipeline from "./middlewarePipeline.js";
import authenticate from "./middleware/authenticate.js";

const routes = [
    {
        path: "/",
        redirect: "/projects",
        component: DefaultLayout,
        meta: {
            requiresAuth: true,
            middleware: [authenticate],
        },
        children: [
            {
                path: "/projects",
                name: "Project",
                component: Project
            },
            {
                path: "/projects/:id",
                name: "ProjectView",
                component: ProjectView
            }
        ]
    },
    {
        path: "/auth",
        redirect: "/login",
        name: "Auth",
        component: AuthLayout,
        meta: {
            isGuest: true,
            middleware: [authenticate],
        },
        children: [
            {
                path: "/login",
                name: "Login",
                component: Login,
            },
            {
                path: "/register",
                name: "Register",
                component: Register,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {

    if (!to.meta.middleware) {
        return next();
    }
    const middleware = to.meta.middleware;

    const context = {
        to,
        from,
        next,
        store,
    };

    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1),
    });
});

export default router;