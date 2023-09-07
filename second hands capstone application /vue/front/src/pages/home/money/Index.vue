<template>
  <div style="display: flex;flex-direction: row">
    <el-input  v-model="money" readonly style="flex: 1;margin-right: 20px"></el-input>
    <el-button type="primary" icon="el-icon-add" @click="handleMoney">Recharge</el-button>
  </div>
</template>

<script>
  import {getMoney,addMoney} from '@/api/home/home'
  export default {
    name: "Index",
    data() {
      return {
        money:0
      }
    },
    methods: {
      handleMoney(){
        this.$prompt('Please enter the recharge amount', 'Tip', {
          inputPattern:/^\d+(\.\d+)?$/,
          inputErrorMessage: 'Please enter the recharge amount'
        }).then(({ value }) => {
          if(value.length){
            addMoney({money:value}).then(()=>{
              this.initMoney()
            }).catch(()=>{return})
          }else{
            return
          }
        }).catch(() => {
          return
        })
      },
      initMoney(){
        getMoney().then((res)=>{
          this.money = res
        })
      }
    },
    mounted() {
      this.initMoney()
    }
  }
</script>
