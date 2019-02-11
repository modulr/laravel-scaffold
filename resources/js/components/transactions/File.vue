<template>
  <div class="media">
    <!-- <img class="rounded-circle mr-4" style="width: 120px; height: 120px" :src="user.avatar_url"> -->
    <div class="media-body pt-1">
      <vue-clip
        :options="options"
        :on-sending="sending"
        :on-complete="complete">
        <template slot="clip-uploader-action">
            <button class="dz-message btn btn-outline-secondary btn-sm" type="button">Seleccione un archivo</button>
        </template>
      </vue-clip>
      <small class="form-text text-muted">El tamaño máximo permitido del archivo es de 10MB.</small>
      <small class="form-text text-danger" v-if="errors.status">{{errors.message}}</small>
      <div class="progress mt-2 mb-3" style="height: 1px;">
        <div class="progress-bar"
          :class="{'bg-success': preview.status == 'success', 'bg-danger': preview.status == 'error', }"
          :style="{width: preview.progress+'%'}">
        </div>
      </div>
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
      options: {
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        url: '/api/files/upload',
        paramName: 'file',
        parallelUploads: 1,
        acceptedFiles: {
          extensions: ['application/pdf'],
          message: 'You are uploading an invalid file'
        },
        maxFilesize: {
          limit: 10,
          message: 'The file size is {{filesize}}MB is greater than the {{maxFilesize}}MB'
        }
      }
    }
  },
  props: ['stage'],
  methods: {
    sending (file, xhr, formData) {
      this.errors = {}
      this.preview = file
      formData.append('stageId', this.stage.id)
    },
    complete (file, status, xhr) {
      if (status == 'success') {
        this.stage.files.push(JSON.parse(xhr.response))
        $('#stageUploadFileModal').modal('hide')
      } else {
        this.errors = {
          status: status,
          message: file.errorMessage
        }
      }
    }
  }
}
</script>
