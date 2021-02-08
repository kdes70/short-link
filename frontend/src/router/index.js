import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import middleware from "./middleware";

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
            middleware: [middleware.auth],
        },
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import(/* webpackChunkName: "login" */ '../views/Login.vue'),
        meta: {layout: "empty"},
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import(/* webpackChunkName: "login" */ '../views/Register.vue'),
        meta: {layout: "empty"},
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        to.meta.middleware.forEach(element => {
            element({next, router});
        });
    }

    next();
});

export default router
