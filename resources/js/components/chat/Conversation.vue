<template>
  <div class="col-7 px-0">
    <div class="px-4 py-5 chat-box bg-white">
      <div id="messages-div" class="messages-div"  ref="chat">
      <span v-for="message in messages">
      <!-- Sender Message-->

      <div v-if="message.to == contact.id" class="media w-50 mb-3"><img :src="contact.photo_profile_url" alt="user" width="50" class="rounded-circle">
        <div class="media-body ml-3">
          <div class="bg-light rounded py-2 px-3 mb-2">
            <p class="text-small mb-0 text-muted">{{message.text}}</p>
          </div>
          <p class="small text-muted">{{ message.date }}</p>
        </div>
      </div>

      <!-- Reciever Message-->

      <div v-if="message.to != contact.id" class="media w-50 ml-auto mb-3">
        <div class="media-body">
          <div class="bg-primary rounded py-2 px-3 mb-2">
            <p class="text-small mb-0 text-white">{{message.text}}</p>
          </div>
          <p class="small text-muted"> {{message.date}}</p>
        </div>
      </div>

      </span>
      </div>
    <!-- Typing area -->


    </div>
    <div v-if="contact">
      <MessageComposer @send="sendMessage"/>
    </div>

  </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';

    export default {
        props: {
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            },
            target_user:{
                type: Object,
                required: false,
                default:null,
            }
        },
         mounted() {
           this.scrollDown();
        },

      watch: {
        messages:function (val){

          this.scrollDown()
          this.scrollDown()
          this.scrollDown()
        },
        contact:function (){
          this.scrollDown()
        }
      },
        methods: {
            scrollDown(){
              let container = this.$el.querySelector("#messages-div");
              console.log("scroll")

              container.scrollTop = container.scrollHeight - container.clientHeight+10;

            },
            sendMessage(text) {
                if (!this.contact) {
                    return;
                }

                axios.post('api/contact/conversation/send', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('new', response.data);
                })
            }
        },
        components: {MessagesFeed, MessageComposer}

    }
</script>

<style lang="scss" scoped>
    .messages-div{
      max-height: 50vh;
      overflow-y: scroll;
    }

 /*   .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h1 {
            font-size: 20px;
            padding: 10px;
            margin: 0;
            border-bottom: 1px dashed lightgray;
        }
    }
  */
</style>
