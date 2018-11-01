
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

Vue.use(require('vue-moment'));
Vue.use(Toasted)
Vue.toasted.register('error', message => message, {
    position : 'bottom-center',
    duration : 1000
})
Vue.use(VueClip)
Vue.component('multiselect', Multiselect)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

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

const app = new Vue({
    el: '#app',
    data() {
      return {
        loading: false
      }
    },
    mounted() {
      // Add a loader request interceptor
      axios.interceptors.request.use((config) => {
        this.setLoading(true);
        return config;
      }, (error) => {
        this.setLoading(false);
        return Promise.reject(error);
      });

      // Add a loader response interceptor
      axios.interceptors.response.use((response) => {
        this.setLoading(false);
        return response;
      }, (error) => {
        this.setLoading(false);
        return Promise.reject(error);
      });
    },
    methods: {
      setLoading(value) {
        this.loading = !!value;
      }
    }
});
