/**
 * Created by wqq on 2017/3/20.
 */
import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App'
import routes from './config/router'
import axios from 'axios'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
Vue.prototype.$http=axios;
Vue.use(VueRouter);//use vue-router
Vue.use(ElementUI);
Vue.config.debug = true;
const router=new VueRouter(
    routes
);
router.push("/program");
var app = new Vue({
        el:"#app",
        router,
        render: h => h(App)
});


