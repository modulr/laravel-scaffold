<template>
  <div>
    <div class="card mb-3" v-for="(file, index) in stage.files">
      <div class="card-body p-0 d-flex">
        <i class="fas fa-file-alt bg-warning p-3 font-2xl mr-3"></i>
        <div>
          <div class="font-weight-bold mt-1"><a :href="file.url" target="_blank" class="text-secondary">{{file.name}}</a></div>
          <small class="text-muted">Subido por <i>{{file.creator.name}}. {{file.created_at | moment("LL")}}</i></small>
        </div>
        <button type="button" class="close ml-auto mb-auto mt-1 mr-1" aria-label="Close" @click="destroyFile(stage, file, index)">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
    <content-placeholders class="mb-3" v-if="preview.progress > 0">
      <content-placeholders-heading :img="true"/>
    </content-placeholders>
    <vue-clip
      :options="options"
      :on-sending="sending"
      :on-complete="complete">
      <template slot="clip-uploader-action">
          <button class="dz-message btn btn-outline-secondary btn-sm" type="button">Subir un archivo</button>
      </template>
    </vue-clip>
    <!-- <div class="progress my-2" style="height: 1px;">
      <div class="progress-bar"
        :class="{'bg-success': preview.status == 'success', 'bg-danger': preview.status == 'error'}"
        :style="{width: preview.progress+'%'}">
      </div>
    </div> -->
    <small class="form-text text-muted">Tamaño máximo 10MB.</small>
    <small class="form-text text-danger" v-if="errors.status">{{errors.message}}</small>
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
        this.preview.progress = 0
        this.stage.files.push(JSON.parse(xhr.response))
      } else {
        this.errors = {
          status: status,
          message: file.errorMessage
        }
      }
    },
    destroyFile (stage, file, index) {
      swal({
        title: "Estas seguro?",
        text: "Una vez borrado, no podras recuperar el documento!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          axios.delete(`/api/files/destroy/${file.id}`)
          .then(response => {
            stage.files.splice(index, 1)
            this.$toasted.global.error('Documento borrado!')
          })
          .catch(error => {
            if (error.response) {
              this.errors = error.response.data.errors
            }
          })
        }
      })
    }
  }
}
</script>
