<template>
  <el-card class="fullscreen">
    <div class="table-filter-inline">
      <span class="filter-name">Mobile/Name：</span>
      <el-input v-model="listQuery.name" clearable class="filter-item" size="small" @input="handleFilter"></el-input>
    </div>
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
      <el-table-column prop="mobile" label="Mobile" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="sdu_num" label="Student ID" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="nickname" label="Name" :show-overflow-tooltip="true"></el-table-column>

      <el-table-column prop="email" label="E-mail" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="money" label="Balance"></el-table-column>
      <el-table-column prop="score" label="Score"></el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList'></pagination>
  </el-card>
</template>

<script>
  import {index} from '@/api/dataset/user'
  export default {
    name: "Index",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
    },
    computed: {
      autoHeight() {
        return document.body.clientHeight - 249
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
