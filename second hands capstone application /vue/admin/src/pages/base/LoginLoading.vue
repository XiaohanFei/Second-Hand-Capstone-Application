<template>
  <div class="index-loading" v-show="isShow">
    <div class="loader">
      <div class="timerWrap">
        <svg version="1.1" viewBox="131.623 175.5 120 160" preserveAspectRatio="xMinYMin meet" class="timer">
          <path fill="#FFFFFF" d="M212.922,255.45l36.855-64.492c1.742-3.069,1.742-6.836-0.037-9.896c-1.783-3.06-5.037-4.938-8.581-4.938
			h-99.158c-3.524,0-6.797,1.878-8.569,4.938c-1.773,3.06-1.792,6.827-0.03,9.896l36.846,64.491l-36.845,64.492
			c-1.762,3.068-1.743,6.836,0.03,9.896c1.772,3.061,5.044,4.938,8.569,4.938h99.158c3.544,0,6.798-1.878,8.581-4.938
			c1.779-3.06,1.779-6.827,0.037-9.896L212.922,255.45z M142.001,324.86l39.664-69.41l-39.664-69.41h99.158l-39.663,69.41
			l39.663,69.41H142.001z"></path>
        </svg>
      </div>
    </div>
    <p>Home page loading, please wait</p>
  </div>
</template>

<script>
  export default {
    name: "LoginLoading",
    props: {
      isShow: {
        required: true,
        type: Boolean
      }
    },
  }
</script>

<style lang="scss" scoped>
  .index-loading{
    /*transition: all .58s;*/
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    background: white;
    z-index: 100;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    p{
      margin-top: 20px;
      margin-bottom: 100px;
      font-weight: bold;
      font-size: 20px;
      letter-spacing: 0.2em;
    }
    @keyframes timerRotate {
      0% {
        transform: rotateZ(0deg);
      }
      50% {
        transform: rotateZ(0deg);
      }
      100% {
        transform: rotateZ(-180deg);
      }
    }

    @keyframes bottomFill {
      0% {
        border-bottom-width: 0px;
      }
      50% {
        border-bottom-width: 60px;
      }
      100% {
        border-bottom-width: 60px;
      }
    }


    @keyframes topEmpty {
      0% {
        top: 19px;
        border-top-width: 60px;
        border-left-width: 35px;
        border-right-width: 35px;
      }
      50% {
        top: 80px;
        border-top-width: 0px;
        border-left-width: 0px;
        border-right-width: 0px;
      }
      100% {
        top: 80px;
        border-top-width: 0px;
        border-left-width: 0px;
        border-right-width: 0px;
      }
    }

    .loader {
      backface-visibility: hidden;
    }
    .loader .timerWrap {
      position: relative;
      animation: timerRotate 2s infinite ease;
      width: 120px;
      height: 160px;
    }
    .loader .timerWrap:before {
      content: "";
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 60px 35px 0 35px;
      border-color: #409EFF transparent transparent transparent;
      position: absolute;
      top: 19px;
      left: 0;
      right: 0;
      margin: auto;
      animation: topEmpty 2s infinite ease;
    }
    .loader .timerWrap:after {
      content: "";
      width: 0;
      height: 0;
      border-style: solid;
      border-width: 0 35px 60px 35px;
      border-color: transparent transparent #409EFF transparent;
      position: absolute;
      bottom: 19px;
      left: 0;
      right: 0;
      margin: auto;
      animation: bottomFill 2s infinite ease;
    }
    .loader .timerWrap .timer {
      width: 120px;
      max-width: 100%;
      height: 160px;
      position: relative;
      top: 0;
      left: 0;
    }
    .loader .timerWrap .timer path {
      fill: black;
    }

  }
</style>