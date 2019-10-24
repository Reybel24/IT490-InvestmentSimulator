import Vue from 'vue'
import BootstrapVue from "bootstrap-vue"
import App from './App.vue'
import VueRouter from 'vue-router'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"

import routes from './routes';

Vue.use(BootstrapVue)

Vue.use(VueRouter)
const router = new VueRouter({mode: 'history', routes});

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
