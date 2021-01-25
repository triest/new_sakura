<template>
  <div>
    <div class="col-lg-3 col-md-5 col-sm-6  justify-content-center col-xs-9 box-shadow" v-for="item in likes"
         style="padding-left:60px; padding-right: 20px;margin: auto;">
      <a>
        <img width="250" height="250" :src="item.blur_photo_profile_url">
        <div class="cell">
          <div class="cell-overflow">
          </div>
        </div>
      </a>
    </div>
  </div>

</template>

<script>
export default {
  name: "like",
  mounted() {

    this.getMyLikes();
  },
  data() {
    return {
      likes:[]
    }
  },
  methods:
      {
        getMyLikes() {
          console.log("likes")
          axios.get('api/like/get-my-likes')
              .then((response) => {
                let data = response.data;
                this.likes=data.data;
              });
        },
        like(action) {

        }
      }
}
</script>

<style scoped>
* {
  box-sizing: border-box;
}

.buttons-scroll{
  margin-left: 50px;
}

.search-container {
  margin-left: 55px;
  left: 200px;
  top: 5px
}

.search-modal{
  max-width: calc(100vh - 225px);;
  max-height: calc(100vh - 225px);;
}


.circle:before {
  content: ' \25CF';
  font-size: 20px;
  margin: 0 auto;
  position: absolute;
  bottom: 0;
  background: rgb(0, 0, 0); /* Fallback color */
  background: rgba(145, 100, 153, 0); /* Black background with 0.5 opacity */
  color: #20f100;
  width: 100%;
  padding: 10px;
}

.container img {
  vertical-align: middle;
}

.searchCount {
  position: absolute;
  top: 5px;
  left: 200px;
}

.container .content {
  position: absolute;
  bottom: 0;
  background: rgb(0, 0, 0); /* Fallback color */
  background: rgba(0, 0, 0, 0); /* Black background with 0.5 opacity */
  color: #f1f1f1;
  width: 100%;
  padding: 0px;
  margin: 115px;
}

.cell {
  position: absolute;
  top: 150px;
  right: 0;
  bottom: 30px;
  left: 0;
  box-sizing: border-box;
  display: block;
  padding: 70px;
  width: 100%;
  color: white !important;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
  cursor: pointer;
}

.cell-overflow {
  box-sizing: border-box;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: white;
  cursor: pointer;
}

.previous {
  cursor: pointer;
  margin-left: 50%;

}

.white:link {
  color: white;
}

.notfound {

}

#searchCount {
  margin-left: auto;
  margin-right: auto;
}
</style>
