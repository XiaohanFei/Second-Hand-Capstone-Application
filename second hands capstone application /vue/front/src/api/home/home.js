import request from '@/utils/request'


export function getClassify() {
  return request({
    url: '/home/base/getClassify',
    method: 'get'
  })
}

export function getGoods(data) {
  return request({
    url: '/home/base/getGoods',
    method: 'post',
    data
  })
}


export function getGoodsDetail(data) {
  return request({
    url: '/home/base/getGoodsDetail',
    method: 'post',
    data
  })
}

export function getNocite() {
  return request({
    url: '/home/base/getNocite',
    method: 'get'
  })
}

export function getUserInfo() {
  return request({
    url: '/home/home/getUserInfo',
    method: 'get'
  })
}

export function editUserInfo(data) {
  return request({
    url: '/home/home/editUserInfo',
    method: 'post',
    data
  })
}

export function addAddress(data) {
  return request({
    url: '/home/home/addAddress',
    method: 'post',
    data
  })
}

export function editAddress(data) {
  return request({
    url: '/home/home/editAddress',
    method: 'post',
    data
  })
}

export function getAddress(data) {
  return request({
    url: '/home/home/getAddress',
    method: 'post',
    data
  })
}

export function delAddress(data) {
  return request({
    url: '/home/home/delAddress',
    method: 'post',
    data
  })
}

export function addGoods(data) {
  return request({
    url: '/home/home/addGoods',
    method: 'post',
    data
  })
}
export function addFavourite(data) {
  return request({
    url: '/home/home/addFavourite',
    method: 'post',
    data
  })
}
export function getFavourite(data) {
  return request({
    url: '/home/home/getFavourite',
    method: 'post',
    data
  })
}
export function delFavourite(data) {
  return request({
    url: '/home/home/delFavourite',
    method: 'post',
    data
  })
}
export function getCart(data) {
  return request({
    url: '/home/home/getCart',
    method: 'post',
    data
  })
}
export function delCart(data) {
  return request({
    url: '/home/home/delCart',
    method: 'post',
    data
  })
}
export function addCart(data) {
  return request({
    url: '/home/home/addCart',
    method: 'post',
    data
  })
}
export function addComment(data) {
  return request({
    url: '/home/home/addComment',
    method: 'post',
    data
  })
}
export function getComment(data) {
  return request({
    url: '/home/base/getComment',
    method: 'post',
    data
  })
}
export function addReply(data) {
  return request({
    url: '/home/home/addReply',
    method: 'post',
    data
  })
}
export function getMoney(data) {
  return request({
    url: '/home/home/getMoney',
    method: 'post',
    data
  })
}
export function addMoney(data) {
  return request({
    url: '/home/home/addMoney',
    method: 'post',
    data
  })
}
export function getOrderList(data) {
  return request({
    url: '/home/home/getOrderList',
    method: 'post',
    data
  })
}
export function addOrder(data) {
  return request({
    url: '/home/home/addOrder',
    method: 'post',
    data
  })
}

export function getMyBug(data) {
  return request({
    url: '/home/home/getMyBug',
    method: 'post',
    data
  })
}
export function getMySell(data) {
  return request({
    url: '/home/home/getMySell',
    method: 'post',
    data
  })
}
export function statusGoods(data) {
  return request({
    url: '/home/home/statusGoods',
    method: 'post',
    data
  })
}
export function editGoods(data) {
  return request({
    url: '/home/home/editGoods',
    method: 'post',
    data
  })
}
export function getNoticeDetail(data) {
  return request({
    url: '/home/base/getNoticeDetail',
    method: 'post',
    data
  })
}

export function getChatList(data) {
  return request({
    url: '/home/home/getChatList',
    method: 'post',
    data
  })
}

export function addChat(data) {
  return request({
    url: '/home/home/addChat',
    method: 'post',
    data
  })
}

export function deleteChat(data) {
  return request({
    url: '/home/home/deleteChat',
    method: 'post',
    data
  })
}

export function getChatDetail(data) {
  return request({
    url: '/home/home/getChatDetail',
    method: 'post',
    data
  })
}

export function getOrderDetail(data) {
  return request({
    url: '/home/home/getOrderDetail',
    method: 'post',
    data
  })
}

export function getMyScore(data) {
  return request({
    url: '/home/home/getMyScore',
    method: 'post',
    data
  })
}

export function addScore(data) {
  return request({
    url: '/home/base/addScore',
    method: 'post',
    data
  })
}

export function getScoreList(data) {
  return request({
    url: '/home/home/getScoreList',
    method: 'post',
    data
  })
}





