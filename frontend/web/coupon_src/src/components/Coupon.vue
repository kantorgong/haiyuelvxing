

<template>
  <yd-layout>
    <yd-navbar slot="navbar" title="NavBar">
      <router-link to="#" slot="left">
        <yd-navbar-back-icon></yd-navbar-back-icon>
      </router-link>
    </yd-navbar>

    <div>乱七八糟的内容在这里，超出容器，将出现滚动条。</div>
    <div>乱七八糟的内容在这里，超出容器，将出现滚动条。</div>
    <div>乱七八糟的内容在这里，超出容器，将出现滚动条。</div>

    <yd-tabbar slot="tabbar">
      <yd-tabbar-item title="首页" link="#" active>
        <yd-icon name="home" slot="icon"></yd-icon>
      </yd-tabbar-item>
      <yd-tabbar-item title="购物车" link="#">
        <yd-icon name="shopcart-outline" slot="icon"></yd-icon>
      </yd-tabbar-item>
      <yd-tabbar-item title="个人中心" link="#">
        <yd-icon name="ucenter-outline" slot="icon"></yd-icon>
      </yd-tabbar-item>
    </yd-tabbar>

  </yd-layout>
</template>
<script>
  export default {

  }
</script>
