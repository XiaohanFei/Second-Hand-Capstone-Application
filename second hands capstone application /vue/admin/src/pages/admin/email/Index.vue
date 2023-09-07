<template>
  <el-card class="fullscreen" >

    <el-form ref="form" :model="form" label-width="170px" :rules="rules" class="dark-label-form"
             :hide-required-asterisk="true" style="width: 600px">


      <el-form-item label="Address" prop="host">
        <el-input v-model="form.host"></el-input>
      </el-form-item>
      <el-form-item label="Account" prop="username">
        <el-input v-model="form.username"></el-input>
      </el-form-item>
      <el-form-item label="Secret key" prop="password">
        <el-input v-model="form.password"  type="password"></el-input>
      </el-form-item>
      <el-form-item label="Subject" prop="subject">
        <el-input v-model="form.subject" ></el-input>
      </el-form-item>

      <el-form-item >
        <el-button  type="primary" :loading="loading" @click="submitForm">Save</el-button>
      </el-form-item>
    </el-form>
  </el-card>
</template>

<script>
  import {index, edit} from '@/api/admin/email'

  export default {

    name: "Index",
    data() {
      return {
        uploadAction: window.baseUrl+'/admin/setting/upload',
        isSuper:false,
        form: {},
        rules: {
          host: [{required: true, message: 'Required', trigger: 'blur'}],
          username: [{required: true, message: 'Required', trigger: 'blur'}],
          password: [{required: true, message: 'Required', trigger: 'blur'}],
          subject: [{required: true, message: 'Required', trigger: 'blur'}],
        },
        loading: false
      }
    },
    methods: {
      submitForm() {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            edit(this.form)
              .then(res => {

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
    },
    mounted() {
      index()
        .then(res => {
          const {list} = res
          this.form = list
        })
        .catch(() => {
          this.$router.push({path: '/error'})
        })
    }
  }
</script>



