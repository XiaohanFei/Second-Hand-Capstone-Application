import {removeToken} from '@/utils/auth'
import { resetRouter } from '@/router'
import { getInfo } from '@/api/admin/user'
import store from '@/store'
 
const state = {
  username:'',
  realname:'',
  avatar:'',
  menu:[],
  auth:[]
}

const mutations = {
  SET_USERNAME:(state,data)=>{
    state.username = data
  },
  SET_REALNAME:(state,data)=>{
    state.realname = data
  },
  SET_AVATAR:(state,data)=>{
    state.avatar = data
  },
  SET_MENU:(state,data)=>{
    state.menu = data
  },
  SET_AUTH:(state,data)=>{
    state.auth = data
  }
}

const actions = {

  logout({ commit }){
    return new Promise((resolve) => {
      commit('SET_REALNAME', '')
      commit('SET_MENU', [])
      commit('SET_AVATAR', '')
      commit('SET_AUTH', [])
      removeToken()
      resetRouter()
      resolve()
    })
  },
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo().then(res => {
        resetRouter()
        const { realname,avatar,menu,router,auth} = res
        if(router.length){
          commit('SET_REALNAME', realname)
          commit('SET_AVATAR', avatar)
          commit('SET_MENU', menu)
          commit('SET_AUTH', auth)
          let index  = getIndex(menu)
          if(index){
            resolve({userRouter:router,index:index})
          }else{
            reject('当前用户没有菜单')
          }
        }else{
          reject('当前用户没有菜单')
        }
      }).catch(error => {
        reject(error)
      })
    })
  },
  setRealName({ commit }, data) {
    commit('SET_REALNAME', data)
  },
  setUserName({ commit }, data) {
    commit('SET_USERNAME', data)
  },
  setAvatar({ commit }, data) {
    commit('SET_AVATAR', data)
  },
}

function getIndex(obj) {
  for(let key  in obj){
    if(obj[key].path.length){
      if(store.getters.navId == 0){
        store.dispatch('system/setNavId',obj[key].id)
        store.dispatch('system/setNavIndex',parseInt(key))
      }
      return '/page/'+obj[key].path
    }else if(obj[key].hasOwnProperty('children')){
      return getIndex(obj[key].children)
    }else{
      continue
    }
  }
  return false
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
