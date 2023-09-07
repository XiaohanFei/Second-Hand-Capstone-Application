<template>
  <div>
    <el-table  :data="list" row-key="id"  border  size="mini" v-loading="listLoading">
      <el-table-column type="index" label="ID" align="center" width="45" ></el-table-column>
      <el-table-column prop="order_id" label="Order number" :show-overflow-tooltip="true"  width="150"></el-table-column>
      <el-table-column prop="info.name" label="Name" :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="info.price" label="Price" :show-overflow-tooltip="true"  width="100"></el-table-column>
      <!--<el-table-column prop="mobile" label="手机号" width="200"></el-table-column>-->
      <el-table-column prop="address" label="Address" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="status_name" label="Status" width="100"></el-table-column>
    </el-table>
  </div>
</template>

<script>
  import {getMyBug} from '@/api/home/home'
  export default {
    name: "Index",
    computed: {
      autoHeight() {
        return document.body.clientHeight - 170
      }
    },

    data() {
      return {
        list: [],
        listLoading: false,

      }
    },
    methods: {
      async getList() {
        this.listLoading = true
        const list = await getMyBug()
        this.list = list
        this.listLoading = false
      },
    },
    mounted() {
      this.getList()
    }
  }
</script>
