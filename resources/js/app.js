require('./bootstrap');
window.Vue = require('vue');
window.moment = require('moment');//para funcionar o moment fora do js


import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import Vuex from 'vuex';
import {routes} from './routes';
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';
import 'es6-promise/auto';
import store from './loginLogout';
import { ValidationProvider, extend } from 'vee-validate';
import { ValidationObserver } from 'vee-validate';
import Vuetify from "../plugins/vuetify";
//vue tables 2
import { ServerTable, ClientTable, Event } from 'vue-tables-2';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
//permission
import { abilitiesPlugin } from '@casl/vue';
import {ability} from './ability.js'
//laguang
import {i18n} from './i18n.js'


Vue.config.productionTip = false;
// Add a rule.
extend('secret', {
  validate: value => value === 'example',
  message: 'This is not the magic word'
});

// Register it globally
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
Vue.use(Antd);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Vuex);
Vue.use(ServerTable, {}, false, 'bootstrap4')
Vue.use(require('vue-moment'));
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(abilitiesPlugin, ability);


window.moment = require('moment');//para funcionar o moment fora do js

//axios.defaults.baseURL = 'http://localhost/data_sync/public/api'; //dev
axios.defaults.baseURL = 'https://moz-concursopublico.info/api'; //production

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    //base: "/data_sync/public/", //dev
    base: "/", //production
    routes: routes
});

import { AbilityBuilder, Ability } from '@casl/ability';
const { can, rules } = new AbilityBuilder(Ability);
router.beforeEach((to, from, next) => {

  const loggedIn = localStorage.getItem('user')
  const canNavigate = to.matched.some(route => {
      if(route.meta.resource){
          return ability.can(route.meta.resource)
      }
    return true
  })


  if (to.matched.some(record => record.meta.auth) && !loggedIn) {
    next('/login')
    return
  }else{

    if (!canNavigate) {
        return next('/403')
    }
  }

  next()
});



const app = new Vue({
    vuetify:Vuetify,
    el: '#app',
    router: router,
    store,
    i18n,
    created () {
	    const userInfo = localStorage.getItem('user')
	    if (userInfo) {
	      const userData = JSON.parse(userInfo)
	      this.$store.commit('setUserData', userData)
	    }
	    axios.interceptors.response.use(
	      response => response,
	      error => {
	        if (error.response.status === 401) {
	          this.$store.dispatch('logout')
	        }
	        return Promise.reject(error)
	      }
	    )
	 },
    render: h => h(App),
});

