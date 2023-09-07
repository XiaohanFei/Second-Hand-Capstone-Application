import request from '@/utils/request'

//登录
export function login(data) {
  return request({
    url: '/home/base/login',
    method: 'post',
    data
  })
}

export function register(data) {
  return request({
    url: '/home/base/register',
    method: 'post',
    data
  })
}

export function getUserInfo(data) {
  return request({
    url: '/home/base/getUserInfo',
    method: 'post',
    data
  })
}




