<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="700px">
    <el-form ref="form" :model="form" label-width="80px" :rules="rules">
      <el-form-item label="Superior" prop="pid" v-if="form.pid > 0">
        <el-cascader
                v-model="form.pid"
                :options="selection"
                :props="{ checkStrictly: true,emitPath:false,label:'title',value:'id'}"
                style="width: 100%">
        </el-cascader>
      </el-form-item>
      <el-form-item label="Name" prop="title">
        <el-input v-model.trim="form.title"></el-input>
      </el-form-item>
    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">Close</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">Save</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {add, edit} from '@/api/dataset/classify'

  export default {

    data() {
      return {
        rules: {
          title: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          pid: [
            {required: true, message: 'Required', trigger: 'blur'}
          ]
        },
        loading: false,
        form: {},
        selection:[],
      }
    },
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.$nextTick(() => {
            this.form = Object.assign({}, this.dialogForm)
            this.selection = [...this.dialogSelection]
            this.$refs['form'].clearValidate()
          })
        }
      }
    },
    props: {
      dialog: Object,
      dialogForm: Object,
      dialogSelection: Array
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

