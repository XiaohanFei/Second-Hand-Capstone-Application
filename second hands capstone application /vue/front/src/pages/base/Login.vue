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
        <div class="login-form">
          <div class="welcome-title">{{title}}</div>
          <el-form :model="loginForm" :rules="rules" ref="loginForm">
            <el-form-item prop="username">
              <el-input
                      ref="username"
                      placeholder="Mobile/Mailbox"
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
                      placeholder="Code"
                      @keyup.enter.native="submitForm">
              </el-input>
              <img :src="verifyImg" class="verify-box" @click="refreshVerify">
            </el-form-item>
            <el-form-item>
              <el-button :loading="loading" @click="submitForm" class="login-button">Login</el-button>
            </el-form-item>
          </el-form>
          <el-divider >No account?</el-divider>
          <div style="display: flex;flex-direction: row">
            <el-button round style="flex: 1" icon="el-icon-arrow-left" @click="toUrl('/register')" type="primary" plain>Register</el-button>
            <el-button round style="flex: 1" @click="toUrl('/')" type="primary" plain id="look-around">Look around<i class="el-icon-arrow-right el-icon--right" ></i></el-button>
          </div>

        </div>
      </div>
    </div>
</template>

<script>
  import {getConfigs} from '@/api/admin/setting'
  import {login} from '@/api/home/user'
  import {setToken} from '@/utils/auth'

  export default {
    name: "Login",
    data() {
      return {
        videoUrl:require('@/assets/images/bg2.mp4'),
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
      }
    },
    methods: {
      _isMobile() {
        let flag = navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i)
        return flag;
      },
      toUrl(url){
        this.$router.push(url)
      },
      submitForm() {
        this.$refs.loginForm.validate((valid) => {
          if (valid) {
            this.loading = true;
            login(this.loginForm)
              .then(res => {
                setToken(res.token)
                this.$store.dispatch('user/setUserName', {
                  username:this.loginForm.username,
                  nickname:res.nickname
                })
                .then(()=>{
                  if (this._isMobile()) {
                    this.$router.replace('/mobile/index');
                  } else {
                    this.$router.replace('/home/index');
                  }
                  // this.$router.push({path: '/'})
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
          const {verifyUrl,title} = res

          this.verifyUrl = verifyUrl
          this.title = title
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
            message: 'System Error',
            duration:5000
          })
      })
    }
  }
</script>

