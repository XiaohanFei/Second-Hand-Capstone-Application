<template>
  <div class="error-container">
    <img :src="imgUrl">
    <h2>Sorry, the page you visited doesn't exist
      <el-button type="primary" @click="returnHome">Return to home page</el-button>
    </h2>
  </div>
</template>

<script>
  export default {
    name: "Error",
    data() {
      return {
        imgUrl: require('@/assets/images/error.jpg'),
      }
    },
    methods: {
      returnHome() {
        this.$router.push({path: '/'})
      }
    }
  }
</script>

<style scoped>
  .error-container {
    width: 100%;
    height: 100%;
    text-align: center;
  }

  img {
    margin: 180px auto 50px;
  }

  .el-button {
    margin-left: 50px;
  }
</style>
