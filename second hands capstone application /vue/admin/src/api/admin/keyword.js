import request from '@/utils/request'

export function index() {
  return request({
    url: '/admin/keyword/index',
    method: 'get'
  })
}

export function edit(data) {
  return request({
    url: '/admin/keyword/edit',
    method: 'post',
    data
  })
}
