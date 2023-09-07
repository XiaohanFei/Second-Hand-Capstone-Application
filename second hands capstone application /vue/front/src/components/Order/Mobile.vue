<template>
  <el-dialog title="Purchase settlement" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="900px" class="mobile-order-dialog" :top="'60px'">
    <div>
      <div style="border-left: 4px solid var(--blue);padding-left: 10px;margin-bottom: 10px">Receiving address</div>
      <el-radio-group v-model="form.address">
        <el-radio :label="item.name+'--'+item.mobile+'--'+item.address" v-for="item in addressList" :key="this">{{item.name}}--{{item.mobile}}--{{item.address}}</el-radio>
      </el-radio-group>
      <div style="border-left: 4px solid var(--blue);padding-left: 10px;margin-bottom: 10px;margin-top: 10px">Product list</div>
      <el-table  :data="list" row-key="id" :height="300" size="mini">
        <el-table-column type="index" label="ID" align="center" width="40" ></el-table-column>
        <el-table-column prop="name" label="Name" :show-overflow-tooltip="true">
        </el-table-column>
        <el-table-column prop="price" label="Price" :show-overflow-tooltip="true" width="80"></el-table-column>
      </el-table>
    </div>
    <div slot="footer">
      <el-button @click="dialogClose">Close</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">Buy</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {getAddress,getOrderList,addOrder} from '@/api/home/home'
  export default {
    name: "Index",
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.getAddressList()
          this.getOrder()
        }
      }
    },
    props: {
      dialog: Object
    },
    data() {
      return {
        addressList:[],
        list:[],
        loading:false,
        form:{
          address:''
        }
      }
    },
    methods: {
      dialogClose() {
        this.dialog.show = false
      },
      submitForm() {
        addOrder({address:this.form.address,ids:this.dialog.id})
          .then(res => {
            this.loading = false
            this.dialogClose()
            this.$router.push({path: '/mobile/person'})
          })
          .catch(() => {
            this.loading = false
          })
      },
      async getAddressList() {
        this.addressList = await getAddress()
      },
      async getOrder(){
        this.list =await getOrderList({ids:this.dialog.id})
      }
    },

  }
</script>
