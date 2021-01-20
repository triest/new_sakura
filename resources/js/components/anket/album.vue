<template>
  <div>
    <div class="col-lg-3 col-md-5 col-sm-6  justify-content-center col-xs-9 box-shadow" v-for="item in photos"
         style="padding-left:60px; padding-right: 20px;margin: auto;">
      <img width="250" height="250" :src="'/'+item.url">
    </div>

  </div>
</template>

<script>
export default {
  props: {
    user_id: {
      type: Number,
      required: false
    },
    album_id: {
      type: Number,
      required: false
    }
  },
  data() {
    return {
      photos: null,
      owner: false
    };
  },
  mounted() {
    console.log("album");
    this.getPhotos();
  },
  methods: {
    getPhotos() {
      let url = '/api/anket/' + this.user_id + '/album/' + this.album_id;
      var that=this;
      axios.get(url, {}).then(function (response) {
        let data = null;
        data = response.data;
        that.photos=data.photos;
      });

    }
  }
}
</script>

<style scoped>

</style>
