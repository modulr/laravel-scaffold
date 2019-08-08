<template lang="html">
  <div>
    <a href="#" @click.prevent="viewUser">
      <div class="media">
        <div class="avatar float-left mr-2">
          <img class="img-avatar" :src="user.avatar_url">
        </div>
        <div class="media-body">
          <div class="text-body">{{user.name}}</div>
          <div class="small text-muted">
            {{role}}<span class="badge badge-pill badge-primary ml-1" v-if="user.level > 0">Nivel {{user.level}}</span>
          </div>
        </div>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  props: ['user', 'role'],
  methods: {
    viewUser () {
      this.$emit('viewUser', this.user)
      $('#viewUser').modal('show')
    }
  }
}
</script>
