<template>
  <div class="main-box" style="padding: 15px">
    <el-form ref="form" :model="form" label-width="120px" :rules="rules"
             size="small">
      <el-form-item label="商品名称" prop="name">
        <el-input v-model="form.name"></el-input>
      </el-form-item>
      <el-form-item label="商品价格" prop="price">
        <el-input v-model="form.price"></el-input>
      </el-form-item>
      <el-form-item label="商品图片" prop="picture">
        <el-upload
                class="upload-demo"
                :action="uploadAction"
                :on-remove="handleRemove"
                :file-list="fileList"
                :headers="headers"
                :on-success="handleSuccess"
                accept="image/*"
                multiple
                :limit="6"
                list-type="picture-card">
          <i class="el-icon-plus"></i>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png图片，大小不超过5M，最多上传6张图片</div>
        </el-upload>
      </el-form-item>
      <el-form-item label="商品分类" prop="classify_id">
        <el-cascader :options="classifyList" :props="{label:'title',value:'id',expandTrigger:'hover',emitPath:false}"  v-model="form.classify_id" style="width: 100%"></el-cascader>
      </el-form-item>
      <!--<el-form-item label="新旧程度" prop="level">-->
        <!--<el-input v-model="form.level">-->
          <!--<template slot="append">成新</template>-->
        <!--</el-input>-->
      <!--</el-form-item>-->
      <el-form-item label="购入时间" prop="buy_time">
        <el-date-picker style="width: 100%" v-model="form.buy_time" type="date" :value-format="'yyyy-MM-dd'">
        </el-date-picker>
      </el-form-item>
      <el-form-item label="是否包邮" prop="free_shipping">
        <el-radio-group v-model="form.free_shipping">
          <el-radio-button :label="1">包邮</el-radio-button>
          <el-radio-button :label="2">不包邮</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="商品描述" prop="desc">
        <el-input v-model="form.desc" type="textarea"  :autosize="{ minRows: 5}"></el-input>
      </el-form-item>
      <el-form-item >
        <el-button  type="primary" :loading="loading" @click="submitForm">Save</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  import { getToken } from '@/utils/auth'
  import {getClassify,getGoodsDetail,editGoods} from '@/api/home/home'
  import { notification  } from '@/utils/index'
  export default {
    name: "Index",
    data() {
      return {
        fileList: [],
        uploadAction: window.baseUrl+'/home/home/imageUpload',
        headers: {'n-token': getToken()},
        sourceUrl:window.sourceUrl,
        form:{
          name:'',
          price:'',
          classify_id:'',
          buy_time:'',
          level:'',
          free_shipping:1,
          desc:'',
          status:1,
          picture:[],
        },
        rules: {
          name: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
          price: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
          classify_id: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
          buy_time: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
          level: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
          free_shipping: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
          desc: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
          picture: [{required: true, message: '必填项,请输入', trigger: 'blur'}],
        },
        loading: false,
        classifyList:[]
      }
    },
    methods: {
      handleSuccess(res, file) {
        if (res.code == 200) {
          this.form.picture.push(res.data)
        } else {
          notification(res.msg)
        }
      },
      handleRemove(file) {
        console.log(file)
        var match = ''
        if(file.hasOwnProperty('response')){
          match = file['response']['data']
        }else{
          var a = file.url.split('/')
          a = a.pop()
          match = "market/"+a
        }

        this.form.picture = this.form.picture.filter((item)=>{
          if(item !== match){
            return item
          }
        })
      },
      submitForm() {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            var data = JSON.parse(JSON.stringify(this.form))
            data.picture =  data.picture.join(',')
            editGoods(data)
              .then(res => {
                this.loading = false
                this.$router.push({path: '/mobile/index'})
              })
              .catch(() => {
                this.loading = false
              })
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      getClassify({type:1}).then((res)=>{
        this.classifyList = res
      })
      getGoodsDetail({id:this.$route.query.id}).then((res=>{
        var temp = [];
        res.picture.filter(item=>{
          temp.push({url:sourceUrl+item})
        })
        this.form = res
        this.fileList = temp
      })).catch(()=>{
        return
      })
    }
  }
</script>
