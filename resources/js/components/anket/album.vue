<template>
  <div>
    <gallery :images="images" :index="index" @close="index = null"></gallery>
    <div
        class="image"
        v-for="(image, imageIndex) in images"
        :key="imageIndex"
        @click="index = imageIndex"
        :style="{ backgroundImage: 'url(' + image + ')', width: '300px', height: '200px' }"
    ></div>
  </div>
</template>

<script>
import VueGallery from 'vue-gallery';

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
  data: function () {
    return {
      images: [
        /*'https://dummyimage.com/800/ffffff/000000',
        'https://dummyimage.com/1600/ffffff/000000',
        'https://dummyimage.com/1280/000000/ffffff',
        'https://dummyimage.com/400/000000/ffffff',*/
      ],
      index: null
    };
  },
  mounted() {
    this.getPhotos();
  },
  methods:{
    getPhotos() {
      let url = '/api/anket/' + this.user_id + '/album/' + this.album_id;
      let that = this;
      that.photos = [];
      that.ImageArray = [];
      axios.get(url, {}).then(function (response) {
        let data = null;
        data = response.data;
        console.log(data);
        that.images = data;
        /*              for (let i = 0; i < that.photos.length; i++) {
                          let temp = {
                              id: that.photos[i].id,
                              src: '/' + that.photos[i].url,
                              caption: that.photos[i].name,
                              thumbnail: '/' + that.photos[i].url,
                          }
                          that.ImageArray.push(temp);
                      }
      */
      });
    },

  },

  components: {
    'gallery': VueGallery
  },
}
</script>

<style scoped>
.image {
  float: left;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  border: 1px solid #ebebeb;
  margin: 5px;
}
</style>
