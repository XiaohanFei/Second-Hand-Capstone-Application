<template>
  <div class="app-container" :class="noMenu?'no-menu':''">
    <div class="main-container">
      <div  class="app-main">
        <transition name="fade-transform" mode="out-in">
          <router-view :key="key"></router-view>
        </transition>
      </div>
    </div>
    <top-bar></top-bar>
    <side-bar></side-bar>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  export default {
    computed: {
      ...mapGetters([
        'navIndex',
        'menu'
      ]),
      key() {
        return this.$route.path
      },
      noMenu(){
        if(this.menu.length){
          var temp = this.menu[this.navIndex]
          if(temp && temp.path.length>0){
            return true
          }
        }
        return false
      }
    },
    components: {
      TopBar:()=>import('./TopBar'),
      SideBar :()=>import('./SideBar/Index')

    },
    name: "AppContainer",
  }
</script>

