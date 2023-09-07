<template>
  <div class="main-box">
    <!--<div class="table-filter-inline">-->
      <!--<span class="filter-name">商品名称：</span>-->
      <!--<el-input v-model="listQuery.name"  clearable class="filter-item"  size="small" @input="getList"></el-input>-->
    <!--</div>-->
    <el-table border :data="list" row-key="id" :height="autoHeight"   v-loading="listLoading" >
      <el-table-column type="index" label="ID" align="center" width="45" ></el-table-column>
      <el-table-column prop="info.name" label="Name" :show-overflow-tooltip="true">
        <template slot-scope="scope">
          <span @click="toDetail(scope.row.info.id)" style="text-decoration:underline;color: var(--blue);cursor: pointer" v-if="scope.row.info.status == 1">{{scope.row.info.name}}</span>
          <span v-else-if="scope.row.info.status == 2" style="color: #aaa">{{scope.row.info.name}} (商品已下架)</span>
          <span v-else style="color: #aaa">{{scope.row.info.name}} (商品已出售)</span>
        </template>
      </el-table-column>
      <el-table-column prop="info.price" label="Price" width="150"></el-table-column>
      <el-table-column prop="create_time" label="Add time" width="200"></el-table-column>
      <el-table-column label="Operation" width="100">
        <template slot-scope="scope">
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)">Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import {getFavourite,delFavourite} from '@/api/home/home'
  export default {
    name: "Index",
    computed: {
      autoHeight() {
        return document.body.clientHeight - 130
      }
    },
    data() {
      return {
        listQuery:{
          name:''
        },
        list:[],
        listLoading: false,
      }
    },
    methods: {
      toDetail(id){
        // let routeUrl = this.$router.resolve({
        //   path: "/home/goodDetail",
        //   query: {id:id}
        // })
        // window.open(routeUrl.href, '_blank')
        this.$router.push({
          path: "/home/goodDetail",
          query: {id:id}
        })
      },
      async getList() {
        this.listLoading = true
        const list = await getFavourite(this.listQuery)
        this.list = list
        this.listLoading = false
      },
      handleDelete(id){
        this.$confirm('Confirm Delete?', 'Tip', {
          type: 'warning'
        }).then(() => {
          delFavourite({id:id})
            .then(res => {
              this.getList()
            })
            .catch(() => {
              return
            })
        }).catch(() => {
          return
        })
      },
    },
    mounted() {
      this.getList()
    }
  }
</script>
