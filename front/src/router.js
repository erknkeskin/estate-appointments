import Vue from "vue";
import Router from "vue-router";
import Dashboard from "./views/dashboard/Dashboard";
import Home from "./views/home/Home";
import Appointment from "./views/appointment/Appointment";
import Office from "./views/office/Office";
import Login from "./views/auth/Login";
import store from './store'
import Logout from "./views/auth/Logout";

Vue.use(Router);

export default new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            component: Dashboard
        },
        {
            path: '/homes',
            component: Home
        },
        {
            path: '/appointments',
            component: Appointment
        },
        {
            path: '/offices',
            component: Office
        },
        {
            path: '/dashboard',
            component: Dashboard
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/logout',
            component: Logout
        }
    ]
});