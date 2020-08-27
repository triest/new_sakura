<template>
    <div>
        <b>Принятых заявок:</b>
        {{countaccepted}} <br>
        <b>Максимальное число заявок:</b> {{max_people}}

        <div v-if="countaccepted==max_people">
            <b> Максимальное число участников! </b>
        </div>

        <ul class="nav nav-tabs">
            <li role="presentation" @click="currentTab = 'accepted'"><a href="#"><b>Принятые</b></a></li>
            <li role="presentation" @click="currentTab = 'rejected'"><a href="#"><b>Отклоненные</b></a></li>
            <li role="presentation" @click="currentTab = 'unredded'"><a href="#"><b>Непрочитанные</b></a></li>
            <li role="presentation" @click="currentTab = 'all'"><a href="#"><b>Все</b></a>
            </li>
        </ul>
        <div class="applicationClass">
            <div class="tab-content">
                <div v-if="currentTab == 'all'">
                    <div v-for="requwest in requwestlist">

                        <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                                <div class="card-body">

                                    <a @click="myFunction(requwest.id)">
                                        <img :src="requwest.profile_url" height="150">
                                    </a>
                                    <a @click="myFunction(requwest.id)">
                                  {{requwest.name}}, {{requwest.age}}</a>
                                    <h5 v-if="requwest.requwest_status=='not_read'"><b>
                                        <p><a class="btn btn-primary" @click="accept(requwest.requwest_id)">
                                            Принять
                                        </a></p>
                                        <p>
                                            <a class="btn btn-danger" @click="reject(requwest.requwest_id)">
                                                Отклонить
                                            </a>
                                        </p>
                                    </b></h5>
                                    <h5 v-if="requwest.requwest_status=='accept'"><b>
                                        Заявка принята
                                        <a class="btn btn-danger" @click="reject(requwest.requwest_id)">
                                            Отклонить
                                        </a>
                                    </b></h5>

                                    <h5 v-if="requwest.requwest_status=='denide'"><b>
                                        Заявка отклонена
                                        <a class="btn btn-danger" @click="accept(requwest.requwest_id)">
                                            Принять
                                        </a>
                                    </b></h5>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentTab == 'accepted'">
                <div v-for="requwest in requwestlist">

                    <div v-if="requwest.requwest_status=='accept'">
                        <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                            <div class="card-body">

                                <a @click="myFunction(requwest.id)">
                                    <img :src="requwest.profile_url" height="150">
                                </a>
                                <a @click="myFunction(requwest.id)">
                                    <p>{{requwest.name}},
                                        {{requwest.age}}</p></a>

                                <h5 v-if="requwest.requwest_status=='not_read'">
                                    <p>
                                        <a class="btn btn-primary" @click="accept(requwest.requwest_id)">
                                            Принять
                                        </a>
                                    </p>
                                    <p>
                                        <a class="btn btn-danger" @click="reject(requwest.requwest_id)">
                                            Отклонить1
                                        </a>
                                    </p>
                                </h5>
                                <h5 v-if="requwest.requwest_status=='accept'"><b>
                                    <p>
                                        <a class="btn btn-danger" @click="reject(requwest.requwest_id)">
                                            Отклонить
                                        </a>
                                    </p>
                                </b></h5>
                                <h5 v-if="requwest.requwest_status=='denide'"><b>
                                    <p>
                                        <a class="btn btn-primary" @click="accept(requwest.requwest_id)">
                                            Принять
                                        </a>
                                    </p>
                                </b>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentTab == 'rejected'">
                <div v-for="requwest in requwestlist">
                    <div v-if="requwest.requwest_status=='denide'" class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                        <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                            <div class="card-body">

                                <a @click="myFunction(requwest.id)">
                                    <img :src="requwest.profile_url" height="150">
                                </a>
                                <a @click="myFunction(requwest.id)">
                                    <p>{{requwest.name}},
                                        {{requwest.age}}</p></a>

                                <h5 v-if="requwest.requwest_status=='denide'"><b>
                                    <a class="btn btn-primary" @click="accept(requwest.requwest_id)">
                                        Принять
                                    </a>
                                </b>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentTab == 'unredded'">
                <div v-for="requwest in unredded">

                    <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                        <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                            <div class="card-body">

                                <a @click="myFunction(requwest.id)">
                                    <img :src="requwest.profile_url" height="150">
                                </a>
                                <a @click="myFunction(requwest.id)">
                                    <p>{{requwest.name}},
                                        {{requwest.age}}</p></a>
                                <h5 v-if="requwest.requwest_status=='not_read'"><b>
                                    <p><a class="button" @click="accept(requwest.requwest_id)">
                                        Принять1
                                    </a></p>
                                    <p>
                                        <a class="button btn-danger" @click="reject(requwest.requwest_id)">
                                            Отклонить
                                        </a>
                                    </p>
                                </b></h5>
                                <h5 v-if="requwest.requwest_status=='accept'"><b>
                                    <a class="button " @click="reject(requwest.requwest_id)">
                                        Отклонить
                                    </a>
                                </b></h5>
                                <h5 v-if="requwest.requwest_status=='denide'"><b>
                                    <a class="button " @click="reject(requwest.requwest_id)">
                                        Отклонить
                                    </a>
                                </b></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            event: {
                type: Object,
                required: false
            },
        },
        components: {},
        mounted() {
            console.log("requwesteventlist1");
            this.getrequwests();
            //  this.getunreaded();
            //this.getacepted();
            // this.getdenided();
            // this.requwestcount();
        },
        data() {
            return {
                requwestlist: null,
                currentTab: 'all',
                accepted: null,
                rejected: null,
                unredded: null,
                countaccepted: null,
                max_people: null,
            }
        },
        methods: {
            gatall() {
                this.getrequwests();
                this.getacepted();
                this.getdenided();
                this.requwestcount();
            },

            accept( req_id) {
                this.requwestlist = [];
                this.accepted = null;
                this.rejected = null;
                this.unredded = null;
                axios.get('/events/accept', {
                        params: {
                            action: 'accept',
                            req_id: req_id,
                        }
                    }
                )
                    .then((response) => {

                    });
            //    this.gatall();
             //   this.getacepted();
            },
            reject( req_id) {

                axios.get('/events/denied', {
                        params: {
                            action: 'denied',
                            req_id: req_id,
                        }
                    }
                )
                    .then((response) => {
                    });
              //  this.gatall();
            },
            getrequwests() {
                this.requwestlist = null;
                axios.get('/events/' + this.event.id + '/requwestlist')
                    .then((response) => {
                        this.requwestlist = response.data.requwest;
                        console.log(this.requwestlist)
                    });
            }


        },
    }
</script>

<style scoped>

</style>