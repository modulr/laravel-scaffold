<template>
  <div class="container mb-5">
    <div class="row justify-content-center" v-if="questions.length > 0">
      <div class="col-12 text-center">
        <h2 class="title mt-4 mb-3">DIAGNOSTICO</h2>
      </div>
      <div class="col-md-10 back-questions d-flex align-items-center">
        <div class="row justify-content-center flex-fill">
          <div class="col-12">
            <form class="form-horizontal" v-if="!loading">
              <div class="progress mt-1 mb-4 rounded-0" style="height: 10px; width:80%">
                <div class="progress-bar" role="progressbar" :style="`width: ${count*100/80}%;`" :aria-valuenow="count*100/80" aria-valuemin="0" aria-valuemax="80"></div>
              </div>
              <div class="my-2" v-for="question in questions" :key="question.id">
                <p class="mb-0">{{question.name}}</p>
                <div class="col-form-label">
                  <div class="form-check form-check-inline mr-3">
                    <input class="form-check-input" :id="`si${question.id}`" type="radio" value="si" v-model="question.answer">
                    <label class="form-check-label" :for="`si${question.id}`">Si</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" :id="`no${question.id}`" type="radio" value="no" v-model="question.answer">
                    <label class="form-check-label" :for="`no${question.id}`">No</label>
                  </div>
                </div>
              </div>
              <div class="text-center mt-3">
                <a class="btn btn-primary rounded-0 btn-cut title px-4 py-2" href="#" :disabled="submiting" @click.prevent="saveQuestions">
                  <span class="mr-2">Siguiente</span>
                  <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                  <i class="fas fa-chevron-right" v-else></i>
                </a>
              </div> 
            </form>
            <content-placeholders class="my-4" v-else>
              <content-placeholders-heading/>
              <content-placeholders-text/>
            </content-placeholders>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-if="count == 80">
      <div class="col-12 text-center">
        <h2 class="title mt-4 mb-4">RESULTADOS</h2>
      </div>
      <div class="col-md-6 back-results">
        <div class="my-2 text-left" v-for="personality in personalities" :key="personality.id">
          <p class="mb-0">{{personality.personality.name}}</p>
          <div class="progress mb-0 rounded-0" style="height: 20px;">
            <div class="progress-bar bg-danger" role="progressbar" :style="`width: ${personality.result*100/20}%;`" :aria-valuenow="`${personality.result*100/20}`" aria-valuemin="0" aria-valuemax="20">{{Math.round(personality.result*100/20)}}%</div>
          </div>
        </div>
      </div>
      <div class="col-md-6 back-results-video text-center">
        <video autoplay controls>
          <source src="/videos/test_real_final.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
      <div class="col-md-6">
        <img src="/img/results-text.png" class="img-fluid mt-1">
      </div>
      <div class="col-md-6 text-center">
        <a href="https://www.i11online.com/products/medeex" target="_blank" class="btn btn-primary rounded-0 btn-cut title px-4 py-2 mt-5">COMENZAR AHORA</a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      count: 0,
      questions: [],
      personalities: [],
      loading: true,
      submiting: false,
      errors: false
    }
  },
  mounted () {
    this.getQuestions()
  },
  methods: {
    getQuestions () {
      this.loading = true
      axios.get(`/api/questions/getQuestions`)
        .then(response => {
          this.count = response.data.count
          this.questions = response.data.questions
          this.personalities = response.data.personalities
          this.loading = false
      })
    },
    saveQuestions () {
      this.submiting = true
      this.errors = false
      this.questions.some(question => {
        if (question.answer == null ) {
          this.errors = true
          return this.errors
        }
      });
      if (this.errors) {
        this.$toasted.global.error('Por favor responde todas las preguntas');
        this.submiting = false
      } else { 
        axios.put(`/api/questions/saveQuestions`, this.questions)
        .then(response => {
          this.count = response.data.count
          this.questions = response.data.questions
          this.personalities = response.data.personalities
          this.submiting = false
        })
        .catch(error => {
          this.submiting = false
        })
      }
    }
  }
}
</script>