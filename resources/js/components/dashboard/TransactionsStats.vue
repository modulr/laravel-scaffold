<template>
  <div class="brand-card">
    <div class="brand-card-header bg-success">
      <i class="fas fa-exchange-alt mr-2"></i>
      <h3>Transacciones</h3>
    </div>
    <div class="brand-card-body">
      <div>
        <div class="text-value">{{transactionsStats.open}}</div>
        <div class="text-uppercase text-muted small">Abiertas</div>
      </div>
      <div>
        <div class="text-value">{{transactionsStats.finished}}</div>
        <div class="text-uppercase text-muted small">Cerradas</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      transactionsStats: 0
    }
  },
  mounted () {
    this.getTransactionsStats()
  },
  methods: {
    getTransactionsStats () {
      axios.get(`/api/transactions/stats`)
      .then(response => {
        this.transactionsStats = response.data
      })
    },
  }
}
</script>
