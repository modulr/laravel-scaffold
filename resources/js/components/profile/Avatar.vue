<template>
  <div class="media">
    <img class="rounded-circle mr-4" style="width: 120px; height: 120px" :src="user.avatar_url">
    <div class="media-body pt-1">
      <vue-clip
        :options="optionsAvatar"
        :on-sending="sendingAvatar"
        :on-complete="completeAvatar">
        <template slot="clip-uploader-action">
            <button class="dz-message btn btn-outline-secondary btn-sm" type="button">Choose file</button>
        </template>
      </vue-clip>
      <small class="form-text text-muted">The maximum file size allowed is 10MB.</small>
      <small class="form-text text-danger" v-if="errors.status">{{errors.message}}</small>
      <div class="progress mt-2 mb-3" style="height: 1px;">
        <div class="progress-bar"
          :class="{'bg-success': preview.status == 'success', 'bg-danger': preview.status == 'error', }"
          :style="{width: preview.progress+'%'}">
        </div>
      </div>
      <button class="btn btn-ghost-info btn-sm" type="button" @click="removeAvatarAuthUser" :disabled="submiting">
        <i class="fas fa-spinner fa-spin" v-if="submiting"></i> Restart avatar
      </button>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      errors: {},
      submiting: false,
      preview: {},
      optionsAvatar: {
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        url: '/api/profile/uploadAvatarAuthUser',
        paramName: 'file',
        parallelUploads: 1,
        maxFilesize: {
          limit: 10,
          message: 'The size image is {{filesize}}MB is greater than the {{maxFilesize}}MB'
        },
        acceptedFiles: {
          extensions: ['image/*'],
          message: 'You are uploading an invalid file'
        }
      }
    }
  },
  props: ['user'],
  methods: {
    sendingAvatar (file, xhr, formData) {
      this.errors = {}
      this.preview = file
    },
    completeAvatar (file, status, xhr) {
      if (status == 'success') {
        this.user.avatar_url = JSON.parse(xhr.response).avatar_url
        // if (Laravel.user.id == this.user.id)
        // Laravel.user.avatar_url = JSON.parse(xhr.response).avatar_url
      } else {
        this.errors = {
          status: status,
          message: file.errorMessage
        }
      }
    },
    removeAvatarAuthUser () {
      this.submiting = true
      axios.post(`/api/profile/removeAvatarAuthUser`)
      .then(response => {
        this.errors = {}
        this.submiting = false
        this.user.avatar_url = response.data.avatar_url
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submiting = false
      })
    }
  }
}
</script>
