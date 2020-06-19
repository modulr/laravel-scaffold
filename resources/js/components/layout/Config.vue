<template lang="html">
    <div class="row justify-content-center my-5">
        <div class="col-9 col-sm-6 col-md-3 pl-4 py-4">
            <h5 class="mb-3 ml-2"><strong>Descarga el App</strong></h5>
            <a target="_blank" href='https://play.google.com/store/apps/details?id=com.traeme.traemeapp&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'>
                <img alt='Disponible en Google Play' class="img-fluid logo-footer" src='https://play.google.com/intl/en_us/badges/static/images/badges/es-419_badge_web_generic.png'/>
            </a>
        </div>
        <div class="col-9 col-sm-6 col-md-3 pl-4 py-4">
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
              <h5 class="mt-4">
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
        <div class="col-9 col-sm-6 col-md-3 pl-4 py-4">
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
