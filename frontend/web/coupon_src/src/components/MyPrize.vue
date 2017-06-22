<template>




  <yd-layout>

    <!--顶部导航-->
    <yd-navbar title="我的抽奖">
      <a onclick="window.history.go(-1)"  slot="left">
        <yd-navbar-back-icon></yd-navbar-back-icon>
      </a>
    </yd-navbar>


    <yd-cell-group>

      <ul v-for="mc in myprize">
        <li>
          <div  class="stamp " v-bind:class="[mc.modify_time > 1 ? 'stamp02' : 'stamp01']">
            <div class="par"><p>{{mc.act_name}}</p><sub class="sign"></sub><span>{{mc.name}}</span><sub></sub><p v-if="mc.modify_time == 0">未领奖</p><p v-if="mc.modify_time > 1">已领奖</p></div>
            <div class="copy">奖项<p>获：{{mc.insert_time | time}}</p><p v-if="mc.modify_time > 0">领：{{mc.modify_time | time}}</p></div>
            <i style="padding-left: 60px"></i>
          </div>
        </li>
      </ul>

    </yd-cell-group>


    <!--底部导航-->
    <yd-tabbar slot="tabbar" fixed>
      <yd-tabbar-item title="首页" link="/" >
        <yd-icon name="home" slot="icon"></yd-icon>
      </yd-tabbar-item>

      <yd-tabbar-item title="个人中心" link="/my" active>
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
        'myprize': {},
        'status': 1,
        'post': {}
      };
    },
    created() {
      let _this = this;
      axios.get(_this.domain + '/activity/coupon/my-prize.html')
        .then(function (response) {
          if (response.data.code === -2) {
            window.location.href = _this.domain + '/wechat/oauth/callback.html';
            return false;
          }

          //展示奖项
          let prizeList = response.data.data;

          if (prizeList) {
            _this.initPrize(prizeList.myprize);
          }
        })
        .catch(function (error) {
          console.log(error);
        });

    },

    methods: {
      initPrize(ele) {
        this.myprize = ele;
        console.log(this.myprize);
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

  .stamp {width: 100%;height: 140px;padding: 0 10px;position: relative;overflow: hidden;}
  .stamp:before {content: '';position: absolute;top:0;bottom:0;left:10px;right:10px;z-index: -1;}
  .stamp:after {content: '';position: absolute;left: 10px;top: 10px;right: 10px;bottom: 10px;box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.5);z-index: -2;}
  .stamp i{position: absolute;left: 20%;top: 45px;height: 190px;width: 390px;background-color: rgba(255,255,255,.15);transform: rotate(-30deg);}
  .stamp .par{float: left;padding: 16px 15px;width: 220px;border-right:2px dashed rgba(255,255,255,.3);text-align: left;}
  .stamp .par p{color:#fff;}
  .stamp .par span{font-size: 50px;color:#fff;margin-right: 5px;}
  .stamp .par .sign{font-size: 34px;}
  .stamp .par sub{position: relative;top:-5px;color:rgba(255,255,255,.8);}
  .stamp .copy{display: inline-block;padding:21px 14px;width:170px;vertical-align: text-bottom;font-size: 24px;color:rgb(255,255,255);}
  .stamp .copy p{font-size: 12px;margin-top: 15px;}
  .stamp01{background: #F39B00;background: radial-gradient(rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 5px, #F39B00 5px);background-size: 15px 15px;background-position: 9px 3px;}
  .stamp01:before{background-color:#F39B00;}
  .stamp02{background: #333333;background: radial-gradient(transparent 0, transparent 5px, #333333 5px);background-size: 15px 15px;background-position: 9px 3px;}
  .stamp02:before{background-color:#333333;}

</style>
