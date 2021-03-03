<template>
  <div>
    <div class="container">
      <p class="search-container">
        <button class="btn btn-primary" v-on:click="openSeachModal()">Настроить поиск</button>
        <code id="searchCount" class="searchCount" v-if="total!=null">Найдено анкет: {{ total }} </code>
      </p>
      <div class="buttons-scroll">
      <span style="width: 70px; display: inline-block">
      <button id="next" v-if="prev_page_url!=null" class="btn btn-primar" v-on:click="seach(prev_page_url)">
        Назад
      </button>
      </span>
        <span style="width: 200px; display: inline-block">
       {{current_page}} из {{page_count}}
         <button v-if="next_page_url!=null" class="btn btn-primary" v-on:click="seach(next_page_url)">Вперед</button>
      </span>
      </div>
      <div class="row">
        <br>
        <div class="card" v-for="item in anketList">
          <anket-short-view :user="item"></anket-short-view>
        </div>
        <SearchModal class="search-modal" v-if="seachModal" @closeSeachModal="closeSeachModal()"></SearchModal>
      </div>
      <span style="width: 70px; display: inline-block">
      <button id="next2" v-if="prev_page_url!=null" class="btn btn-primar" v-on:click="seach(prev_page_url)">
        Назад
      </button>
      </span>
      <span style="width: 200px; display: inline-block">
       {{current_page}} из {{page_count}}
         <button v-if="next_page_url!=null" class="btn btn-primary" v-on:click="seach(next_page_url)">Вперед</button>
      </span>
    </div>
  </div>
</template>

<script>
import SearchModal from './SearchModal'
import AnketShortView from "./AnketShortView";

export default {

  mounted() {
    this.seach();
    this.scroll();
    this.page = 1;
  },
  data() {
    return {
      anketList: [],
      page: 1,
      numPages: null,
      count: 0,
      seachModal: false,
      event: "",
      prev_page_url: null,
      next_page_url: null,
      total: null,
      page_count: null,
      current_page: null
    }
  },
  components: {SearchModal,AnketShortView},
  methods: {

    seach(url = 'api/anket/search') {
      this.anketList = [];
      axios.get(url).then((response) => {
        let data = response.data;
        this.anketList = data.data;
        this.prev_page_url = data.links.prev;
        this.next_page_url = data.links.next;
        this.total = data.meta.total;
        this.page_count = data.meta.last_page;
        this.current_page = data.meta.current_page;
      })
    },

    scroll() {
      window.onscroll = () => {
        let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;

        if (bottomOfWindow && this.page < this.numPages) {
          this.loadNew();
        }
      }
    },
    next(page) {
      this.page = this.page + 1;
      this.loadNew();
    },
    previous() {
      this.page = this.page - 1;
      this.loadNew();
    },
    loadNew: function () {
      console.log(this.page);
      axios.get('api/anket/search',
          {
            params:
                {
                  page: this.page
                }
          }
      ).then((response) => {
        let data = response.data;
        this.anketList = data.ankets;
        this.numPages = data.num_pages;
        this.count = data.count;
      })
    },
    closeSeachModal() {
      this.seachModal = false;
      this.seach();
    },
    openSeachModal() {
      this.seachModal = true;
    },
  }
}
</script>


<style scoped>
.cell {
  position: absolute;
  top: 180px;
  right: 0;
  bottom: 30px;
  left: 0;
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

</style>
