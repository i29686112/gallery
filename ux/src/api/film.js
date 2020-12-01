import request from '@/utils/request'

export function getFilm() {
  return request({
    url: '/film',
    method: 'get'
  })
}

