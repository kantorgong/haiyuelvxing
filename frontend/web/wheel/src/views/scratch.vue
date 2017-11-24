<template>
	<div class="wrapper" id="app">
		<img src="../assets/images/scratch_banner.png" width="100%" class="banner scratch-banner">
		<div class="container scratch-con">
			<img src="../assets/images/scratch_bg.png" class="scratch-bg">
			<div class="scratch">
				<img src="../assets/images/draw_img.jpg" id="draw-img">
				<img src="../assets/images/scratch_img.png" class="scratch-img">
				<div id="prize" v-text="prizeName"></div>
				<div id="scratchpad"></div>
			</div>
			<p class="warning">剩余抽奖次数 : <em>{{drawNum}}</em> 次</p>
			<div class="info">
				<span class="title">奖项设置<i></i></span>
				<template v-for="item in prize">
					<p>{{item.name}} : {{item.content}} {{item.num > 0 ? ': ' + item.num : ''}}</p>
				</template>
				<span class="title explanation">活动说明<i></i></span>
				<p class="desc">{{lottery.act_note}}</p>
			</div>
		</div>
		<template v-if="status < 0 && show  > 0">
			<div class="error-mask show"></div>
			<div class="dialog show">
				<p v-text="message"></p>
				<a @click="showResult" v-if="status == -5" class="data">填写资料</a>
				<a class="ensure" @click="hideMask">确定</a>
			</div>
		</template>
		<div class="result-wrapper" v-if="complete > 0">
			<div class="container result-con">
				<strong>{{nickname}}，恭喜你中了{{prizeName}}</strong>
				<p></p>
				<form>
					<div class="line">
						<label>真实姓名:</label>
						<input type="text" v-model="realName">
					</div>
					<div class="line">
						<label>手机号码:</label>
						<input type="tel" v-model="phone">
					</div>
					<div class="line error" v-if="errMsg" v-text="errMsg"></div>
					<button type="button" @click="saveInfo">领 取</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import '../assets/css/common.css'
	import '../assets/css/style.css'
	import '../assets/js/wScratchPad'
	import shareImg from '../assets/images/scratch-share.png'
	import axios from 'axios'
	import qs from 'qs'

	export default {
		name: 'scratch',
		data() {
			return {
				realName: '',  //真实姓名
				errMsg: '',    //保存资料时出现的错误信息
				shareImg: shareImg,
				phone: '',     //手机号码
				status: 0,    //状态码
				show: 1,      //是否显示错误信息
				message: '',  //提示内容
				nickname: '', //微信昵称
				prize: [],  //奖品列表
				lottery: {},    //活动详情
				drawNum: 0,     //剩余抽奖次数
				shareNum: 0,    //已分享次数
				complete: 0,    //是否显示完善资料
				prizeName: '',    //中奖名称
				guid: '',          //活动分组ID
				domain: ''      //请求主域名
			}
		},
		beforeCreate() {
			document.title = '刮刮卡抽奖';
		},
		created() {
			this.domain = 'http://' + window.location.hostname;
			this.guid = this.$route.params.id;
		},
		methods: {
			hideMask() {
				this.show = 0;
				//如果还有抽奖次数，则重置刮卡区
				if (this.drawNum > 0) {
					$('#scratchpad').empty();
					this.prizeName = '';
					this.initScratch();
				}
			},
			saveInfo() {
				if (!this.realName) {
					this.errMsg = '请填写姓名';
					return false;
				}
				if (!this.phone) {
					this.errMsg = '请填写手机号码';
					return false;
				}
				if(!(/^1[34578]\d{9}$/.test(this.phone))){
					this.errMsg = '手机号码格式不正确';
					return false;
				}
				let _this = this;
				axios.post('/activity/wheel/save-info.html', qs.stringify({
					mobile: this.phone,
					name: this.realName
				}), {
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				})
					.then(function (response) {
						if (response.data.code < 0) {
							_this.errMsg = response.data.data;
							return false;
						}
						_this.errMsg = '资料填写成功';
						setTimeout(function() {
							_this.complete = 0;
							_this.status = -4;
							_this.message = '你已经中过奖啦';
						}, 2000);
					})
					.catch(function (error) {
						console.log(error);
					});
			},
			showResult() {
				this.complete = 1;
				this.show = 0;
			},
			getPrizeStatus(prizeId) {
				let _this = this;

				setTimeout(function() {
					if (prizeId < 0) {
						_this.setStatus(prizeId);
					}
					else {
						//如果不是红包抽奖，则需要用户填写资料
						if (parseInt(_this.lottery.bonus) === 0) {
							_this.status = -5;
							_this.show = 1;
							//_this.complete = 1;
							_this.message = '恭喜你中了' + _this.prizeName + '，请填写资料领取奖品';
						}
						else {
							_this.status = -4;
							_this.show = 1;
							_this.message = '恭喜你中了' + _this.prizeName;
						}
						//剩余抽奖次数清零
						_this.drawNum = 0;
					}
				}, 1500);
			},
			setStatus(status) {
				let _this = this;
				_this.status = status;
				_this.show = 1;
				if (status === -4) {
					_this.message = '你已经中过奖啦';
				}
				if (status === -5) {
					_this.message = '你已中奖，请填写资料';
				}
				if (status === -6) {
					_this.message = '你今日的抽奖次数已用完，分享之后可增加抽奖次数';
				}
				if (status === -7) {
					_this.message = '你今日的抽奖次数已用完';
				}
				if (status === -8) {
					_this.message = '就差那么一点点，请再接再厉';
				}
			},
			wxShare() {
				let _this = this;
				let pathName = window.document.location.pathname;
				let _path = pathName.substring(0, pathName.substr(1).indexOf('/')+1);
				let wxData = {
					imgUrl: _this.domain + _path + _this.shareImg.substr(1),
					link: window.location.href,
					title: this.lottery.act_name,
					desc: this.lottery.act_note,
					success: function () {
						axios.get('/activity/wheel/share.html')
							.then(function (response) {
								if (response.data.code === 0) {
									if (response.data.data > 0) {
										_this.status = 0;
										_this.drawNum = response.data.data;
										//如果还有抽奖次数，则重置刮卡区
										if (_this.drawNum > 0) {
											$('#scratchpad').empty();
											_this.prizeName = '';
											_this.initScratch();
										}
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
			},
			setPrizeName(prize_name, bonus_amount) {
				if (this.lottery.bonus && bonus_amount) {
					this.prizeName = bonus_amount + '元红包';
				}
				else {
					this.prizeName = prize_name;
				}
			},
			getLottery() {
				let _this = this;
				let path = this.$route.path;

				//获取活动分组ID
				if (this.guid === null) {
					this.status = -1;
					this.message = '活动不存在';
					return false;
				}

				//请求活动数据
				axios.get(this.domain + '/activity/wheel/index.html?guid=' + this.guid)
					.then(function (response) {
						if (response.data.code === -1) {
							_this.status = -1;
							_this.show = 1;
							_this.message = response.data.data;
							return false;
						}
						if (response.data.code === -2) {
							window.location.href = _this.domain + '/wechat/oauth/callback.html?path=' + encodeURIComponent('#' + path);
							return false;
						}
						if (response.data.code === 0) {
							_this.prize = JSON.parse(response.data.data.prize);
							_this.drawNum = response.data.data.times;
							_this.nickname = response.data.data.nickname;
							_this.lottery = JSON.parse(response.data.data.lottery);
							//_this.prizeName = response.data.data.prize_name;
							_this.setPrizeName(response.data.data.prize_name, response.data.data.bonus_amount);

							if (response.data.data.status < 0) {
								_this.setStatus(response.data.data.status);
							}

							//初始化微信分享
							_this.wxShare();

							//初始化刮卡画布
							_this.initScratch();
						}
					})
					.catch(function (error) {
						console.log(error);
					});
			},
			initScratch() {
				let num = 0;
				let _this = this;
				if (_this.status < 0 && _this.drawNum === 0) {
					_this.prizeName = _this.prizeName || '谢谢参与';
					return false;
				}

				$("#scratchpad").wScratchPad({
					width: 220,
					height: 100,
					image2: $('#draw-img').attr('src'),
					scratchMove: function() {

						num++;

						// 在刮第五十次的时候执行ajax请求
						if (num === 50) {
							axios.get(_this.domain + '/activity/wheel/lottery.html')
								.then(function (response) {
									if (response.data.code === -1) {
										_this.status = -1;
										_this.message = response.data.data;
										_this.show = 1;
										return false;
									}
									if (response.data.code === -2) {
										window.location.href = _this.domain + '/wechat/oauth/callback.html?path=' + encodeURIComponent('#' + path);
										return false;
									}

									if (response.data.code === 0) {
										//未中奖
										if (response.data.data.status < 0) {
											//不需要抽奖，直接提示错误
											if (!response.data.data.wheel) {
												_this.setStatus(response.data.data.status);
												return false;
											}
											//有抽奖操作
											else {
												_this.prizeName = '谢谢参与';
												_this.getPrizeStatus(response.data.data.status);
												_this.drawNum -= 1;
											}
										}
										//中奖了
										else {
											//_this.prizeName = response.data.data.prize_name;
											_this.setPrizeName(response.data.data.prize_name, response.data.data.bonus_amount);
											_this.getPrizeStatus(response.data.data.prize_id);
											_this.drawNum -= 1;
										}
									}
								})
								.catch(function (error) {
									console.log(error);
								});
						}
					}
				});
			}
		},
		mounted() {
			this.getLottery();
		}
	}
</script>
