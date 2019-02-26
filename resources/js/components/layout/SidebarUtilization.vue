<template>
  <div>
    <li class="nav-divider"></li>
    <li class="nav-title">Utilización</li>
    <li class="nav-item px-3 d-compact-none d-minimized-none">
        <div class="text-uppercase mb-1">
          <small>
            <b>Transacciones</b>
          </small>
          <span class="float-right">{{transactionPercentage}}%</span>
        </div>
        <div class="progress progress-xs">
          <div class="progress-bar bg-success" role="progressbar" :style="`width: ${transactionCount*100/10}%`" :aria-valuenow="transactionCount*100/10" aria-valuemin="0" aria-valuemax="10"></div>
        </div>
        <small class="text-muted">{{transactionCount}} de 10</small>
    </li>
    <li class="nav-item px-3 d-compact-none d-minimized-none">
        <div class="text-uppercase mb-1">
          <small>
            <b>Empresas</b>
          </small>
          <span class="float-right">{{companyPercentage}}%</span>
        </div>
        <div class="progress progress-xs">
          <div class="progress-bar bg-info" role="progressbar" :style="`width: ${CompanyCount*100/10}%`" :aria-valuenow="CompanyCount*100/10" aria-valuemin="0" aria-valuemax="10"></div>
        </div>
        <small class="text-muted">{{CompanyCount}} de 10</small>
    </li>
  </div>
</template>

<script>
export default {
  data () {
    return {
      transactionCount: 0,
      CompanyCount: 0
    }
  },
  mounted () {
    this.getTransactionCount()
    this.getCompanyCount()
  },
  computed: {
    transactionPercentage: function () {
      return this.transactionCount*100/10
    },
    companyPercentage: function () {
      return this.CompanyCount*100/10
    }
  },
  methods: {
    getTransactionCount () {
      axios.post(`/api/transactions/count`)
      .then(response => {
        this.transactionCount = response.data
      })
    },
    getCompanyCount () {
      axios.post(`/api/companies/count`)
      .then(response => {
        this.CompanyCount = response.data
      })
    }
  }
}
</script>
