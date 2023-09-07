<template>
  <el-card class="fullscreen">
    <el-table
            :data="list"
            row-key="id"
            :height="autoHeight"
            border
            size="small"
            v-loading="listLoading">
      <el-table-column type="index" label="ID" align="center" width="45" :index="tableIndex"></el-table-column>
      <el-table-column prop="content" :show-overflow-tooltip="true" label="Content"></el-table-column>
      <el-table-column prop="mobile" :show-overflow-tooltip="true" label="Account" width="150"></el-table-column>
      <el-table-column prop="nickname" :show-overflow-tooltip="true" label="Name" width="150"></el-table-column>
      <el-table-column prop="create_time" label="Create time" width="150"></el-table-column>
      <el-table-column
              label="Operation"
              width="150">
        <template slot-scope="scope">
          <el-button type="text" size="small"  @click="handleDetail(scope.row.id)" >View reply</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)" >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
    <add-dialog :dialog="dialog"></add-dialog>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList'></pagination>
  </el-card>
</template>

<script>
  import {index, del} from '@/api/dataset/chat'
  export default {
    name: "Index",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
      AddDialog: () => import('./AddDialog'),
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
          pid:0
        },
        listTotal: 0,
        dialog: {
          show: false,
          id: 0
        },
      }
    },
    methods: {
      handleDetail(id){
        this.dialog = {
          show: true,
          id:id
        }
      },
      handleDelete(id){
        this.$confirm('Confirm Delete?', 'Tip', {
          type: 'warning'
        }).then(() => {
          del({id:id})
            .then(res => {
              this.getList()
            })
            .catch(() => {
              return
            })
        }).catch(() => {
          return
        });
      },
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
