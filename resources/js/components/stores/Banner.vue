<template>
  <div class="row justify-content-center mb-3">
    <div class="col-12 text-center">
      <img class="rounded img-fluid mb-2" :src="user.banner_url">
    </div>
    <div class="col-4 text-center">
      <vue-clip
        :options="optionsBanner"
        :on-sending="sendingBanner"
        :on-complete="completeBanner">
        <template slot="clip-uploader-action">
            <button class="dz-message btn btn-outline-info btn-sm" type="button">Cambiar Banner</button>
        </template>
      </vue-clip>
      <small class="form-text text-danger" v-if="errors.status">{{errors.message}}</small>
      <div class="progress mt-2 mb-3" style="height: 2px;" v-if="preview.progress">
        <div class="progress-bar"
          :class="{'bg-success': preview.status == 'success', 'bg-danger': preview.status == 'error', }"
          :style="{width: preview.progress+'%'}">
        </div>
      </div>
      <!-- <button class="btn btn-ghost-info btn-sm" type="button" @click="removeBannerAuthUser" :disabled="submiting">
        <i class="fas fa-spinner fa-spin" v-if="submiting"></i> Restart banner
      </button> -->
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
      optionsBanner: {
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        url: '/api/stores/uploadBanner',
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
    sendingBanner (file, xhr, formData) {
      this.errors = {}
      this.preview = file
      formData.append('userId', this.user.id)
    },
    completeBanner (file, status, xhr) {
      if (status == 'success') {
        this.user.banner_url = JSON.parse(xhr.response).banner_url
        this.preview = {}
      } else {
        this.errors = {
          status: status,
          message: file.errorMessage
        }
      }
    },
    // removeBannerAuthUser () {
    //   this.submiting = true
    //   axios.post(`/api/users/removeBanner`)
    //   .then(response => {
    //     this.errors = {}
    //     this.submiting = false
    //     this.user.banner_url = response.data.banner_url
    //   })
    //   .catch(error => {
    //     this.errors = error.response.data.errors
    //     this.submiting = false
    //   })
    // }
  }
}
</script>
