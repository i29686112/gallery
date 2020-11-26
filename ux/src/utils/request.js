import axios from 'axios'
import store from '@/store'
import router from '@/router'

axios.defaults.withCredentials = true

// create an axios instance
const service = axios.create({
  baseURL: process.env.VUE_APP_BASE_API, // url = base url + request url
  // withCredentials: true, // send cookies when cross-domain requests
  timeout: 15000, // request timeout
  withCredentials: false
})

service.CancelToken = axios.CancelToken
service.isCancel = axios.isCancel

// request interceptor
service.interceptors.request.use(
  config => {
    // do something before request is sent

    return config
  },
  error => {
    // do something with request error
    console.log(error) // for debug
    return Promise.reject(error)
  }
)

// response interceptor
service.interceptors.response.use(
  /**
   * If you want to get http information such as headers or status
   * Please return  response => response
   */

  /**
   * Determine the request status by custom code
   * Here is just an example
   * You can also judge the status by HTTP Status Code
   */
  response => {
    const res = response.data
    // const status = response.status

    let errorMsg = ''
    if (res && res.errorCode === -501) {
      // `no permission error`
      errorMsg = 'not login'
    }

    if (errorMsg && process.env.VUE_APP_AUTO_LOGOUT !== 'false') {
      store.dispatch('user/resetToken').then(() => {
        router.push({
          path: `/login`,
          query: { errorMsg: errorMsg }
        })
      })
      return { success: false }
    } else {
      return res
    }
  },
  error => {
    console.log('err' + error) // for debug

    return { success: false, error: error.response }
  }
)

export default service
