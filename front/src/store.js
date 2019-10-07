import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import logo from './assets/images/logo.png';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        appData: {
            name: 'ICEBERG',
            logo: logo
        },
        status: '',
        warningStyle: '',
        loginMessage: '',
        token: localStorage.getItem('token') || '',
        user: {}
    },
    mutations: {
        auth_request(state) {
            state.status = 'loading';
            state.warningStyle = 'badge badge-warning';
            state.loginMessage = 'giriş yapılıyor...';
        },
        auth_success(state, token, user) {
            state.status = 'success';
            state.token = token;
            state.user = user;
            state.warningStyle = 'badge badge-success';
            state.loginMessage = 'giriş başarılı';
        },
        auth_error(state) {
            state.status = 'error';
            state.warningStyle = 'badge badge-danger';
            state.loginMessage = 'giriş başarısız';
        },
        logout(state) {
            state.status = '';
            state.token = '';
            state.warningStyle = '';
            state.loginMessage = '';
        }
    },
    actions: {
        login({commit}, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request');
                axios({url: '/auth/login', data: {email: user.email, password: user.password}, method: 'POST'})
                    .then(resp => {
                        const token = resp.data.access_token;
                        const user = resp.data.user;

                        localStorage.setItem('token', token);
                        axios.defaults.headers.common['Authorization'] = 'Bearer '+token;
                        commit('auth_success', token, user);
                        resolve(resp);
                    })
                    .catch(err => {
                        commit('auth_error');
                        localStorage.removeItem('token');
                        reject(err);
                    })
            })
        },
        logout({commit}) {
            return new Promise((resolve, reject) => {
                commit('logout');
                localStorage.removeItem('token')
                delete axios.defaults.headers.common['Authorization']
                resolve()
            })
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    }
});