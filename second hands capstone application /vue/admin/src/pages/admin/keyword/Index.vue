<template>
  <el-card class="fullscreen">
    <div class="table-button-box">
      <el-button class="filter-item" type="primary" size="small" :loading="loading" @click="submitForm">Save</el-button>
      <el-button class="filter-item" type="info" size="small">Keywords are separated by |</el-button>
    </div>
    <el-form ref="form"  label-width="0" >
      <el-form-item label="" >
        <el-input type="textarea" :rows="20"v-model="content">
        </el-input>
      </el-form-item>

    </el-form>
  </el-card>
</template>

<script>
  import {index, edit} from '@/api/admin/keyword'
  export default {
    name: "MainIndex",
    data() {
      return {
        content:'',
        loading:false
      }
    },
    methods: {
      submitForm() {
        this.loading = true;
        edit({content:this.content})
          .then(res => {
            this.content = res
            this.loading = false
          })
          .catch(() => {
            this.loading = false
          })
      },
    },
    mounted() {
      index()
        .then(res => {
          const {list} = res
          this.content = list
        })
        .catch(() => {
          this.$router.push({path: '/error'})
        })
    }
  }
</script>
