<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent border-bottom-0 clearfix">
          <h4 class="float-left pt-2">Test <span v-if="count == 80">Resultados</span></h4>
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
          <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="errors">
            <strong>Warning!</strong> {{this.errors}}
          </div>
          <div class="text-center" v-if="count == 0 && questions.length == 0 && !loading">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="setQuestions">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-file-alt" v-else></i>
              <span class="ml-1">Iniciar Test</span>
            </a>
          </div>
          <div v-else>
            <form class="form-horizontal" v-if="!loading">
              <div class="my-4 border-bottom" v-for="question in questions" :key="question.id">
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
          </div>
          <div v-if="count == 80">
            <div class="my-4 border-bottom" v-for="personality in personalities" :key="personality.id">
              <p class="lead">{{personality.personality.name}} <a :href="personality.personality.link" target="_blank" class="small">link</a></p>
              <div class="progress mb-0" style="height: 30px;">
                <div class="progress-bar" role="progressbar" :style="`width: ${personality.result*100/max}%;`" :aria-valuenow="`${personality.result*100/max}`" aria-valuemin="0" :aria-valuemax="max">{{Math.round(personality.result*100/max)}}%</div>
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
      max: 0,
      personalities: [],
      loading: true,
      submiting: false,
      errors: ''
    }
  },
  mounted () {
    this.getQuestions()
  },
  methods: {
    setQuestions () {
      this.loading = true
      axios.get(`/api/questions/setQuestions`)
        .then(response => {
          this.getQuestions()
          this.loading = false
      })
    },
    getQuestions () {
      this.loading = true
      axios.get(`/api/questions/getQuestions`)
        .then(response => {
          this.count = response.data.count
          this.questions = response.data.questions
          this.max = response.data.max,
          this.personalities = response.data.personalities
          this.loading = false
      })
    },
    saveQuestions () {
      this.submiting = true
      this.questions.some(question => {
        if (question.answer == null ) {
          this.errors = 'Por favor responde todas las preguntas'
          return this.errors
        } else {
          this.errors = ''
        }
      });
      this.submiting = false
      if (this.errors == '') {
        axios.put(`/api/questions/saveQuestions`, this.questions)
        .then(response => {
          this.count = response.data.count
          this.questions = response.data.questions
          this.max = response.data.max,
          this.personalities = response.data.personalities
          this.errors = ''
          this.submiting = false
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
      
    }
  }
}
</script>