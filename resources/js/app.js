import './bootstrap';
/* Import all of Bootstrap's CSS */
import 'bootstrap/dist/css/bootstrap.min.css'

/* @import "bootstrap-icons/font/bootstrap-icons"; */
// import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");


import {createApp} from 'vue';
import { createPinia } from 'pinia';

import router from "./router";
import App from './pages/App.vue'

const app = createApp(App)
const pinia = createPinia()

app.use(router)
app.use(pinia)
app.mount('#app')
