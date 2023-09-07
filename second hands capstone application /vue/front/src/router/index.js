import Vue from 'vue'
import Router from 'vue-router'
import Layout from '@/components/Layout/Index'
import LayoutMobile from '@/components/LayoutMobile/Index'
Vue.use(Router)

export const constantRoutes = [
  {path:'/',redirect:'/home/index'},
  {
    path:'/home',
    component:Layout,
    children:[
      {
        path:'index',
        component:() => import('@/pages/home/index/Index'),
      },
      {
        path:'chat',
        component:() => import('@/pages/home/chat/Index'),
      },
      {
        path:'chatDetail',
        component:() => import('@/pages/home/chat/Detail'),
      },
      {
        path:'person',
        component:() => import('@/pages/home/person/Index'),
      },
      {
        path:'user',
        component:() => import('@/pages/home/person/Other'),
      },
      {
        path:'publish',
        component:() => import('@/pages/home/publish/Index'),
      },
      {
        path:'publishEdit',
        component:() => import('@/pages/home/publish/Edit'),
      },
      {
        path:'goodDetail',
        component:() => import('@/pages/home/goods/Detail'),
      },
      {
        path:'notice',
        component:() => import('@/pages/home/notice/Index'),
      },
      {
        path:'favourite',
        component:() => import('@/pages/home/favourite/Index'),
      },
      {
        path:'cart',
        component:() => import('@/pages/home/cart/Index'),
      }
    ]
  },
  {
    path:'/mobile',
    component:LayoutMobile,
    children:[
      {
        path:'index',
        component:() => import('@/pages/mobile/index/Index'),
      },
      {
        path:'chat',
        component:() => import('@/pages/mobile/chat/Index'),
      },
      {
        path:'cart',
        component:() => import('@/pages/mobile/cart/Index'),
      },
      {
        path:'person',
        component:() => import('@/pages/mobile/person/Index'),
      },
      {
        path:'notice',
        component:() => import('@/pages/mobile/notice/Index'),
      },
      {
        path:'goodDetail',
        component:() => import('@/pages/mobile/goods/Detail'),
      },
      {
        path:'user',
        component:() => import('@/pages/mobile/person/Other'),
      },
      {
        path:'chatDetail',
        component:() => import('@/pages/mobile/chat/Detail'),
      },
      {
        path:'publish',
        component:() => import('@/pages/mobile/publish/Index'),
      },
      {
        path:'publishEdit',
        component:() => import('@/pages/mobile/publish/Edit'),
      },
    ]
  },
  {
    path:'/login',
    component:() => import('@/pages/base/Login'),
  },
  {
    path:'/register',
    component:() => import('@/pages/base/Register'),
  },
  {
    path:'/error',
    component:() => import('@/pages/base/Error'),
  },

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

