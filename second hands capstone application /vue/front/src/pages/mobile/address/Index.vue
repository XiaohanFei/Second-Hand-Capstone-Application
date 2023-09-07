<template>
  <div>
    <div class="table-button-box">
      <el-button type="primary" icon="el-icon-plus" @click="handleAdd">Add</el-button>
    </div>
    <add-dialog :dialog="dialog" :dialogForm="dialogForm" @update="getList"></add-dialog>
    <el-table  :data="list" row-key="id"  border  size="mini" v-loading="listLoading">
      <el-table-column prop="name" label="Name" :show-overflow-tooltip="true" ></el-table-column>
      <el-table-column prop="mobile" label="Mobile"  :show-overflow-tooltip="true"></el-table-column>
      <el-table-column prop="address" label="Address"  :show-overflow-tooltip="true"></el-table-column>
      <el-table-column label="Operation" width="100px">
        <template slot-scope="scope">
          <el-button type="text" size="mini" @click="handleEdit(scope.row)">Edit</el-button>
          <el-button type="text" size="mini" style="color: var(--red)" @click="handleDelete(scope.row.id)">Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import {getAddress,delAddress} from '@/api/home/home'
  export default {
    name: "Index",
    computed: {
      autoHeight() {
        return document.body.clientHeight - 210
      }
    },
    components: {
      AddDialog: () => import('./AddDialog'),
    },
    data() {
      return {
        list: [],
        listLoading: false,
        dialog: {
          show: false,
          title: '',
          operation: ''
        },
        dialogForm: {},
      }
    },
    methods: {
      async getList() {
        this.listLoading = true
        const list = await getAddress()
        this.list = list
        this.listLoading = false
      },
      handleAdd(){
        this.dialogForm = {
          name:'',
          mobile:'',
          address:'',
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
          delAddress({id:id})
            .then(res => {
              this.getList()
            })
            .catch(() => {
              return
            })
        }).catch(() => {
          return
        })
      },
    },
    mounted() {
      this.getList()
    }
  }
</script>
