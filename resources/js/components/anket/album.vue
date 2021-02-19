<template>
    <div>
        <lingallery :iid.sync="currentId" :height="500"  :items="ImageArray"/>
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
    computed: {
    },
    data() {
        return {
            currentId: 0,
            images: [{
                src: 'https://picsum.photos/600/400/?image=0',
                thumbnail: 'https://picsum.photos/64/64/?image=0',
                caption: 'Some Caption',
                id: 'someid1'
            },
                {
                    src: 'https://picsum.photos/600/400/?image=10',
                    thumbnail: 'https://picsum.photos/64/64/?image=10'
                },
            ],
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
            this.photos = [];
            axios.get(url, {}).then(function (response) {
                let data = null;
                data = response.data;
                that.photos = data.photos;
                console.log("this.photos");
                console.log(that.photos)
                console.log("this.images")
                console.log(that.images);
                for (let i=0;i<that.photos.length;i++){
                let temp={
                    id:that.photos[i].id,
                    src:'/'+that.photos[i].url,
                    caption:that.photos[i].name,
                    thumbnail:'/'+that.photos[i].url,
                }
                that.ImageArray.push(temp);
                }

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
