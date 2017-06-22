<template>
  <yd-layout>

    <!--顶部导航-->
    <yd-navbar title="首页">

    </yd-navbar>


    <div>

      <ul v-for="(item, index) in couponlist">
        <li>
          <div class="coupon_show">
            <div class="stamp stamp04">
              <div class="par"><p>{{item.title}}</p><sub class="sign">￥</sub><span>{{item.price}}</span><sub></sub>
                <p></p></div>
              <div class="copy">优惠券
                <p><br></p>
                <yd-button type="hollow" @click.native="receiveCoupon(item.coupon_guid, index)"
                           v-if="!item.couponLog.length">获取
                </yd-button>
                <yd-button type="disabled" v-if="item.couponLog.length >0">已获取</yd-button>
              </div>
              <i style="padding-left: 60px">{{item.depict}}</i>
            </div>
          </div>

          <br/>
        </li>
      </ul>

    </div>


    <!--底部导航-->
    <yd-tabbar slot="tabbar" fixed>
      <yd-tabbar-item title="首页" link="/" active>
        <yd-icon name="home" slot="icon"></yd-icon>
      </yd-tabbar-item>

      <yd-tabbar-item title="个人中心" link="/my">
        <yd-icon name="ucenter-outline" slot="icon"></yd-icon>
      </yd-tabbar-item>
    </yd-tabbar>

  </yd-layout>
</template>

<script type="text/babel">
  import shareImg from '../assets/images/dzp.jpg'
  import axios from 'axios'
  import qs from 'qs'

  export default {
    name: 'app',
    data() {
      return {
        'domain': 'http://' + window.location.hostname,
//        'domain': 'http://plus.xxcb.cn',
        'couponlist': {},
        'post': {}
      };
    },

    //初始化微信分享
    mounted() {
      this.wxShare();
    },


    //加载页面
    created() {
      let _this = this;
      axios.get(_this.domain + '/activity/coupon/index.html')
        .then(function (response) {
          if (response.data.code === -2) {
            window.location.href = _this.domain + '/wechat/oauth/callback.html';
            return false;
          }
          //是否获取过这个优惠券
          _this.status = response.data.data.status;
          //展示优惠券
          let retdata = response.data.data;
          if (retdata) {
            _this.initCoupon(retdata.couponlist);
          }
        })
        .catch(function (error) {
          console.log(error);
        });


    },

    methods: {
      //初始化优惠券列表
      initCoupon(ele) {
        this.couponlist = ele;
      },
      //用户获取优惠券
      receiveCoupon(coupon_guid, index) {
        let _this = this;

        this.post['coupon_guid'] = coupon_guid;

console.log(this.post);
        //提交给后端
        axios.post(_this.domain + '/activity/coupon/receive-coupon.html', qs.stringify({
          data: _this.post
        }), {
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        })
          .then(function (response) {
            if (response.data.code < 0) {
              //提示失败
              _this.$dialog.toast({
                mes: '获取失败！',
                timeout: 1500,
                icon: 'error',
              });
              return false;
            }

            _this.couponlist[index].couponLog = [1];

            //提示成功
            _this.$dialog.toast({
              mes: '获取成功！',
              timeout: 1500,
              icon: 'success'
            });

            //提示转发
            _this.$dialog.notify({
              mes: '点击右上角，转发到朋友圈可参与抽奖！',
              timeout: 5000,
              callback: () => {
                console.log('我走咯！');
              }
            });


          })
          .catch(function (error) {
            console.log(error);
          });
      },
      //微信分享
      wxShare() {
        let _this = this;
        //分享链接
        let pathName = window.document.location.pathname;
        let _path = pathName.substring(0, pathName.substr(1).indexOf('/') + 1);
        let wxData = {
          imgUrl: _this.domain  + '/' + shareImg.substr(1),
          link: window.location.href,
          title: '分享优惠券，获大奖',
          desc: '分享优惠券，获大奖',
          success: function () {
            axios.get('/activity/coupon/share.html')
              .then(function (response) {
                if (response.data.code === 0) {
                  if (response.data.data.group_id != '') {
                    location.href = _this.domain + '/lottery/#/wheel/' + response.data.data.group_id;
                  }
                }
              })
              .catch(function (error) {
                console.log(error);
              });
          }
        };
        weixin.on('ready', function () {
          weixin.bindData(wxData);
          weixin.bindShareInfo();
        });

      }
    }
  }
