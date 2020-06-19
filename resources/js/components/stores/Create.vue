<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Nueva Tienda</h4>
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
            <label>Tienda *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="Pollo Feliz">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
          <!-- <div class="form-group">
            <label>Nivel *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.level}" v-model="user.level" placeholder="1">
            <div class="invalid-feedback" v-if="errors.level">{{errors.level[0]}}</div>
          </div> -->
          <div class="form-group">
            <label>Correo electrónico *</label>
            <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="email" placeholder="john@modulr.io">
            <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
          </div>
          <!-- <div class="form-group">
            <label>Contraseña *</label>
            <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
            <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
          </div> -->
          <div class="form-group">
            <label>Dirección</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.address}" v-model="user.address" placeholder="Av. Boulevard #15, col. Centro">
            <div class="invalid-feedback" v-if="errors.address">{{errors.address[0]}}</div>
          </div>
          <div class="form-group">
            <label>Horario</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.schedule}" v-model="user.schedule" placeholder="8:00am - 10:00pm">
            <div class="invalid-feedback" v-if="errors.schedule">{{errors.schedule[0]}}</div>
          </div>
          <div class="form-group">
            <label>Descripción</label>
            <textarea class="form-control" rows="3" v-model="user.description" placeholder="Pollos y más"></textarea>
            <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
          </div>
          <div class="form-group">
            <label>Teléfono</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.phone}" v-model="user.phone" placeholder="5230034">
            <div class="invalid-feedback" v-if="errors.phone">{{errors.phone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Celular</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="user.cellphone" placeholder="6271012233">
            <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Categorias</label>
            <multiselect
              v-model="user.tags"
              :options="categories"
              :multiple="true"
              openDirection="bottom"
              :class="{'border border-danger rounded': errors.roles}">
            </multiselect>
            <div class="invalid-feedback" v-if="errors.tags">{{errors.tags[0]}}</div>
          </div>
          <div class="form-group">
            <label>Pagina Web</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.web}" v-model="user.web" placeholder="http://www.tacos-chu.com">
            <div class="invalid-feedback" v-if="errors.web">{{errors.web[0]}}</div>
          </div>
          <div class="form-group">
            <label>Facebook</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.facebook}" v-model="user.facebook" placeholder="facebook.com/profile">
            <div class="invalid-feedback" v-if="errors.facebook">{{errors.link[0]}}</div>
          </div>
          <div class="form-group">
            <label>Instagram</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.instagram}" v-model="user.instagram" placeholder="instagram.com/profile">
            <div class="invalid-feedback" v-if="errors.instagram">{{errors.link[0]}}</div>
          </div>
          <div class="form-group">
            <label>Otro Link</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.link}" v-model="user.link" placeholder="www.otrolink.com">
            <div class="invalid-feedback" v-if="errors.link">{{errors.link[0]}}</div>
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
        level: 0,
        password: '123456',
        store: true,
        roles: [
          {name: 'user', display_name: 'Cliente'},
          {name: 'store', display_name: 'Store'}
        ]
      },
      categories: [
        'Belleza',
        'Comida',
        'Postres',
        'Recibos',
        'Super',
        'Licores',
        'Paquetes',
        'Farmacia',
        'Tacos',
        'Hamburguesas',
        'Pizza',
        'Sushi',
        'Gorditas',
        'Tortas',
        'Lonches',
        'Flautas',
        'Quesadillas',
        'Tripitas',
        'Otro'
      ],
      errors: {},
      submiting: false
    }
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        this.user.email = this.email
        this.user.phone = this.phone
        this.user.cellphone = this.cellphone
        axios.post(`/api/stores/store`, this.user)
        .then(response => {
          this.$toasted.global.error('¡Tienda creada!')
          location.href = `/stores/${response.data.id}/edit`
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
    },
    cellphone: function () {
      return this.user.cellphone.toString().toLowerCase()
      .replace(/\s+/g, '') // Replace spaces with -
      .replace(/[^\w\-]+/g, '') // Remove all non-word characters
      .replace(/^521/g, '') // Replace & with 'and'
      .replace(/^-+/, '') // Trim - from start of text
      .replace(/-+$/, '') // Trim - from end of text
    },
    phone: function () {
      return this.user.phone.toString().toLowerCase()
      .replace(/\s+/g, '') // Replace spaces with -
      .replace(/[^\w\-]+/g, '') // Remove all non-word characters
      .replace(/^521/g, '') // Replace & with 'and'
      .replace(/^-+/, '') // Trim - from start of text
      .replace(/-+$/, '') // Trim - from end of text
    },
  }
}
</script>
