<template>
  <div>

      <div class="row rounded-lg overflow-hidden ">
        <!-- Users box-->
        <div class="col-5 px-0">
          <div class="bg-white">
            <ContactsList :contacts="contacts" @selected="startConversationWith"/>
          </div>
        </div>
        <!-- Chat Box-->
        <Conversation :contact="selectedContact" :unreaded="unreaded" :messages="messages" @new="saveNewMessage"/>
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
                .listen('messages', (e) => {
                    console.log("new message")
                    this.hanleIncoming(e.message);
                    this.getContacts()
                });
            this.getContacts()
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
                this.getContacts();
            },
            hanleIncoming(message) {
                if (this.selectedContact && message.from == this.selectedContact.id) {
                    this.saveNewMessage(message);
                    return;
                }

                this.updateUnreadCount(message.from_contact, false);
            },
            /*  updateUnreadCount(contact, reset) {
                  this.contacts = this.contacts.map((single) => {
                      if (single.id !== contact.id) {
                          return single;
                      }

                      if (reset)
                          single.unread = 0;
                      else
                          single.unread += 1;

                      return single;
                  }),
                      this.unreaded = single.unread;
              }
              */
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
