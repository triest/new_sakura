<template>
    <div>
        <div v-if="owner">
            Загрузить фотографию
            <input type="file" id="photo" name="photo" ref="galerayFileInput" v-on:change="handleFileUpload()">
            <button type="button" class="btn btn-primary" v-on:click="submitFile()">Загрузить</button>
            <div v-if="ImageArray.length!=0">
                <div class="col-lg-3 col-md-5 col-sm-6  justify-content-center col-xs-9 box-shadow"
                     v-for="item in photos"
                     style="padding-left:60px; padding-right: 20px;margin: auto;">
                    <img width="250" height="250" :src="'/'+item.url" class="photo" v-on:click="showPhoto(item)">
                    <span v-if="owner">
               <button class="btn btn-danger" v-on:click="deletePhoto(item.id)">Удалить</button>
               </span>
                </div>
            </div>
        </div>
        <div v-else>
            <lingallery :iid.sync="currentId" :height="500" :items="ImageArray"/>
        </div>
    </div>
</template>

<script>
import photoModal from './photoModal';
import VueGallerySlideshow from 'vue-gallery-slideshow';

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
    computed: {},
    data() {
        return {
            currentId: '',
            ImageArray: []
        };

    },
    mounted() {
        this.getPhotos();
    },
    components: {
        photoModal,
        VueGallerySlideshow
    },
    methods: {

        getPhotos() {
            let url = '/api/anket/' + this.user_id + '/album/' + this.album_id;
            let that = this;
            that.photos = [];
            that.ImageArray = [];
            axios.get(url, {}).then(function (response) {
                let data = null;
                data = response.data;
                that.photos = data.photos;
                for (let i = 0; i < that.photos.length; i++) {
                    let temp = {
                        id: that.photos[i].id,
                        src: '/' + that.photos[i].url,
                        caption: that.photos[i].name,
                        thumbnail: '/' + that.photos[i].url,
                    }
                    that.ImageArray.push(temp);
                }

            });
        },
        deletePhoto(id) {
            console.log("this.currentId")

            let result = window.confirm("Удалить фотографию?");
            if (!result) {
                return;
            }
            let formData = new FormData();
            formData.append('image_id', this.currentId);


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
                that.getPhotos()
            })
                .catch(function () {
                    Alert("Ошибка!")
                    that.getPhotos()
                });
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
                console.log(data);
                let temp = {
                    id: data.photo.id,
                    src: '/' + data.photo.url,
                    caption: data.photo.name,
                    thumbnail: '/' + data.photo.url,
                }
                that.ImageArray.push(temp);
                /* that.photos.push(data.photo)
                 $("#photo")[0].value = "";*/
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

        showPhoto(photo) {
            this.photo_item = photo;
            this.photos_array = this.photos;
            this.showPhotoModal = true;
        },
        closeModal() {
            this.showPhotoModal = false;
        }

    }
}
</script>

<style scoped>
.vgs__container {
    top: 15%
}
</style>
