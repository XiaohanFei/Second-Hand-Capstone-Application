<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="900px" :top="'60px'">
    <el-form ref="form" :model="form" label-width="80px" :rules="rules">
      <el-form-item label="Title" prop="title">
        <el-input v-model.trim="form.title"></el-input>
      </el-form-item>
      <el-form-item label="Content" prop="content">
        <wang-editor :content="form.content" @input="updateContent" :key="'e'"></wang-editor>
      </el-form-item>

      <el-form-item label="Status">
        <el-radio-group v-model="form.status" size="medium">
          <el-radio-button :label="1">Enable</el-radio-button>
          <el-radio-button :label="2">Disable</el-radio-button>
        </el-radio-group>
      </el-form-item>
    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">Close</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">Save</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {add, edit} from '@/api/dataset/notice'
  import { notification  } from '@/utils/index'
  export default {
    components: {
      WangEditor: () => import('@/components/WangEditor/Index'),
    },
    data() {
      return {
        rules: {
          title: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          content: [
            {required: true, message: 'Required', trigger: 'blur'}
          ]
        },
        loading: false,
        form: {
          content:''
        },
      }
    },
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.$nextTick(() => {
            this.form = Object.assign({}, this.dialogForm)
            // this.$refs['tinymceDemo'].setContent(this.form.content)
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
      updateContent(html){
        this.form.content = html
      },
      dialogClose() {
        this.dialog.show = false
      },
      submitForm() {
        if(this.form.content.length == 0){
          notification('Content Required')
          return
        }
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

