
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

Vue.use(require('vue-moment'));
Vue.use(Toasted)
Vue.toasted.register('error', message => message, {
    position : 'bottom-center',
    duration : 1000
})
Vue.use(VueClip)
Vue.component('multiselect', Multiselect)
Vue.use(VueContentPlaceholders)


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
Vue.component('transactions-count', require('./components/dashboard/TransactionsCount.vue'));
Vue.component('companies-count', require('./components/dashboard/CompaniesCount.vue'));

// Profile
Vue.component('profile', require('./components/profile/Profile.vue'));
Vue.component('profile-password', require('./components/profile/Password.vue'));

// Users
Vue.component('users-index', require('./components/users/Index.vue'));
Vue.component('users-create', require('./components/users/Create.vue'));
Vue.component('users-edit', require('./components/users/Edit.vue'));

// Roles
Vue.component('roles-index', require('./components/roles/Index.vue'));
Vue.component('roles-create', require('./components/roles/Create.vue'));
Vue.component('roles-edit', require('./components/roles/Edit.vue'));

// Companies
Vue.component('companies-index', require('./components/companies/Index.vue'));
Vue.component('companies-create', require('./components/companies/Create.vue'));
Vue.component('companies-edit', require('./components/companies/Edit.vue'));
Vue.component('companies-users', require('./components/companies/Users.vue'));

// Transactions
Vue.component('transactions-index', require('./components/transactions/Index.vue'));
Vue.component('transactions-create', require('./components/transactions/Create.vue'));
Vue.component('transactions-edit', require('./components/transactions/Edit.vue'));
Vue.component('transactions-stages', require('./components/transactions/Stages.vue'));
Vue.component('transactions-file', require('./components/transactions/File.vue'));
Vue.component('transactions-comments', require('./components/transactions/Comments.vue'));

const app = new Vue({
    el: '#app'
});
