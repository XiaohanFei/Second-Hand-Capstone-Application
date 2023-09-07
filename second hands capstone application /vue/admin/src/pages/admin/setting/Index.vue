<template>
  <el-card class="fullscreen" >

    <el-form ref="form" :model="form" label-width="170px" :rules="rules" class="dark-label-form"
             :hide-required-asterisk="true" style="width: 600px">
      <el-form-item label="Verification Code" prop="verification">
        <el-radio-group v-model="form.verification">
          <el-radio-button :label="1">On</el-radio-button>
          <el-radio-button :label="2">Off</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="Token valid time" prop="token_expire">
        <el-input v-model.number="form.token_expire">
          <template slot="append">second</template>
        </el-input>
      </el-form-item>
      <!--<el-form-item label="超级用户ID" prop="super_user" v-if="isSuper">-->
        <!--<el-input v-model.number="form.super_user"></el-input>-->
      <!--</el-form-item>-->
      <el-form-item label="Website title" prop="title">
        <el-input v-model="form.title"></el-input>
      </el-form-item>
      <!--<el-form-item label="网站副标题">-->
        <!--<el-input v-model="form.sub_title"></el-input>-->
      <!--</el-form-item>-->
      <!--<el-form-item label="版权信息" prop="copy_right">-->
        <!--<el-input v-model="form.copy_right"></el-input>-->
      <!--</el-form-item>-->
      <el-form-item label="Website logo" prop="logo">
        <upload-image :uploadAction="uploadAction" :imageSrc="form.logo"
                      @success="uploadSuccess"></upload-image>
      </el-form-item>
      <el-form-item >
        <el-button  type="primary" :loading="loading" @click="submitForm">Save</el-button>
      </el-form-item>
    </el-form>
  </el-card>
</template>

<script>
  import {index, edit} from '@/api/admin/setting'

  export default {
    components: {
      UploadImage: () => import('@/components/UploadImage/Index'),
    },
    name: "Index",
    data() {
      return {
        uploadAction: window.baseUrl+'/admin/setting/upload',
        isSuper:false,
        form: {},
        rules: {
          verification: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          token_expire: [
            {required: true, message: 'Required', trigger: 'blur'},
          ],
          super_user: [
            {required: true, message: '请输入超级用户ID', trigger: 'blur'},
            {type: 'number', message: '必须为数字值'}
          ],
          title: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          logo: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          copy_right: [
            {required: true, message: '请输入版权信息', trigger: 'blur'}
          ]
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
                this.$store.dispatch('system/setTitle', this.form.title)
                this.$store.dispatch('system/setLogo', this.form.logo)
                this.$store.dispatch('system/setSubTitle', this.form.sub_title)
                this.$store.dispatch('system/setCopyRight', this.form.copy_right)
                this.loading = false
              })
              .catch(() => {
                this.loading = false
              })
          } else {
            return false;
          }
        });
      },
      uploadSuccess(res) {
        this.form.logo = res.logoPath
      }
    },
    mounted() {
      index()
        .then(res => {
          const {list,isSuper} = res
          this.form = list
          this.isSuper = isSuper
        })
        .catch(() => {
          this.$router.push({path: '/error'})
        })
    }
  }
</script>



