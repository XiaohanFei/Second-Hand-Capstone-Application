<template>
  <el-form ref="form" :model="form" label-width="150px" :rules="rules" class="label-form" style="width: 600px">
    <el-form-item label="Old password" prop="oldPass">
      <el-input v-model="form.oldPass"></el-input>
    </el-form-item>
    <el-form-item label="New password" prop="password">
      <el-input v-model="form.password" type="password"></el-input>
    </el-form-item>
    <el-form-item label="Verify password" prop="checkPass">
      <el-input v-model="form.checkPass" type="password"></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" round :loading="loading" @click="submitForm">Save</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  import {setPassword} from '@/api/admin/user'

  export default {
    name: "Password",
    data() {
      var validatePass2 = (rule, value, callback) => {
        if (value !== this.form.password) {
          callback(new Error('Verify password error'));
        } else {
          callback();
        }
      };
      return {
        form: {
          oldPass: '',
          password: '',
          checkPass: '',
        },
        rules: {
          oldPass: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          password: [
            {required: true, message: 'Required', trigger: 'blur'},
          ],
          checkPass: [
            {required: true, message: 'Required', trigger: 'blur'},
            {validator: validatePass2, trigger: 'blur'}
          ],
        },
        loading: false,
      }
    },
    methods: {
      submitForm() {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            setPassword(this.form)
              .then(() => {
                this.form = {
                  oldPass: '',
                  password: '',
                  checkPass: '',
                }
                this.loading = false
              })
              .catch(() => {
                this.loading = false
              })
          } else {
            return false;
          }
        });
      }
    }
  }
</script>
