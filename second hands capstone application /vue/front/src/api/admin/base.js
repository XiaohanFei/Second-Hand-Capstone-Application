import request from '@/utils/request'

//系统设置
export function sendEmail(data) {
  return request({
    url: '/admin/base/sendEmail',
    method: 'post',
    data
  })
}



