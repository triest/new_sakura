<template>
  <div>
    <div v-if="owner">
      Загрузить фотографию
      <input type="file" id="photo" name="photo" ref="galerayFileInput" v-on:change="handleFileUpload()">
      <button type="button" class="btn btn-primary" v-on:click="submitFile()">Загрузить</button>
    </div>
    <div v-if="photos.length!=0">
    <div class="col-lg-3 col-md-5 col-sm-6  justify-content-center col-xs-9 box-shadow" v-for="item in photos"
         style="padding-left:60px; padding-right: 20px;margin: auto;">
      <img width="250" height="250" :src="'/'+item.url"  class="photo" v-on:click="showPhoto(item)">
      <span v-if="owner">
        <button class="btn btn-danger" v-on:click="deletePhoto(item.id)">Удалить</button>
      </span>
    </div>
    </div>
    <span class="not_photo" v-else>
       В альбоме нет фотографий
    </span>
    <div v-if="photos.length!=0">
        <photo-modal :photo="photo_item" :photos="photos" v-if="showPhotoModal" @closePhotoModal="closeModal()" class="photoModal-component"></photo-modal>
    </div>
  </div>
</template>

<script>
import photoModal from './photoModal';
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
      photos_array:[],
      photo_item:null,
      photo: null,
      galerayFile: null,
      showPhotoModal:false,
      resizable: true,
      adaptive: true,
      draggable: true
    };
  },
  mounted() {
    this.getPhotos();
    this.$modal.show('example-modal')
  },
  components:{
    photoModal
  },
  methods: {
    getPhotos() {
      let url = '/api/anket/' + this.user_id + '/album/' + this.album_id;
      let that = this;
      this.photos = [];
      axios.get(url, {}).then(function (response) {
        let data = null;
        data = response.data;
        that.photos = data.photos;
      });
    },
    deletePhoto(id) {
      let result = window.confirm("Удалить фотографию?");
      if (!result) {
        return;
      }
      let formData = new FormData();
      formData.append('image_id', id);
      let url = '/api/anket/' + this.user_id + '/albums/' + this.album_id + '/delete/' + id;
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
        $("#photo")[0].value = "";
      })
          .catch(err => {
            let message = "";
            if (err.response.status === 422) {
              message = Object.values(err.response.data.errors).join('<br>')
            }
            if (err.response.status === 500) {
              message += "Ошибка. Обратитесь к администратору";
            }

            alert(message)
          })
      //   this.getPhotos();
    },
    showPhoto(photo){
        this.photo_item=photo;
        this.photos_array=this.photos;
        this.showPhotoModal=true;
    },
    closeModal(){
        this.showPhotoModal=false;
    }

  }
}
</script>

<style scoped>
.not_photo {
  width: 25rem;
  background-color: #eeeeee;
  border: 1px solid transparent;
  display:inline;
  text-align: center;
  position:absolute;
  margin-left: 40%;
}

.photo{
   cursor: pointer;
}

.photoModal-component{
  position: absolute;
  margin-top: auto;
  margin-left: auto;
}

</style>