</script>
<style>
  .stamp {
    width: 387px;
    height: 140px;
    padding: 0 10px;
    position: relative;
    overflow: hidden;
  }

  .stamp:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 10px;
    right: 10px;
    z-index: -1;
  }

  .stamp:after {
    content: '';
    position: absolute;
    left: 10px;
    top: 10px;
    right: 10px;
    bottom: 10px;
    box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.5);
    z-index: -2;
  }

  .stamp i {
    position: absolute;
    left: 20%;
    top: 45px;
    height: 190px;
    width: 390px;
    background-color: rgba(255, 255, 255, .15);
    transform: rotate(-30deg);
    z-index: 9;
  }

  .stamp .par {
    float: left;
    padding: 16px 15px;
    width: 220px;
    border-right: 2px dashed rgba(255, 255, 255, .3);
    text-align: left;
  }

  .stamp .par p {
    color: #fff;
  }

  .stamp .par span {
    font-size: 50px;
    color: #fff;
    margin-right: 5px;
  }

  .stamp .par .sign {
    font-size: 34px;
  }

  .stamp .par sub {
    position: relative;
    top: -5px;
    color: rgba(255, 255, 255, .8);
  }

  .stamp .copy {
    position: relative;
    display: inline-block;
    padding: 21px 14px;
    width: 100px;
    vertical-align: text-bottom;
    font-size: 30px;
    color: rgb(255, 255, 255);
    z-index: 10;
  }

  .stamp .copy p {
    font-size: 16px;
    margin-top: 15px;
  }

  .stamp01 {
    background: #F39B00;
    background: radial-gradient(rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 5px, #F39B00 5px);
    background-size: 15px 15px;
    background-position: 9px 3px;
  }

  .stamp01:before {
    background-color: #F39B00;
  }

  .stamp02 {
    background: #D24161;
    background: radial-gradient(transparent 0, transparent 5px, #D24161 5px);
    background-size: 15px 15px;
    background-position: 9px 3px;
  }

  .stamp02:before {
    background-color: #D24161;
  }

  .stamp03 {
    background: #7EAB1E;
    background: radial-gradient(transparent 0, transparent 5px, #7EAB1E 5px);
    background-size: 15px 15px;
    background-position: 9px 3px;
  }

  .stamp03:before {
    background-color: #7EAB1E;
  }

  .stamp03 .copy {
    padding: 10px 6px 10px 12px;
    font-size: 24px;
    z-index: 999;
  }

  .stamp03 .copy p {
    font-size: 14px;
    margin-top: 5px;
    margin-bottom: 8px;
  }

  .stamp03 .copy a {
    background-color: #fff;
    color: #333;
    font-size: 14px;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 3px;
    display: block;
  }

  .stamp04 {
    width: 390px;
    background: #50ADD3;
    background: radial-gradient(rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 4px, #50ADD3 4px);
    background-size: 12px 8px;
    background-position: -5px 10px;
  }

  .stamp04:before {
    background-color: #50ADD3;
    left: 5px;
    right: 5px;
  }

  .stamp04 .copy {
    padding: 10px 6px 10px 12px;
    font-size: 24px;
    z-index: 10;
  }

  .stamp04 .copy p {
    font-size: 14px;
    margin-top: 5px;
    margin-bottom: 8px;
  }

  .stamp04 .copy a {
    background-color: #fff;
    color: #333;
    font-size: 14px;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 3px;
    display: block;
  }
</style>
