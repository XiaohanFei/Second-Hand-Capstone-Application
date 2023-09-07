<template>
  <div class="base-person-container">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-card class="box-card person-box">
          <el-avatar :size="150" :src="sourceUrl + avatar"></el-avatar>
          <div class="person-name">{{realname}}</div>
        </el-card>
      </el-col>
      <el-col :span="18">
        <el-card class="box-card">
          <el-tabs tab-position="left" style="height: 100%">
            <el-tab-pane label="Information">
              <el-form ref="form" :model="form" label-width="150px" :rules="rules" class="label-form"
                       style="width: 600px">
                <el-form-item label="Name" prop="realname">
                  <el-input v-model="form.realname"></el-input>
                </el-form-item>
                <el-form-item label="Avatar" prop="avatar">
                  <upload-image :uploadAction="uploadAction" :imageSrc="form.avatar"
                                @success="uploadSuccess"></upload-image>
                </el-form-item>
                <el-form-item>
                  <el-button type="primary" round :loading="loading" @click="submitForm">Save</el-button>
                </el-form-item>
              </el-form>
            </el-tab-pane>
            <el-tab-pane label="Reset password">
              <password></password>
            </el-tab-pane>

          </el-tabs>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import {getPerson, setPerson} from '@/api/admin/user'

  export default {
    name: "Index",
    components: {
      UploadImage: () => import('@/components/UploadImage/Index'),
      Password: () => import('./Password')
    },
    data() {
      return {
        uploadAction: window.baseUrl+'/admin/user/upload',
        loading: false,
        info: {},
        form: {},
        log: [],
        sourceUrl:window.sourceUrl,
        rules: {
          realname: [
            {required: true, message: 'Required', trigger: 'blur'}
          ],
          avatar: [
            {required: true, message: 'Required', trigger: 'blur'}
          ]
        }
      }
    },
    computed: {
      ...mapGetters([
        'realname',
        'avatar'
      ]),
      autoHeight() {
        return document.body.clientHeight - 150
      }
    },
    methods: {
      uploadSuccess(res) {
        this.form.avatar = res.avatarPath
      },
      submitForm() {
        this.$refs['form'].validate((valid) => {
          if (valid) {
            this.loading = true;
            setPerson(this.form)
              .then(res => {
                this.$store.dispatch('user/setRealName', this.form.realname)
                this.$store.dispatch('user/setAvatar', this.form.avatar)
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
      async init(){
        const { info} = await getPerson()
        this.info = info
        this.form = {
          realname: info.realname,
          avatar: info.avatar
        }
      }
    },
    mounted() {
      this.init()
    }
  }
</script>
