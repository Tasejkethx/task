/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueRouter from 'vue-router'
require('./bootstrap')

window.Vue = require('vue')
window.VueAxios = require('vue-axios').default
window.Axios = require('axios').default
/* eslint no-undef:0 */
Vue.use(VueRouter, VueAxios, axios)

const routes = [
  { path: '/', component: require('./components/MainPage').default },
  { path: '/employees', component: require('./components/Employee/IndexEmployee').default },
  { path: '/employees/create', component: require('./components/Employee/CreateEmployee').default },
  { path: '/employees/edit/:id', component: require('./components/Employee/EditEmployee').default },
  { path: '/departments', component: require('./components/Department/IndexDepartment').default },
  { path: '/departments/create', component: require('./components/Department/CreateDepartment').default },
  { path: '/departments/edit/:id', component: require('./components/Department/EditDepartment').default }

]

const router = new VueRouter({
  mode: 'history',
  routes
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.component('pagination', require('laravel-vue-pagination'))
Vue.component('departmentFormComponent', require('../js/components/Department/departmentFormComponent').default)
Vue.component('employeeFormComponent', require('./components/Employee/employeeFormComponent').default)
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* eslint no-unused-vars:0 */
const app = new Vue({
  router
}).$mount('#app')
