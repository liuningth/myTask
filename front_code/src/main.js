import Vue from 'vue'
import App from './App.vue'
import router from './router'

Vue.config.productionTip = false

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';


Vue.use(ElementUI);

import "bootstrap/dist/css/bootstrap.min.css";

import http from '@/plugs/http.js'
console.log(http)
Vue.prototype.$http = http

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
