<template>
	<div id="prize">
		<nav class="nav has-shadow">
			<div class="container is-primary">
				<div class="nav-center">
					<a class="nav-item" v-text="title"></a>
				</div>
			</div>
		</nav>
		<div class="card" v-if="name || avatar">
			<div class="card-content">
				<div class="media">
					<div class="media-left">
						<figure class="image is-48x48">
							<img :src="avatar" alt="Image">
						</figure>
					</div>
					<div class="media-content">
						<p class="title is-4" v-html="name"></p>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-content">
				<div class="content" v-if="prizeName">
					<p class="title is-5"><small>奖品名称：</small>{{prizeName}}</p>
				</div>
				<br>
				<div class="field has-addons" v-if="prizeName && !getTime">
					<p class="control">
						<input class="input" type="text" placeholder="领奖密码" v-model="pwd" minlength="4" maxlength="4">
					</p>
					<p class="control">
						<a class="button is-success" @click="getPrize">立即领奖</a>
					</p>
				</div>
				<div class="notification" style="text-align: center" v-if="status < 0" v-text="message"></div>
				<small v-if="getTime">领奖时间：{{getTime}}</small>
			</div>
		</div>
	</div>
</template>
<script>
	import 'bulma/css/bulma.css';
	import axios from 'axios'
	import qs from 'qs'

	export default {
		name: 'prize',
		data() {
			return {
				title:  '',
				avatar: '',
				name: '',
				prizeName: '',
				message: '',
				status: 0,
				getTime: '',
				pwd: ''
			};
		},
		beforeCreate() {
			document.title = '领取奖品';
		},
		created() {
			this.domain = 'http://' + window.location.hostname;
			this.guid = this.$route.params.id;

			this.initInfo();
		},
		methods: {
			initInfo() {
				let _this = this;
				let path = this.$route.path;

				//获取活动分组ID
				if (this.guid === null) {
					this.status = -1;
					this.message = '活动不存在';
					return false;
				}

				//请求活动数据
				axios.get(this.domain + '/activity/wheel/get-prize.html?guid=' + this.guid)
					.then(function (response) {
						if (response.data.code === -1) {
							_this.status = -1;
							_this.message = response.data.data;
							return false;
						}
						if (response.data.code === -2) {
							window.location.href = _this.domain + '/wechat/oauth/callback.html?path=' + encodeURIComponent('#' + path);
							return false;
						}
						if (response.data.code === 0) {
							_this.getTime = response.data.data.modify_time;
							_this.name = response.data.data.name;
							_this.avatar = response.data.data.avatar;
							_this.title = response.data.data.title;
							_this.prizeName = response.data.data.prizeName;
							if (_this.getTime) {
								_this.status = -1;
								_this.message = '奖品已领';
							}
						}
					})
					.catch(function (error) {
						console.log(error);
					});
			},
			getPrize() {
				let _this = this;
				let path = this.$route.path;

				if (this.pwd.length !== 4) {
					_this.status = -1;
					_this.message = '请输入四位领奖密码';
					return false;
				}

				//请求活动数据
				axios.post(this.domain + '/activity/wheel/get-prize.html?guid=' + this.guid, qs.stringify({
					pwd: this.pwd
				}), {
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				})
						.then(function (response) {
						if (response.data.code === -1) {
							_this.status = -1;
							_this.message = response.data.data;
							return false;
						}
						if (response.data.code === -2) {
							window.location.href = _this.domain + '/wechat/oauth/callback.html?path=' + encodeURIComponent('#' + path);
							return false;
						}
						if (response.data.code === 0) {
							_this.getTime = response.data.data.modify_time;
							if (_this.getTime) {
								_this.status = -1;
								_this.message = '奖品领取成功';
							}
						}
					})
					.catch(function (error) {
						console.log(error);
					});
			}
		}
	}
</script>