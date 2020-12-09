import Vue from 'vue'
import VueRouter from 'vue-router'
import Gallery from '../views/Gallery.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '',
    name: 'Gallery',
    component: Gallery
  }
]

const router = new VueRouter({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes
})

export default router
