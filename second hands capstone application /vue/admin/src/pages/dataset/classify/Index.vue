<template>
  <el-card class="fullscreen admin-menu-container">
    <div class="table-button-box">
      <el-button type="primary" size="small" icon="el-icon-plus" @click="handleAdd(0)">Add</el-button>
    </div>
    <add-dialog :dialog="dialog" :dialogForm="dialogForm" :dialogSelection="list" @update="getList"></add-dialog>
    <el-table
            ref="sortableTable"
            :data="list"
            row-key="id"
            :height="autoHeight"
            :key="tableKey"
            border
            class="table-hover-show-operation"
            v-loading="listLoading"
            default-expand-all>
      <el-table-column label="Name" :show-overflow-tooltip="true">
        <template slot-scope="scope">
          {{scope.row.title}}
          <svg-icon class="title-icon" :icon-class="scope.row.icon" v-if="scope.row.icon"/>
        </template>
      </el-table-column>
      <el-table-column label="Create time" prop="create_time" :show-overflow-tooltip="true" width="250"></el-table-column>

      <el-table-column label="Operation" width="250"  class-name="operation-box">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleAdd(scope.row.id)" v-if="scope.row.pid == 0">Add sub</el-button>
          <el-button type="text" size="small" @click="handleEdit(scope.row)">Edit</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)">Delete</el-button>
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
  import { index , handleSort , del } from '@/api/dataset/classify'
  import { treeToList } from '@/utils/index'
  export default {
    name: "Index",
    components: {
      AddDialog: () => import('./AddDialog')
    },
    computed:{
      autoHeight() {
        return document.body.clientHeight - 202
      }
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
        }
        this.dialog = {
          title: 'Add',
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
