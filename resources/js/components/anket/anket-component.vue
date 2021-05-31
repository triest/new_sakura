<template>
    <div>

      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
            Написать сообщение
      </button>

      <!-- Modal -->
       <modal  :user="user" data-backdrop="static" data-keyboard="false" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel" aria-hidden="true"></modal>


        <a v-if="likeExist===false" v-on:click="like()"><i id="color" class="fas fa-heart fa-2x indigo-text pr-3"  style="position: absolute; margin-top: 2px"
                                                           aria-hidden="true" title="Поставить лайк"></i></a>

        <i v-if="likeExist===true" class="fas fa-heart fa-2x indigo-text pr-3 human-heart"
           style="position: absolute; margin-top: 45px; margin-left: 3px"
           aria-hidden="true" id="heart" title="Вам нравиться эта анкета"></i>


        <img class="present-icon" data-toggle="modal" data-target="#presentModal" height="40"
             src="/public/images/icons/gift.jpg"    style="position: absolute; margin-left: 35px">

        <present-modal :user="user" data-backdrop="static" data-keyboard="false" tabindex="-1" id="presentModal" aria-labelledby="staticBackdropLabel" aria-hidden="true"></present-modal>


      <div v-if="matchVisibly===true">
        <div class="match-font">Совпадение!</div>
      </div>
    </div>
</template>

<script>
    import presentModal from './PresentModal.vue'
    import modal from './newMessageModal'
    import MessageModal from "./message-modal";

    export default {

        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                showPresentModal: false,
                showMessageModal: false,
                likeExist: null,
                matchVisibly:false,
            };
        },
        components: {
          MessageModal,
          presentModal,
          modal,
        },
      beforeMount() {
        this.checkLike();
      },
      mounted() {
        },
        methods: {
            closePresentModal() {
                this.showPresentModal = false;
            },
            clouseNewMessageModal() {
                this.showMessageModal = false;
            },
            like() {
                axios.post('/api/like-carousel/like',
                     {
                        user_id: this.user.id,
                        action: "like",
                    }
                )
                    .then((response) => {
                       console.log(response.data.result);
                        let res=response.data;

                      if(res.result===true){
                        this.likeExist=true;
                      }
                      if(res.match===true){
                          this.matchVisibly=true;
                      }

                    });
            },
            checkLike() {
                axios.get('/api/like-carousel/check-like', {
                    params: {
                        user_id: this.user.id,
                        action: "checkLike",
                    }
                })
                    .then((response) => {
                        this.likeExist = response.data.result;
                    });
            }
        }
    }
</script>

<style scoped>
  .present-icon{
     cursor: pointer;

  }


  @keyframes heartbeat {
    0% {
      transform: scale(1) rotate(-45deg);
    }
    20% {
      transform: scale(1.25) rotate(-45deg);
    }
    40% {
      transform: scale(1.5) rotate(-45deg);
    }
  }

  .human-heart {
      /* margin: 5em;*/
      animation: .8s infinite beatHeart;
      color: red;
      top: 1em;
      margin-top: 5%;
  }

  #heart{
      margin-top: 5%;
  }

  @keyframes beatHeart {
    0% {
      transform: scale(1);
    }
    25% {
      transform: scale(1.1);
    }
    40% {
      transform: scale(1);
    }
    60% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }

  .match-font{
    font-family: Impact, Charcoal, sans-serif;
    font-size: 40px;
    letter-spacing: 5px;
    word-spacing: 6px;
    color: #2EFF2C;
    font-weight: 700;
    text-decoration: rgb(68, 68, 68);
    font-style: italic;
    font-variant: small-caps;
    text-transform: uppercase;
    margin-left: -45px;
  }

  #color{
    color:red;
    cursor: pointer;
  }
</style>
