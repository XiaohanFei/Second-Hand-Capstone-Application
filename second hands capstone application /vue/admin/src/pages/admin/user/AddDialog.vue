<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show"  :close-on-click-modal="false"
             width="900px"  class="admin-user-dialog">
    <el-form ref="form" :model="form" label-width="80px" :rules="rules">
      <el-row :gutter="10">
        <el-col :span="24">
          <el-form-item label="登录账号" prop="username">
            <el-input v-model.trim="form.username"></el-input>
          </el-form-item>
          <el-form-item label="用户姓名" prop="realname">
            <el-input v-model.trim="form.realname"></el-input>
          </el-form-item>
          <el-form-item label="用户状态">
            <el-radio-group v-model="form.status" size="small">
              <el-radio-button :label="1">启用</el-radio-button>
              <el-radio-button :label="2">禁用</el-radio-button>
            </el-radio-group>
          </el-form-item>
        </el-col>
        <!--<el-col :span="8">-->
          <!--<div class="title-block">部门</div>-->
          <!--<el-tree-->
            <!--ref="dept_auth_tree"-->
            <!--class="dept_auth_tree"-->
            <!--:data="deptList"-->
            <!--default-expand-all-->
            <!--node-key="id"-->
            <!--check-strictly-->
            <!--@check-change="handleCheck"-->
            <!--:props="{label: 'name'}"-->
            <!--show-checkbox>-->
          <!--</el-tree>-->
        <!--</el-col>-->
        <!--<el-col :span="8">-->
          <!--<div class="title-block">角色</div>-->
          <!--<el-radio-group v-model="form.role" class="rule-radio">-->
            <!--<el-radio :label="item.id" v-for="(item,index) in roleList" :key="index">{{item.name}}</el-radio>-->
          <!--</el-radio-group>-->
        <!--</el-col>-->
      </el-row>

    </el-form>
    <div slot="footer" class="dialog-footer">
      <el-button @click="dialogClose">关 闭</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {add, edit} from '@/api/admin/user'

  export default {
    data() {
      return {
        rules: {
          username: [
            {required: true, message: '请输入登录账号', trigger: 'blur'}
          ],
          realname: [
            {required: true, message: '请输入用户姓名', trigger: 'blur'}
          ]
        },
        loading: false,
        form: {},
      }
    },
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.$nextTick(() => {
            this.form = Object.assign({}, this.dialogForm)
            this.$refs['form'].clearValidate()
            this.$refs['dept_auth_tree'].setCheckedKeys([this.form.dept])
          })
        }
      }
    },
    props: {
      dialog: Object,
      dialogForm: Object,
      deptList: Array,
      roleList: Array,
    },
    methods: {
      handleCheck(nodeKey,isChecked){
        let id = nodeKey.id
        if(isChecked){
          this.$refs['dept_auth_tree'].setCheckedKeys([id])
          this.form.dept = id
        }else{
          this.$refs['dept_auth_tree'].setCheckedKeys([this.form.dept])
        }

      },
      dialogClose() {
        this.dialog.show = false
      },
      submitForm() {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            if (this.dialog.operation === 'add') {
              add(this.form)
                .then(res => {
                  this.loading = false
                  this.dialogClose()
                  this.$emit('update')
                })
                .catch(() => {
                  this.loading = false
                })
            } else {
              edit(this.form)
                .then(res => {
                  this.loading = false
                  this.dialogClose()
                  this.$emit('update')
                })
                .catch(() => {
                  this.loading = false
                })
            }
          } else {
            return false;
          }
        });
      }
    }
  }
</script>

