<template>
  <el-card class="fullscreen" >
    <div class="table-button-box">
      <el-button class="filter-item" type="primary" size="small" icon="el-icon-plus" @click="handleAdd">添加</el-button>
    </div>
    <add-dialog :dialog="dialog" :dialogForm="dialogForm"  @update="getList"></add-dialog>
    <el-table ref="sortableTable" :data="list" row-key="id"
              height="calc(100vh - 201px)" :key="tableKey" border size="small"
        class="table-hover-show-operation" v-loading="listLoading">
      <el-table-column label="名称" prop="name" :show-overflow-tooltip="true"></el-table-column>
      <el-table-column label="操作" width="150" class-name="operation-box">
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button type="text" size="small" style="color: var(--red)" @click="handleDelete(scope.row.id)" v-if="scope.row.id > 1">删除</el-button>
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
  import {index,del,handleSort} from '@/api/admin/carousel'
  export default {
    name: "Index",
    components: {
      AddDialog: () => import('./AddDialog')
    },
    props: {
      deptList: Array
    },
    data() {
      return {
        list:[],
        tableKey:Math.random(),
        listLoading:false,
        dialog: {
          show: false,
          title: '',
          operation: ''
        },
        dialogForm: {},
        menuList:[],
      }
    },
    methods:{
      initSort () {
        this.$nextTick(() => {
          const el = this.$refs.sortableTable.$el.querySelector('.el-table__body-wrapper tbody')
          if (!el) { return }
          const that = this
          Sortable.create(el, {
            animation: 300,
            handle:".drag-move",
            ghostClass: 'sortable-ghost',
            onEnd ({ oldIndex, newIndex }) {
              const oldRow = that.list[oldIndex] // 移动的那个元素
              const newRow = that.list[newIndex] // 新的元素
              if ( oldIndex !== newIndex) {
                var orginIds = []
                that.list.filter(item=>{
                  orginIds.push(item.id)
                })
                orginIds[newIndex] = orginIds.splice(oldIndex, 1, orginIds[newIndex])[0]
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
        const { list } = await index()
        this.list = list
        this.listLoading = false
        this.tableKey = Math.random()
        this.initSort()
      },
      handleAdd(){
        this.dialogForm = {
          path:''
        }
        this.dialog = {
          title: '添加',
          show: true,
          operation: 'add'
        }
      },
      handleEdit(data){
        this.dialogForm = JSON.parse(JSON.stringify(data))
        this.dialog = {
          title: '编辑',
          show: true,
          operation: 'edit'
        }
      },
      handleCopy(data){
        this.dialogForm = JSON.parse(JSON.stringify(data))
        delete this.dialogForm.id
        this.dialogForm.name = this.dialogForm.name+'-副本'
        this.dialog = {
          title: '复制',
          show: true,
          operation: 'add'
        }
      },
      handleDelete(id){
        this.$confirm('确定删除', '确定删除?', {
          type: 'warning'
        }).then(() => {
          del({ids:[id]})
            .then(() => {
              this.getList()
            })
            .catch(() => {
              return
            })
        }).catch(() => {
          return
        });
      },
    },
    mounted(){
      this.getList()
    }
  }
</script>
