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
        },
        methods: {
            openMyPresentsPodal() {
                this.showPresentModal = true;
            },
            closePresentModal() {
                this.showPresentModal = false;
            },
            closeNewMessageModal() {
                this.showMessageModal = false;
            },
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
