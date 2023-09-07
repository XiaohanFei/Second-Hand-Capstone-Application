import {removeToken} from '@/utils/auth'
import { resetRouter } from '@/router'
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
  setRealName({ commit }, data) {
    commit('SET_REALNAME', data)
  },
  setUserName({ commit }, data) {
    const {username,nickname} = data
    commit('SET_USERNAME', username)
    commit('SET_REALNAME', nickname)
  },
  setAvatar({ commit }, data) {
    commit('SET_AVATAR', data)
  },
}


export default {
  namespaced: true,
  state,
  mutations,
  actions
}
