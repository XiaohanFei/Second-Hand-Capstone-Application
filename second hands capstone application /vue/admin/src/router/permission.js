import router from '@/router/index'
import { notification  } from '@/utils/index'
import { getToken } from '@/utils/auth'
import store from '@/store'
import Layout from '@/components/Layout/Index'
 
//前置路由
router.beforeEach(async(to, from, next) =>{
  
  const hasToken = getToken()

  if(hasToken){
    if (to.path === '/login') {
      next({ path: '/' })
    }else{
      let realname = store.getters.realname
      if(realname){
        next()
      }else{
        try {
          var { userRouter,index } = await store.dispatch('user/getInfo')
          var menu = [
            {path:'/',redirect:index},
            filterAsyncRouter(userRouter),
            {path:'*',redirect:'/error'}
          ]
          router.addRoutes(menu)
          next({ ...to, replace: true })

        } catch (error) {
          await store.dispatch('user/logout')
          notification(error)
          next('/login')
        }
      }
    }
  }else{
    if(to.path == '/login'){
      next();
    }else{
      next('/login')
    }
  }
})

// 遍历后台传来的路由字符串，转换为组件对象
function filterAsyncRouter(asyncRouterMap) {
  const accessedRouters = {
    path:'/page',
    component:Layout,
    children:[]
  }
  accessedRouters.children = asyncRouterMap.filter((route) => {
    route.component = _import(route.component)
    return true
  })
  return accessedRouters
}


const _import = file => () => Promise.resolve(require('@/pages/' + file + '.vue').default)


