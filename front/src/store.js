import Vue from "vue";
import Vuex from "vuex";
import axios from 'axios'
import router from "./router";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        token: null,
        appData: {
            name: 'ICEBERG'
        }
    },
    mutations: {
        setToken(state, token) {
            state.token = token
        },
        clearToken(state) {
            state.token = null
        }
    },
    actions: {
        initAuth() {
            let token = localStorage.getItem('token')
            if (token) {
                this.$store.commit('setToken', token)
            } else {
                this.$router.push('/login')
            }
        },
        logout({commit}) {
            return axios.post('/auth/logout', {token: localStorage.getItem('token')})
                .then((response) => {
                    commit('clearToken')
                    localStorage.removeItem('token')
                    router.replace('/')
                })
        },
        expired({dispatch}, expireTime) {
            setTimeout(() => {
                dispatch('logout')
            }, expireTime)
        },
        login({commit}, authData) {
            return axios.post('/auth/login', {email: authData.email, password: authData.password})
                .then((response) => {
                    commit('setToken', response.data.access_token)
                    localStorage.setItem('token', response.data.access_token)
                })
        }
    },
    getters: {
        isAuth(state) {
            return state.token === null ? false : true // token geçerliliğini de backend tarafında kontrol et
        }
    }
});
