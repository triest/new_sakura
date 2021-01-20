<template>
  <div>
    <div v-if="owner">
      вы
      <input type="file" id="photo" name="photo" ref="galerayFileInput" v-on:change="handleFileUpload()">
      <button type="button" class="btn btn-primary" v-on:click="submitFile()">Загрузить</button>
    </div>

    <div class="col-lg-3 col-md-5 col-sm-6  justify-content-center col-xs-9 box-shadow" v-for="item in photos"
         style="padding-left:60px; padding-right: 20px;margin: auto;">
      <img width="250" height="250" :src="'/'+item.url">
      <span v-if="owner">
        <button class="btn btn-danger" v-on:click="deletePhoto(item.id)">Удалить</button>
      </span>
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
      galerayFile: null,
    };
  },
  mounted() {
    this.getPhotos();
  },
  methods: {
    getPhotos() {
      let url = '/api/anket/' + this.user_id + '/album/' + this.album_id;
      let that = this;
      this.photos=[];
      axios.get(url, {}).then(function (response) {
        let data = null;
        data = response.data;
        that.photos = data.photos;
      });
    },
    deletePhoto(id){
     let result = window.confirm("Удалить фотографию?");
      if(!result){
         return ;
      }
      let formData = new FormData();
      formData.append('image_id',id);
      let url = '/api/anket/' + this.user_id + '/albums/' + this.album_id + '/delete/'+id;
      let that = this;
      axios.delete(url,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
      ).then(function (response) {
        let data = null;

      })
          .catch(function () {
                Alert("Ошибка!")
          });
      this.getPhotos();
    },
    handleFileUpload() {
      this.galerayFile = this.$refs.galerayFileInput.files[0];
    },
    submitFile() {
      let formData = new FormData();
      formData.append('image', this.galerayFile);
      let url = '/api/anket/' + this.user_id + '/albums/' + this.album_id + '/upload/image';
      let that = this;
      axios.post(url,
          formData,
          {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }
      ).then(function (response) {
        let data = null;
        data = response.data;
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
