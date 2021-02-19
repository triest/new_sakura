<template>
    <div>
        <img class="image33223" v-for="(image, i) in images"   :src="image" @click="index = i">
        <vue-gallery-slideshow :images="images" :index="index" @close="index = null"></vue-gallery-slideshow>
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
            images: [],
            photos: null,
            photos_array: [],
            photo_item: null,
            photo: null,
            galerayFile: null,
            showPhotoModal: false,
            resizable: true,
            adaptive: true,
            draggable: true,
            index: null,
        };
    },
    mounted() {
        this.getPhotos();
      /*  this.$modal.show('example-modal');*/
        this.setStyle();
    },
    components: {
        photoModal,
        VueGallerySlideshow
    },
    methods: {
        setStyle(){
           let temp=document.getElementsByClassName("vgs__container");
            temp.removeAttribute("style")
        },
        getPhotos() {
            let url = '/api/anket/' + this.user_id + '/album/' + this.album_id;
            let that = this;
            this.photos = [];
            axios.get(url, {}).then(function (response) {
                let data = null;
                data = response.data;
                that.photos = data.photos;
                that.getImages();
            });
        },
        getImages() {
            let array = [];
            for (let i = 0; i < this.photos.length; i++) {
                console.log(this.photos[i].url)
                this.images.push("/" + this.photos[i].url);
            }
            console.log(this.images);
            //return array;
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
.vgs__container{
    top:15%
}
</style>
