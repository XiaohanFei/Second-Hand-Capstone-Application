<template>
  <div class="side-bar">
    <el-menu>
      <side-bar-item v-for="(route,index) in displayRouter" :key="index" :item="route"></side-bar-item>
    </el-menu>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  export default {
    name: "SideBar",
    components: {
      SideBarItem :()=>import('./SideBarItem'),
    },
    computed: {
      ...mapGetters([
        'navIndex',
        'menu'
      ]),
      displayRouter(){
        if(this.menu.length){
          var temp = this.menu[this.navIndex]
          if(temp && temp.hasOwnProperty('children')){
            return temp.children
          }
        }
        return []

      }
    }

  }
</script>

