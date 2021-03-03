<template>
  <div class="row">

    <div class="card" v-for="item in visits">
      <div v-if="item.who!==null">
        <a :href="/anket/+item.who.id">
          <img width="250" height="250" :src="item.who.photo_profile_url">
          <div class="cell">
            <div class="cell-overflow">
              {{item.who.name}}
              {{item.date}}
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "visit",
  props: {},
  components: {},
  data() {
    return {
      visits: null
    }
        ;
  },
  mounted() {
    console.log('visits')
    this.getVisits()
  },
  methods:
      {
        getVisits() {
          axios.get('/api/visits')
              .then((response) => {
                this.visits = response.data;
              })
        }
      }
}
</script>


<style scoped>

</style>
