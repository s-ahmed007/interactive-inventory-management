import './bootstrap';
/* Import all of Bootstrap's CSS */
import 'bootstrap/dist/css/bootstrap.min.css'
import 'vue3-toastify/dist/index.css';


import {createApp} from 'vue';
import { createPinia } from 'pinia';

import router from "./router";
import App from './pages/App.vue'

const app = createApp(App)
const pinia = createPinia()

app.use(router)
app.use(pinia)
app.mount('#app')
