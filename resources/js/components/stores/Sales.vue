<template lang="html">
  <div class="row justify-content-center mb-3">
      <div class="col-10 pb-3 text-center mt-5 mb-4">
          <h1 class="font-weight-bold">Promociones</h1>
      </div>
      <div class="col-10 col-lg-8">
        <div class="row justify-content-center">
          <div class="col-12 col-md-4 px-2 text-center">
              <a href="#modalPromo1" data-toggle="modal" data-target="#modalPromo1">
                  <img src="/img/stores/banner_pollo_feliz.png" class="img-fluid" alt="Pollo Feliz">
              </a>
              <div class="modal fade" id="modalPromo1" tabindex="-1" role="dialog" aria-hidden="true" v-touch:swipe="swipeHandler">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                      <div class="modal-body">
                          <div id="carouselPromo1" class="carousel slide" data-ride="carousel" data-interval="false" data-touch="true">
                              <div class="carousel-inner">
                                  <div class="carousel-item active" v-touch:swipe="swipeHandler">
                                      <img src="/img/stores/menu/pollo_feliz/pollo_feliz_1.jpg" class="d-block w-100" alt="Pollo Feliz menu 1">
                                  </div>
                                  <div class="carousel-item" v-touch:swipe="swipeHandler">
                                      <img src="/img/stores/menu/pollo_feliz/pollo_feliz_2.jpg" class="d-block w-100" alt="Pollo Feliz menu 2">
                                  </div>
                                  <div class="carousel-item" v-touch:swipe="swipeHandler">
                                      <img src="/img/stores/menu/pollo_feliz/pollo_feliz_3.jpg" class="d-block w-100" alt="Pollo Feliz menu 3">
                                  </div>
                                  <div class="carousel-item" v-touch:swipe="swipeHandler">
                                      <img src="/img/stores/menu/pollo_feliz/pollo_feliz_4.jpg" class="d-block w-100" alt="Pollo Feliz menu 4">
                                  </div>
                                  <div class="carousel-item" v-touch:swipe="swipeHandler">
                                      <img src="/img/stores/menu/pollo_feliz/pollo_feliz_5.jpg" class="d-block w-100" alt="Pollo Feliz menu 5">
                                  </div>
                              </div>
                              <a class="carousel-control-prev" href="#carouselPromo1" role="button" data-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Previous</span>
                              </a>
                              <a class="carousel-control-next" href="#carouselPromo1" role="button" data-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Next</span>
                              </a>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-12 col-md-4 px-2 text-center">
            <a href="#modalPromo2" data-toggle="modal" data-target="#modalPromo2">
                <img src="/img/stores/banner_blvd_chino.png" class="img-fluid" alt="Blvd Chino">
            </a>
              <div class="modal fade" id="modalPromo2" tabindex="-1" role="dialog" aria-hidden="true" v-touch:swipe="swipeHandler">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                      <div class="modal-body">
                          <div id="carouselPromo2" class="carousel slide" data-ride="carousel" data-interval="false" data-touch="true">
                              <div class="carousel-inner">
                                  <div class="carousel-item active">
                                      <img src="/img/stores/menu/blvd_chino/blvd_chino_promocion_jueves.jpeg" class="img-fluid" alt="Blvd Chino Promocion">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-12 col-md-4 px-2 text-center">
              <img src="/img/stores/banner_dogos_co_2.png" class="img-fluid" alt="Dogos & Co">
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  methods: {
    swipeHandler (direction) {
      if (direction == 'left') {
        $('#carouselPromo1').carousel('next')
      } else if (direction == 'right') {
        $('#carouselPromo1').carousel('prev')
      }
      if (direction == 'top' || direction == 'bottom') {
        $('#modalPromo1, #modalPromo2').modal('hide')
      }
    }
  }
}
</script>
