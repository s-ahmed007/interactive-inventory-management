import {createRouter, createWebHistory} from "vue-router";

import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Inventory from './pages/inventory/Inventory.vue'
// import InventoryItem from './pages/inventoryItem/InventoryItem.vue'

const routes = [
    {path: '/', redirect: '/login'},
    {path: '/login', name: 'login', component: Login, meta: {title: 'Login', guest: true}},
    {path: '/register', name: 'register', component: Register, meta: {title: 'Register', guest: true}},
    {path: '/inventory', name: 'inventory', component: Inventory, meta: {title: 'Inventory list', requiresAuth: true}},
    // {path: '/inventory-item', name: 'inventoryItem', component: InventoryItem, meta: {requiresAuth: true}},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'link-secondary'
})

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (localStorage?.getItem('token')) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
    document.title = `${to.meta.title}`
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
        if (localStorage?.getItem('token')) {
            next("/");
            return;
        }
        next();
    } else {
        next();
    }
    document.title = `${to.meta.title}`
});


export default router;

