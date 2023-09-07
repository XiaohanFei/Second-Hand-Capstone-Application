<template>
  <div class="top-bar">
    <div class="top-bar-box">
      <div class="title">
        <div>Second Hand</div>
        <div>Campus Trading Platform</div>
      </div>
      <div class="menu">
        <div class="menu-item" @click="toUrl('/')">Home</div>
        <template v-if="hasToken">
          <div class="menu-item" @click="toUrl('/home/chat')">Chat</div>
          <div class="menu-item" @click="toUrl('/home/publish')">Publish</div>
          <div class="menu-item" @click="toUrl('/home/cart')">Cart</div>
          <div class="menu-item" @click="toUrl('/home/favourite')">Favorite</div>
          <div class="menu-item" @click="toUrl('/home/person')">Personal Center</div>
        </template>
      </div>
      <div class="name-box">
        <template v-if="hasToken">
          <span class="user-name">{{realname}}</span>
          <el-tooltip class="item" effect="light" content="Log out" placement="bottom-end">
            <el-button icon="el-icon-switch-button" @click="logout"></el-button>
          </el-tooltip>
        </template>
        <span class="user-name" v-else @click="toUrl('/login')" style="border: 1px solid white;padding: 5px 10px;border-radius: 5px">Register / Login</span>
      </div>
    </div>
  </div>
</template>

<script>
  import { getToken } from '@/utils/auth'
  import {mapGetters} from 'vuex'

  export default {
    computed: {
      ...mapGetters([
        'realname',
      ]),
    },
    name: "TopBar",
    data() {
      return {
        hasToken:getToken()
      }
    },
    methods: {
      toUrl(url){
        this.$router.push(url)
      },
      logout() {
        this.$store.dispatch('user/logout').then(()=>{
          this.$router.push('/login')
        })
      }
    },
    mounted(){

    }
  }
</script>


