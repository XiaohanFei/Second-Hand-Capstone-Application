<template>
  <div class="main-box mobile-person-container">
    <el-tabs type="border-card" :tab-position="'top'">
      <el-tab-pane label="Info">
        <el-form ref="form" :model="form" label-width="80px" :rules="rules"
                 :hide-required-asterisk="true" style="width:100%" size="small">
          <el-form-item label="Mobile" prop="mobile">
            <el-input v-model="form.mobile"></el-input>
          </el-form-item>
          <el-form-item label="Student ID" prop="sdu_num">
            <el-input v-model="form.sdu_num"></el-input>
          </el-form-item>
          <el-form-item label="Name" prop="nickname">
            <el-input v-model="form.nickname"></el-input>
          </el-form-item>
          <el-form-item label="Email" prop="email">
            <el-input v-model="form.email"></el-input>
          </el-form-item>
          <el-form-item label="Password">
            <el-input v-model="form.password" placeholder="If left blank, it will not be modified"></el-input>
          </el-form-item>
          <el-form-item label="Avatar">
            <upload-image :uploadAction="uploadAction" :imageSrc="form.avatar"
                          @success="uploadSuccess"></upload-image>
          </el-form-item>
          <el-form-item >
            <el-button  type="primary" :loading="loading" @click="submitForm">Save</el-button>
            <el-button  type="danger" @click="logout">Logout</el-button>
          </el-form-item>

        </el-form>
      </el-tab-pane>
      <el-tab-pane label="Score" lazy>
        <score-page></score-page>
      </el-tab-pane>
      <el-tab-pane label="Address" lazy>
        <address-page></address-page>
      </el-tab-pane>
      <el-tab-pane label="Buy" lazy>
        <my-buy-page></my-buy-page>
      </el-tab-pane>
      <el-tab-pane label="Sell" lazy>
        <my-sell-page></my-sell-page>
      </el-tab-pane>
      <el-tab-pane label="Balance" lazy>
        <money-page></money-page>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
  import {getUserInfo,editUserInfo} from '@/api/home/home'
  export default {
    name: "Index",
    components: {
      AddressPage: () => import('@/pages/mobile/address/Index'),
      MoneyPage: () => import('@/pages/mobile/money/Index'),
      MyBuyPage: () => import('@/pages/mobile/myBuy/Index'),
      MySellPage: () => import('@/pages/mobile/mySell/Index'),
      ScorePage: () => import('@/pages/mobile/score/Index'),
      UploadImage: () => import('@/components/UploadImage/Index'),
    },
    data() {
      return {
        uploadAction: window.baseUrl+'/home/home/upload',
        form: {},
        rules: {
          mobile: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          sdu_num: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          email: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          nickname: [
            {required: true, message: 'Required', trigger: 'blur'}
          ]
        },
        loading: false
      }
    },
    methods: {
      logout() {
        this.$store.dispatch('user/logout').then(()=>{
          this.$router.push('/login')
        })
      },
      uploadSuccess(res) {
        this.form.avatar = res
      },
      submitForm() {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            editUserInfo(this.form)
              .then(() => {
                this.$store.dispatch('user/setRealName', this.form.nickname)
                this.form.password = ''
                this.loading = false
              })
              .catch(() => {
                this.loading = false
              })
          } else {
            return false
          }
        });
      },
    },
    mounted() {
      getUserInfo().then(res=>{
        this.form = res
      })
    }
  }
</script>
