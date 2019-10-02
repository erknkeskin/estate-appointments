import Vue from "vue";
import Router from "vue-router";
import Dashboard from "./views/dashboard/Dashboard";
import Home from "./views/home/Home";
import Appointment from "./views/appointment/Appointment";
import Office from "./views/office/Office";
import Login from "./views/auth/Login";
import Logout from "./views/auth/Logout";
import Customer from "./views/customer/Customer";
import store from "./store";

Vue.use(Router);

const router = new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            component: Dashboard,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/homes',
            component: Home,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/appointments',
            component: Appointment,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/offices',
            component: Office,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/dashboard',
            redirect: '/',
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/customers',
            component: Customer,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/login',
            component: Login,
        },
        {
            path: '/logout',
            component: Logout,
            meta: {
                requiresAuth: true
            }
        }
    ]
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login')
    } else {
        next()
    }
});

export default router;