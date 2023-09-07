import request from '@/utils/request'

export function index(data) {
  return request({
    url: '/dataset/chat/index',
    method: 'post',
    data
  })
}




export function del(data) {
  return request({
    url: '/dataset/chat/delete',
    method: 'post',
    data
  })
}