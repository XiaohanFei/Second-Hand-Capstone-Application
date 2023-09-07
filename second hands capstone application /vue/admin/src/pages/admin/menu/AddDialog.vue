<template>
  <el-dialog :title="dialog.title" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="700px">
    <el-form ref="form" :model="form" label-width="80px" :rules="rules">
      <el-form-item label="上级菜单" prop="pid" v-if="form.pid > 0">
        <el-cascader
                v-model="form.pid"
                :options="selection"
                :props="{ checkStrictly: true,emitPath:false,label:'title',value:'id'}"
                style="width: 100%">
        </el-cascader>
      </el-form-item>
      <el-form-item label="名称" prop="title">
        <el-input v-model.trim="form.title"></el-input>
      </el-form-item>
      <el-form-item label="组件">
        <el-input v-model.trim="form.component" :placeholder="placeholder"></el-input>
      </el-form-item>
      <el-form-item label="组件类型">
        <el-radio-group v-model="form.component_type" size="medium" @change="radioChange">
          <el-radio-button :label="1">内部组件</el-radio-button>
          <el-radio-button :label="2">外部链接</el-radio-button>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="图标" >
        <el-select v-model="form.icon" placeholder="请选择" style="width: 100%" clearable filterable>
          <el-option
                  v-for="(item,index) in iconList"
                  :key="index"
                  :label="item"
                  :value="item">
            <span style="float: left"><svg-icon :icon-class="item" style="font-size: 18px"></svg-icon></span>
            <span style="float: right">{{ item }}</span>
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="状态">
        <el-radio-group v-model="form.status" size="medium">
          <el-radio-button :label="1">开启</el-radio-button>
          <el-radio-button :label="2">关闭</el-radio-button>
        </el-radio-group>
      </el-form-item>
    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">关 闭</el-button>
      <el-button type="primary" @click="submitForm" :loading="loading">确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
  import {add, edit} from '@/api/admin/menu'

  export default {
    computed:{
      iconList(){
        let icon = []
        const files = require.context('@/icons/svg', true, /\.svg$/)
        files.keys().forEach(key => {
          icon.push(key.replace(/(\.\/|\.svg)/g, ''))
        })
        return icon
      }
    },
    data() {
      return {
        rules: {
          title: [
            {required: true, message: '请输入菜单名称', trigger: 'blur'}
          ],
          pid: [
            {required: true, message: '请选择上级菜单', trigger: 'blur'}
          ]
        },
        loading: false,
        form: {},
        selection:[],
        placeholder:'控制器/模型/方法'
      }
    },
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.$nextTick(() => {
            this.form = Object.assign({}, this.dialogForm)
            this.selection = [...this.dialogSelection]
            this.$refs['form'].clearValidate()
          })
        }
      }
    },
    props: {
      dialog: Object,
      dialogForm: Object,
      dialogSelection: Array
    },
    methods: {
      radioChange(e){
        if(1 == e){
          this.placeholder = '控制器/模型/方法'
        }else{
          this.placeholder = 'http://或者https://'
        }
      },
      dialogClose() {
        this.dialog.show = false
      },
      submitForm() {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            if (this.dialog.operation === 'add') {
              add(this.form)
                .then(res => {
                  this.loading = false
                  this.dialogClose()
                  this.$emit('update')
                })
                .catch(() => {
                  this.loading = false
                })
            } else {
              edit(this.form)
                .then(res => {
                  this.loading = false
                  this.dialogClose()
                  this.$emit('update')
                })
                .catch(() => {
                  this.loading = false
                })
            }
          } else {
            return false;
          }
        });
      }
    },
  }
</script>

