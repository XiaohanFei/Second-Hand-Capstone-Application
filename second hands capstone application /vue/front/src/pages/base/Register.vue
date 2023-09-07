<template>
    <div class="login-container">
      <div class="nectar-video-wrap">
        <div class="nectar-video-inner">
          <video class="banner-video" width="100%" height="100%" loop="" autoplay="" muted="" preload="auto" style="object-fit: cover;">
            <source :src="videoUrl" type="video/mp4">
          </video>
        </div>
      </div>
      <div class="login-bg">
        <div class="register-form">
          <div class="welcome-title">Welcome to register</div>
          <el-form ref="form" :model="form" :rules="rules" class="dark-label-form" label-width="140px" size="medium ">
            <el-form-item label="Mailbox" prop="email">
              <el-input v-model="form.email"></el-input>
            </el-form-item>
            <el-form-item label="Mailbox Code" prop="verify" class="email-box">
              <el-input v-model="form.verify"></el-input>
              <el-button @click="handleEmail" type="primary" :loading="loginLoading">Send</el-button>
            </el-form-item>
            <el-form-item label="Mobile" prop="mobile">
              <el-input  v-model="form.mobile"></el-input>
            </el-form-item>
            <el-form-item label="Student ID" prop="sdu_num">
              <el-input  v-model="form.sdu_num"></el-input>
            </el-form-item>

            <el-form-item label="Password" prop="password">
              <el-input type="password" v-model.trim="form.password"></el-input>
            </el-form-item>
            <el-form-item label="Confirm" prop="re_password">
              <el-input type="password" v-model.trim="form.re_password"></el-input>
            </el-form-item>
            <el-button :loading="loading" @click="submitForm" class="login-button">Register</el-button>
          </el-form>
          <el-divider >Existing account?</el-divider>
          <div style="display: flex;flex-direction: row">
            <el-button round style="flex: 1" @click="toUrl('/login')" type="primary" plain>Go login</el-button>
          </div>

        </div>
      </div>
    </div>
</template>

<script>
  // import {getConfigs} from '@/api/admin/setting'
  import {register} from '@/api/home/user'
  import {sendEmail} from '@/api/admin/base'
  // import {setToken} from '@/utils/auth'

  export default {
    name: "Login",
    data() {
      let validatePhone = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Required'));
        // } else if(!(/^1[34578]\d{9}$/.test(value))) {
        } else if(!(/^(\+?1)?[2-9]\d{2}[2-9](?!11)\d{6}$/.test(value))) {
          callback(new Error('Mobile Error'))
        } else {
          callback();
        }
      }
      let validateEmail = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('Required'));
        } else if(!(/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.edu$/.test(value))) {
          callback(new Error('Only available for education mailbox, ends with ‘edu’'))
        } else {
          callback();
        }
      }
      return {
        videoUrl:require('@/assets/images/bg2.mp4'),
        loginLoading:false,
        verifyUrl: '',
        verifyImg: '',
        form: {
          mobile: '',
          password: '',
          re_password: '',
          verify: '',
          sdu_num:'',
          email:''
        },
        rules: {
          mobile: [{required: true, validator: validatePhone, trigger: 'blur'}],
          sdu_num: [{required: true, message: 'Required', trigger: 'blur'}],
          email: [{required: true, validator: validateEmail, trigger: 'blur'}],
          password: [{required: true, message: 'Required', trigger: 'blur'}],
          re_password: [{required: true, message: 'Required', trigger: 'blur'}],
          verify: [{required: true, message: 'Required', trigger: 'blur'}]
        },
        loading: false,
        title:'',
      }
    },
    methods: {
      handleEmail(){
        this.$refs.form.validateField('email',(valid)=>{
          if(valid) return
          this.loginLoading = true
          sendEmail({email:this.form.email}).then(()=>{
            return
          }).catch(()=>{
            this.loginLoading = false
          })
        })
      },
      toUrl(url){
        this.$router.push(url)
      },
      submitForm() {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            register(this.form)
              .then(res => {
                this.$router.push({path: '/login'})
              })
              .catch(() => {
                this.loading = false
              })
          } else {
            return false
          }
        });
      },
      refreshVerify() {
        if (this.verifyUrl.length > 0) {
          setTimeout(() => {
            this.verifyImg = this.verifyUrl + '?v=' + (new Date()).valueOf()
          }, 300)
        }
      },
    },
    mounted() {
      // getConfigs()
      //   .then(res => {
      //     const {verifyUrl,title} = res
      //
      //     this.verifyUrl = verifyUrl
      //     this.title = title
      //     this.$store.dispatch('system/init', res)
      //
      //     this.refreshVerify()
      //
      //     setTimeout(()=>{
      //       this.loginLoading=false
      //     },1000)
      //
      //   }).catch((error)=>{
      //     this.$notify.error({
      //       title: '错误',
      //       message: '服务器地址错误',
      //       duration:5000
      //     })
      // })
    }
  }
</script>

