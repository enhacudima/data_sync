import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import { AbilityBuilder, Ability } from '@casl/ability';
import {ability} from './ability.js'


Vue.use(Vuex,ability)

//axios.defaults.baseURL = 'http://localhost/data_sync/public/api'
axios.defaults.baseURL = 'https://moz-concursopublico.info/api'; //production

export default new Vuex.Store({
  state: {
    user: null
  },

  mutations: {
    setUserData (state, userData) {
      state.user = userData
      localStorage.setItem('user', JSON.stringify(userData))
      localStorage.setItem('permissions', JSON.stringify(userData.permissions))
      axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`
    },
    setUserPermission(userData){
        const { can, rules } = new AbilityBuilder(Ability);
        can(userData.user.permissions, 'all');
        ability.update(rules);
    },

    clearUserData () {
      localStorage.removeItem('user')
      localStorage.removeItem('permissions')
      //location.reload()
    }
  },

  actions: {
    login ({ commit }, credentials) {
      return axios
        .post('/login', credentials)
        .then(({ data }) => {
          commit('setUserData', data),
          commit('setUserPermission', data)
        })
    },

    logout ({ commit }) {
      return axios
        .post('/logout')
        .then(({ data }) => {
          commit('clearUserData')
          this.$router.push({ name: 'register/result' });
        })
    },

    logoutAll ({ commit }) {
      return axios
        .post('/logoutAll')
        .then(({ data }) => {
          commit('clearUserData')
        })
    }
  },

  getters : {
    isLogged: state => !!state.user
  }
})
