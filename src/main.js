import Vue from 'vue'
import BootstrapVue from "bootstrap-vue"
import Toasted from 'vue-toasted';
import App from './App.vue'
import VueRouter from 'vue-router'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"
import routes from './routes';

// Stylish
Vue.use(BootstrapVue);
Vue.use(Toasted, {
  iconPack : 'fontawesome'
});

// Router
Vue.use(VueRouter);
const router = new VueRouter({mode: 'history', routes});

// Icon pack
//library.add(faUserSecret)
//Vue.component('font-awesome-icon', FontAwesomeIcon)

// Important
new Vue({
  router,
  render: h => h(App)
}).$mount('#app')

// options to the toast
let options = {
  type: "success",
  icon : 'ad',
  position: "bottom-right",
  duration: 1500,
};

// Lets Register a Global Error Notification Toast.
Vue.toasted.register('purchase_complete',
  (payload) => {  
    // if there is no message passed show default message
      if(! payload.message) {
        return "SUCCESS"
      }
    
      // if there is a message show it with the message
      return payload.message;
  },
  options
)

// options to the toast
options = {
  type : 'error',
  icon : 'ad',
  position: "bottom-right",
  duration: 1500,
};

// Lets Register a Global Error Notification Toast.
Vue.toasted.register('fail',
  (payload) => {  
    // if there is no message passed show default message
      if(! payload.message) {
        return "SUCCESS"
      }
    
      // if there is a message show it with the message
      return payload.message;
  },
  options
)