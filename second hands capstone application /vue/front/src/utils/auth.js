import Cookies from 'js-cookie'

const TokenKey = 'n-token'

export function getToken() {
  return Cookies.get(TokenKey)||false
}

export function setToken(token) {
  return Cookies.set(TokenKey, token)
}

export function removeToken() {
  return Cookies.remove(TokenKey)
}
