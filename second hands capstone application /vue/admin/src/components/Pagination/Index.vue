<template>
  <div class="pagination-container" v-show="total > 0">
    <el-pagination
      :background="true"
      layout="total, sizes, prev, pager, next, jumper"
      :page-sizes="pageSizes"
      :current-page.sync="currentPage"
      :page-size.sync="pageSize"
      :total="total"
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange">
    </el-pagination>
  </div>
</template>

<script>

  export default {
    name: 'Index',
    props: {
      total: {
        required: true,
        type: Number
      },
      page: {
        type: Number,
        default: 1
      },
      limit: {
        type: Number,
        default: 20
      },
      pageSizes: {
        type: Array,
        default() {
          return [10, 20, 30, 50]
        }
      }
    },
    computed: {
      currentPage: {
        get() {
          return this.page
        },
        set(val) {
          this.$emit('update:page', val)
        }
      },
      pageSize: {
        get() {
          return this.limit
        },
        set(val) {
          this.$emit('update:limit', val)
        }
      }
    },
    methods: {
      handleSizeChange(val) {
        this.$emit('update', {page: this.currentPage, limit: val})
        // scrollToTop(".main-container .el-scrollbar__wrap")
      },
      handleCurrentChange(val) {
        this.$emit('update', {page: val, limit: this.pageSize})
        // scrollToTop(".main-container .el-scrollbar__wrap")
      }
    }
  }
</script>



