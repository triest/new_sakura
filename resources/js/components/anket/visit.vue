<template>
  <div class="row">
    <div class="card" v-for="item in visits">
      <div v-if="item.who!==null">
        <anket-short-view :user="item.who"></anket-short-view>
        <div class="cell">
          <div class="cell-overflow">
            {{ item.date }}

          </div>
          <div class="cell-new">
          <span v-if="item.read===0" class="new">Новый!</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AnketShortView from "./AnketShortView";

export default {
  name: "visit",
  props: {},
  components: {AnketShortView},
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

.cell {
  position: absolute;
  top: 180px;
  right: 0;
  bottom: 30px;
  left: 100px;
  box-sizing: border-box;
  display: block;
  padding: 20px;
  width: 100%;
  color: white;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}

.cell-overflow {
  box-sizing: border-box;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: white;
}

.cell-new {
  box-sizing: border-box;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: white;
  position: relative;
  bottom: 200px;
  left: 40;
}



.new{
  color: #ff0000;
}
</style>
