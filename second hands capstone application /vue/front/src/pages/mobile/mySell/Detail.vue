<template>
  <el-dialog title="Buyer information" :visible.sync="dialog.show" :close-on-click-modal="false"
             width="100%">
    <el-form  label-width="120px"   size="mini">
      <el-form-item label="Order number">
        <el-input :value="form.order_id" readonly></el-input>
      </el-form-item>
      <el-form-item label="Payment time">
        <el-input :value="form.create_time" readonly></el-input>
      </el-form-item>
      <el-form-item label="Buyer name">
        <el-input :value="form.user.nickname" readonly></el-input>
      </el-form-item>
      <el-form-item label="Buyer mobile">
        <el-input :value="form.user.mobile" readonly></el-input>
      </el-form-item>
      <el-form-item label="Buyer address">
        <el-input :value="form.address" readonly></el-input>
      </el-form-item>
    </el-form>
    <div slot="footer">
      <el-button @click="dialogClose">Close</el-button>
    </div>
  </el-dialog>
</template>

<script>

  import {getOrderDetail} from '@/api/home/home'
  export default {

    data() {
      return {
        form: {},
      }
    },
    watch: {
      'dialog.show'(val) {
        if (val) {
          this.$nextTick(() => {
            getOrderDetail({id:this.dialog.id}).then(res=>{
              this.form = res
            }).catch(()=>{return})
          })
        }
      }
    },
    props: {
      dialog: Object,
    },
    methods: {

      dialogClose() {
        this.dialog.show = false
      },

    },
  }
</script>

