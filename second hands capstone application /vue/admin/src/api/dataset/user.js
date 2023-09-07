import request from '@/utils/request'

export function index(data) {
  return request({
    url: '/dataset/user/index',
    method: 'post',
    data
  })
}

