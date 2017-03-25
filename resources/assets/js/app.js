window._ = require('lodash');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'
import Toast from 'vue-easy-toast'
import VueFlatpickr from 'vue-flatpickr'
import axios from 'axios'
import {registration, user} from './models'
import navigation from './components/Navigation.vue'
import routes from './router'

Vue.use(Toast)
Vue.use(VueRouter)
Vue.use(VueFlatpickr)

window.Vue = require('vue');
window.VueRouter = VueRouter;
window.axios = require('axios');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = Laravel.csrfToken;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
	routes,
    mode: 'history',
	linkActiveClass: 'is-active'
});

const app = new Vue({
    router,

    components: {
    	navigation,
    },

    data: {
        user: {},
        registrations: [],
    },

    created() {
    	user.fetchUser().then(() => this.user = user.get());

    	registration.retrieve().then(rsp => this.registrations = rsp.data);
    }
}).$mount('#app');
