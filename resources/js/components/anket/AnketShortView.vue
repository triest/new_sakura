<template>
  <div>
    <a :href="/anket/+user.id">
      <div v-if="user.online===true" class="cell-online">
        <div class="cell-online-overflow">
          <span class="online"></span>
        </div>
      </div>
      <img width="250" height="250" :src="user.photo_profile_url">
      <div class="cell">
        <div class="cell-overflow">
          {{ user.name }}, {{ user.age }}
        </div>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  name: "AnketShortView",
  props: {
    user: {
      type: Object,
      required: false
    }
  },
}
</script>
