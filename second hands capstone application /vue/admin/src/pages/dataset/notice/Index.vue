<template>
  <el-card class="fullscreen">
    <div class="table-button-box">
      <el-button type="primary" size="small" icon="el-icon-plus" @click="handleAdd">Add</el-button>
    </div>
    <div class="table-filter-inline">
      <span class="filter-name">Title：</span>
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
      <el-table-column prop="title" label="Title" >
        <template slot-scope="scope">
         <span v-html="scope.row.title"></span>
        </template>
      </el-table-column>
      <el-table-column prop="update_time" label="Update time" width="200"></el-table-column>
      <el-table-column prop="status_name" label="Status" width="200"></el-table-column>
      <el-table-column
              label="Operation"
              width="150">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleEdit(scope.row)">Edit</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)">Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit"
                @update='getList'></pagination>
    <add-dialog :dialog="dialog" :dialogForm="dialogForm" @update="getList"></add-dialog>
  </el-card>
</template>

<script>
  import {index, del} from '@/api/dataset/notice'
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
          operation: ''
        },
        dialogForm: {},
      }
    },
    methods: {
      handleAdd(){
        this.dialogForm = {
          title:'',
          content:'',
          status:1
        }
        this.dialog = {
          title: 'Add',
          show: true,
          operation: 'add'
        }
      },
      handleEdit(data){
        this.dialogForm = JSON.parse(JSON.stringify(data))
        this.dialog = {
          title: 'Edit',
          show: true,
          operation: 'edit'
        }
      },
      handleDelete(id){
        this.$confirm('Confirm Delete?', 'Tip', {
          type: 'warning'
        }).then(() => {
          del({ids:[id]})
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
