<template>
  <div>
    <ul class="list-group list-group-flush" v-if="transaction.stages != null && transaction.stages.length > 0">
      <li v-for="(stage, index) in transaction.stages" track-by="id" class="list-group-item p-0 pt-4 border-light bg-transparent">
        <div>
          <div class="float-left mr-3">
            <label class="switch switch-label switch-success">
              <input class="switch-input" type="checkbox" v-model="stage.authorized" @change="toggleAuthorized(stage, index)">
              <span class="switch-slider" data-checked="✓" data-unchecked="✕"></span>
            </label>
          </div>
          <div class="d-flex justify-content-between">
            <div class="form-inline" v-if="stageEdit.id == stage.id">
              <input type="text" class="form-control mb-2 mr-sm-2" :class="{'is-invalid': errorsEdit.name}" v-model="stageEdit.name" placeholder="Nombre de la etapa" @keyup.enter="update(stageEdit, index)" @keyup.esc="update(stageEdit, index)" @blur="update(stageEdit, index)" autofocus>
              <div class="invalid-feedback" v-if="errorsEdit.name">{{errorsEdit.name[0]}}</div>
            </div>
            <a href="#" class="text-secondary" @click.prevent="editStage(stage, index)" v-else>
              <strong>{{stage.name}}</strong><br>
            </a>
            <div class="nav nav-pills" id="pills-tab" role="tablist">
              <a class="nav-item text-secondary active" :id="`pills-files-tab-${stage.id}`" data-toggle="pill" :href="`#pills-files-${stage.id}`" role="tab" :aria-controls="`pills-files-${stage.id}`" aria-selected="true">
                <i class="fas fa-file-upload mr-2"></i><span class="d-md-down-none mr-3">Archivos</span>
              </a>
              <a class="nav-item text-secondary" :id="`pills-comments-tab-${stage.id}`" data-toggle="pill" :href="`#pills-comments-${stage.id}`" role="tab" :aria-controls="`pills-comments-${stage.id}`" aria-selected="false">
                <i class="fas fa-comment mr-2"></i><span class="d-md-down-none mr-3">{{stage.comments.length}} Comentarios</span>
              </a>
              <a href="#" class="text-secondary":disabled="submitingDestroy" @click.prevent="destroy(stage.id, index)">
                <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
                <i class="far fa-trash-alt" v-else></i>
              </a>
            </div>
          </div>
          <p class="text-muted small mb-1"><span v-if="stage.authorized && stage.authorized_by_user">Autorizada por <i>{{stage.authorized_by_user.name}}</i></span></p>
        </div>
        <!-- Files & Comments-->
        <div class="tab-content bg-transparent border-0" id="pills-tabContent">
          <div class="tab-pane px-2 fade show active" :id="`pills-files-${stage.id}`" role="tabpanel" :aria-labelledby="`pills-files-tab-${stage.id}`">
            <transactions-file :stage="stage"></transactions-file>
          </div>
          <div class="tab-pane px-3 fade" :id="`pills-comments-${stage.id}`" role="tabpanel" :aria-labelledby="`pills-comments-tab-${stage.id}`">
            <transactions-comments :stage="stage"></transactions-comments>
          </div>
        </div>
      </li>
    </ul>
    <!-- Create stage -->
    <br>
    <div class="card-body bg-light">
      <div class="form-inline">
        <label class="sr-only">Nombre de la etapa</label>
        <input type="text" class="form-control  mb-2 mr-sm-2" :class="{'is-invalid': errors.name}" v-model="stage.name" placeholder="Nombre etapa" @keyup.enter="create">
        <a class="btn btn-primary mb-2" href="#" :disabled="submitingCreate" @click.prevent="create">
          <i class="fas fa-spinner fa-spin" v-if="submitingCreate"></i>
          <i class="fas fa-plus" v-else></i>
          <span class="ml-1">Crear etapa</span>
        </a>
        <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      stage: {},
      stageEdit: {},
      errors: {},
      errorsEdit: {},
      stageEditActive: false,
      submitingCreate: false,
      submitingEdit: false,
      submitingDestroy: false
    }
  },
  props: ['transaction'],
  mounted () {
    this.stage.transactionId = this.transaction.id
  },
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
          this.stage.name = ''
          this.errors = {}
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
    editStage (stage, index) {
      this.stageEdit = stage
      this.stageEdit.index = index
    },
    update (stage, index) {
      if (!this.submitingEdit) {
        this.submitingEdit = true
        axios.put(`/api/stages/update/${stage.id}`, stage)
        .then(response => {
          this.transaction.stages[index].name = response.data.name
          this.stageEdit = {}
          this.errorsEdit = {}
          this.$toasted.global.error('Updated stage!')
        })
        .catch(error => {
          this.errorsEdit = error.response.data.errors
        })
        .then(() => {
          this.submitingEdit = false
        })
      }
    },
    destroy (stageId, index) {
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
            axios.delete(`/api/stages/${stageId}`)
            .then(response => {
              this.transaction.stages.splice(index, 1)
              this.$toasted.global.error('Etapa borrada!')
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
  }
}
</script>
