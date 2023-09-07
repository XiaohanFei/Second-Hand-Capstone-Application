<template>
  <div class="top-bar">
    <div class="logo-title" ref="logo-title">
      <img :src="sourceUrl+logo" class="logo"/>
      <div class="title" :class="subTitle?'sub-title':''">
        <div>{{title}}</div>
        <div v-if="subTitle">{{subTitle}}</div>
      </div>
    </div>

    <div class="nav-main">
      <canvas id="canvas-menu" ref="canvas-menu"></canvas>
      <span class="nav-span" v-for="(item,index) in userMenu">
        <a class="nav-link" :class="navIndex == index ?'nav-active':''" @click="change(index)">{{item}}</a>
      </span>
    </div>

    <div class="name-box">
      <el-avatar :size="30" :src="sourceUrl+ avatar"></el-avatar>
      <span class="user-name">{{realname}}</span>
      <el-tooltip class="item" effect="light" content="Personal Center" placement="bottom-end">
        <el-button icon="el-icon-user-solid" @click="toPerson"></el-button>
      </el-tooltip>
      <el-tooltip class="item" effect="light" content="Log out" placement="bottom-end">
        <el-button icon="el-icon-switch-button" @click="logout"></el-button>
      </el-tooltip>
    </div>
  </div>
</template>

<script>
  import {init,toggle} from '@/utils/menu'
  import {mapGetters} from 'vuex'

  export default {
    computed: {
      ...mapGetters([
        'title',
        'logo',
        'avatar',
        'realname',
        'sidebar',
        'navIndex',
        'menu',
        'subTitle'
      ]),
      userMenu(){
        let menu = []
        menu = this.menu.map(item=>{
          return item.name
        })
        return menu
      }
    },
    name: "TopBar",
    data() {
      return {
        sourceUrl:window.sourceUrl
      }
    },
    methods: {
      toPerson(){
        this.$router.push('/person/index')
      },
      change(index){
        var temp = this.menu[index]
        if(temp.component_type == 2){
          window.open(temp.component,'_blank')
        }else{
          this.$store.dispatch('system/setNavIndex',index)
          toggle(index)
          if(temp.path.length){
            this.$store.dispatch('system/setNavId',temp.id)
            this.$router.push('/page/'+temp.path)
          }
        }

      },
      logout() {
        this.$store.dispatch('user/logout').then(()=>{
          this.$router.push('/login')
        })
      }
    },
    mounted(){
      init(this.$refs['canvas-menu'],this.$refs['logo-title'].clientWidth)
      this.change(this.navIndex)
    }
  }
</script>


