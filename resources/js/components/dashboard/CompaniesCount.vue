<template>
  <div class="card">
    <div class="card-body p-3 d-flex align-items-center">
      <i class="fas fa-building bg-info p-3 font-2xl mr-3"></i>
      <div>
        <div class="text-value-sm text-dark">Empresas</div>
        <div class="text-muted font-weight-bold small">{{count}} de 10</div>
        <div class="progress my-2" style="height: 4px;">
          <div class="progress-bar bg-info" role="progressbar" :style="`width: ${count*100/10}%`" :aria-valuenow="count*100/10" aria-valuemin="0" aria-valuemax="10"></div>
        </div>
      </div>
    </div>
    <div class="card-footer px-3 py-2">
      <a class="btn-block text-muted d-flex justify-content-between align-items-center" href="/companies">
        <span class="small font-weight-bold">Ver empresas</span>
        <i class="fa fa-angle-right"></i>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      count: 0
    }
  },
  mounted () {
    this.getCount()
  },
  methods: {
    getCount () {
      axios.post(`/api/companies/count`)
      .then(response => {
        this.count = response.data
      })
    }
  }
}
</script>
