import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { router } from './router/index.js';
import App from './App.vue';
import ECharts from 'vue-echarts';

const app = createApp(App);
app.use(createPinia());
app.use(router);
// Registrar componente global de gráficos
app.component('v-chart', ECharts);
app.mount('#app');