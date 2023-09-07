<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show"  :close-on-click-modal="false"
             width="900px"  :top="'80px'" class="admin-role-dialog">
    <el-form ref="form" :model="form" label-width="100px" :rules="rules">
      <el-form-item label="轮播图图片" prop="path">
        <upload-image :uploadAction="uploadAction" :imageSrc="form.path"
                      @success="uploadSuccess"></upload-image>
      </el-form-item>
    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">关 闭</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {add, edit} from '@/api/admin/carousel'
  export default {
    components: {
      UploadImage: () => import('@/components/UploadImage/Index'),
    },
    data() {
      return {
        rules: {
          path: [
            {required: true, message: '请上传图片', trigger: 'blur'}
          ],
        },
        loading: false,
        form: {},
        uploadAction: window.baseUrl+'/admin/carousel/imageUpload',
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
      uploadSuccess(res) {
        // console.log(res)
        this.form.path = res
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
    },
  }
</script>

<style scoped>
  /deep/.upload-preview-box{
    width: auto!important;
  }
</style>

