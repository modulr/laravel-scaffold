<template lang="html">
  <div>
    <div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="row justify-content-center mb-3">
              <div class="col-12 text-center">
                <img class="rounded-circle mb-2" style="width: 120px; height: 120px" :src="user.avatar_url_large">
                <rate class="mb-3" :length="5" v-model="user.score" :disabled="true"/>
              </div>
              <div class="col-12 text-center">
                <h3>{{user.name}}</h3>
                <small class="text-muted">{{user.description}}</small>
                <p class="mt-2 mb-1">
                  <a class="text-info" :href="`mailto:${user.email}`" target="_blank"><i class="far fa-envelope mr-1"></i></a>
                  {{user.email}}
                </p>
                <p v-if="user.cellphone">
                  <a class="text-info" :href="`https://api.whatsapp.com/send?phone=52${user.cellphone}`" target="_blank"><i class="fab fa-whatsapp mr-1"></i></a>
                  {{user.cellphone}}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['user']
}
</script>
