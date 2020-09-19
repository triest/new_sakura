<template>
    <div>
        <p>
            <button class="btn btn-primary" v-on:click="openSeachModal()">Настроить поиск</button>
            <b id="searchCount" class="col-lg-2" v-if="total!=null">Найдено анкет: {{total}} </b>
        </p>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-9 box-shadow" v-for="item in anketList">
            <a :href="/anket/+item.id">
                <img width="250" height="250" :src="item.profile_url">
                <div class="cell">
                    <div class="cell-overflow">
                        {{item.name}}, {{item.age}}
                    </div>
                </div>
            </a>
        </div>
        <div>
            <div v-if="prev_page_url!=null">
                <button class="btn btn-primar" v-on:click="seach(prev_page_url)">Назад</button>
            </div>
            <div v-if="next_page_url!=null">
                <button class="btn btn-primary" v-on:click="seach(next_page_url)">Вперед</button>
            </div>
        </div>
        <SearchModal v-if="seachModal" @closeSeachModal="closeSeachModal()"></SearchModal>
    </div>
</template>

<script>
    import SearchModal from './SearchModal'

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
                total: null
            }
        },
        components: {SearchModal},
        methods: {

            seach(url = '/seach') {
                this.anketList = [];
                axios.get(url).then((response) => {
                    let data = response.data;
                    this.anketList = data.data;
                    this.prev_page_url = data.links.prev;
                    this.next_page_url = data.links.next;
                    this.total = data.meta.total;
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
                axios.get('/seach',
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
    * {
        box-sizing: border-box;
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

    #searchCount {
        position: absolute;
        top: 5px;
        left: 150px;
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
        padding: 20px;
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