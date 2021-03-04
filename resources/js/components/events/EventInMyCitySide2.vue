<template>
  <div>
    <div v-if="eventList.length">
      <carousel :width="30" :height="30" :loop ="true" :autoplay="true" :autoplayTimeout="3000" :autoplayHoverPause="true" :perPage="1" :navigationEnabled="true" :paginationEnabled="false" >
        <slide  v-for="event in eventList" :key="event.id" >

            <div class="col-sm-1"></div>
            <b>{{ event.name }}</b> <br>
            Место:{{ event.place }} <br>
            Начало: {{ event.begin }} <br>
            {{ event.status.name }}
            <span v-if="user!=null && typeof user.id!=='undefined'&& event.user_id===user.id">
              владелец
              <!--
              <carousel :loop ="true" :autoplay="true" :autoplayTimeout="3000" :autoplayHoverPause="true" :perPage="1" :navigationEnabled="true" :paginationEnabled="false" >
                         <slide v-for="request in checkRequest(event.id)">
                            {{request.user.name}}
                         </slide>
              </carousel>
              -->
            </span>
            <div v-else>
              <div v-if="checkPartificator(event.id)!==false">
                <a class="btn btn-primary" v-bind:href="'/events/'+event.id"> {{
                    checkPartificator(event.id).name
                  }} </a>
              </div>
              <div v-else>
                <a class="btn btn-primary" v-bind:href="'/events/'+event.id">Записаться!</a>
              </div>
            </div>
          </slide>
      </carousel>
    </div>
    <div v-else>
      Событий в вашем городе нет.
      <a class="btn btn-primary" href="/events/create">Создать событие!</a>
    </div>

  </div>
</template>

<script>
import {Carousel, Slide} from 'vue-carousel';

export default {
  name:'EventInMyCitySide2',
  props: {
    city: {
      type: Object,
      default: null
    },
    user: {
      type: Object,
      default: null
    }
  },
  beforeMount() {
    this.getEvents();
  },
  mounted() {

  },
  data() {
    return {
      eventList: "",
      partification: [],
      add: false,
      requests: []
    };
  },
  components: {
    Carousel,
    Slide
  },
  methods: {
    getEvents() {
      axios.get('/api/events/inmycity', {params: {type: "json", city: this.city.id}}
      )
          .then((response) => {
            this.eventList = response.data.events;
            this.partification = response.data.partificators;
            this.requests = response.data.requests
            console.log("events")
          });
    },
    checkPartificator(event_id) {

      for (let i = 0; i < this.partification.length; i++) {
        if (typeof this.partification[i] === "undefined" && this.partification[i].event_id === event_id) {
          return this.partification[i].status;
        }
      }
      return false;
    },
    checkRequest(event_id) {
      let requests = [];
      for (let j = 0; j < this.requests.length; j++) {
        for (let i = 0; i < this.requests[j].length; i++) {
          if (this.requests[j][i]["event_id"] === event_id) {
            requests.push(this.requests[j][i]);
          }
        }
      }
      console.log(requests);
      return requests;
    }
  }

}
</script>

<style scoped>
.eventPanel {
  max-width: 250px;
}

.VueCarousel-slide {
 /* height: 30px;*/
  width: 30px;
  white-space: 1px;
  text-align: center;
}

.VueCarousel-slide .img-container {
  height: 50px;
  width: 100%;
  /*float: left;*/
}

.VueCarousel-slide img {
  margin: 0 auto;
}

.VueCarousel-slide h3 {
  height: 30px;
}

</style>
