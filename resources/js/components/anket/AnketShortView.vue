<template>
  <div>
    <a :href="/anket/+user.id">
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

<style scoped>
.cell {
  position: absolute;
  top: 180px;
  right: 0;
  bottom: 30px;
  left: 0;
  box-sizing: border-box;
  display: block;
  padding: 20px;
  width: 100%;
  color: white;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}

.cell-overflow {
  box-sizing: border-box;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: white;
}

</style>
