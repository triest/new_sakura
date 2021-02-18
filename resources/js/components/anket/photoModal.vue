<template>
  <div class="newMessageModal">
    <transition name="modal" @close="showModal = false">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
              Фотография {{number}} из {{photos.length}}
            <div class="modal-body">
              <button v-if="scrollPrevision" v-on:click="scrollPrevisionFunction()">Назад</button>
              <button class="close" v-on:click="close()"><span aria-hidden="true">&times;</span></button>
              <img :src="'/'+photo.url" class="album-image" alt="image">
              <button v-if="scrollNext" v-on:click="scrollNextFunction()">Вперед</button>
              <div class="copy">
                Загружено {{ photo.created }},
                {{ photo.user.name }}      <a :href="'anket/'+photo.user.id">  <img width="50" height="50" :src="'/'+photo.user.photo_profile_url" alt=""> </a>
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>


    export default {
        props: {
            photo:{
                type: Object,
                required: false
            },
            photos:{
                type:Array,
                required: false,
                default:[]
            }
        },
        name: 'modal',
        mounted() {
              this.checkScroll()
        },
        computed: {
           number:function (){
             let index=this.arrayKeySearch(this.photos,this.photo.id);
             return index+1;
           }
        },
        data() {
            return {
                MessageText: "",
                message: "",
                showPhotoModal:false,
                scrollNext:false,
                scrollPrevision:false,
                index:null
            }
        },
        methods: {
            close() {
                  this.$emit('closePhotoModal')
            },
            arrayKeySearch(arr, val) {  //задает переменную по цвету
              return arr.indexOf(this.photo);
            },
            checkScroll(){
                 let index=this.arrayKeySearch(this.photos,this.photo.id); //индек текущей фотки в массивк
                  //проверка на возможность скролинга назад
                 if(index===0){
                   this.scrollPrevision=false;
                 }else {
                   this.scrollPrevision=true;
                 }
                  //проверка на возможность скролинга вперед
                   if(this.photos.length-1 > (index)){
                      this.scrollNext=true;
                   }else {
                      this.scrollNext=false;
                   }
            },
            scrollNextFunction(){
              let index=this.arrayKeySearch(this.photos,this.photo); //индек текущей фотки в массивк
              this.photo=this.photos[index+1];
              this.checkScroll()
            },
            scrollPrevisionFunction(){
              let index=this.arrayKeySearch(this.photos,this.photo); //индек текущей фотки в массивк
              this.photo=this.photos[index-1];
              this.checkScroll()
            }
        },
    };
</script>

<style scoped>

    .modal-container {
        width: auto;
        height: auto;
        overflow-x: hidden;
        overflow-y: hidden;
        /*height:300px;*/
  /*      margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
        overflow: hidden*/
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .album-image{
      width:auto;
      height: auto;
      max-height: 80ch;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .album-image{
        width: 80ch;
    }
/*
    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
*/

    .newMessageModal {
      position: fixed;
      bottom: 0;
      right: 0;
    }

.modal-container {
  bottom: 0;
  left: 0;
  height: 80%;
  width: 80%;
  margin: auto;
  position: absolute;
  right: 0;
  text-align: center;
  top: 0;
}

.avatar{
 height:  30%;
}

.container img {
  max-width: 100%;
}

.close_modal_button{
   position: relative;
   right: -60%;
}

</style>
