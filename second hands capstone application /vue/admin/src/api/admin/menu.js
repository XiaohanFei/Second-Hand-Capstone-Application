import request from '@/utils/request'

export function index() {
  return request({
    url: '/admin/menu/index',
    method: 'get'
  })
}
/**
 * 添加菜单
 * @param data
 */
export function add(data) {
  return request({
    url: '/admin/menu/add',
    method: 'post',
    data
  })
}

export function edit(data) {
  return request({
    url: '/admin/menu/edit',
    method: 'post',
    data
  })
}

export function handleSort(data) {
  return request({
    url: '/admin/menu/handleSort',
    method: 'post',
    data
  })
}

export function getChilren(data) {
  return request({
    url: '/admin/menu/getChilren',
    method: 'post',
    data
  })
}

export function del(data) {
  return request({
    url: '/admin/menu/delete',
    method: 'post',
    data
  })
}
