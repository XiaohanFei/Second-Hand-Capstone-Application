import request from '@/utils/request'


export function index() {
  return request({
    url: '/admin/email/index',
    method: 'get'
  })
}

export function edit(data) {
  return request({
    url: '/admin/email/edit',
    method: 'post',
    data
  })
}
