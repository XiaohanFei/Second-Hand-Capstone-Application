<template>
  <div class="main-box" style="background: white;box-shadow: 0 0px 6px 2px rgba(34, 39, 54, 0.15);padding: 20px;width: 800px;margin-top: 100px">
    <img :src="sourceUrl+info.avatar" style="width: 120px;height: 120px;border: 1px solid #ccc;padding: 3px;float: left">
    <div style="margin-left: 140px">
      <div style="font-size: 22px;line-height: 40px;border-bottom: 1px solid #ccc">{{info.nickname}}</div>
      <div style="line-height: 20px;font-size: 14px;color: #666;margin-top: 6px">Mobile：{{info.mobile}}</div>
      <div style="line-height: 20px;font-size: 14px;color: #666;margin-top: 6px">Student ID：{{info.sdu_num}}</div>
      <div style="line-height: 20px;font-size: 14px;color: #666;margin-top: 6px">Mailbox：{{info.email}}</div>
    </div>
  </div>
</template>

<script>
  import {getUserInfo} from '@/api/home/user'
  export default {
    name: "MainIndex",
    data() {
      return {
        info:{},
        sourceUrl:window.sourceUrl,
      }
    },
    methods: {},
    mounted() {
      getUserInfo({id:this.$route.query.id}).then(res=>{
        this.info = res
      }).catch(()=>{return})
    }
  }
</script>

<style lang="scss" scoped>

</style>