import { RouteRecordRaw, createRouter, createWebHashHistory, createWebHistory } from "vue-router";
import Login from '../views/Login.vue';
import Home from '../views/Home.vue';
import { authGuard } from "../guards";

const routes: RouteRecordRaw[] = [
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/',
        name: 'Home',
        component: Home,
        beforeEnter: [authGuard]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;