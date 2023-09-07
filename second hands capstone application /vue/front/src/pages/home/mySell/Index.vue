<template>
  <div>
    <el-table  :data="list" row-key="id" :height="autoHeight" border  size="small" v-loading="listLoading">
      <el-table-column type="index" label="ID" align="center" width="45" ></el-table-column>
      <el-table-column prop="name" label="Name" :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="price" label="Price" :show-overflow-tooltip="true"  width="100"></el-table-column>
      <el-table-column prop="status_name" label="Status" width="100"></el-table-column>
      <el-table-column label="Operation">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleEdit(scope.row.id)" v-if="scope.row.status == 1||scope.row.status == 2">Edit</el-button>
          <el-button type="text" size="small" @click="handleInfo(scope.row.id)" v-if="scope.row.status > 2">Buyer information</el-button>
          <el-button type="text" size="small" @click="handleStatus(scope.row.id,4)" v-if="scope.row.status == 3">Deliver</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleStatus(scope.row.id,2)" v-if="scope.row.status == 1">Off the shelf</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleStatus(scope.row.id,1)" v-if="scope.row.status == 2">Put on the shelf</el-button>
        </template>
      </el-table-column>
    </el-table>
    <detail-dialog :dialog="dialog"></detail-dialog>
  </div>
</template>

<script>
  import {getMySell,statusGoods} from '@/api/home/home'
  export default {
    name: "Index",
    computed: {
      autoHeight() {
        return document.body.clientHeight - 170
      }
    },
    components: {
      DetailDialog: () => import('./Detail')
    },

    data() {
      return {
        list: [],
        listLoading: false,
        dialog: {
          show: false,
          id:0
        },
      }
    },
    methods: {
      handleInfo(id){
        this.dialog = {
          show:true,
          id:id
        }
      },
      async getList() {
        this.listLoading = true
        const list = await getMySell()
        this.list = list
        this.listLoading = false
      },
      handleStatus(id,status){
        this.$confirm('Confirm ?', 'Tip', {
          type: 'warning'
        }).then(() => {
          statusGoods({id:id,status:status})
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
      handleEdit(id){
        let routeUrl = this.$router.resolve({
          path: "/home/publishEdit",
          query: {id:id}
        })
        window.open(routeUrl.href, '_blank')
      }
    },
    mounted() {
      this.getList()
    }
  }
</script>
