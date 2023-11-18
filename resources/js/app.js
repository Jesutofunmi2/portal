/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'regenerator-runtime/runtime';

window.Vue = require('vue');
Vue.use(VueRouter)

import { routes } from './routes'

import Ministry from './views/Ministry'
import School from './views/School'
import Parent from './views/Parent'
import Liberian from './views/Liberian'
import Aeozeo from './views/Aeozeo'
import Teacher from './views/Teacher'
import Burser from './views/Burser'
import Student from './views/Student'
import Cas from './views/Cas'

import ClipLoaderComponent from './components/Shared/ClipLoaderComponent'
import VueRouter from 'vue-router'
import store from './store'
import FlashMessage from '@smartweb/vue-flash-message';
import VueLoading from 'vuejs-loading-plugin'
import VueSimpleAlert from "vue-simple-alert";
//import VueTableDynamic from 'vue-table-dynamic'
import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css';
import VueHtml2Canvas from 'vue-html2canvas';
import VueSignature from "vue-signature-pad";

Vue.use(VueHtml2Canvas);
Vue.use(VueSignature);

const user = JSON.parse(localStorage.getItem('user'));
Vue.prototype.$user = user.original.user;
Vue.use(FlashMessage);
// using default options

// overwrite defaults
Vue.use(VueLoading, {
  dark: false, // default false
  text: 'Loading...', // default 'Loading'
  loading: false, // default false
  customLoader: ClipLoaderComponent, // replaces the spinner and text with your own
  //background: 'rgb(255,255,255)', // set custom background
  //classes: ['myclass'] // array, object or string
})

Vue.use(VueSimpleAlert);
//Vue.use(VueTableDynamic)
Vue.component('Modal', VueModal);
    
// routes
const router = new VueRouter({
    routes: routes,
    mode: 'history',
    base: '/',
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('validation-errors', require('./components/Shared/ValidationErrorComponent.vue').default) 

const app = new Vue({
    el: '#app',
    components: { Ministry , School, Liberian, Parent, Teacher, Student, Aeozeo, Burser, Cas},
    router,
    store,
});
