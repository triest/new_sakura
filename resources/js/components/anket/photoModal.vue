<template>
    <div class="newMessageModal">
        <transition name="modal" @close="showModal = false">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                      <img :src="'/'+photo.url" class="album-image" alt="image">
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
            }
        },
        name: 'modal',
        mounted() {
            //console.log(this.id);
          console.log(photo);
        },
        data() {
            return {
                MessageText: "",
                message: "",
                showPhotoModal:false
            }
        },
        methods: {
            close() {
                  this.$emit('closePhotoModal')
            },
            findUserByid() {

            },
            send() {
                console.log("send")
                axios.post('/api/contact/conversation/sendModal', {
                    contact_id: this.user.id,
                    text: this.MessageText
                }).then((response) => {
                    this.MessageText = "";
                    this.$emit('close');
                    this.close();
                });
            }
        },
    };
</script>

<style scoped>
/*
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 80ch;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
*/
    .modal-container {
       /* width: 50vh !important;*/
        overflow-x: hidden;
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

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
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


</style>
