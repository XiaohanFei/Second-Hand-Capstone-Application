<template>
  <div>
    <img :src="imageUrl" class="upload-preview-box" v-if="imageSrc">
    <el-upload
      :action="uploadAction"
      :headers="headers"
      :before-upload="beforeUpload"
      :on-success="handleSuccess"
      list-type="picture-card"
      :show-file-list="false"
      :accept="accept">
      <i slot="default" class="el-icon-plus"></i>
      <div slot="tip" class="el-upload__tip" v-if="tip">{{tip}}</div>
    </el-upload>
  </div>
</template>

<script>
  import { getToken } from '@/utils/auth'
  import { notification  } from '@/utils/index'
  export default {
    name: "Index",
    props: {
      uploadAction: {
        required: true,
        type: String
      },
      imageSrc: {
        type: String,
        default: ''
      },
      accept: {
        type: String,
        default: 'image/*'
      },
      uploadRule: {
        type: Object,
        default: function () {
          return {type: ['image/jpeg', 'image/png'], size: 5 * 1024 * 1024}
        }
      },
      tip: {
        type: String,
        default: 'Only JPG / PNG files can be uploaded and no more than 5m'
      }
    },
    data() {
      return {
        headers: {'n-token': getToken()},
        sourceUrl:window.sourceUrl
      }
    },
    computed: {
      imageUrl: function () {
        if (this.imageSrc.length > 0) {
          return sourceUrl + this.imageSrc
        } else {
          return ""
        }
      }
    },
    methods: {
      beforeUpload(file) {
        let rules = this.uploadRule
        if (Object.keys(rules).length > 0) {
          if (rules.hasOwnProperty('type') && rules['type'].indexOf(file.type) == -1) {
            notification('请上传正确的文件格式')
            return false
          }
          if (rules.hasOwnProperty('size') && file.size > rules['size']) {
            notification('文件大小超出限制')
            return false
          }
        }
        return true
      },
      handleSuccess(res, file) {
        if (res.code == 200) {
          // this.imageSrc = res.data
          this.$emit('success', res.data)
        } else {
          notification(res.msg)
        }
      }
    }
  }
</script>
