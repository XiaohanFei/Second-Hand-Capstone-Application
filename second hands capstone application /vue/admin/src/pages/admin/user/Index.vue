<template>
  <el-card class="fullscreen admin-user-container">
    <div class="table-button-box">
      <el-button class="filter-item" type="primary" size="small" icon="el-icon-plus" @click="handleAdd">添加</el-button>
      <el-button class="filter-item" type="danger" size="small" :disabled="multipleSelection.length ==  0" icon="el-icon-delete" @click="handleDelete">删除</el-button>
    </div>
    <div class="table-filter-inline">
      <span class="filter-name">账号/姓名：</span>
      <el-input v-model="listQuery.name"  clearable class="filter-item"  size="small" @input="handleFilter"></el-input>
    </div>
    <add-dialog :dialog="dialog" :dialogForm="dialogForm" :deptList="deptList" :roleList="roleList" @update="getList"></add-dialog>
    <el-table
      :data="list"
      :height="autoHeight"
      row-key="id"
      border
      stripe
      size="small"
      @selection-change="handleSelectionChange"
      v-loading="listLoading">
      <el-table-column type="selection" width="42" align="center"></el-table-column>
      <el-table-column type="index" label="ID" align="center" width="45" :index="tableIndex"></el-table-column>
      <el-table-column prop="username" label="登录账号"  :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="realname" label="用户姓名" width="180" :show-overflow-tooltip="true"></el-table-column>
      <!--<el-table-column prop="dept_name" label="部门" :show-overflow-tooltip="true"></el-table-column>-->
      <!--<el-table-column prop="role_name" label="角色" :show-overflow-tooltip="true"></el-table-column>-->
      <el-table-column prop="status" label="用户状态" width="80">
        <template slot-scope="scope">
          <el-tag :type="scope.row.status == 1?'primary':'danger'" size="small" effect="dark">
            {{scope.row.status == 1?'正常':'禁用'}}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column
        label="操作"
        width="150">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button type="text" size="small" @click="initPassword(scope.row)">重置密码</el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :total="listTotal" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @update='getList'></pagination>
  </el-card>
</template>

<script>
  import {index, edit,del} from '@/api/admin/user'
  export default {
    name: "Index",
    components: {
      Pagination: () => import('@/components/Pagination/Index'),
      AddDialog: () => import('./AddDialog'),
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
          dept: 1,
          name: ''
        },
        listTotal: 0,
        multipleSelection: [],
        dialog: {
          show: false,
          title: '',
          operation: ''
        },
        dialogForm: {},
        deptList:[],
        roleList:[],
      }
    },
    methods:{
      handleDelete(){
        this.$confirm('确定删除用户?', '提示', {
          type: 'warning'
        }).then(() => {
          const ids = []
          this.multipleSelection.filter(item => {
            ids.push(item.id)
          })
          del({ids:ids})
            .then(res => {
              this.initPage(res).then(() => {
                this.getList()
              })
            })
            .catch(() => {
              return
            })
        }).catch(() => {
          return
        })
      },
      handleFilter() {
        this.listQuery.page = 1
        this.getList()
      },
      handleEdit(data){
        this.dialog = {
          title: "编辑用户",
          operation: "edit",
          show: true
        }
        this.dialogForm = data
      },
      initPage(res) {
        return new Promise(resolve => {
          let total = this.listTotal - parseInt(res)
          if (total == 0) {
            this.listQuery.page = 1
          } else {
            let page = Math.ceil(total / this.listQuery.limit)
            this.listQuery.page = this.listQuery.page > page ? page : this.listQuery.page
          }
          resolve()
        })
      },
      handleSelectionChange(val) {
        this.multipleSelection = val
      },
      initPassword(data) {
        this.$confirm('初始密码为123456', '确定重置密码?', {
          type: 'warning'
        }).then(() => {
          data.password = '123456'
          edit(data)
            .then(res => {
              return
            })
            .catch(() => {
              return
            })
        }).catch(() => {
          return
        });
      },

      handleAdd(){
        this.dialog = {
          title: "添加用户",
          operation: "add",
          show: true
        }
        this.dialogForm = {
          username: '',
          realname: '',
          dept: 1,
          role: 1,
          status:1
        }
      },
      handleFilter(){
        this.listQuery.page = 1
        this.getList()
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
    },
    mounted() {
      this.getList()
    }
  }
</script>
