<template lang="html">
    <div class="row justify-content-center my-5">
      <div class="col-9 col-sm-6 col-md-3 pl-4 py-4 text-center">
          <h5 class="mb-4"><strong>Síguenos</strong></h5>
          <a :href="this.config.facebook" target="_blank" class="text-secondary mr-3">
            <i class="fab fa-facebook-square fa-2x"></i>
          </a>
          <a :href="this.config.instagram" target="_blank" class="text-secondary mr-3">
            <i class="fab fa-instagram fa-2x"></i>
          </a>
          <a :href="`https://wa.me/52${this.config.phone}?text=¡Hola!%20quiero%20más%20información%20sobre%20...`" target="_blank" class="text-secondary">
            <i class="fab fa-whatsapp fa-2x"></i>
          </a>
          <div>
            <h5 class="mt-3">
              <a class="text-secondary" :href="`tel:${this.config.phone}`">
                <!-- <small class="fa-stack mr-1">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                </small> -->
                {{this.config.phone}}
            </a>
            </h5>
          </div>
      </div>
      <div class="col-9 col-sm-6 col-md-3 pl-4 py-4 text-center">
            <h5 class="mb-3"><strong>Descarga el App</strong></h5>
            <a target="_blank" href='https://play.google.com/store/apps/details?id=com.traeme.traemeapp&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'>
                <img alt='Disponible en Google Play' class="img-fluid logo-footer" src='img/googleplay.png'/>
            </a>
            <br>
            <a target="_blank" href='https://appgallery5.huawei.com/#/app/C102447831'>
                <img alt='Disponible en App Gallery' class="img-fluid logo-footer" src='img/appgallery.png'/>
            </a>
            <a href="#" data-toggle="modal" data-target="#exampleModal">
                <img alt='Disponible en App Store' class="img-fluid logo-footer" src='img/appstore.png'/>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Descarga la WebApp para IPhone</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
                      <ol class="carousel-indicators">
                        <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleControls" data-slide-to="1"></li>
                        <li data-target="#carouselExampleControls" data-slide-to="2"></li>
                        <li data-target="#carouselExampleControls" data-slide-to="3"></li>
                        <li data-target="#carouselExampleControls" data-slide-to="4"></li>
                      </ol>
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img src="img/appstore/1.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                          <img src="img/appstore/2.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                          <img src="img/appstore/3.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                          <img src="img/appstore/4.jpg" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                          <img src="img/appstore/5.jpg" class="d-block w-100">
                        </div>
                      </div>
                      <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      <div class="col-9 col-sm-6 col-md-3 pl-4 py-4 text-center">
            <!-- <h5 class="mb-4"><strong>Información de interés</strong></h5> -->
            <p class="mb-3"><strong>{{config.schedule}}</strong></p>
            <p class="mb-2"><a class="text-secondary" href="/terms-of-use">Términos y condiciones</a></p>
            <p class="mb-2"><a class="text-secondary" href="/privacy-policy">Aviso de privacidad</a></p>
        </div>
    </div>
</template>

<script>
export default {
  data () {
    return {
      config: {}
    }
  },
  mounted () {
    this.getConfig()
  },
  methods: {
    getConfig () {
      axios.get(`/api/configs/first`)
      .then(response => {
        this.config = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
  }
}
</script>
