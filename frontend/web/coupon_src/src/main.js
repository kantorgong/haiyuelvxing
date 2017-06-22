// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

import YDUI from 'vue-ydui';
import 'vue-ydui/dist/ydui.rem.css';

Vue.use(YDUI);
Vue.config.productionTip = false

//时间格式化
Vue.filter('time', function (value) {
  return new Date(parseInt(value) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
});


/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
