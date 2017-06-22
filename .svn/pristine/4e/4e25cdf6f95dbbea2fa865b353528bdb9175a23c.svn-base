<template>
	<div class="wrap">
		<section class="loading">
			<p>
				<img src="./assets/images/load-bg.png" class="load-bg">
				<img src="./assets/images/load-img.png" class="load-img">
			</p>
		</section>

		<section class="swiper-container">
			<div class="swiper-wrapper">
				<article class="swiper-slide page1" data-hash="page1">
				</article>
				<article class="swiper-slide page2" data-hash="page2">
					<h1><img src="./assets/images/p2-img1.png"></h1>
					<div class="enroll">
						<form action="" id="enroll-form">
							<ul v-html="form"></ul>
							<div class="btn-cont">
								<button type="button" class="btn btn-ok" @click="applyTo" v-if="status == 0">确认提交</button>
								<div class="btn btn-e" v-if="status > 0">已报名</div>
							</div>
						</form>
					</div>
				</article>
			</div>
		</section>

		<!-- 全局控制区域 -->
		<section class="global-ctrl" id="g-ctrl">
			<!-- 返回首页 -->
			<span class="home-btn"></span>
			<!-- 音乐播放控制 -->
			<!-- 向下箭头 -->
			<img class="arrow preload" src="./assets/images/arrow.png" alt="向下滑动">
		</section>

		<!--pc-->
		<div id="pc-board">
			<div class="qrcode"><div></div>扫一扫在手机上打开</div>
			<div class="pager"><a href="#" id="btn-next">下一页</a></div>
		</div>
		<!--copyright-->
		<a id="copyright" target="_blank" href="http://www.xxcb.cn">技术支持：XXCB</a>
	</div>
</template>

<script>
import './assets/css/page.css'
import page from './assets/js/main-new'
import axios from 'axios'
import qs from 'qs'

export default {
  	name: 'app',
	data() {
  		return {
			'domain': 'http://' + window.location.hostname,
			'form': '',
			'status': 0,
			'post': {}
		};
	},
	created() {
		let _this = this;
		let guid = page.getUrlParameterByName('guid');
		axios.get(_this.domain + '/activity/apply/index.html?guid=' + guid)
			.then(function (response) {
				if (response.data.code === -2) {
					window.location.href = _this.domain + '/wechat/oauth/callback.html';
					return false;
				}
				if (response.data.code < 0) {
					page.tip.show(response.data.data);
					return false;
				}
				_this.status = response.data.data.status;
				//展示表单
				let formList = response.data.data.form;
				if (formList) {
					$.each(formList, function (ele) {
						_this.initForm(formList[ele]);
					})
				}
			})
			.catch(function (error) {
				console.log(error);
			});

	},
	mounted() {
		page.app.height = $(window).height();
		page.app.width = $(window).width();

		if (page.checkIsPC()) {
			page.app.isPC = true;
			page.app.width = page.app.DEFAULT_WIDTH;
			page.app.height = Math.min(960 * (page.app.DEFAULT_WIDTH / page.app.DEFAULT_HEIGHT), page.app.height);
		}
		// 判断横屏还是竖屏
		$(window).on('orientationchange',function(){
			if( window.orientation == 90 || window.orientation == -90 ) {
				page.tip.show('请使用竖屏浏览');
			}
			if ( window.orientation == 180 || window.orientation==0 ) {
				if ($('#page-tip-layer').length) {
					$('#page-tip-layer').remove();
				}
			}
		});
		// 调整页面元素高度
		$('.wrap, .swiper-slide, .swiper-container').height(page.app.height).width(page.app.width);

		// 滑屏初始化
		page.app.init({
			// hashnav: true
		});
		page.app.initPC();
		page.hanldeAnimate()
	},
	methods: {
		initForm(ele) {
			let disabled = this.status > 0 ? 'disabled' :'';
			switch (ele.label) {
				case 'input':
					this.form += '<li><input type="text" name="'+ele.name+'" class="textstyle" placeholder="'+ele.text+'" '+disabled+'></li>';
					break;
				case 'select':
					let opts = ele.options.split(',');
					this.form += '<li><select name="'+ele.name+'" class="textstyle" '+disabled+'>';
					this.form += '<option value="">请选择'+ele.text+'</option>';
					if (opts.length > 0) {
						let _this = this;
						opts.forEach(function(e) {
							_this.form += '<option value="'+e+'">'+e+'</option>';
						});
					}
					this.form += '</select></li>';
					break;
			}
		},
		applyTo() {
			let _this = this;
			let sub = 1;
			$.each($('input'), function (inx, ele) {
				let obj = $(ele);
				let txt = obj.attr('placeholder');
				let val = $.trim(obj.val());
				let attr = obj.attr('name');
				switch (attr) {
					case 'name':
						if (val === '') {
							page.tip.show('姓名不能为空', 1000);
							sub = 0;
							return false;
						}
						break;
					case 'tel':
						if (val === '') {
							page.tip.show('手机号码不能为空', 1000);
							sub = 0;
							return false;
						}
						if (!val.match(/^1[3,4,5,7,8]\d{9}$/)) {
							page.tip.show('手机号码格式不正确', 1000);
							sub = 0;
							return false;
						}
						break;
					default:
						//
				}
				_this.post[txt] = val;
			});

			if (sub === 0) return false;

			$.each($('select'), function (inx, ele) {
				let obj = $(ele);
				let opt1 = $(obj.find('option')[0]);
				let txt = opt1.text().replace('请选择', '');
				_this.post[txt] = $(obj.find('option:checked')).val();
			});

			this.post['guid'] = page.getUrlParameterByName('guid');

			//提交给后端
			axios.post(_this.domain + '/activity/apply/save-info.html', qs.stringify({
				data: this.post
			}), {
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			})
				.then(function (response) {
					if (response.data.code < 0) {
						page.tip.show(response.data.data, 1000);
						return false;
					}
					_this.status = 1;
					page.tip.show('报名成功', 1000);
				})
				.catch(function (error) {
					console.log(error);
				});
		}
	}
}
</script>

