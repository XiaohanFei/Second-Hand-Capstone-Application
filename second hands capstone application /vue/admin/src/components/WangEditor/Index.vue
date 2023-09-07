<template>
  <div :id="uniqueId"></div>
</template>

<script>
  import { getToken } from '@/utils/auth'
  import { notification  } from '@/utils/index'
  import E from 'wangeditor'
  export default {
    name: "MainIndex",
    data() {
      return {
        editor: null,
        flag: true,
      }
    },
    watch: {
      content(val) {
        this.editor.txt.html(val);
        if(this.flag){
          //这里初始化的时候赋值

        }
        this.flag = true;
      }
    },
    methods: {},
    props: {
      uploadAction: {
        type: String,
        default: '/home/home/imageUpload'
      },
      height: {
        type: Number,
        default: 350
      },
      content:{
        type: String,
        default: ''
      },
      uniqueId: {
        type: String,
        default: "e"
      }

    },
    mounted() {
      this.editor = new E('#'+this.uniqueId)
      this.editor.config.height =this.height
      this.editor.config.onchangeTimeout = 1000
      this.editor.config.menuTooltipPosition = 'down'
      this.editor.config.excludeMenus = ['emoticon', 'video']
      this.editor.config.uploadImgServer = window.baseUrl+this.uploadAction
      this.editor.config.uploadFileName = 'file'
      this.editor.config.uploadImgHeaders = {
        'n-token': getToken()
      }
      this.editor.config.onchange = (html) => {
        this.flag = false
        this.$emit('input', html);
      }
      this.editor.config.uploadImgHooks = {
        customInsert: function(insertImgFn, result) {
          if (result.code == 200) {
            insertImgFn(window.sourceUrl+result['data'])
          } else {
            notification(result.msg)
          }

        }
      }
      this.editor.create()
      this.editor.txt.html(this.content)
    },
    beforeDestroy() {
      // 销毁编辑器
      this.editor.destroy()
      this.editor = null
    }
  }
</script>

