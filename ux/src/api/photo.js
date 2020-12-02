import request from '@/utils/request'

export function getPhoto(filmId) {
  return request({
    url: '/photo/' + filmId,
    method: 'get'
  })
}

