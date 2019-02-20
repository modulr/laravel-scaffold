<template>
  <div>
    <div class="input-group mb-2">
      <input type="text" class="form-control" :class="{'is-invalid': errors.comment}" placeholder="Escribe un comentario..." v-model="comment" @keyup.enter="storeComment">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" @keyup.enter="storeComment"><i class="fas fa-paper-plane"></i></button>
      </div>
      <div class="invalid-feedback" v-if="errors.comment">{{errors.comment[0]}}</div>
    </div>
    <div class="p-4 rounded border overflow-auto" style="max-height: 300px;">
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
  </div>
</template>

<script>
export default {
  data () {
    return {
      comment: '',
      comments: [],
      errors: {}
    }
  },
  props: ['stage'],
  mounted () {
    this.comments = this.stage.comments
  },
  methods: {
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
        if (error.response) {
          this.errors = error.response.data.errors
        }
      })
    }
  }
}
</script>
