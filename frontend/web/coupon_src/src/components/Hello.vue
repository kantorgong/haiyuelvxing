<template>
	<yd-list theme="3">
		<!-- 这里可选1/2/3/4/5五种样式 -->
		<yd-list-item v-for="item in list" :key="item.id">
			<img slot="img" :src="item.img">
			<span slot="title">{{item.title}}</span>
			<yd-list-other slot="other">
				<div>
					<span class="list-price"><em>¥</em>{{item.price}}</span>
					<span class="list-del-price">¥{{item.w_price}}</span>
				</div>
				<div>content</div>
			</yd-list-other>
		</yd-list-item>
	</yd-list>
</template>

<script>
	import Vue from 'vue';
	import {ListTheme, ListItem, ListOther} from 'vue-ydui/dist/lib.rem/list';

	Vue.component(ListTheme.name, ListTheme);
	Vue.component(ListItem.name, ListItem);
	Vue.component(ListOther.name, ListOther);
	export default {
		data() {
			return {
				list: [
					{id: 1, img: "//img1.shikee.com/try/2016/06/23/14381920926024616259.jpg", title: "标题111标题标题标题标题", price: 156.23, w_price: 89.36},
					{id: 2, img: "//img1.shikee.com/try/2016/06/21/10172020923917672923.jpg", title: "标题222标题标题标题标题", price: 256.23, w_price: 89.36},
					{id: 3, img: "//img1.shikee.com/try/2016/06/23/15395220917905380014.jpg", title: "标题333标题标题标题标题", price: 356.23, w_price: 89.36},
					{id: 4, img: "//img1.shikee.com/try/2016/06/25/14244120933639105658.jpg", title: "标题444标题标题标题标题", price: 456.23, w_price: 89.36},
					{id: 5, img: "//img1.shikee.com/try/2016/06/26/12365720933909085511.jpg", title: "标题555标题标题标题标题", price: 556.23, w_price: 89.36},
					{id: 6, img: "//img1.shikee.com/try/2016/06/19/09430120929215230041.jpg", title: "标题666标题标题标题标题", price: 656.23, w_price: 89.36}
				]
			}
		}
	}
</script>
