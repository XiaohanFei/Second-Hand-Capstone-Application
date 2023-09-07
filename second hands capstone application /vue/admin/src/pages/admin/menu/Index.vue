<template>
  <el-card class="fullscreen admin-menu-container">
    <div class="table-button-box">
      <el-button type="primary" size="small" icon="el-icon-plus" @click="handleAdd(0)">添加菜单</el-button>
    </div>
    <add-dialog :dialog="dialog" :dialogForm="dialogForm" :dialogSelection="list" @update="getList"></add-dialog>
    <detail-index :dialog="authDialog" @update="getList"></detail-index>
    <el-table
            ref="sortableTable"
            :data="list"
            row-key="id"
            height="calc(100vh - 202px)"
            :key="tableKey"
            border
            class="table-hover-show-operation"
            v-loading="listLoading"
            default-expand-all>
      <el-table-column label="名称" :show-overflow-tooltip="true" width="300">
        <template slot-scope="scope">
          {{scope.row.title}}
          <svg-icon class="title-icon" :icon-class="scope.row.icon" v-if="scope.row.icon"/>
        </template>
      </el-table-column>
      <el-table-column label="Component" prop="component" :show-overflow-tooltip="true" width="250"></el-table-column>
      <el-table-column label="权限" :show-overflow-tooltip="true">
        <template slot-scope="scope">
          {{scope.row.auth | getAuthName }}
        </template>
      </el-table-column>
      <el-table-column label="操作" width="250"  class-name="operation-box">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleAdd(scope.row.id)">添加子菜单</el-button>
          <el-button type="text" size="small" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button type="text" size="small" @click="handleCopy(scope.row)">复制</el-button>
          <el-button type="text" size="small" @click="handleAuth(scope.row.id)">权限</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>
      <el-table-column align="center" label="排序" width="80" class-name="drag-move">
        <template slot-scope="scope">
          <svg-icon class="drag-handler" icon-class="drag" />
        </template>
      </el-table-column>
    </el-table>
  </el-card>
</template>

<script>
  import Sortable from 'sortablejs'
  import { index , handleSort , del } from '@/api/admin/menu'
  import { treeToList } from '@/utils/index'
  export default {
    name: "Index",
    components: {
      AddDialog: () => import('./AddDialog'),
      DetailIndex: () => import('./Detail/Index'),
    },
    data() {
      return {
        list:[],
        tableKey:Math.random(),
        listLoading:false,
        activeRows:[],
        dialog: {
          show: false,
          title: '',
          operation: ''
        },
        dialogForm: {},
        authDialog:{
          show: false,
          id:0
        }
      }
    },
    methods:{
      handleAuth(id){
        this.authDialog={
          show: true,
          id:id
        }
      },
      handleCopy(data){
        this.dialogForm = JSON.parse(JSON.stringify(data))
        delete this.dialogForm.id
        if(this.dialogForm.hasOwnProperty('children')){
          delete this.dialogForm.children
        }
        this.dialogForm.title = this.dialogForm.title+'-副本'
        this.dialog = {
          title: '复制菜单',
          show: true,
          operation: 'add'
        }
      },
      handleAdd(pid){

        this.dialogForm = {
          type: 1,
          pid:pid,
          title: '',
          status: 1,
          component: '',
          icon:'',
          component_type:1
        }
        this.dialog = {
          title: '添加菜单',
          show: true,
          operation: 'add'
        }
      },
      handleEdit(data){
        this.dialogForm = JSON.parse(JSON.stringify(data))
        if(this.dialogForm.hasOwnProperty('children')){
          delete this.dialogForm.children
        }
        this.dialog = {
          title: '编辑',
          show: true,
          operation: 'edit'
        }
      },
      handleDelete(id){
        this.$confirm('确定删除?', '提示', {
          type: 'warning'
        }).then(() => {
          del({ids:[id]})
            .then(res => {
              this.$store.dispatch('system/setNavIndex',0)
              this.getList()
            })
            .catch(() => {
              return
            })
        }).catch(() => {
          return
        });
      },
      initSort () {
        this.$nextTick(() => {
          const el = this.$refs.sortableTable.$el.querySelector('.el-table__body-wrapper tbody')
          if (!el) { return }
          const that = this
          Sortable.create(el, {
            animation: 300,
            handle:".drag-move",
            ghostClass: 'sortable-ghost',
            onMove ({ dragged, related }) {
              const oldRow = that.activeRows[dragged.rowIndex]
              const newRow = that.activeRows[related.rowIndex]
              if (oldRow.pid !== newRow.pid) {
                //不能跨级拖拽
                return false
              }
            },
            onEnd ({ oldIndex, newIndex }) {
              const oldRow = that.activeRows[oldIndex] // 移动的那个元素
              const newRow = that.activeRows[newIndex] // 新的元素
              if ( oldIndex !== newIndex && oldRow.pid === newRow.pid) {
                var orginIds = []
                that.activeRows.filter(item=>{
                  orginIds.push(item.id)
                })
                let tempId = orginIds[oldIndex]
                orginIds.splice(oldIndex,1)
                orginIds.splice(newIndex,0,tempId)
                orginIds = orginIds.join(",")
                handleSort({ids:orginIds}).then(()=>{
                  that.getList()
                }).catch(()=>{return})
              }
            }
          })
        })
      },
      async getList(){
        this.listLoading = true
        const list = await index()
        this.list = list
        this.activeRows = treeToList(list)
        this.listLoading = false
        this.tableKey = Math.random()
        this.initSort()
      }
    },
    mounted(){
      this.getList()
    }
  }
</script>
