import { createWebHistory, createRouter } from 'vue-router';
import Login from './components/auth/Login.vue';
import Signup from './components/auth/Signup.vue';
import Forget from './components/auth/Forget.vue';
import Logout from './components/auth/Logout.vue';
//authentication route import end
import home from "./components/Home.vue";
import contact from "./components/contact.vue";


const routes = [
    {
        name: 'home',
        path: '/home',
        component: home
    },
    {
        name: 'contact',
        path: '/contact',
        component: contact
    },
    {
        name: 'signup',
        path: '/signup',
        component: Signup
    },
    {
        name: '/',
        path: '/',
        component: Login
    },
    {
        name: 'forget',
        path: '/forget',
        component: Forget
    },
    {
        name: 'logout',
        path: '/logout',
        component: Logout
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;