<template>
  <el-dialog title="List" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="1000px" class="no-padding-dialog">
    <el-table
            :data="list"
            row-key="id"
            height="500"
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
              width="80">
        <template slot-scope="scope">
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)" >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList' style="padding:0 0 10px 20px"></pagination>
  </el-dialog>
</template>

<script>
  import {index, del} from '@/api/dataset/chat'
  export default {
    name: "MainIndex",
    data() {
      return {
        list: [],
        listLoading: true,
        listQuery: {
          page: 1,
          limit: 20,
          pid:0
        },
        listTotal: 0
      }
    },
    components: {
      Pagination: () => import('@/components/Pagination/Index')
    },
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.listQuery.page = 1
          this.listQuery.pid = this.dialog.id
          this.getList()
        }
      }
    },
    props: {
      dialog: Object
    },
    methods: {
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
    }
  }
</script>

