import request from '@/utils/request'

export function index(data) {
  return request({
    url: '/dataset/comment/index',
    method: 'post',
    data
  })
}




export function del(data) {
  return request({
    url: '/dataset/comment/delete',
    method: 'post',
    data
  })
}