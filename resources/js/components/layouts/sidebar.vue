<template>
  <div class="d-flex justify-content-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

      <a class="btn btn-primary" href="/applications" style="cursor: pointer">Заявки на открытие анкеты
        <div v-if="numberApplication>0">({{ numberApplication }})</div>
      </a>
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
  </div>
</template>

<script>

export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  components: {},
  data() {
    return {
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
      count_accept_notification: 0
    }
        ;
  },
  mounted() {
   // this.inSearch();
    this.getAllDataForSidePanel();
    this.getNumberUnreadedEventRequwest();
    Echo.private(`messages.${this.user.id}`)
        .listen('NewMessage', (e) => {
          console.log('NewMessage');
          axios.get('/getCountUnreaded')
              .then((response) => {
                this.numberUnreaded = response.data;
              });
          this.getNumberUnreadedMessages();
          this.showNemMessageModal = true;
        });
    Echo.private(`requwests.${this.user.id}`)
        .listen('newApplication', (e) => {
          console.log('NewRequwest');
          axios.get('/getCountUnreadedRequwest')
              .then((response) => {
                this.numberApplication = response.data;
              })
        });
    Echo.private(`gifs.${this.user.id}`)
        .listen('eventPreasent', (e) => {
          this.getNumberUnreadedPresents();
          console.log("presrn");
        });
    Echo.private(`eventsrequwest.${this.user.id}`)
        .listen('Newevent', (e) => {
          console.log('NewRequwestEvent');
        });
    Echo.private(`App.User.${this.user.id}`)
        .listen('Newevent', (e) => {
          this.getNumberUnreadedEventRequwest();
        });
  },
  methods:
      {
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
          axios.get('/getCountUnreaded')
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

          axios.post('logout').then(response => {
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
