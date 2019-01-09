<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Edit Company</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="update">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Save</span>
            </a>
            <a class="card-header-action ml-1" href="#" :disabled="submitingDestroy" @click.prevent="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Delete</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="row" v-if="!loading">
            <div class="form-group col-md-9">
              <label>Name</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="company.name" placeholder="Modulr Co.">
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Created</label>
                <p class="form-control-plaintext text-muted">{{company.created_at | moment("LLL")}}</p>
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
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      company: {},
      errors: {},
      loading: true,
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getCompany()
  },
  methods: {
    getCompany() {
      this.loading = true
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/companies/${res[2]}`)
      .then(response => {
        this.company = response.data
      })
      .catch(error => {
        this.$toasted.global.error('Company does not exist!')
        location.href = '/companies'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/companies/update/${this.company.id}`, this.company)
        .then(response => {
          this.$toasted.global.error('Updated company!')
          location.href = '/companies'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    destroy () {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this company!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/companies/${this.company.id}`)
            .then(response => {
              this.$toasted.global.error('Deleted company!')
              location.href = '/companies'
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
