<template>
    <div class="login-container">
      <login-loading :isShow="loginLoading"></login-loading>
      <!--<div class="title">{{title}}</div>-->
      <div class="login-bg">
        <div class="login-form">
          <div class="welcome-title">{{title}}</div>
          <el-form :model="loginForm" :rules="rules" ref="loginForm">
            <el-form-item prop="username">
              <el-input
                      ref="username"
                      placeholder="Username"
                      tabindex="1"
                      autocomplete="on"
                      prefix-icon="el-icon-user-solid"
                      v-model.trim="loginForm.username">
              </el-input>
            </el-form-item>
            <el-form-item prop="password">
              <el-input
                      tabindex="2"
                      autocomplete="on"
                      ref="password"
                      type="password"
                      prefix-icon="el-icon-connection"
                      placeholder="Password"
                      v-model.trim="loginForm.password"
                      @keyup.enter.native="submitForm">
              </el-input>
            </el-form-item>
            <el-form-item v-if="verifyUrl" prop="verify">
              <el-input
                      type="text"
                      prefix-icon="el-icon-menu"
                      v-model.trim="loginForm.verify"
                      placeholder="Verification Code"
                      @keyup.enter.native="submitForm">
              </el-input>
              <img :src="verifyImg" class="verify-box" @click="refreshVerify">
            </el-form-item>
            <el-form-item>
              <el-button :loading="loading" @click="submitForm" class="login-button">Login</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>

    </div>


</template>

<script>
  import {getConfigs} from '@/api/admin/setting'
  import {login} from '@/api/admin/user'
  import {setToken} from '@/utils/auth'

  export default {
    name: "Login",
    components: {
      LoginLoading: () => import('./LoginLoading')
    },
    data() {
      return {
        loginLoading:false,
        verifyUrl: '',
        verifyImg: '',
        loginForm: {
          username: '',
          password: '',
          verify: ''
        },
        rules: {
          username: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          password: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          verify: [
            {required: true, message: 'Required', trigger: 'blur'}
          ]
        },
        loading: false,
        title:'',
        logo:'',
        copyRight:'',
        showLink:2

      }
    },
    computed: {
      softwareUrl(){
        return window.sourceUrl.replace('uploads','software')
      }
    },
    methods: {
      submitForm() {
        this.$refs.loginForm.validate((valid) => {
          if (valid) {
            this.loading = true;
            login(this.loginForm)
              .then(res => {
                setToken(res)
                this.$store.dispatch('user/setUserName', this.loginForm.username)
                  .then(()=>{
                    this.$router.push({path: '/'})
                  })
              })
              .catch(() => {
                this.refreshVerify()
                this.loginForm.verify = ''
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
      getConfigs()
        .then(res => {
          const {verifyUrl, title, logo,sub_title,copy_right,show_link} = res

          this.verifyUrl = verifyUrl
          this.showLink = show_link
          this.title = title+'  '+sub_title
          this.copyRight = copy_right
          this.logo = window.sourceUrl + logo
          this.loginForm.username = this.$store.getters.username
          this.$store.dispatch('system/init', res)

          this.refreshVerify()
          if (this.loginForm.username === '') {
            this.$refs.username.focus()
          } else if (this.loginForm.password === '') {
            this.$refs.password.focus()
          }
          setTimeout(()=>{
            this.loginLoading=false
          },1000)

        }).catch((error)=>{
          this.$notify.error({
            title: 'Error',
            message: 'Error',
            duration:5000
          })
      })
    }
  }
</script>

