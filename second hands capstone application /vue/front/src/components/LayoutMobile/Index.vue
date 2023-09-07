<template>
  <div class="mobile-app">
    <div class="navbar">Second Hand Campus Trading Platform</div>
    <div  class="mobile-main">
      <transition name="fade-transform" mode="out-in">
        <router-view :key="key"></router-view>
      </transition>
    </div>
    <wd-tabbar  fixed border active-color="rgba(75, 190, 216, 0.8)" inactive-color="#333">
      <wd-tabbar-item icon="wd-icon-setting" to="/mobile/index">Home</wd-tabbar-item>
      <wd-tabbar-item icon="wd-icon-setting" to="/mobile/chat">Chat</wd-tabbar-item>
      <wd-tabbar-item icon="wd-icon-setting" to="/mobile/cart">Cart</wd-tabbar-item>
      <wd-tabbar-item icon="wd-icon-setting" to="/mobile/person">Mine</wd-tabbar-item>
    </wd-tabbar>
  </div>
</template>

<script>
  export default {
    name: "MainIndex",
    computed: {
      key() {
        return this.$route.path
      },
    },
    data() {
      return {
        tabbar:0
      }
    },
    methods: {},
    mounted() {
    }
  }
</script>
