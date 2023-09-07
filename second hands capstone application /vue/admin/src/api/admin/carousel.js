import request from '@/utils/request'

export function index() {
  return request({
    url: '/admin/carousel/index',
    method: 'get'
  })
}

export function add(data) {
  return request({
    url: '/admin/carousel/add',
    method: 'post',
    data
  })
}

export function edit(data) {
  return request({
    url: '/admin/carousel/edit',
    method: 'post',
    data
  })
}

export function del(data) {
  return request({
    url: '/admin/carousel/delete',
    method: 'post',
    data
  })
}


export function handleSort(data) {
  return request({
    url: '/admin/carousel/handleSort',
    method: 'post',
    data
  })
}
