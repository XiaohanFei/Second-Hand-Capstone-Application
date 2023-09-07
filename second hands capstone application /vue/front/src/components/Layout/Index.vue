<template>
  <div class="app-container">
    <!--<div class="nectar-video-wrap">-->
      <!--<div class="nectar-video-inner">-->
        <!--<video class="banner-video" width="100%" loop="" autoplay="" muted="" preload="auto">-->
          <!--<source :src="videoUrl" type="video/mp4">-->
        <!--</video>-->
      <!--</div>-->
    <!--</div>-->
    <div class="main-container">
      <div  class="app-main">
        <transition name="fade-transform" mode="out-in">
          <router-view :key="key"></router-view>
        </transition>
      </div>
    </div>
    <top-bar></top-bar>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  export default {
    computed: {
      key() {
        return this.$route.path
      },
    },
    data() {
      return {
        videoUrl:require('@/assets/images/bg2.mp4'),
      }
    },
    components: {
      TopBar:()=>import('./TopBar'),
    },
    name: "AppContainer",
  }
</script>

