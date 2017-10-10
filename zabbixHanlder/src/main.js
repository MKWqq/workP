// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import VueRouter from 'vue-router'
import routes from './config/routes'
Vue.use(VueRouter);//use vue-router
Vue.use(ElementUI);
Vue.config.debug = true;
const router=new VueRouter(
  routes
);
var app = new Vue({
    router,
    render: h => h(App)
}).$mount('#app');


