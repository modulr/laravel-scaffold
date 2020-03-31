<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-10 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent border-bottom-0 clearfix">
          <h4 class="float-left pt-2">DIAGNOSTICO</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="saveQuestions" v-if="questions.length > 0">
              <span class="mr-2">Siguiente</span>
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-chevron-right" v-else></i>
            </a>
          </div>
        </div>
        <div class="progress mb-0" style="height: 2px;">
          <div class="progress-bar" role="progressbar" :style="`width: ${count*100/80}%;`" :aria-valuenow="count*100/80" aria-valuemin="0" aria-valuemax="80"></div>
        </div>
        <div class="card-body px-0">
          <div v-if="questions.length > 0">
            <form class="form-horizontal" v-if="!loading">
              <div class="my-4" v-for="question in questions" :key="question.id">
                <p class="lead">{{question.name}}</p>
                <div class="mb-4 col-form-label">
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
            </form>
            <div class="row justify-content-md-center" v-else>
              <div class="col-md-12">
                <content-placeholders>
                  <content-placeholders-heading/>
                  <content-placeholders-text/>
                </content-placeholders>
              </div>
            </div>
            <div class="text-right border-top pt-3">
              <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="saveQuestions">
                <span class="mr-2">Siguiente</span>
                <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                <i class="fas fa-chevron-right" v-else></i>
              </a>
            </div>  
          </div>
          <div v-if="count == 80">
            <video width="100%" autoplay controls>
                <source src="/videos/test_real_final.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="my-4" v-for="personality in personalities" :key="personality.id">
              <p class="lead mb-2"><span class="mr-2">{{personality.personality.name}}</span> [ <a :href="personality.personality.link" target="_blank" class="small">Link</a> ]</p>
              <div class="progress mb-0" style="height: 30px;">
                <div class="progress-bar" role="progressbar" :style="`width: ${personality.result*100/20}%;`" :aria-valuenow="`${personality.result*100/20}`" aria-valuemin="0" aria-valuemax="20">{{Math.round(personality.result*100/20)}}%</div>
              </div>
            </div>
          </div>
        </div>
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