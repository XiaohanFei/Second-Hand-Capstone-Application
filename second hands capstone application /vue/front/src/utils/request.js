import axios from 'axios'
import { notification  } from '@/utils/index'
import { getToken } from '@/utils/auth'
import qs from 'qs'
import store from '@/store'
import router from '@/router/index'

const service = axios.create()

var baseUrl = 'http://127.0.0.1/taobao/secondhand'

if(process.env.NODE_ENV === 'production'){
  baseUrl = window.location.protocol+window.location.port+'//'+window.location.hostname
  // baseUrl = baseUrl+'/secondhand'
}


var sourceUrl = baseUrl+'/public/uploads/'

baseUrl = baseUrl+'/index.php'

window.sourceUrl = sourceUrl
window.baseUrl = baseUrl

service.defaults.baseURL = baseUrl
service.defaults.timeout = 10000
service.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
service.defaults.transformRequest = [obj => qs.stringify(obj)]

//请求拦截
service.interceptors.request.use(
  config => {
    const token = getToken()
    if (token) {
      config.headers['n-token'] = token
    }
    return config
  },
  error => {
    return Promise.reject(error)
  }
)

// 响应拦截
service.interceptors.response.use(
  response=>{
    const res = response.data
    const msg = res.msg

    switch (res.code) {
      case 200:
        //请求成功
        notification(msg,'success')
        return res.data
        break;
      case 404:
        // 非法登录或者登录超时
        notification(msg)
        setTimeout(() =>{
          store.dispatch('user/logout').then(() => {
            router.push({path: '/login'})
          })
        },1000)
        return Promise.reject(response)
        break;
      default:
        // 请求错误
        notification(msg)
        return Promise.reject(response)
    }
  },
  error=>{
    notification('Error')
    return Promise.reject(error)
  }
)

export default service
