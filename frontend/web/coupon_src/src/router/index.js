import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import My from '@/components/My'
import MyCoupon from '@/components/MyCoupon'
import MyPrize from '@/components/MyPrize'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/my',
      name: 'My',
      component: My
    },
    {
      path: '/mycoupon',
      name: 'MyCoupon',
      component: MyCoupon
    },
    {
      path: '/myprize',
      name: 'MyPrize',
      component: MyPrize
    }
  ]
})
