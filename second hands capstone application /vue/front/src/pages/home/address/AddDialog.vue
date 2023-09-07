<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="700px">
    <el-form ref="form" :model="form" label-width="80px" :rules="rules">
      <el-form-item label="Name" prop="name">
        <el-input v-model.trim="form.name"></el-input>
      </el-form-item>
      <el-form-item label="Mobile" prop="mobile">
        <el-input v-model.trim="form.mobile"></el-input>
      </el-form-item>
      <el-form-item label="Address" prop="address">
        <el-input v-model="form.address"></el-input>
      </el-form-item>
    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">Close</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">Save</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {addAddress, editAddress} from '@/api/home/home'
  export default {
    data() {
      return {
        rules: {
          name: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          mobile: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          address: [
            {required: true, message: 'Required', trigger: 'blur'}
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
              addAddress(this.form)
                  .then(res => {
                    this.loading = false
                    this.dialogClose()
                    this.$emit('update')
                  })
                  .catch(() => {
                    this.loading = false
                  })
            } else {
              editAddress(this.form)
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
            return false
          }
        })
      }
    },
  }
</script>

