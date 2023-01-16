import { createApp } from 'vue'
import App from './App.vue'
import router from './router/router'
import store from '@/store/index.js'

import './css/style.css'

const app = createApp(App)

app.use(router);

app.use(store);

app.mount('#app');
