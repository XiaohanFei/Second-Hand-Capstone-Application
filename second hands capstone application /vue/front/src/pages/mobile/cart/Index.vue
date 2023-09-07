<template>
  <div class="main-box" style="padding: 10px">
    <!--<div class="table-filter-inline">-->
    <!--<span class="filter-name">商品名称：</span>-->
    <!--<el-input v-model="listQuery.name"  clearable class="filter-item"  size="small" @input="getList"></el-input>-->
    <!--</div>-->
    <div class="table-button-box">
      <el-button  type="danger" icon="el-icon-goods" :disabled="multipleSelection.length ==  0" @click="handleMultiBuy" size="mini">
        Buy
      </el-button>
    </div>
    <el-table  :data="list" row-key="id" border size="mini" v-loading="listLoading" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="42" align="center" :selectable="canSelect"></el-table-column>
      <el-table-column prop="info.name" label="Name" :show-overflow-tooltip="true">
        <template slot-scope="scope">
          <span @click="toDetail(scope.row.info.id)" style="text-decoration:underline;color: var(--blue);cursor: pointer" v-if="scope.row.info.status == 1">{{scope.row.info.name}}</span>
          <span v-else-if="scope.row.info.status == 2" style="color: #aaa">{{scope.row.info.name}} (商品已下架)</span>
          <span v-else style="color: #aaa">{{scope.row.info.name}} (商品已出售)</span>
        </template>
      </el-table-column>
      <el-table-column prop="info.price" label="Price"></el-table-column>
      <el-table-column prop="create_time" label="Add time"  width="150"></el-table-column>
      <el-table-column label="Operation" widht="30">
        <template slot-scope="scope">
          <el-button type="text" size="mini" style="color: var(--red)" @click="handleDelete(scope.row.id)">Delete</el-button>
        </template>
      </el-table-column>

    </el-table>
    <order :dialog="dialog"></order>
  </div>
</template>

<script>
  import {getCart,delCart} from '@/api/home/home'
  export default {
    name: "Index",
    computed: {
      autoHeight() {
        return document.body.clientHeight - 190
      }
    },
    components: {
      Order: () => import('@/components/Order/Mobile'),
    },
    data() {
      return {
        listQuery:{
          name:''
        },
        list:[],
        listLoading: false,
        multipleSelection:[],
        dialog:{
          show:false,
          id:[]
        }
      }
    },
    methods: {
      handleSelectionChange(val) {
        this.multipleSelection = val
      },
      handleMultiBuy(){
        const ids = []
        this.multipleSelection.filter(item => {
          ids.push(item.info.id)
        })
        this.dialog = {
          show:true,
          id:ids
        }
      },
      canSelect(row, index){
        return row.info.status == 1?true:false
      },
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
        const list = await getCart(this.listQuery)
        this.list = list
        this.listLoading = false
      },
      handleDelete(id){
        this.$confirm('Confirm Delete?', 'Tip', {
          type: 'warning'
        }).then(() => {
          delCart({id:id})
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
