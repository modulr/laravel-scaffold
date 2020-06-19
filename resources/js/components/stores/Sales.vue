<template lang="html">
  <div class="row justify-content-center mb-3">
    <!-- <div class="col-10 pb-3 text-center mt-5 mb-4">
      <h2 class="font-weight-bold">Promociones</h2>
    </div> -->
    <div class="col-10 col-lg-8">
      <div class="row justify-content-center">
        <div class="col-12 col-md-4 px-3 mb-4" v-for="store in stores">
          <!-- <a href="#modalPromo" data-toggle="modal" data-target="#modalPromo"> -->
          <a href="#" @click.prevent="create(store)">
            <img :src="store.banner_url" class="rounded img-fluid" :alt="store.name">
          </a>
        </div>
        <!-- <div class="modal fade" id="modalPromo" tabindex="-1" role="dialog" aria-hidden="true" v-touch:swipe="swipeHandler">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="carouselPromo" class="carousel slide" data-ride="carousel" data-interval="false" data-touch="true">
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
                        <a class="carousel-control-prev" href="#carouselPromo" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselPromo" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      stores: [],
      order: {}
    }
  },
  mounted () {
    this.getStores()
  },
  methods: {
    swipeHandler (direction) {
      if (direction == 'left') {
        $('#carouselPromo').carousel('next')
      } else if (direction == 'right') {
        $('.carouselPromo').carousel('prev')
      }
      if (direction == 'top' || direction == 'bottom') {
        $('#modalPromo').modal('hide')
      }
    },
    getStores () {
      if (this.stores.length == 0) {
        axios.get(`/api/stores/getStoresLevel23`)
        .then(response => {
          this.stores = response.data
        })
      }
    },
    create (store) {
      this.order.order = `Traeme de ${store.name}`
      localStorage.setItem("order", JSON.stringify(this.order))
      location.href = `/`
    }
  }
}
</script>
