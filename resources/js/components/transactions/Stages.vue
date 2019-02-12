<template>
  <div>
    <ul class="list-group list-group-flush" v-if="transaction.stages != null && transaction.stages.length > 0">
      <li v-for="(stage, index) in transaction.stages" track-by="id" class="list-group-item media border-light">
        <div class="float-left mr-3">
          <label class="switch switch-label switch-success">
            <input class="switch-input" type="checkbox" v-model="stage.authorized" @change="toggleAuthorized(stage, index)">
            <span class="switch-slider" data-checked="✓" data-unchecked="✕"></span>
          </label>
        </div>
        <div class="media-body">
          <div class="d-flex justify-content-between">
            <strong>{{stage.name}}</strong>
            <div>
              <a href="#" class="text-secondary" @click.prevent="editStage(stage.id, index)"><i class="fas fa-pencil-alt"></i></a>
              <a href="#" class="ml-2 text-secondary" @click.prevent="uploadFile(stage, index)"><i class="fas fa-cloud-upload-alt"></i></a>
              <a href="#" class="ml-2 text-secondary"><i class="fas fa-comment"></i></a>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <div class="text-muted small" v-if="stage.authorized && stage.authorized_by_user">Autorizada por <i>{{stage.authorized_by_user.name}}</i></div>
              <div class="card my-3" v-for="(file, index) in stage.files">
                <div class="card-body p-0 d-flex align-items-center">
                  <i class="fas fa-file-alt bg-warning p-2 font-2xl mr-3"></i>
                  <div>
                    <div class="text-muted font-weight-bold small"><a :href="file.url" target="_blank" class="text-secondary">{{file.name}}</a></div>
                  </div>
                  <button type="button" class="close ml-auto mb-auto mt-1 mr-1" aria-label="Close" @click="destroyFile(stage, file, index)">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
    <div class="card-body text-center px-0">
      <a class="btn btn-success mb-2" href="#" role="button" @click.prevent="newStage">
        <i class="fa fa-plus"></i>&nbsp; Crear etapa
      </a>
      <p class="text-muted"><small>Agrega etapas en las transaccion.</small></p>
    </div>
    <!-- stage Create -->
    <div class="modal fade" id="stageCreateModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear etapa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="stage.name" placeholder="Proforma Expo">
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submitingCreate" @click.prevent="create">
              <i class="fas fa-spinner fa-spin" v-if="submitingCreate"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- stage Edit -->
    <div class="modal fade" id="stageEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar etapa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row" v-if="!loadingEdit">
              <div class="form-group col-md-12">
                <label>Nombre</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="stage.name" placeholder="Proforma Expo">
                <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
              </div>
            </div>
            <div class="row" v-else>
              <div class="col-md-12">
                <content-placeholders>
                  <content-placeholders-text/>
                </content-placeholders>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submitingEdit" @click.prevent="update">
              <i class="fas fa-spinner fa-spin" v-if="submitingEdit"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
            <a class="card-header-action ml-1" href="#" :disabled="submitingDestroy" @click.prevent="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Borrar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- stage Upload File -->
    <div class="modal fade" id="stageUploadFileModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Subir Documento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <transactions-file :stage="stage"></transactions-file>
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
      stage: {},
      errors: {},
      loadingEdit: true,
      submitingCreate: false,
      submitingEdit: false,
      submitingDestroy: false
    }
  },
  props: ['transaction'],
  methods: {
    newStage () {
      this.stage = {}
      this.stage.transactionId = this.transaction.id
      this.errors = {}
      $('#stageCreateModal').modal('show')
    },
    create () {
      if (!this.submitingCreate) {
        this.submitingCreate = true
        axios.post(`/api/stages/store`, this.stage)
        .then(response => {
          this.transaction.stages.push(response.data)
          this.$toasted.global.error('Etapa creada!')
          $('#stageCreateModal').modal('hide')
        })
        .catch(error => {
          this.errors = error.response.data.errors
        })
        .then(() => {
          this.submitingCreate = false
        })
      }
    },
    editStage (stageId, index) {
      this.errors = {}
      this.loadingEdit = true
      axios.get(`/api/stages/${stageId}`)
      .then(response => {
        this.stage = response.data
        this.stage.index = index
      })
      .catch(error => {
        this.$toasted.global.error('Stage does not exist!')
      })
      .then(() => {
        this.loadingEdit = false
      })
      $('#stageEditModal').modal('show')
    },
    update () {
      if (!this.submitingEdit) {
        this.submitingEdit = true
        axios.put(`/api/stages/update/${this.stage.id}`, this.stage)
        .then(response => {
          this.transaction.stages[this.stage.index].name = response.data.name
          this.$toasted.global.error('Updated stage!')
          $('#stageEditModal').modal('hide')
        })
        .catch(error => {
          this.errors = error.response.data.errors
        })
        .then(() => {
          this.submitingEdit = false
        })
      }
    },
    destroy () {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "Estas seguro?",
          text: "Una vez borrada, no podras recuperar la etapa!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/stages/${this.stage.id}`)
            .then(response => {
              this.transaction.stages.splice(this.stage.index, 1)
              this.$toasted.global.error('Etapa borrada!')
              $('#stageEditModal').modal('hide')
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    },
    toggleAuthorized (stage, index) {
      axios.put(`/api/stages/toggleAuthorized/${stage.id}`, stage)
      .then(response => {
        this.transaction.stages[index].authorized = response.data.authorized
        this.transaction.stages[index].authorized_by = response.data.authorized_by
        this.transaction.stages[index].authorized_by_user = response.data.authorized_by_user
        if (response.data.authorized) {
          this.$toasted.global.error('Etapa Autorizada!')
        } else {
          this.$toasted.global.error('Etapa Desautorizada!')
        }
      })
      .catch(error => {
        if (error.response) {
          this.errors = error.response.data.errors
        }
      })
    },
    uploadFile (stage, index) {
      this.stage = stage
      this.stage.index = index
      $('#stageUploadFileModal').modal('show')
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
