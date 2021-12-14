require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from "vue";
import App from "./components/App";

import mitt from 'mitt';

const emitter = mitt();

const app = createApp(App);
app.config.globalProperties.emitter = emitter;
app.mount('#app');
