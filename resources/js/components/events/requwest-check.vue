<template>
  <div>
    <b>Принятых заявок:</b>
    {{ countaccepted }} <br>
    <b>Максимальное число заявок:</b> {{ max_people }}

    <div v-if="countaccepted==max_people">
      <b> Максимальное число участников! </b>
    </div>

    <ul class="nav nav-pills flex-column flex-sm-row">
      <li class="flex-sm-fill text-sm-center nav-link " v-bind:class="currentTab==='accepted'?'active':''" @click="setTab('accepted')"><b>Принятые</b></li>
      <li class="flex-sm-fill text-sm-center nav-link "  v-bind:class="currentTab==='rejected'?'active':''" @click="setTab('rejected')"><b>Отклоненные</b></li>
      <li class="flex-sm-fill text-sm-center nav-link "  v-bind:class="currentTab==='unredded'?'active':''"  @click="setTab('unredded')"><b>Непрочитанные</b></li>
      <li class="flex-sm-fill text-sm-center nav-link " v-bind:class="currentTab==='all'?'active':''"  @click="setTab('all')"><b>Все</b>
      </li>
    </ul>
    <div class="applicationClass">
      <div class="tab-content">
        <div v-if="currentTab == 'all'">
          <div v-for="requwest in request_list">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 box-shadow">
              <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                  <div class="card-body">

                    <a @click="myFunction(requwest.id)">
                      <img :src="requwest.user.profile_url" height="150">
                    </a>
                    <a @click="myFunction(requwest.id)">
                      <p>{{ requwest.user.name }},
                        {{ requwest.user.age }}</p></a>
                    <h5 v-if="requwest.status_id==1">
                      <p>
                        <a class="btn btn-primary" @click="accept(requwest.id)">
                          Принять
                        </a>
                      </p>
                      <p>
                        <a class="btn btn-danger" @click="reject(requwest.id)">
                          Отклонить
                        </a>
                      </p>
                    </h5>
                    <h5 v-if="requwest.status_id==2"><b>
                      <p>
                        <a class="btn btn-danger" @click="reject(requwest.id)">
                          Отклонить
                        </a>
                      </p>
                    </b></h5>
                    <h5 v-if="requwest.status_id==3"><b>
                      <p>
                        <a class="btn btn-primary" @click="accept(requwest.id)">
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
        </div>
      </div>
      <div v-if="currentTab == 'accepted'">
        <div v-for="requwest in request_list">
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 box-shadow" v-if="requwest.status_id==2">
            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
              <div class="card-body">


                    <div class="card-body">

                      <a @click="myFunction(requwest.id)">
                        <img :src="requwest.user.profile_url" height="150">
                      </a>
                      <a @click="myFunction(requwest.id)">
                        <p>{{ requwest.user.name }},
                          {{ requwest.user.age }}</p></a>

                      <h5 v-if="requwest.status_id==1">
                        <p>
                          <a class="btn btn-primary" @click="accept(requwest.id)">
                            Принять
                          </a>
                        </p>
                        <p>
                          <a class="btn btn-danger" @click="reject(requwest.id)">
                            Отклонить
                          </a>
                        </p>
                      </h5>
                      <h5 v-if="requwest.status_id==2"><b>
                        <p>
                          <a class="btn btn-danger" @click="reject(requwest.id)">
                            Отклонить
                          </a>
                        </p>
                      </b></h5>
                      <h5 v-if="requwest.status_id==3"><b>
                        <p>
                          <a class="btn btn-primary" @click="accept(requwest.id)">
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
      </div>
      <div v-if="currentTab == 'rejected'">
        <div v-for="requwest in request_list">
          <div v-if="requwest.status_id==3" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 box-shadow">
            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
              <div class="card-body">

                <a @click="myFunction(requwest.id)">
                  <img :src="requwest.user.profile_url" height="150">
                </a>
                <a @click="myFunction(requwest.id)">
                  <p>{{ requwest.user.name }},
                    {{ requwest.user.age }}</p></a>

                <h5 v-if="requwest.status_id==3"><b>
                  <a class="btn btn-primary" @click="accept(requwest.id)">
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
        <div v-for="requwest in request_list">
          <div v-if="requwest.status_id==1" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 box-shadow">
            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
              <div class="card-body">

                <a @click="myFunction(requwest.id)">
                  <img :src="requwest.user.profile_url" height="150">
                </a>
                <a @click="myFunction(requwest.id)">
                  <p>{{ requwest.user.name }},
                    {{ requwest.user.age }}</p></a>

                <a class="btn btn-primary" @click="accept(requwest.id)">
                  Принять
                </a>
                <a class="btn btn-danger" @click="reject(requwest.id)">
                  Отклонить
                </a>

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
    this.getrequests();
  },
  data() {
    return {
      request_list: null,
      currentTab: 'all',
      accepted: null,
      rejected: null,
      unreadded: null,
      countaccepted: null,
      max_people: null,
    }
  },
  methods: {
    gatall() {
      this.getrequests();
    },

    accept(req_id) {
      this.request_list = [];
      this.accepted = null;
      this.rejected = null;
      this.unreadded = null;
      axios.get('/api/events/accept', {
            params: {
              action: 'accept',
              req_id: req_id,
            }
          }
      )
          .then((response) => {
            this.getrequests();
          });
    },
    reject(req_id) {

      axios.get('/api/events/denied', {
            params: {
              action: 'denied',
              req_id: req_id,
            }
          }
      )
          .then((response) => {
            this.getrequests();
          });

    },
    getrequests() {
      this.request_list = null;
      axios.get('/api/events/' + this.event.id + '/request-list')
          .then((response) => {
            this.request_list = response.data.request_list;
            console.log(this.request_list)
          });
    },

    setTab(tab){
        this.currentTab=tab;
    }


  },
}
</script>

<style scoped>
 .flex-sm-fill{
    cursor: pointer;
 }

</style>
