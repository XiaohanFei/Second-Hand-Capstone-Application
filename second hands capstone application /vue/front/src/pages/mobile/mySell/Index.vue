<template>
  <div>
    <el-table  :data="list" row-key="id" border  size="mini" v-loading="listLoading">
      <el-table-column type="index" label="ID" align="center" width="40" ></el-table-column>
      <el-table-column prop="name" label="Name" :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="price" label="Price" :show-overflow-tooltip="true"  width="100"></el-table-column>
      <el-table-column prop="status_name" label="Status" width="100"></el-table-column>
      <el-table-column label="Operation" width="200" >
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleEdit(scope.row.id)" v-if="scope.row.status == 1||scope.row.status == 2">Edit</el-button>
          <el-button type="text" size="small" @click="handleInfo(scope.row.id)" v-if="scope.row.status > 2">Buyer information</el-button>
          <el-button type="text" size="small" @click="handleStatus(scope.row.id,4)" v-if="scope.row.status == 3">Deliver</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleStatus(scope.row.id,2)" v-if="scope.row.status == 1">Off the shelf</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleStatus(scope.row.id,1)" v-if="scope.row.status == 2">Put on the shelf</el-button>
        </template>
      </el-table-column>
    </el-table>
    <!--<detail-dialog :dialog="dialog"></detail-dialog>-->
    <wd-icon name="add" class="add-button" @click.native="handleAdd"></wd-icon>
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
      handleAdd(){
        this.$router.push({
          path: "/mobile/publish"
        })
      },
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
        this.$router.push({
          path: "/mobile/publishEdit",
          query: {id:id}
        })
      }
    },
    mounted() {
      this.getList()
    }
  }
</script>
