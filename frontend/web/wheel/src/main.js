// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routers';

Vue.use(VueRouter);

//Vue.config.productionTip = false;

// 实例化VueRouter
const router = new VueRouter({
	routes
});

new Vue({
	router
}).$mount('#app');

/* eslint-disable no-new */
// new Vue({
//   el: '#app',
//   template: '<App/>',
//   components: { App }
// });