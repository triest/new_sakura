<template>
    <div>
        <div class="bd-example bd-example-tabs">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home"
                           role="tab" aria-controls="v-pills-home" aria-selected="true">Я нравлюсь</a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile"
                           role="tab" aria-controls="v-pills-profile" aria-selected="false">Нравиться мне</a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages"
                           role="tab" aria-controls="v-pills-messages" aria-selected="false">Взаимная симпатия</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <div v-for="likes in likesForMe">
                                <anket-short-view :user="likes.who"></anket-short-view>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                             aria-labelledby="v-pills-profile-tab">
                            <div v-for="likes in myLikes">
                                <anket-short-view :user="likes.target"></anket-short-view>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                             aria-labelledby="v-pills-messages-tab">
                            <div v-for="likes in mutual">
                                <anket-short-view :user="likes.who"></anket-short-view>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import AnketShortView from "./AnketShortView";

export default {
    props: {
        event: {
            type: Object,
            required: false
        },
    },
    components: {AnketShortView},
    mounted() {
        this.getLikes()
    },
    data() {
        return {
            currentTab: 'all',
            myLikes:[],
            likesForMe:[],
            mutual:[]
        }
    },
    methods: {
        getLikes(){
            axios.get('/api/like/get-like-list', {

                }
            )
                .then((response) => {
                    this.myLikes=response.data.myLikes;
                    this.likesForMe=response.data.likesForMe;
                    this.mutual=response.data.mutual;

                });

        }

    },
}
</script>

<style scoped>
.flex-sm-fill {
    cursor: pointer;
}

</style>
