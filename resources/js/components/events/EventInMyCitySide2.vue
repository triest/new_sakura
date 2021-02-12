<template>
    <div>
        <div v-if="eventList.length">
            <div v-for="event in eventList" :key="event.id">
                <div class="col-sm-1"></div>
                <b>{{event.name}}</b> <br>
                Место:{{event.place}} <br>
                Дата: {{event.begin}} <br>
              {{ event.status.name }}
              <div v-if="checkRequest(event.id)!==false">
                <a class="btn btn-primary" v-bind:href="'/events/'+event.id"> {{ checkRequest(event.id).name }} </a>
              </div>
              <div v-else>
                <a class="btn btn-primary" v-bind:href="'/events/'+event.id">Записаться!</a>
              </div>
            </div>
        </div>
        <div v-else>
            Событий в вашем городе нет.
            <a class="btn btn-primary" href="/events/create">Создать событие!</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            city: {
                type: Object,
                default: null
            }
        },
        mounted() {
          this.getEvents()
        },
        data() {
            return {
                eventList: "",
                partification: "",
                add: false
            };
        },
        methods: {
            getEvents() {
                axios.get('/api/events/inmycity', {params: {type: "json", city: this.city.id}}
                )
                    .then((response) => {
                        this.eventList = response.data.events;
                        this.partification = response.data.partificators;
                        console.log("events")
                    });
            },
            checkRequest(event_id) {

                for (let i = 0; i < this.partification.length; i++) {
                    if (typeof this.partification[i] === "undefined") {
                        return false;
                    }

                    if (this.partification[i].event_id === event_id) {

                        return this.partification[i].status;
                    }
                }
                return false;
            }
        }

    }
</script>

<style scoped>
    .eventPanel {
        max-width: 250px;
    }
</style>
