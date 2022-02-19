import Vue from 'vue';
import VueRouter from 'vue-router';
import Router from './router.js';
import App from './App.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: Router
});

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});