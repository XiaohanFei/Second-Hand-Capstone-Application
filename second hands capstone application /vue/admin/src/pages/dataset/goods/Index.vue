<template>
  <el-card class="fullscreen">
    <div class="table-filter-inline">
      <span class="filter-name">Name：</span>
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
      <el-table-column prop="name" label="Name" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="price" label="Price" width="100" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="classify_name" label="Classification"></el-table-column>
      <el-table-column prop="user.mobile" label="Seller account" width="150" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="user.nickname" label="Seller name" width="150" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="view" label="View" width="100"></el-table-column>
      <el-table-column prop="status_name" label="Status" width="120"></el-table-column>
      <el-table-column
              label="Operation"
              width="150">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleEdit(scope.row.id)" v-if="scope.row.status == 1">Edit</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)" v-if="scope.row.status == 1">Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList'></pagination>
    <add-dialog :dialog="dialog"  @update="getList"></add-dialog>
  </el-card>
</template>

<script>
  import {index, del} from '@/api/dataset/goods'
  export default {
    name: "Index",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
      AddDialog: () => import('./AddDialog')
    },
    computed: {
      autoHeight() {
        return document.body.clientHeight - 250
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
          title: 'Edit',
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
