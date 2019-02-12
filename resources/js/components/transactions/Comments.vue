<template>
  <div>
    <div class="form-group mb-4">
      <input type="text" class="form-control" :class="{'is-invalid': errors.comment}" placeholder="Escribe un comentario..." v-model="comment" @keyup.enter="storeComment">
      <div class="invalid-feedback" v-if="errors.comment">{{errors.comment[0]}}</div>
    </div>
    <div class="px-2" v-if="!loading">
      <div class="media mb-2" v-for="comment in this.comments">
        <div class="media-left">
          <img class="avatar-sm img-avatar mr-2" :src="comment.creator.avatar_url">
        </div>
        <div class="media-body">
          <span class="text-primary">{{comment.creator.name}}</span>
          <small class="text-muted pull-right">
            {{comment.created_at | moment('from')}}
          </small>
          <br>
          <span>{{comment.comment}}</span>
        </div>
      </div>
    </div>
    <div class="px-2" v-else>
        <content-placeholders>
          <content-placeholders-text/>
        </content-placeholders>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      comment: '',
      comments: [],
      errors: {},
      loading: true
    }
  },
  props: ['stage'],
  watch: {
    stage: function (newValue, oldValue) {
      if (newValue.id) {
        this.getComments(newValue.id)
      }
    }
  },
  methods: {
    getComments(stageId) {
      this.loading = true
      axios.get(`/api/comments/byStage/${stageId}`)
      .then(response => {
        this.comments = response.data
      })
      .catch(error => {
        this.$toasted.global.error('Comments does not exist!')
      })
      .then(() => {
        this.loading = false
      })
    },
    storeComment () {
      var comment = {
        comment: this.comment,
        stage_id: this.stage.id
      }
      axios.post(`/api/comments/store`, comment)
      .then(response => {
        this.comments.unshift(response.data)
        this.comment = ''
        this.errors = {}
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    }
  }
}
</script>
