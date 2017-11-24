<template>




  <yd-layout>

    <!--顶部导航-->
    <yd-navbar title="个人中心">
      <a onclick="window.history.go(-1)"  slot="left">
        <yd-navbar-back-icon></yd-navbar-back-icon>
      </a>
    </yd-navbar>

    <template>
    <section id="scrollView" style="text-align: center;margin: 0 auto" class="g-scrollview">
      <h1 class="demo-logo" style="text-align: center;margin: 0 auto"><img v-bind:src=headimgurl|imgUrl /></h1>
      <h2 class="demo-detail-title">{{nickname}}</h2>
    </section>
    </template>

  <yd-cell-group>

    <yd-cell-item arrow>
      <yd-icon slot="icon" name="discount" size=".42rem"></yd-icon>
      <span slot="left">我的优惠券</span>
      <span slot="right" >
        <router-link to="/myCoupon">查看</router-link>
      </span>
    </yd-cell-item>

    <yd-cell-item arrow>
      <yd-icon slot="icon" name="star" size=".42rem"></yd-icon>
      <span slot="left">我的抽奖</span>
      <span slot="right">
        <router-link to="/myPrize">查看</router-link>
      </span>
    </yd-cell-item>
  </yd-cell-group>


    <!--底部导航-->
  <yd-tabbar slot="tabbar" fixed>
    <yd-tabbar-item title="首页" link="/" >
      <yd-icon name="home" slot="icon"></yd-icon>
    </yd-tabbar-item>

    <yd-tabbar-item title="个人中心" link="#" active>
      <yd-icon name="ucenter-outline" slot="icon"></yd-icon>
    </yd-tabbar-item>
  </yd-tabbar>

    </yd-layout>

</template>

<script type="text/babel">
  import axios from 'axios'
  import qs from 'qs'


  export default {
    name: 'app',
    data() {
      return {
        'domain': 'http://' + window.location.hostname,
        'nickname': '', //微信昵称,
        'headimgurl': '',  //头像
      };
    },
    created() {
      let _this = this;
      axios.get(_this.domain + '/activity/coupon/my.html')
        .then(function (response) {
          if (response.data.code === -2) {
            window.location.href = _this.domain + '/wechat/oauth/callback.html';
            return false;
          }

          //展示优惠券
          let my = response.data.data;

          if (my) {
            _this.initMy(my);
          }
        })
        .catch(function (error) {
          console.log(error);
        });

    },

    methods: {
      initMy(ele) {
        this.nickname = ele.nickname;
        this.headimgurl = ele.headimgurl;
      }

    }
  }
</script>
<style>
  .g-scrollview{width:100%;height:100%;-webkit-box-flex:1;-webkit-flex:1;-ms-flex:1;flex:1;}
  .demo-logo{text-align:center}.demo-logo img{display:inline-block;height:3.8rem;padding:.5rem 0 .4rem}
  .demo-detail-title {
    color: #888;
    font-size: .28rem;
    margin-bottom: .1rem;
    font-weight: 400;
    line-height: .10rem;
    text-align: center;
  }
</style>
