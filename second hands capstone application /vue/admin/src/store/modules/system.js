const state = {
  title:'',
  logo:'',
  navIndex:0,
  navId:0,
  subTitle:'',
  copyRight:''
}
 
const mutations = {

  SET_TITLE:(state,data)=>{
    state.title = data
  },
  SET_SUB_TITLE:(state,data)=>{
    state.subTitle = data
  },
  SET_COPY_RIGHT:(state,data)=>{
    state.copyRight = data
  },
  SET_NAV_INDEX:(state,data)=>{
    state.navIndex = data
  },
  SET_NAV_ID:(state,data)=>{
    state.navId = data
  },
  SET_LOGO:(state,data)=>{
    state.logo = data
  }
}

const actions = {
  init({ commit }, data) {
    const {  title, logo ,sub_title ,copy_right } = data
    commit('SET_TITLE', title)
    commit('SET_LOGO', logo)
    commit('SET_SUB_TITLE', sub_title)
    commit('SET_COPY_RIGHT', copy_right)
    commit('SET_NAV_INDEX', 0)
    commit('SET_NAV_ID', 0)
  },
  setNavIndex({ commit },data) {
    commit('SET_NAV_INDEX',data)
  },
  setNavId({ commit },data) {
    commit('SET_NAV_ID',data)
  },
  setTitle({ commit },data) {
    commit('SET_TITLE',data)
  },
  setLogo({ commit },data) {
    commit('SET_LOGO',data)
  },
  setSubTitle({ commit },data) {
    commit('SET_SUB_TITLE',data)
  },
  setCopyRight({ commit },data) {
    commit('SET_COPY_RIGHT',data)
  }

}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
