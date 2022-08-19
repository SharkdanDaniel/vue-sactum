import { RouteRecordRaw, createRouter, createWebHashHistory, createWebHistory } from "vue-router";
import Login from '../views/Login.vue';
import Home from '../views/Home.vue';

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;