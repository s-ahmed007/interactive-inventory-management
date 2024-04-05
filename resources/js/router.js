import {createRouter, createWebHistory} from "vue-router";

import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Inventory from './pages/inventory/Inventory.vue';
import CreateInventory from "./pages/inventory/CreateInventory.vue";
import UpdateInventory from "./pages/inventory/UpdateInventory.vue";
import InventoryItem from './pages/inventory-item/Items.vue';
import inventoryItemCreate from "./pages/inventory-item/ItemCreate.vue";
import inventoryItemUpdate from "./pages/inventory-item/ItemUpdate.vue";

const routes = [
    {path: '/', redirect: '/login'},
    {path: '/login', name: 'login', component: Login, meta: {title: 'Login', guest: true}},
    {path: '/register', name: 'register', component: Register, meta: {title: 'Register', guest: true}},
    {path: '/inventory', name: 'inventory', component: Inventory, meta: {title: 'Inventory list', requiresAuth: true}},
    {path: '/inventory/create', name: 'createInventory', component: CreateInventory, meta: {title: 'Create Inventory', requiresAuth: true}},
    {path: '/inventory/update/:id', name: 'UpdateInventory', component: UpdateInventory, meta: {title: 'Update Inventory', requiresAuth: true}},
    {path: '/inventory/:inventoryId/item', name: 'inventoryItem', component: InventoryItem, meta: {title: 'Inventory item', requiresAuth: true}},
    {path: '/inventory/:inventoryId/item/create', name: 'inventoryItemCreate', component: inventoryItemCreate, meta: {title: 'Inventory item create', requiresAuth: true}},
    {path: '/inventory/:inventoryId/item/:id/update', name: 'inventoryItemUpdate', component: inventoryItemUpdate, meta: {title: 'Inventory item update', requiresAuth: true}},
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

