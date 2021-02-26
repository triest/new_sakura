<template>
  <div class="d-flex justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">


      <a class="btn btn-secondary" href="/contact" style="cursor: pointer">Сообщения
        <div v-if="numberUnreaded>0">({{ numberUnreaded }})</div>
      </a>
      <a class="btn btn-info" href="/mypresents">Мои подарки</a>
      <a class="btn btn-info" href="/events/my-events-list">Мои события
        <div v-if="unreeadedEventRequwest>0">{{ unreeadedEventRequwest }}</div>
      </a>
      <span class="span-like" v-if="likesNumber>0">
        <i class="fas fa-heart fa-2x indigo-text pr-3" aria-hidden="true"></i>
        <span class="like-number"> {{likesNumber}} </span>
      </span>
      <div class="dropdown" style="cursor: pointer">
        <div v-if="user.photo_profile_url">
          <img :src="'/'+user.small_photo_profile_url" height="35px" class="dropbtn">
        </div>
        <div v-else>
          <img src='/public/home/img/image-placeholder.png' height="35px" class="dropbtn">
        </div>
        <div class="dropdown-content">
          <a href="/lk/profile">Профиль</a>
          <a v-on:click="logout()" href="#">Выйти</a>
        </div>
      </div>
    </nav>
    <eventRequestModal :eventRequest="eventRequest" v-if="showPresentModal" @closeRequest='clousePresentModal()'></eventRequestModal>
    <changeEventRequestStatusModal :eventRequest="eventRequest" v-if="showChangeEvemtRequestStatusPresentModal" @closeRequest='clouseChangeRventRequestModal()'></changeEventRequestStatusModal>
  </div>
</template>

<script>

import eventRequestModal from './modals/eventRequestModal'
import changeEventRequestStatusModal from './modals/ChangeEventRequestStatusModal'

export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  components: {
    eventRequestModal,
    changeEventRequestStatusModal,
  },
  data() {
    return {
      showEventRequestModal:false,
      showPresentModal:false,
      showChangeEvemtRequestStatusPresentModal:false,
      numberUnreaded: 0,
      numberApplication: 0,
      numberApplicationPresents: 0,
      inseach: false,
      likesNumber: 0,
      showLikeModal: false,
      unreeadedEventRequwest: 0,
      showAlertModal: false,
      event: "",
      showNemMessageModal: false,
      filter_enable: false,
      count_accept_notification: 0,
      eventRequest:null,
    }
        ;
  },
  mounted() {
   // this.inSearch();
    this.getAllDataForSidePanel();
    this.getNumberUnreadedEventRequwest();
    Echo.private(`user.${this.user.id}`)
        .listen('NewMessage', (e) => {

          this.getNumberUnreadedMessages();
          this.showNemMessageModal = true;
        });

    // заявка на моё событие
    Echo.private(`user.${this.user.id}`)
        .listen('NewEventRequest', (e) => {
           console.log('new Event Request');
           this.showEventRequestModal=true;
           this.showPresentModal=true;
            this.handleIncomingEventRequest(e.eventRequest)
        });

    Echo.private(`user.${this.user.id}`)
        .listen('ChangeEventRequestStatus', (e) => {
          console.log('ChangeEventRequestStatus')
          this.handleChangeEventRequestStatus(e.eventRequest)
        });
  },
  methods:
      {
        clousePresentModal(){
            this.showPresentModal=false;
        },
        handleIncomingEventRequest(e){
            this.eventRequest=e;
            this.showEventRequestModal=true;
        },
        handleChangeEventRequestStatus(e){
              this.eventRequest=e;
              this.showChangeEvemtRequestStatusPresentModal=true;
        },
        triger() {
          clearTimeout(this.timer);
          this.timer = setTimeout(() => {
            clearTimeout(this.timer);
            this.showLikeModal = true;
          }, 1500)
        },
        cleare() {
          clearTimeout(this.timer);
        },
        closeLikeModal() {
          this.showLikeModal = false;
        },
        getNumberUnreadedMessages() {
          axios.get('/api/contact/count-unreaded')
              .then((response) => {
                this.numberUnreaded = response.data;
              })
        },
        getNumberUnreadedPresents() {
          axios.get('/getCountUnreadedPresents')
              .then((response) => {
                this.numberApplicationPresents = response.data;
              })
        },
        inSearch() {
          let res;
          axios.get('/api/inseach')
              .then((response) => {
                res = response.data;
                if (res == true) {
                  this.inseach = true;
                } else {
                  this.inseach = false;
                }
              })
        },
        getLikesNumber() {
          axios.get('/getLikesNumberAuch', {
            params: {
              girl_id: this.girlid
            }
          })
              .then((response) => {
                this.likesNumber = response.data['likeNumber']
              });
          console.log("likes number " + this.likesNumber)
        },
        getAllDataForSidePanel() {
          axios.get('/api/getalldataforsidepanel', {
            params: {
              girl_id: this.girlid
            }
          })
              .then((response) => {
                var data = response.data;
                this.likesNumber = data.like;
                this.numberApplicationPresents = data.gift;
                this.numberUnreaded = data.messages;
                this.numberApplication = data.countRequwest;
                this.unreeadedEventRequwest=data.eventRequest
             //   this.filter_enable = data.filter.filter_enable;
                this.count_accept_notification = data.countAccept_notification;
              });
        },
        //
        getNumberUnreadedEventRequwest() {
          axios.get('/api/events/request/unread', {})
              .then((response) => {
                    //    this.unreeadedEventRequwest = response.data["count(*)"];
                    this.unreeadedEventRequwest = response.data.organizer;
                  }
              )
          ;
        },
        clouseChangeRventRequestModal(){
           this.showChangeEvemtRequestStatusPresentModal=false;
        },
        remidese() {
          axios.get('/api/events/reminders', {})
              .then((response) => {
                    //  console.log(response.data)
                    if (response.data.requestMyEvent.length > 0) {
                      this.showAlertModal = true;
                      this.event = response.data.requestMyEvent;
                    }
                  }
              )
          ;
        },
        clouseAlertModal() {
          this.showAlertModal = false;
        },
        logout() {

          axios.post('/logout').then(response => {
            if (response.status === 302 || 401) {
              console.log('logout')
              location.reload();
              document.location.reload();
            } else {
              document.location.reload();
              location.reload();
            }
          }).catch(error => {
            document.location.reload();
            location.reload();
          });
        }
      }
}
</script>

<style scoped>


.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(231, 199, 199, 0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.navbar {
  position: relative;
  width: 100%;
  left: 0;
  text-align: center;
}

.indigo-text{
  color:red;
  height: 50px;
  cursor: pointer;
}

.like-number{
  color: red;
  top:3px
}

.span-like{
  position: relative;
    top: 5px;
}

</style>
