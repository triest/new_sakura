<template>
  <div>
   <a href="/messages">Сообщения
      <div v-if="numberUnreaded>0">({{numberUnreaded}})</div>
    </a>
    <a href="/applications">Заявки на открытие анкеты
      <div v-if="numberApplication>0">({{numberApplication}})</div>
    </a>
    <a class="btn btn-info" href="/mypresents">Мои подарки</a>
    <div class="dropdown">
      <img :src="user.profile_url" height="50px" class="dropbtn">
      <div class="dropdown-content">
        <a href="/lk/profile">Профиль</a>
        <a href="/lk/logout">Выйти</a>
      </div>
    </div>
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
  components: {

  },
  data() {
    return {
      numberUnreaded: 0,
      numberApplication: 0,
      numberApplicationPresents: 0,
      inseach: false,
      likesNunber: 0,
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
    this.inSeach();
    this.getAllDataForSidePanel();
    this.getNumberUnreadedEventRequwest();
    this.remidese();
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
        inSeach() {
          let res;
          axios.get('/inseach')
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
                this.likesNunber = response.data['likeNumber']
              });
          console.log("likes number " + this.likesNunber)
        },
        getAllDataForSidePanel() {
          axios.get('/getalldataforsidepanel', {
            params: {
              girl_id: this.girlid
            }
          })
              .then((response) => {
                var data = response.data;
                this.likesNunber = data.likeNumber;
                this.numberApplicationPresents = data.countGift;
                this.numberUnreaded = data.countMessages;
                this.numberApplication = data.countRequwest;
                this.filter_enable = data.filter.filter_enable;
                this.count_accept_notification = data.countAccept_notification;
              });
        },
        clouseLikeModal() {
          console.log("clouseLikeModal");
          this.showLikeModal = false;
        },
        //
        getNumberUnreadedEventRequwest() {
          axios.get('/event/requwest/myevent', {})
              .then((response) => {
                    //    this.unreeadedEventRequwest = response.data["count(*)"];
                    this.unreeadedEventRequwest = response.data.organizer;
                  }
              )
          ;
        },
        remidese() {
          axios.get('/event/reminders', {})
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
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

</style>
