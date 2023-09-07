<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="700px" append-to-body>
    <el-form ref="form" :model="form" label-width="80px" :rules="rules">
      <el-form-item label="名称" prop="title">
        <el-input v-model.trim="form.title"></el-input>
      </el-form-item>
      <el-form-item label="组件" prop="component">
        <el-input v-model.trim="form.component" placeholder="控制器/模型/方法"></el-input>
      </el-form-item>
    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">关 闭</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {add, edit} from '@/api/admin/menu'

  export default {
    data() {
      return {
        rules: {
          title: [
            {required: true, message: '请输入名称', trigger: 'blur'}
          ],
          component: [
            {required: true, message: '请输入组件路径', trigger: 'blur'}
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
          })
        }
      }
    },
    props: {
      dialog: Object,
      dialogForm: Object
    },
    methods: {
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
    },
  }
</script>

