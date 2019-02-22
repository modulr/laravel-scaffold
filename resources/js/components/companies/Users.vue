<template>
  <div>
    <ul class="list-group list-group-flush" v-if="company.users.length > 0">
      <a href="#" v-for="(user, index) in company.users" @click.prevent="editUser(user.id, index)" class="list-group-item list-group-item-action media border-light">
        <div class="avatar float-left mr-3">
          <img class="img-avatar" :src="user.avatar_url">
        </div>
        <div class="media-body">
          <div class="d-flex justify-content-between">
            {{user.name}}
            <i class="fas fa-pencil-alt float-right"></i>
          </div>
          <div class="small text-muted">
            {{user.email}}
          </div>
        </div>
      </a>
    </ul>
    <div class="card-body text-center px-0">
      <p class="text-muted"><small>Agrega usuarios para interactuar con ellos en las transacciones.</small></p>
      <a class="btn btn-success" href="#" role="button" @click.prevent="newUser">
        <i class="fa fa-plus mr-2"></i>Crear usuario
      </a>
    </div>
    <!-- User Create -->
    <div class="modal fade" id="userCreateModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="John Doe">
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="john@modulr.io">
              <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
            </div>
            <div class="form-group">
              <label>Contraseña</label>
              <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
              <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
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
    <!-- User Edit -->
    <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row" v-if="!loadingEdit">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="John Doe">
                  <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="john@modulr.io">
                  <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                </div>
                <div class="form-group">
                  <label>Contraseña</label>
                  <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
                  <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                </div>
                <div class="form-group text-right">
                  <small class="text-muted">Creado <i>{{user.created_at | moment("LLL")}}</i></small>
                </div>
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
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: {},
      errors: {},
      loadingEdit: true,
      submitingCreate: false,
      submitingEdit: false,
      submitingDestroy: false
    }
  },
  props: ['company'],
  methods: {
    newUser () {
      this.user = {}
      this.user.roles = [{id:3, name: 'guest'}]
      this.user.companyId = this.company.id
      this.errors = {}
      $('#userCreateModal').modal('show')
    },
    create () {
      if (!this.submitingCreate) {
        this.submitingCreate = true
        axios.post(`/api/users/store`, this.user)
        .then(response => {
          this.company.users.push(response.data)
          this.$toasted.global.error('Usuario creado!')
          $('#userCreateModal').modal('hide')
        })
        .catch(error => {
          this.errors = error.response.data.errors
        })
        .then(() => {
          this.submitingCreate = false
        })
      }
    },
    editUser (userId, index) {
      this.errors = {}
      this.loadingEdit = true
      axios.get(`/api/users/getUserRoles/${userId}`)
      .then(response => {
        this.user = response.data
        this.user.index = index
      })
      .catch(error => {
        this.$toasted.global.error('El usuario no existe!')
      })
      .then(() => {
        this.loadingEdit = false
      })
      $('#userEditModal').modal('show')
    },
    update () {
      if (!this.submitingEdit) {
        this.submitingEdit = true
        this.user.roles = [{id:3}]
        axios.put(`/api/users/update/${this.user.id}`, this.user)
        .then(response => {
          this.company.users[this.user.index] = response.data
          this.$toasted.global.error('Usuario actualizado!')
          $('#userEditModal').modal('hide')
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
          title: "¿Estas seguro?",
          text: "Una vez borrado, no podras recuperar el usuario!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/users/${this.user.id}`)
            .then(response => {
              this.company.users.splice(this.user.index, 1)
              this.$toasted.global.error('Usuario borrado!')
              $('#userEditModal').modal('hide')
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    }
  }
}
</script>
