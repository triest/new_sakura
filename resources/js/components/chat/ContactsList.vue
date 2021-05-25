
<template>
  <div class="messages-box">
    <div class="list-group rounded-0">
      <a class="list-group-item list-group-item-action text-white rounded-0" v-bind:class="colorContact(contact.other.id) ?'active':''"  v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)">
        <div class="media"><img  :src="contact.other.photo_profile_url"  width="50" height="50" class="rounded-circle">
          <div class="media-body ml-4">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <h6 class="" v-bind:class="colorContact(contact.other.id) ? 'text-white':'text-muted'">{{ contact.other.name }}</h6><small  class="" v-bind:class="colorContact(contact.other.id) ? 'text-white':'text-muted'">{{contact.date}}</small>
            </div>
          </div>
        </div>
      </a>

    </div>
  </div>
</template>

<script>
    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            },
            target_user:{
                type: Object,
                required: false,
                default:null,
            }
        },
        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null,
                selectedContactId: 0
            };
        },
        mounted() {
            if(this.target_user!=null){
                this.selectedContactId=this.target_user.id;
            }
        },

        methods: {
            selectContact(contact) {
                this.selected = contact.other;
                this.selectedContactId=contact.id;
                this.$emit('selected', contact.other);
                document.title=contact.other.name;

            },
            colorContact(id){
                if(id===this.selectedContactId || (this.target_user!=null && id===this.target_user.id)){
                    return true;
                }else {
                    return false;
                }
            }
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    /* if (contact == this.selected) {
                         return Infinity;
                     }*/

                    return contact.unread;
                }]).reverse();
            },

        }
    }
</script>

<style lang="scss" scoped>

  .list-group-item{
      cursor: pointer;
  }



/*    .contacts-list {
        flex: 2;
        max-height: 600px;
        overflow: scroll;
        overflow-x: hidden;
        border-left: 1px solid #a6a6a6;
        max-width: 200px;
        ul {
            list-style-type: none;
            padding: 0;

            li {
                display: flex;
                padding: 0px;
                border-bottom: 1px solid #aaaaaa;
                height: 60px;
                position: relative;
                cursor: pointer;

                &.selected {
                    background: #dfdfdf;
                }

                span.unread {
                    background: #82e0a8;
                    color: #fff;
                    position: absolute;
                    right: 110px;
                    top: 1px;
                    display: flex;
                    font-weight: 400;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    padding: 0 4px;
                    border-radius: 3px;
                }

                .avatar {
                    flex: 1;
                    display: flex;
                    align-items: center;

                    img {
                        width: 60px;
                        height: 60px;
                        border-radius: 70%;
                        margin: 0 auto;
                    }
                }

                .contact {
                    flex: 3;
                    font-size: 16px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;

                    p {
                        margin: 0;

                        &.name {
                            font-weight: bold;
                        }
                    }
                }
            }
        }
    }
    */

</style>
