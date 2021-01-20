<template>
  <div>
    <div v-if="owner">
      <input type="file" id="photo" name="photo" ref="galerayFileInput" v-on:change="handleFileUpload()">
      <button type="button" class="btn btn-primary" v-on:click="submitFile()">Загрузить</button>
    </div>

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
    owner: {
      type: Boolean,
      required: false,
      default: false,
    },
    album_id: {
      type: Number,
      required: false
    },
  },
  data() {
    return {
      photos: null,
      owner: false,
      photo: null,
      galerayFile:null,
    };
  },
  mounted() {
    console.log("album");
    this.getPhotos();
  },
  methods: {
    getPhotos() {
      let url = '/api/anket/' + this.user_id + '/album/' + this.album_id;
      let that = this;
      axios.get(url, {}).then(function (response) {
        let data = null;
        data = response.data;
        that.photos = data.photos;
      });
    },
    handleFileUpload() {
      this.galerayFile = this.$refs.galerayFileInput.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append('image', this.galerayFile);
      let url = '/api/anket/' + this.user_id + '/albums/' + this.album_id+'/upload/image';
      let that=this;
      axios.post(url,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
      ).then(function (response) {
        let data=null;
        data=response.data;
        that.photos.push(data.photo)
      })
          .catch(function () {
          });
   //   this.getPhotos();
    },
  }
}
</script>

<style scoped>

</style>
