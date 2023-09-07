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
import '@/router/permission'
 
//全局过滤器
import * as filters from './filters'


// const auth = value => {
//   let auth = store.getters.auth.indexOf(value)
//   return auth === -1?false:true
// }
//
// Vue.directive('auth', {
//   inserted: (el, binding) => {
//     if (!auth(binding.value)) {
//       el.remove()
//     }
//   }
// })

Vue.use(ElementUI, { locale });

// 注册全局过滤器
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key])
})

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
