<template>
    <div>
        <p v-if="likeExist===false">
            <a v-on:click="like()"><i id="color" class="fas fa-heart fa-2x indigo-text pr-3" aria-hidden="true" title="Поставить лайк"></i></a>
        </p>
        <span v-if="likeExist===true">
              <i class="fas fa-heart fa-2x indigo-text pr-3 human-heart" aria-hidden="true" title="Вам нравиться эта анкета"></i>

           <img class="present-icon"  height="40" src="/public/images/icons/gift.jpg" v-on:click="showPresentModal=true">
        </span>
        <p>
            <a class="btn btn-primary" v-on:click="showMessageModal=true">Написать сообщение</a>
        </p>
        <present v-if="showPresentModal" :user="user" @closeRequest='closePresentModal()'></present>
        <newMessageModal :user="user" v-if="showMessageModal"
                         @closeNewMessageAlert='clouseNewMessageModal()'></newMessageModal>
      <div v-if="matchVisibly===true">
        <div class="match-font">Совпадение!</div>
      </div>
    </div>
</template>

<script>
    import present from './PresentModal.vue'
    import newMessageModal from './newMessageModal'

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
            present,
            newMessageModal
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
                axios.get('/api/like-carousel/checkLike', {
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
