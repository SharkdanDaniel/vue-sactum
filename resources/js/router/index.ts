import { RouteRecordRaw, createRouter, createWebHashHistory, createWebHistory } from "vue-router";
// import Login from '../views/Login.vue';
// import Home from '../views/Container/pages/Home.vue';
// import UserList from '../views/Container/pages/Users/UserList.vue';
// import ProductList from '../views/Container/pages/Products/ProductList.vue';
// import Container from '../views/Container/Container.vue';
import { authGuard } from "../guards";

const Login = () => import('../views/Login.vue');
const Container = () => import('../views/Container/Container.vue');
const Home = () => import('../views/Container/pages/Home.vue');
const UserList = () => import('../views/Container/pages/Users/UserList.vue');
const UserForm = () => import('../views/Container/pages/Users/UserForm.vue');
const ProductList = () => import('../views/Container/pages/Products/ProductList.vue');
const ProductForm = () => import('../views/Container/pages/Products/ProductForm.vue');

const routes: RouteRecordRaw[] = [
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/',
        name: 'Container',
        component: Container,
        beforeEnter: [authGuard],
        children: [
            { path: 'home', component: Home, name: 'Home' },
            { path: 'users', component: UserList, name: 'Usuários' },
            { path: 'users/create', component: UserForm, name: 'Adicionar Usuário' },
            { path: 'users/:id', component: UserForm, name: 'Atualizar Usuário' },
            { path: 'products', component: ProductList, name: 'Produtos' },
            { path: 'products/create', component: ProductForm, name: 'Adicionar Produto' },
            { path: 'products/:id', component: ProductForm, name: 'Atualizar Produto' },
        ]
    },
    { path: '', redirect: 'home' }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;