<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="1200px">
    <el-form ref="form" :model="form" label-width="155px" :rules="rules" class="dark-label-form"
             :hide-required-asterisk="true">
      <el-row :gutter="10">
        <el-col :span="12">
          <el-form-item label="Name" prop="name">
            <el-input v-model="form.name"></el-input>
          </el-form-item>
          <el-form-item label="Price" prop="price">
            <el-input v-model="form.price"></el-input>
          </el-form-item>
          <el-form-item label="Pictures" prop="picture">
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
              <div slot="tip" class="el-upload__tip">Only JPG / PNG pictures can be uploaded, the size is no more than 5m, and up to 6 pictures can be uploaded</div>
            </el-upload>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Classification" prop="classify_id">
            <el-cascader :options="classifyList" :props="{label:'title',value:'id',expandTrigger:'hover',emitPath:false}"  v-model="form.classify_id" style="width: 100%"></el-cascader>
          </el-form-item>
          <!--<el-form-item label="Old degree" prop="level">-->
            <!--<el-input v-model="form.level">-->
            <!--</el-input>-->
          <!--</el-form-item>-->
          <el-form-item label="Buy time" prop="buy_time">
            <el-date-picker style="width: 100%" v-model="form.buy_time" type="date" :value-format="'yyyy-MM-dd'">
            </el-date-picker>
          </el-form-item>
          <el-form-item label="Free shipping" prop="free_shipping">
            <el-radio-group v-model="form.free_shipping">
              <el-radio-button :label="1">Yes</el-radio-button>
              <el-radio-button :label="2">No</el-radio-button>
            </el-radio-group>
          </el-form-item>
          <el-form-item label="Description" prop="desc">
            <el-input v-model="form.desc" type="textarea"  :autosize="{ minRows: 5}"></el-input>
          </el-form-item>
        </el-col>
      </el-row>


    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">Close</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">Save</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import { edit,getClassify,getGoodsDetail} from '@/api/dataset/goods'
  import { getToken } from '@/utils/auth'
  import { notification  } from '@/utils/index'
  export default {

    data() {
      return {
        fileList: [],
        uploadAction: window.baseUrl+'/dataset/goods/imageUpload',
        headers: {'w-token': getToken()},
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
          name: [{required: true, message: 'Required', trigger: 'blur'}],
          price: [{required: true, message: 'Required', trigger: 'blur'}],
          classify_id: [{required: true, message: 'Required', trigger: 'blur'}],
          buy_time: [{required: true, message: 'Required', trigger: 'blur'}],
          level: [{required: true, message: 'Required', trigger: 'blur'}],
          free_shipping: [{required: true, message: 'Required', trigger: 'blur'}],
          desc: [{required: true, message: 'Required', trigger: 'blur'}],
          picture: [{required: true, message: 'Required', trigger: 'blur'}],
        },
        loading: false,
        classifyList:[]
      }
    },
    watch: {
      'dialog.show'(val) {
        this.fileList = []
        if (val) {
          this.$nextTick(() => {

            getClassify().then((res)=>{
              this.classifyList = res
            })
            getGoodsDetail({id:this.dialog.id}).then((res=>{
              var temp = [];
              res.picture.filter(item=>{
                temp.push({url:sourceUrl+item})
              })
              this.form = res
              this.fileList = temp
            })).catch(()=>{
              return
            })
          })
        }
      }
    },
    props: {
      dialog: Object
    },
    methods: {

      dialogClose() {
        this.dialog.show = false
      },
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
            edit(data)
              .then(res => {
                this.loading = false
                this.dialogClose()
                this.$emit('update')
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
  }
</script>

