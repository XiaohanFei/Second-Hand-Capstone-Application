import request from '@/utils/request'

export function index(data) {
  return request({
    url: '/dataset/goods/index',
    method: 'post',
    data
  })
}

export function getClassify(data) {
  return request({
    url: '/dataset/goods/getClassify',
    method: 'post',
    data
  })
}

export function getGoodsDetail(data) {
  return request({
    url: '/dataset/goods/getGoodsDetail',
    method: 'post',
    data
  })
}


export function edit(data) {
  return request({
    url: '/dataset/goods/edit',
    method: 'post',
    data
  })
}


export function del(data) {
  return request({
    url: '/dataset/goods/delete',
    method: 'post',
    data
  })
}