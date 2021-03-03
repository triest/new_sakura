<template>
  <div>
    <a :href="/anket/+user.id">
      <div class="cell-online">
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

.cell-online {
  position: absolute;
  top: 5px;
  left: 200px;
  bottom: 30px;
  box-sizing: border-box;
  display: block;
  padding: 20px;
  width: 100%;
  color: white;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}

.cell-online-overflow {
  box-sizing: border-box;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: white;
}

.online {
  height: 10px;
  width: 10px;
  background-color: #26ff26;
  border-radius: 50%;
  display: inline-block;

}

</style>
