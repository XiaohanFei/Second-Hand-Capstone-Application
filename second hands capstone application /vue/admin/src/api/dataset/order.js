import request from '@/utils/request'

export function index(data) {
  return request({
    url: '/dataset/order/index',
    method: 'post',
    data
  })
}

export function statistics(data) {
  return request({
    url: '/dataset/order/statistics',
    method: 'post',
    data
  })
}
