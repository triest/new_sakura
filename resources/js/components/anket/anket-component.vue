<template>
    <div>
        <p v-if="likeExist=='false'">
            <a class="btn btn-primary" v-on:click="like()">Нравиться</a>
        </p>
        <p v-else>
            Вам нравиться эта анкета
        </p>
        <p>
            <a class="btn btn-primary" v-on:click="showPresentModal=true">Подарить подарок</a>
        </p>
        <p>
            <a class="btn btn-primary" v-on:click="showMessageModal=true">Написать сообщение</a>
        </p>
        <present v-if="showPresentModal" :user="user" @closeRequest='clousePresentModal()'></present>
        <newMessageModal :user="user" v-if="showMessageModal"
                         @closeNewMessageAlert='clouseNewMessageModal()'></newMessageModal>
    </div>
</template>

<script>
    import present from './PresentModal.vue'
    import newMessageModal from './newMessageModal'

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
                showMessageModal: false,
                likeExist: false,
            };
        },
        components: {
            present,
            newMessageModal
        },
        mounted() {
            console.log("anket component");
            this.checkLike();
        },
        methods: {
            clousePresentModal() {
                console.log("close present modal")
                this.showPresentModal = false;
            },
            clouseNewMessageModal() {
                this.showMessageModal = false;
            },
            like() {
                axios.get('/like-carusel/newLike', {
                    params: {
                        user_id: this.user.id,
                        action: "like",
                    }
                })
                    .then((response) => {
                        this.checkLike();
                    });
            },
            checkLike() {
                axios.get('/like-carusel/checkLike', {
                    params: {
                        user_id: this.user.id,
                        action: "checkLike",
                    }
                })
                    .then((response) => {
                        this.likeExist = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>