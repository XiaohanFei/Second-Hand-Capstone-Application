import request from '@/utils/request'
 
//登录
export function login(data) {
  return request({
    url: '/admin/base/login',
    method: 'post',
    data
  })
}

/**
 * 获取用户信息
 */
export function getInfo() {
  return request({
    url: '/admin/user/getInfo',
    method: 'get'
  })
}

export function getPerson() {
  return request({
    url: '/admin/user/getPerson',
    method: 'get'
  })
}

export function setPerson(data) {
  return request({
    url: '/admin/user/setPerson',
    method: 'post',
    data
  })
}

export function setPassword(data) {
  return request({
    url: '/admin/user/setPassword',
    method: 'post',
    data
  })
}


export function index(data) {
  return request({
    url: '/admin/user/index',
    method: 'post',
    data
  })
}


export function add(data) {
  return request({
    url: '/admin/user/add',
    method: 'post',
    data
  })
}

export function edit(data) {
  return request({
    url: '/admin/user/edit',
    method: 'post',
    data
  })
}

export function del(data) {
  return request({
    url: '/admin/user/delete',
    method: 'delete',
    data
  })
}



