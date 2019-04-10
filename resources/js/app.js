
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// Dependencies --------------------------------------

import Toasted from 'vue-toasted';
import VueClip from 'vue-clip'
import Multiselect from 'vue-multiselect'
import swal from 'sweetalert';
import VueContentPlaceholders from 'vue-content-placeholders'
import rate from 'vue-rate';

Vue.use(require('vue-moment'));
Vue.use(Toasted)
Vue.toasted.register('error', message => message, {
    position : 'bottom-center',
    duration : 2000
})
Vue.use(VueClip)
Vue.component('multiselect', Multiselect)
Vue.use(VueContentPlaceholders)
Vue.use(rate)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 // Layout
 Vue.component('sidebar', require('./components/layout/Sidebar.vue'));

// Dashboard
Vue.component('users-count', require('./components/dashboard/UsersCount.vue'));
Vue.component('roles-count', require('./components/dashboard/RolesCount.vue'));

// Profile
Vue.component('profile', require('./components/profile/Profile.vue'));
Vue.component('profile-password', require('./components/profile/Password.vue'));
Vue.component('profile-avatar', require('./components/profile/Avatar.vue'));

// Users
Vue.component('users-index', require('./components/users/Index.vue'));
Vue.component('users-create', require('./components/users/Create.vue'));
Vue.component('users-edit', require('./components/users/Edit.vue'));
Vue.component('users-avatar', require('./components/users/Avatar.vue'));

// Roles
Vue.component('roles-index', require('./components/roles/Index.vue'));
Vue.component('roles-create', require('./components/roles/Create.vue'));
Vue.component('roles-edit', require('./components/roles/Edit.vue'));

// Orders
Vue.component('orders-index', require('./components/orders/Index.vue'));
Vue.component('orders-all', require('./components/orders/All.vue'));
Vue.component('orders-availables', require('./components/orders/Availables.vue'));
Vue.component('orders-availables-count', require('./components/orders/AvailablesCount.vue'));
Vue.component('orders-dealer', require('./components/orders/Dealer.vue'));
Vue.component('orders-create', require('./components/orders/Create.vue'));
Vue.component('orders-create-auth', require('./components/orders/CreateAuth.vue'));

// Address
Vue.component('address-index', require('./components/address/Index.vue'));

// Rates
Vue.component('rates-index', require('./components/rates/Index.vue'));
Vue.component('rates-day', require('./components/rates/Day.vue'));

const app = new Vue({
    el: '#app'
});
