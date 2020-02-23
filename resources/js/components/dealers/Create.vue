<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Nuevo Repartidor</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="create">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="John Doe">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
          <div class="form-group">
            <label>Correo electrónico</label>
            <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="email" placeholder="john@modulr.io">
            <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
          </div>
          <div class="form-group">
            <label>Cellphone</label>
            <input type="tel" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="user.cellphone" placeholder="6271012345">
            <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Ganancia %</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.profit}" v-model="user.profit" placeholder="70">
            <div class="invalid-feedback" v-if="errors.profit">{{errors.profit[0]}}</div>
          </div>
          <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
            <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
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
      user: {
        name: '',
        pforif: 70,
        password: '123456',
        roles: [{name: 'dealer', display_name: 'Dealer'}]
      },
      errors: {},
      submiting: false
    }
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        this.user.email = this.email
        axios.post(`/api/dealers/store`, this.user)
        .then(response => {
          this.$toasted.global.error('Repartidor creado!')
          location.href = `/dealers/${response.data.id}/edit`
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    }
  },
  computed: {
    email: function () {
      const a = 'àáäâãåăæçèéëêǵḧìíïîḿńǹñòóöôœøṕŕßśșțùúüûǘẃẍÿź·/_,:;'
      const b = 'aaaaaaaaceeeeghiiiimnnnooooooprssstuuuuuwxyz------'
      const p = new RegExp(a.split('').join('|'), 'g')

      return this.user.name.toString().toLowerCase()
      .replace(/\s+/g, '-') // Replace spaces with -
      .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
      .replace(/&/g, '-and-') // Replace & with 'and'
      .replace(/[^\w\-]+/g, '') // Remove all non-word characters
      .replace(/\-\-+/g, '-') // Replace multiple - with single -
      .replace(/^-+/, '') // Trim - from start of text
      .replace(/-+$/, '') // Trim - from end of text
      .concat('@traeme.app')
    }
  }
}
</script>
