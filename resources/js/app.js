/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import moment from 'moment'
import Swal from 'sweetalert2';

window.Vue = require('vue');
window.moment = require('moment');
window.Swal = require('sweetalert2');

/* SweetAlert toast */
// window.Toast = Swal.mixin({
// toast: true,
// position: 'top-end',
// showConfirmButton: false,
// timer: 5000
// });

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})

/* AutoComplete Vue-Bootstrap-typeahead */
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
// Global registration
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)

import numeral from 'numeral';
import numFormat from 'vue-filter-number-format';
window.numeral = require('numeral');

Vue.filter('numFormat', numFormat(numeral));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//   el: '#app',
// });
