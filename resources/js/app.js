
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import Swal from 'sweetalert2'
import VueTelInput from 'vue-tel-input';
window.Swal = Swal

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast

Vue.use(VueRouter);

Vue.use(VueTelInput);

Vue.component('pagination', require('laravel-vue-pagination'));

let routes = [
    { path: '/home', component: require('./components/Contacts.vue').default },
    { path: '/', component: require('./components/Home.vue').default },
];

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

const app = new Vue({
    el: '#app',
    router
});
