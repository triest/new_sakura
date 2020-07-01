<template>
    <div>
        <a class="btn btn-primary" v-on:click="showPresentModal=true">Подарить подарок</a>
        <present v-if="showPresentModal"  @closeRequest='clousePresentModal()'></present>
    </div>
</template>

<script>
    import present from './PresentModal.vue'

    export default {

        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                showPresentModal: false,
            };
        },
        components: {
            present
        },
        mounted() {
            console.log("anket component")
        },
        methods: {
            clousePresentModal(){
                this.showPresentModal=false;
            },

        }
    }
</script>

<style scoped>

</style>