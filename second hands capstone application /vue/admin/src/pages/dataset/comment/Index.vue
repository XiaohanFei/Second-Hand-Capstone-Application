<template>
  <el-card class="fullscreen">
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
      <el-table-column prop="info.name" label="Product name"  :show-overflow-tooltip="true"> </el-table-column>
      <el-table-column prop="info.price" label="Product price" width="100"></el-table-column>
      <el-table-column prop="content" :show-overflow-tooltip="true" label="Message"></el-table-column>
      <el-table-column prop="reply" :show-overflow-tooltip="true" label="Reply"></el-table-column>
      <el-table-column prop="update_time" label="Update time" width="150"></el-table-column>
      <el-table-column
              label="Operation"
              width="100">
        <template slot-scope="scope">
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)" >Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList'></pagination>
  </el-card>
</template>

<script>
  import {index, del} from '@/api/dataset/comment'
  export default {
    name: "Index",
    components: {
      Pagination: () => import('@/components/Pagination/Index')
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
        multipleSelection: [],
        dialog: {
          show: false,
          title: '',
          id: 0
        },
      }
    },
    methods: {
      handleEdit(id){
        this.dialog = {
          title: '编辑',
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
