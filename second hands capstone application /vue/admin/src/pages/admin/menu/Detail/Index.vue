<template>
  <el-dialog title="权限列表" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="800px" class="no-padding-dialog">
    <div slot="title">
      <el-button type="primary" size="small" icon="el-icon-plus" plain @click="handleAdd">添加权限</el-button>
    </div>
    <add-dialog :dialog="authDialog" :dialogForm="authDialogForm" @update="getList"></add-dialog>
    <el-table :data="list" row-key="id" :height="500"  v-loading="listLoading" border style="margin-top: -1px">
      <el-table-column label="名称" align="center" width="200" prop="title" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column label="组件" align="center" prop="component" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column label="操作" width="200" align="center">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button type="text" size="small" @click="handleCopy(scope.row)">复制</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
  </el-dialog>
</template>

<script>
  import { getChilren , del } from '@/api/admin/menu'
  export default {
    name: "AuthTable",
    data() {
      return {
        list:[],
        listLoading:false,
        authDialog: {
          show: false,
          title: '',
          operation: ''
        },
        authDialogForm: {},
      }
    },
    components: {
      AddDialog: () => import('./AddDialog'),
    },
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.getList()
        }else{
          this.$emit('update')
        }
      }
    },
    props: {
      dialog: Object
    },
    methods:{
      handleAdd(){
        this.authDialogForm = {
          type: 2,
          pid:this.dialog.id,
          title: '',
          status: 1,
          component: '',
          component_type:1
        }
        this.authDialog = {
          title: '添加权限',
          show: true,
          operation: 'add'
        }
      },
      handleEdit(data){
        this.authDialogForm = JSON.parse(JSON.stringify(data))
        this.authDialog = {
          title: '编辑权限',
          show: true,
          operation: 'edit'
        }
      },
      handleCopy(data){
        this.authDialogForm = JSON.parse(JSON.stringify(data))
        delete this.authDialogForm.id
        this.authDialogForm.title = this.authDialogForm.title+'-副本'
        this.authDialog = {
          title: '复制权限',
          show: true,
          operation: 'add'
        }
      },
      async getList(){
        this.listLoading = true
        const list = await getChilren({pid:this.dialog.id})
        this.list = list
        this.listLoading = false
      },
      handleDelete(id){
        this.$confirm('确定删除?', '提示', {
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
    }
  }
</script>
