<template>
  <el-card class="fullscreen">
    <!--<div class="table-filter-inline">-->
      <!--<span class="filter-name">商品名称：</span>-->
      <!--<el-input v-model="listQuery.name" clearable class="filter-item" size="small" @input="handleFilter"></el-input>-->
    <!--</div>-->
    <el-table
            stripe
            :data="list"
            row-key="id"
            :height="autoHeight"
            border
            stripe
            size="small"
            v-loading="listLoading">
      <el-table-column type="index" label="ID" align="center" width="45" :index="tableIndex"></el-table-column>
      <el-table-column prop="order_id" label="Order number" width="150"></el-table-column>
      <el-table-column prop="info.name" label="Product name"  :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="info.price" label="Product price" width="100"></el-table-column>

      <el-table-column prop="user.mobile" label="Buyer account" :show-overflow-tooltip="true"  width="150"></el-table-column>
      <el-table-column prop="user.nickname" label="Buyer name" :show-overflow-tooltip="true"  width="150"></el-table-column>
      <el-table-column prop="owner.mobile" label="Seller account" :show-overflow-tooltip="true"  width="150"></el-table-column>
      <el-table-column prop="owner.nickname" label="Seller name" :show-overflow-tooltip="true"  width="150"></el-table-column>
      <el-table-column prop="address" label="Shipping address" :show-overflow-tooltip="true" ></el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList'></pagination>
  </el-card>
</template>

<script>
  import {index} from '@/api/dataset/order'
  export default {
    name: "Index",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
    },
    computed: {
      autoHeight() {
        return document.body.clientHeight - 210
      }
    },
    data() {
      return {
        list: [],
        listLoading: true,
        listQuery: {
          page: 1,
          limit: 20,
          name: '',
        },
        listTotal: 0,

      }
    },
    methods: {

      tableIndex(index) {
        let {page, limit} = this.listQuery
        return (page - 1) * limit + index + 1
      },
      async getList() {
        this.listLoading = true
        const {list, total} = await index(this.listQuery)
        this.list = list
        this.listTotal = total
        this.listLoading = false
      },

      handleFilter() {
        this.listQuery.page = 1
        this.getList()
      },


    },
    mounted() {
      this.getList()
    }
  }
</script>
