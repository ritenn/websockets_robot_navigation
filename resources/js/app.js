/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import VueSweetalert2 from 'vue-sweetalert2';
import { store } from './_store';
import { validationDirective } from './directives/ValidationDirective';
import Toasted from 'vue-toasted';

/**
 * Global usage
 */
Vue.use(Toasted, {
    fullWidth: true,
    type: 'success',
    theme: 'bubble',
    duration: 2500,
    iconPack : 'fontawesome',
    position: "bottom-center",
    icon : 'check-circle',
    action : {
        text: "x",
        onClick : (e, toastObject) => {
            toastObject.goAway(0);
        }
    },
});
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueSweetalert2);
/**
 * Components
 */
Vue.component('loader', require('./components/Loader').default);
Vue.component('fullscreen-managment', require('./components/menu/FullscreenManagment').default);
Vue.component('manage-configurations', require('./components/ManageConfigurations.vue').default);
Vue.component('connect', require('./components/Connect.vue').default);
Vue.component('console', require('./components/Console.vue').default);

/**
 * Pages
 */
Vue.component('main-page', require('./pages/Main.vue').default);
Vue.component('manual-navigation-page', require('./pages/ManualNavigation.vue').default);

/**
 * Directives
 */
Vue.directive('validation', validationDirective)


Vue.prototype.$loader = false;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
