<template>
    <div class="card  border-dark" >
        <div v-if="eventRequwest==null">
            <button class="btn btn-outline-primary" v-on:click="makeRequwest()">Оставить заявку на участие</button>
        </div>
        <div v-else>
               {{eventRequwest.status.name}}
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
                eventRequwest: null
            }
        },
        mounted() {

            this.getRequwest();
        },
        methods: {
            getRequwest() {

                axios.get('/api/events/check-request', {params: {user: this.user.id, event: this.event.id}}
                )
                    .then((response) => {
                        this.eventRequwest = response.data.eventRequwest;
                        console.log("eventRequwest");
                        console.log(this.eventRequwest);
                    });
            },
            makeRequwest() {
                axios.get('/api/events/make-request', {params: {user: this.user.id, event: this.event.id}}
                )
                    .then((response) => {
                        this.getRequwest();
                    });
            }
        }
    }
</script>

<style scoped>

</style>
