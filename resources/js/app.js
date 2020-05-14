
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


// Dependencies --------------------------------------

import Toasted from 'vue-toasted'
import VueClip from 'vue-clip'
import Multiselect from 'vue-multiselect'
import swal from 'sweetalert'
import VueContentPlaceholders from 'vue-content-placeholders'
import rate from 'vue-rate'
import vueStep from 'vue-step'
import InfiniteLoading from 'vue-infinite-loading'
Vue.use(InfiniteLoading)
import Vue2TouchEvents from 'vue2-touch-events'
Vue.use(Vue2TouchEvents)

Vue.use(require('vue-moment'))
Vue.use(Toasted)
Vue.toasted.register('error', message => message, {
    position : 'bottom-center',
    duration : 2000
})
Vue.use(VueClip)
Vue.component('multiselect', Multiselect)
Vue.use(VueContentPlaceholders)
Vue.use(rate)
Vue.component('vue-step', vueStep)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 // Layout
 Vue.component('sidebar', require('./components/layout/Sidebar.vue'));
 Vue.component('config', require('./components/layout/Config.vue'));
 Vue.component('notifications', require('./components/layout/Notifications.vue'));

// Dashboard
Vue.component('users-count', require('./components/dashboard/UsersCount.vue'));
Vue.component('roles-count', require('./components/dashboard/RolesCount.vue'));

// Profile
Vue.component('profile', require('./components/profile/Profile.vue'));
Vue.component('profile-password', require('./components/profile/Password.vue'));
Vue.component('profile-avatar', require('./components/profile/Avatar.vue'));
Vue.component('profile-view', require('./components/profile/View.vue'));

// Users
Vue.component('users-index', require('./components/users/Index.vue'));
Vue.component('users-create', require('./components/users/Create.vue'));
Vue.component('users-edit', require('./components/users/Edit.vue'));
Vue.component('users-avatar', require('./components/users/Avatar.vue'));
Vue.component('users-view', require('./components/users/View.vue'));

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

// Clients
Vue.component('clients-index', require('./components/clients/Index.vue'));
Vue.component('clients-create', require('./components/clients/Create.vue'));
Vue.component('clients-edit', require('./components/clients/Edit.vue'));
Vue.component('clients-avatar', require('./components/clients/Avatar.vue'));

// Dealers
Vue.component('dealers-index', require('./components/dealers/Index.vue'));
Vue.component('dealers-create', require('./components/dealers/Create.vue'));
Vue.component('dealers-edit', require('./components/dealers/Edit.vue'));
Vue.component('dealers-avatar', require('./components/dealers/Avatar.vue'));
Vue.component('dealers-active', require('./components/dealers/Active.vue'));
Vue.component('dealers-agree', require('./components/dealers/Agree.vue'));

// Stores
Vue.component('stores-stores', require('./components/stores/Stores.vue'));
Vue.component('stores-index', require('./components/stores/Index.vue'));
Vue.component('stores-create', require('./components/stores/Create.vue'));
Vue.component('stores-edit', require('./components/stores/Edit.vue'));
Vue.component('stores-avatar', require('./components/stores/Avatar.vue'));
Vue.component('stores-banner', require('./components/stores/Banner.vue'));
Vue.component('stores-random', require('./components/stores/Random.vue'));
Vue.component('stores-level1', require('./components/stores/Level1.vue'));
Vue.component('stores-sales', require('./components/stores/Sales.vue'));
Vue.component('stores-categories', require('./components/stores/Categories.vue'));

const app = new Vue({
    el: '#app'
});
