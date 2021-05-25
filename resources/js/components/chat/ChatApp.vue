<template>
  <div>

      <div class="row rounded-lg overflow-hidden ">
        <!-- Users box-->
        <div class="col-4 px-0">
          <div class="bg-white">
            <ContactsList :contacts="contacts" :target_user="target_user" @selected="startConversationWith"/>
          </div>
        </div>
        <!-- Chat Box-->
        <Conversation :contact="selectedContact" :unreaded="unreaded" :target_user="target_user" :messages="messages" @new="saveNewMessage"/>
      </div>


  </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            },
            target_user:{
                type: Object,
                required: false,
                default:null,
            }
        },
        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: [],
                unreaded: 0
            };
        },
        mounted() {

            Echo.private(`user.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    console.log("new message");
                    this.hanleIncoming(e.message);
             //     eventHub.$on('scroll_to_down', true)
                    this.getContacts()
                });
            this.getContacts()


            if(this.target_user!=null){
                this.startConversationWith(this.target_user,null)
            }
        },
        methods: {
            getContacts(){
              axios.get('api/contact/contacts')
                  .then((response) => {
                    this.contacts = response.data;
                  });
            },
            startConversationWith(contact, image) {
                console.log("start conversation");
                //     this.updateUnreadCount(contact, true);

                axios.get(`api/contact/conversation/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })

            },
            saveNewMessage(message) {
                this.messages.push(message);

             //   this.getContacts();
            },
            hanleIncoming(message) {
                if (this.selectedContact && message.to === this.selectedContact.id) {
                    this.saveNewMessage(message);
                    return;
                }

                this.updateUnreadCount(message.from_contact, false);
            },
              updateUnreadCount(contact, reset) {
                  /*this.contacts = this.contacts.map((single) => {
                      if (single.id !== contact.id) {
                          return single;
                      }

                      if (reset)
                          single.unread = 0;
                      else
                          single.unread += 1;

                      return single;
                  }),
                      this.unreaded = single.unread;*/
              }

        },
        components: {Conversation, ContactsList}
    }
</script>

<!--
<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
</style>
-->
