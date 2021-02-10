import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import middleware from "./middleware";
import {VISIT_LINK} from "@/store/actions/links";
import store from "@/store";
import {GET_IP} from "@/store/actions/other";

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
        meta: {layout: "empty", middleware: [middleware.guest]},
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import(/* webpackChunkName: "login" */ '../views/Register.vue'),
        meta: {layout: "empty", middleware: [middleware.guest]},
    },
    {
        path: '/go/:code',
        name: 'Go',
        meta: {layout: "empty"},
        beforeEnter: (to, from, next) => {
            store.dispatch(GET_IP).then((ip) => {
                store.dispatch(VISIT_LINK, [to.params.code, document.referrer, ip]).then(link => {
                    if (link.data) {
                        window.location.href = link.data;
                    } else {
                        next({name: 'Home'});
                    }
                })
            })
        },
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
    } else {
        next();
    }
});

export default router
