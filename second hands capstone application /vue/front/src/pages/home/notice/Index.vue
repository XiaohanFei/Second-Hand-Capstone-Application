<template>
  <div class="main-box" style="width: 1000px">
      <div style="text-align: center;padding: 10px 0;font-size: 24px;line-height: 1.5;font-weight: bold" v-html="info.title"></div>
    <div style="text-align: right;border-bottom: 1px solid #ccc;padding-bottom: 10px">{{info.update_time}}</div>
    <div v-html="info.content" style="font-size: 18px;line-height: 1.5"></div>
  </div>
</template>

<script>
  import {getNoticeDetail} from '@/api/home/home'
  export default {
    name: "Index",
    data() {
      return {
        info:{}
      }
    },
    methods: {},
    mounted() {
      getNoticeDetail({id:this.$route.query.id}).then((res=>{
        this.info = res
      })).catch(()=>{
        return
      })
    }
  }
</script>
