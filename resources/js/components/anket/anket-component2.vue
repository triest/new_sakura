<template>
    <div>
        <div v-for="gift in gifts">
            <img id="present_image" v-on:click="openMyPresentsPodal()" class="present_image" height="40px"
                 :src="'/upload/presents/'+gift.image">
        </div>
        <myPresentModal :user="user" :gifts="gifts" v-if="showPresentModal"
                        @closeRequest='clousePresentModal()'></myPresentModal>
    </div>
</template>

<script>
    import present from './PresentModal.vue'
    import myPresentModal from './myPresentsModal'

    export default {

        props: {
            user: {
                type: Object,
                required: false
            },
            gifts: {
                type: Array,
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
            myPresentModal
        },
        mounted() {
            console.log("anket component");
            this.checkLike();
            console.log("gifts");
            console.log(this.gifts)
        },
        methods: {
            openMyPresentsPodal() {
                this.showPresentModal = true;
            },
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

    .present_image {
        display: flex;
        width: 60px;
        height: 60px;
        overflow: hidden;
        align-items: center;
        border-radius: 50%;
        border: 1px solid #329BF0;
        position: relative;

    }

    .present_image {
        border-radius: 50% !important;
    }

    .present_image:hover {
        cursor: pointer;
    }


</style>