<template>

  <div>
    <!-- Content -->
    <div class="cd-hero">

      <!-- Navigation -->
      <div class="cd-slider-nav">
        <nav class="navbar">
          <div class="tm-navbar-bg">

            <a class="navbar-brand text-uppercase" href="#">Film Gallery</a>

          </div>

        </nav>
      </div>

      <ul class="cd-hero-slider">

        <!-- main gallery -->
        <li class="selected">
          <div class="cd-full-width">
            <div class="container-fluid js-tm-page-content" data-page-no="1" data-page-type="gallery">
              <div class="tm-img-gallery-container">
                <div v-if="isLoaded" class="tm-img-gallery gallery-one">

                  <div v-for="(film,index) in filmList" :key="index" class="grid-item">
                    <figure class="effect-sadie">
                      <img
                        :src="film.cover_image_url"
                        alt="Image"
                        class="img-fluid tm-img"
                        @load="onImgLoad"
                      >
                      <figcaption>
                        <h2 class="tm-figure-title">{{
                          film.name
                        }}</h2>
                        <p class="tm-figure-description">{{
                          film.description
                        }}</p>
                        <a
                          :href="film.cover_image_url"
                          @click="showPhotoInGallery(film.id,$event)"
                        >View
                          more</a>
                      </figcaption>
                    </figure>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>

      </ul> <!-- .cd-hero-slider -->

      <footer class="tm-footer">

        <div class="tm-social-icons-container text-xs-center">
          <a href="#" class="tm-social-link"><i class="fa fa-linkedin" /></a>
        </div>

        <p class="tm-copyright-text">Copyright &copy; <span class="tm-copyright-year">current year</span> Your
          Company

          | Design: TemplateMo</p>

      </footer>

    </div> <!-- .cd-hero -->

    <!-- Preloader, https://ihatetomatoes.net/create-custom-preloading-screen/ -->
    <div id="loader-wrapper">

      <div id="loader" />
      <div class="loader-section section-left" />
      <div class="loader-section section-right" />

    </div>

  </div>
</template>

<script>
import $ from 'jquery'
import '@/assets/js/tether.min.js'

// bootstrap的css在index.scss引用了
import 'bootstrap'

import '@/assets/js/hero-slider-main.js'
import '@/assets/js/jquery.magnific-popup.min.js'

import { getFilm } from '@/api/film'
import { getPhoto } from '@/api/photo'

window.$ = window.jQuery = $

export default {
  data() {
    return {
      filmList: [],
      isLoaded: false
    }
  },
  watch: {
    isLoaded: {
      handler: function(value) {
        if (value === false) {
          getFilm().then(response => {
            if (response.success) {
              this.filmList = response.data.items
              this.isLoaded = true

              const _this = this
              this.$nextTick(function() {
                _this.initGallery()
              })
            }
          }).catch(e => {
            console.log(e)
          })
        }
      },
      immediate: true
    }
  },
  created() {
  },
  methods: {
    initGallery() {
      // $('.gallery-one').magnificPopup({
      //   delegate: 'a', // child items selector, by clicking on it popup will open
      //   type: 'image',
      //   gallery: {
      //     enabled: true
      //   }
      // })

      this.attachResizeEvent()
    },
    adjustHeightOfPage(pageNo) {
      let pageContentHeight = 0

      const pageType = $('div[data-page-no="' + pageNo + '"]').data('page-type')

      if (pageType !== undefined && pageType === 'gallery') {
        pageContentHeight = $('.cd-hero-slider li:nth-of-type(' + pageNo + ') .tm-img-gallery-container').height()
      } else {
        pageContentHeight = $('.cd-hero-slider li:nth-of-type(' + pageNo + ') .js-tm-page-content').height() + 20
      }

      // Get the page height
      const totalPageHeight = $('.cd-slider-nav').height() +
                pageContentHeight +
                $('.tm-footer').outerHeight()

      // Adjust layout based on page height and window height
      if (totalPageHeight > $(window).height()) {
        $('.cd-hero-slider').addClass('small-screen')
        $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css('min-height', totalPageHeight + 'px')
      } else {
        $('.cd-hero-slider').removeClass('small-screen')
        $('.cd-hero-slider li:nth-of-type(' + pageNo + ')').css('min-height', '100%')
      }
    },
    onImgLoad() {
      this.adjustHeightOfPage(1) // Adjust page height
    },
    attachResizeEvent() {
      const _this = this
      $(window).resize(function() {
        const currentPageNo = $('.cd-hero-slider li.selected .js-tm-page-content').data('page-no')

        setTimeout(function() {
          _this.adjustHeightOfPage(currentPageNo)
        }, 1000)
      })

      // Remove preloader (https://ihatetomatoes.net/create-custom-preloading-screen/)
      $('body').addClass('loaded')

      // Write current year in copyright text.
      $('.tm-copyright-year').text(new Date().getFullYear())
    },
    showPhotoInGallery(filmId, $event) {
      $event.preventDefault()

      const photos = []

      getPhoto(filmId).then(response => {
        if (response.success) {
          response.data.items.forEach(photo => {
            photos.push({ src: photo.photo_url })
          })

          if (photos.length > 0) {
            $.magnificPopup.open({
              items: photos,
              type: 'image',
              gallery: { enabled: true }
            }, 0)
          } else {
            alert('No photo is available under the film')
          }
          return true
        }

        console.log(response)
      }).catch(e => console.log(e))
    }
  }
}
</script>

