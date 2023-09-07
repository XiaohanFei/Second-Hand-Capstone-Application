import request from '@/utils/request'

export function index(data) {
  return request({
    url: '/dataset/notice/index',
    method: 'post',
    data
  })
}


export function edit(data) {
  return request({
    url: '/dataset/notice/edit',
    method: 'post',
    data
  })
}

export function add(data) {
  return request({
    url: '/dataset/notice/add',
    method: 'post',
    data
  })
}

export function del(data) {
  return request({
    url: '/dataset/notice/delete',
    method: 'post',
    data
  })
}

