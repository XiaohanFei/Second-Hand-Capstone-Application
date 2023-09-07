import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/pages/base/Login'
import Error from '@/pages/base/Error'
import Layout from '@/components/Layout/Index'
Vue.use(Router)
 
export const constantRoutes = [
  {
    path:'/login',
    component:Login
  },
  {
    path:'/error',
    component:Error
  },
  {
    path:'/person',
    component:Layout,
    redirect:'/person/index',
    children:[
      {
        path:'index',
        component:() => import('@/pages/base/Person/Index'),
      }
    ]
  }
]

const createRouter = () => new Router({
  // mode: 'history',
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router

