<template>
    <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
        <div v-if="eventRequwest==null">
            <button class="btn btn-secondary" v-on:click="makeRequwest()">Оставить заявку на участие</button>
        </div>
        <div v-else-if="eventRequwest!=null">
            <div v-if="eventRequwest.status==='not_read'">
                Ваша заявка не прочитанна!
            </div>
            <div v-if="eventRequwest.status==='accept'">
                Ваша заявка принята
            </div>
            <div v-if="eventRequwest.status==='denide'">
                Ваша заявка отклонена!
            </div>
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

                axios.get('/events/check-requwest', {params: {user: this.user.id, event: this.event.id}}
                )
                    .then((response) => {
                        this.eventRequwest = response.data.eventRequwest;
                        console.log("eventRequwest");
                        console.log(this.eventRequwest);
                    });
            },
            makeRequwest() {
                console.log("make req");
                axios.get('/events/make-requwest', {params: {user: this.user.id, event: this.event.id}}
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