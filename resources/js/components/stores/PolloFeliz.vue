<template lang="html">
  <div class="col-12 col-md-4 px-5 pt-1 text-center">
      <a href="#pollo-feliz-menu" data-toggle="modal" data-target="#pollo-feliz-menu">
          <img src="/img/stores/banner_pollo_feliz.png" class="img-fluid" alt="Pollo Feliz">
      </a>
      <div class="modal fade" id="pollo-feliz-menu" tabindex="-1" role="dialog" aria-hidden="true">
          <button type="button" class="close text-body mr-3 mt-3" data-dismiss="modal" aria-label="Close">
             <i class="fas fa-times"></i>
          </button>
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-body">
                  <div id="carouselPolloFeliz" class="carousel slide" data-ride="carousel">
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
                      <a class="carousel-control-prev" href="#carouselPolloFeliz" role="button" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselPolloFeliz" role="button" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                      </a>
                  </div>
              </div>
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
        $('#carouselPolloFeliz').carousel('next')
      } else if (direction == 'right') {
        $('#carouselPolloFeliz').carousel('prev')
      }
      // else if (direction == 'top' || direction == 'bottom') {
      //   $('#pollo-feliz-menu').modal('hide')
      // }
    }
  }
}
</script>
