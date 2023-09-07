const getters = {
  username:state=>state.user.username,
  realname:state=>state.user.realname,
  avatar:state=>state.user.avatar,
  menu:state=>state.user.menu,
  auth:state=>state.user.auth,

  title:state=>state.system.title,
  logo:state=>state.system.logo,
  navIndex:state=>state.system.navIndex,
  navId:state=>state.system.navId,
  subTitle:state=>state.system.subTitle,
  copyRight:state=>state.system.copyRight
}

export default getters
