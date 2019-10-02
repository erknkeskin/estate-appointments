import Vue from "vue"
import App from "./App.vue"
import router from "./router"
import store from './store'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min'
import '@fortawesome/fontawesome-free/css/all.min.css'
import './assets/css/custom.css'
import axios from 'axios'

const token = localStorage.getItem('token')
if (token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

axios.defaults.baseURL = 'http://localhost:8000/api'

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
