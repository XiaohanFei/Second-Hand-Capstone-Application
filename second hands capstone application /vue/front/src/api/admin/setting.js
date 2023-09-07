import request from '@/utils/request'

//系统设置
export function getConfigs() {
  return request({
    url: '/admin/base/getConfigs',
    method: 'get'
  })
}

export function index() {
  return request({
    url: '/admin/setting/index',
    method: 'get'
  })
}

export function edit(data) {
  return request({
    url: '/admin/setting/edit',
    method: 'post',
    data
  })
}
