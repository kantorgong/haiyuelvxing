<template>
	<div class="wrapper" id="app">
		<img src="../assets/images/wheel_banner.jpg" width="100%" class="banner">
		<div class="container wheel-con">
			<div class="turnplate">
				<canvas class="item" id="wheelcanvas" width="506" height="506"></canvas>
				<img class="pointer" src="../assets/images/turnplate-pointer.png" @click="getPrize"/>
			</div>
			<p class="warning">剩余抽奖次数 : <em>{{drawNum}}</em> 次</p>
			<div class="info">
				<span class="title">奖项设置<i></i></span>
				<template v-for="item in prize">
					<p>{{item.name}} : {{item.content}} : {{item.num}}</p>
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
	import '../assets/js/awardRotate'
	import shareImg from '../assets/images/wheel-share.png'
	import axios from 'axios'
	import qs from 'qs'

	export default {
		name: 'wheel',
		data() {
			return {
				turnplate: {
					restaraunts:[],             //大转盘奖品名称
					colors:[],                  //大转盘奖品区块对应背景颜色
					outsideRadius:210,          //大转盘外圆的半径
					textRadius:135,             //大转盘奖品位置距离圆心的距离
					insideRadius:68,            //大转盘内圆的半径
					bRotate:false               //false:停止;ture:旋转
				},
				shareImg: shareImg,
				realName: '',  //真实姓名
				errMsg: '',    //保存资料时出现的错误信息
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
				domain: ''       //请求主域名
			}
		},
		methods: {
			hideMask() {
				this.show = 0;
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
			drawRouletteWheel() {
				let canvas = document.getElementById('wheelcanvas');
				if (canvas.getContext) {
					//根据奖品个数计算圆周角度
					let arc = Math.PI / (this.turnplate.restaraunts.length / 2);
					let ctx = canvas.getContext('2d');
					//在给定矩形内清空一个矩形
					ctx.clearRect(0,0,506,506);
					//strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式
					ctx.strokeStyle = '#ff5959';
					//font 属性设置或返回画布上文本内容的当前字体属性
					ctx.font = 'bold 18px Microsoft YaHei';
					for(let i = 0; i < this.turnplate.restaraunts.length; i++) {
						let angle = 1.5*Math.PI - arc/2 + i * arc;
						ctx.fillStyle = this.turnplate.colors[i];
						ctx.beginPath();
						//arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
						ctx.arc(253, 253, this.turnplate.outsideRadius, angle, angle + arc, false);
						ctx.arc(253, 253, this.turnplate.insideRadius, angle + arc, angle, true);
						ctx.stroke();
						ctx.fill();
						//锁画布(为了保存之前的画布状态)
						ctx.save();

						//----绘制奖品开始----
						ctx.fillStyle = '#fff';
						let text = this.turnplate.restaraunts[i];
						//translate方法重新映射画布上的 (0,0) 位置
						ctx.translate(253 + Math.cos(angle + arc / 2) * this.turnplate.textRadius, 253 + Math.sin(angle + arc / 2) * this.turnplate.textRadius);

						//rotate方法旋转当前的绘图
						ctx.rotate(angle + arc / 2 + Math.PI / 2);

						/** 下面代码根据奖品名称长度定位**/
							//measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
						let texts = text.split('');
						if(texts.length > 4){
							let textsLenS = 2;
							for(let j = 0;j < texts.length;j++){
								ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, -textsLenS*25);
								textsLenS -= 0.8;
							}
						}
						else{
							let textsLenF = 1;
							for(let k = 0;k < texts.length;k++){
								ctx.fillText(texts[k], -ctx.measureText(texts[k]).width / 2, -textsLenF*25);
								textsLenF -= 0.8;
							}
						}

						//把当前画布返回（调整）到上一个save()状态之前
						ctx.restore();
						//----绘制奖品结束----
					}
				}
				else {
					console.log('没有获取到canvas');
				}
			},
			showResult() {
				this.complete = 1;
				this.show = 0;
			},
			getPrize() {
				// 阻止用户同一时间多次点击抽奖按钮
				// 阻止提示文字弹出层在转盘未转完的时候弹出
				if(this.turnplate.bRotate) return;
				if (this.status < 0 && this.drawNum === 0) {
					this.show = 1;
					return false;
				}
				this.turnplate.bRotate = !this.turnplate.bRotate;

				let _this = this;

				//点击抽奖
				axios.get(this.domain + '/activity/wheel/lottery.html')
					.then(function (response) {
						if (response.data.code === -1) {
							_this.status = -1;
							_this.message = response.data.data;
							_this.show = 1;
							return false;
						}
						if (response.data.code === -2) {
							window.location.href = _this.domain + '/wechat/oauth/callback.html';
							return false;
						}

						let item = 0;
						let length = _this.prize.length;

						if (response.data.code === 0) {
							//未中奖
							if (response.data.data.status < 0) {
								//不需要抽奖，直接提示错误
								if (!response.data.data.wheel) {
									_this.setStatus(response.data.data.status);
									return false;
								}
								//有抽奖操作，转盘结束提示相关信息
								else {
									let rnd = Math.floor(Math.random() * length * 2 + 1);
									item = rnd % 2 === 0 ? rnd : rnd + 1;
									_this.rotateFn(item, response.data.data.status);
								}
							}
							//中奖了
							else {
								_this.prize.forEach(function(val, inx) {
									if (val.name === response.data.data.prize_name) {
										item = inx * 2 + 1;
									}
								});
								_this.prizeName = response.data.data.prize_name;
								item > 0 && _this.rotateFn(item, response.data.data.prize_id, response.data.data.prize_name);
							}
						}
					})
					.catch(function (error) {
						console.log(error);
					});

			},
			rotateFn (item, prizeId, prizeName) {
				let angles = 360 - (item - 1) * (360 / this.turnplate.restaraunts.length);
				let _this = this;
				let wheelcanvasObj = $('#wheelcanvas');
				_this.drawNum = _this.drawNum - 1;  //将抽奖次数减一
				wheelcanvasObj.stopRotate();
				wheelcanvasObj.rotate({
					angle: 0,
					animateTo: angles + 1800,
					duration: 8000,
					callback: function() {
						if (prizeId < 0) {
							_this.setStatus(prizeId);
						}
						else {
							//如果不是红包抽奖，则需要用户填写资料
							if (parseInt(_this.lottery.bonus) === 0) {
								_this.status = -5;
								_this.show = 1;
								_this.complete = 1;
								_this.message = '恭喜你中了' + prizeName + '，请填写资料领取奖品';
							}
							else {
								_this.status = -4;
								_this.show = 1;
								_this.message = '恭喜你中了' + prizeName;
							}
							//剩余抽奖次数清零
							_this.drawNum = 0;
						}
						_this.turnplate.bRotate = !_this.turnplate.bRotate;
					}
				});
			},
			getQueryString(name) {
				let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
				let r = window.location.search.substr(1).match(reg);
				if (r !== null) return unescape(r[2]); return null;
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
							_this.prizeName = response.data.data.prize_name;

							_this.prize.forEach(function(val, index) {
								let _index = index * 2;
								_this.turnplate.restaraunts[_index] = val.name;
								_this.turnplate.restaraunts[_index + 1] = '谢谢参与';
								_this.turnplate.colors[_index] = '#ff5959';
								_this.turnplate.colors[_index + 1] = '#ff7f7e';
							});

							_this.wxShare();

							if (response.data.data.status < 0) {
								_this.setStatus(response.data.data.status);
							}
						}
					})
					.catch(function (error) {
						console.log(error);
					});
			}
		},
		beforeCreate() {
			document.title = '幸运大转盘';
		},
		created() {
			this.domain = 'http://' + window.location.hostname;
			this.guid = this.$route.params.id;
		},
		mounted() {
			this.getLottery();
		},
		beforeUpdate() {
			this.drawRouletteWheel();
		}
	}
</script>
