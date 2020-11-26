import request from '@/utils/request'

export function setCookie() {
  return request({
    url: '/cookie/set',
    method: 'get'
  })
}
export function getCookie() {
  return request({
    url: '/cookie/get',
    method: 'get'
  })
}
