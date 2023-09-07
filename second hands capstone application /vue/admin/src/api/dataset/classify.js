import request from '@/utils/request'

export function index() {
  return request({
    url: '/dataset/classify/index',
    method: 'get'
  })
}

export function add(data) {
  return request({
    url: '/dataset/classify/add',
    method: 'post',
    data
  })
}

export function edit(data) {
  return request({
    url: '/dataset/classify/edit',
    method: 'post',
    data
  })
}

export function handleSort(data) {
  return request({
    url: '/dataset/classify/handleSort',
    method: 'post',
    data
  })
}

export function del(data) {
  return request({
    url: '/dataset/classify/delete',
    method: 'delete',
    data
  })
}