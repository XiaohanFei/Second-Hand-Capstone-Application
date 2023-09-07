import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
// element-ui框架
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
// 重置样式
import 'normalize.css/normalize.css'
//element-ui 样式
import 'element-ui/lib/theme-chalk/index.css';

// 全局样式
import '@/styles/app.scss'
// 图标
import '@/icons'

//权限控制
import '@/router/index'

import WotDesign from 'wot-design'
import 'wot-design/lib/theme-default/index.css'
import enUS from 'wot-design/lib/locale/lang/en-US'
Vue.use(WotDesign,{locale: enUS})



Vue.use(ElementUI, { locale });



Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
