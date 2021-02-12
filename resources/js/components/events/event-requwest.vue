<template>
  <div>
    <div v-if="eventRequest==null">
        <span >
            <button class="btn btn-primary" v-on:click="makeRequest()">Оставить заявку на участие</button>
        </span>
    </div>
    <div class="event-request" v-else >
        <span class="status">
                {{ eventRequest.status.name }}
        </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    event: {
      type: Object,
      default: null
    },
    user: {
      type: Object,
      default: null
    }

  },
  data() {
    return {
      eventRequest: null
    }
  },
  mounted() {
    this.getRequest();
  },
  methods: {
    getRequest() {

      axios.get('/api/events/check-request', {params: {user: this.user.id, event: this.event.id}}
      )
          .then((response) => {
            this.eventRequest = response.data.eventRequest;
          });
    },
    makeRequest() {
      axios.get('/api/events/make-request', {params: {user: this.user.id, event: this.event.id}}
      )
          .then((response) => {
            if (response.data.result !== false) {
              this.eventRequest = response.data.result;
            } else {
              console.log("Ошибка")
            }
          });
    }
  }
}
</script>

<style scoped>
.event-request {
  width: 13rem;
  height: 4rem;
  background-color: #eeeeee;
  border: 1px solid transparent;
  border-color: black;
  border-radius: 10px;
}

.status {
  top: 8px;
  left: 18%;
  position: relative;
}

</style>
