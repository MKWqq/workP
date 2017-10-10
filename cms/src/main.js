// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import Vuex from 'vuex'
import store from './vuex/store'
import VueRouter from 'vue-router'
import configRouter from './config/router'
import index from  './page/login/login.vue'
Vue.use(VueRouter);//use vue-router
Vue.use(Vuex);
Vue.use(ElementUI);
Vue.config.debug = true;
const router=new VueRouter(
  configRouter
);
var app = new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');
/*new Vue({
    router,
    el: "#app",
    render: h => h(App)
})*/
//router.start(Vue.extend(App),"#app");

