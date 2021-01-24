<template>
  <div class="panel panel-default panel-body">
    <span v-if="item!=null">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9 box-shadow">
      <a :href="/anket/+item.id">
        <img :src="item.profile_url" height="500px" width="300px">
      </a>
        <div class="cell">
          <div class="cell-overflow">
              <button class="btn-primary" v-on:click="like('like')"
                      style="" title="Нравитья">
                    ✓
                </button>
                <button class="btn-secondary" v-on:click="skip()"
                        style="" title="Нейтрально">
                    N
                </button>
                <button class="btn-danger" v-on:click="like('dislike')"
                        style="" title="Не нравиться">×
                </button>
          </div>
          <div v-if="matchVisibly===true">
            <div class="match-font">Совпадение!</div>
          </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9 box-shadow">
      <b> {{ item.name }},1 {{ item.age }}</b>
      <p v-if="city!=null">
        <small>{{ city.name }}</small>
      </p>
      <p v-if="online=='null'"> {{ item.last_login }}
      <p v-else>
        {{ lastLogin }}
      </p>
      <div v-if="targets.length">
        <b>Цель знакомства</b>
        <div v-for="item in targets">
          {{ item.name }},
        </div>
      </div>
      <div v-if="interets.length">
        <b>Интересы</b>
        <div v-for="item in interets">
          {{ item.name }},
        </div>
      </div>
    </div>
    </span>
    <span v-else>
      Нет анкет. Вы поставили лайки всем подходящим пользователям в городе. Попробуйте изменить настройки поиска
    </span>
  </div>
</template>

<script>
export default {
  name: "likeCarousel",
  mounted() {
    this.getAnket();
  },
  data() {
    return {
      mainImage: null,
      girl_id: null,
      anketList: [],
      item: null,
      online: null,
      city: null,
      targets: [],
      interets: [],
      lastLogin: null,
      matchVisibly:false
    }
  },
  methods:
      {
        getAnket() {
          axios.get('api/like-carousel/getAnket')
              .then((response) => {
                this.item = response.data.ankets;
                this.online = response.data.online;
                this.city = response.data.city;
                this.targets = response.data.targets;
                this.interets = response.data.interets;
                this.interets = response.data.interets;
                this.lastLogin = response.data.lastLogin
              });
        },
        like(action) {
          let that = this;
          let temp = null;
          axios.get('api/like-carousel/newLike', {
            params: {
              user_id: this.item.id,
              action: action,
            }
          })
              .then(function (data){
                temp = data.data;
                if(temp.result===false && temp.message==="not auth"){
                }else if(temp.result===true && temp.match===false){
                  that.getAnket();
                }else if(temp.result===true && temp.match===true){
                   that.matchVisibly=true;
                }
              });
        },
        skip() {
          axios.get('api/like-carousel/newlike', {
            params: {
              user_id: this.item.id,
              action: "skip",
            }
          })
              .then((response) => {
                this.getAnket();
              });
        },

      }
}


</script>

<style scoped>
.btn-primary {
  background-color: #44c767;
  border-radius: 50%;
  border: 1px solid #18ab29;
  display: inline-block;
  cursor: pointer;
  color: #ffffff;
  font-family: Arial;
  font-size: 22px;
  padding: 16px 18px;
  text-decoration: none;
  text-shadow: 0px 1px 0px #2f6627;
  position: relative;

}

.btn-primary:hover {
  background-color: #5cbf2a;
}

.btn-primary:active {
  position: relative;
  top: 1px;
}

.btn-secondary {
  background-color: #2a38c7;
  border-radius: 50%;
  border: 1px solid #0300af;
  display: inline-block;
  cursor: pointer;
  color: #ffffff;
  font-family: Arial;
  font-size: 22px;
  padding: 16px 18px;
  text-decoration: none;
  text-shadow: 0px 1px 0px #2a38c7;
}

.btn-secondary:hover {
  background-color: #110aaf;
}

.btn-secondary:active {
  position: relative;
  top: 1px;
}

.btn-danger {
  background-color: #ee001e;
  border-radius: 50%;
  border: 1px solid #ee001e;
  display: inline-block;
  cursor: pointer;
  color: #ffffff;
  font-family: Arial;
  font-size: 22px;
  padding: 16px 18px;
  text-decoration: none;
  text-shadow: 0px 1px 0px #2f6627;
}

.btn-danger:hover {
  background-color: #b30011;
}

.btn-danger:active {
  position: relative;
  top: 1px;
}


.cell {
  position: absolute;
  top: 300px;
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

.match-font{
  font-family: Impact, Charcoal, sans-serif;
  font-size: 40px;
  letter-spacing: 5px;
  word-spacing: 6px;
  color: #2EFF2C;
  font-weight: 700;
  text-decoration: rgb(68, 68, 68);
  font-style: italic;
  font-variant: small-caps;
  text-transform: uppercase;
  margin-left: -45px;
}
</style>
