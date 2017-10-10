// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
//@代表src文件夹，在base.config.js中的alias配置
import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import '@/style/css/common.css'
import store from '@/vuex/store'
import router from '@/config/router'
import moment from 'moment'

import '../static/UEditor/ueditor.config'
import '../static/UEditor/ueditor.all.min'/*../static/UEditor/ueditor.all*/
import '../static/UEditor/lang/zh-cn/zh-cn'
import '../static/UEditor/ueditor.parse.min'
import '../static/mCustomScrollbar/jquery.mCustomScrollbar.css'
import '../static/mCustomScrollbar/jquery.mousewheel.min'
import '../static/mCustomScrollbar/jquery.mCustomScrollbar.min.js'

Vue.use(ElementUI);

Vue.filter('formatDate', function (data,formatString) {   //时间过滤器
  data=parseInt(data)*1000;
  formatString=formatString||'YYYY-MM-DD HH:mm:ss';
  return moment(data).format(formatString);
});

new Vue({
  router,
  store,
  render:h=>h(App),
  el: '#app',
  template: '<App/>',
  components: { App }
}).$mount('#app');
