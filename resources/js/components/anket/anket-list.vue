<template>
    <div>
        <p>
            <button class="btn btn-primary" v-on:click="openSeachModal()">Настроить поиск</button>
        </p>
        <div class="col-md-3" v-for="item in anketList">
            <a :href="/anket/+item.id">
                <img width="250" height="250" :src="item.profile_url">
                <div class="cell">
                    <div class="cell-overflow">
                        {{item.name}},
                    </div>
                    {{item.age}}
                </div>
            </a>
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
            }
        },
        components: {SearchModal},
        methods: {

            seach() {
                this.anketList = [];
                axios.get('/seach').then((response) => {
                    let data = response.data;
                    this.anketList = data.ankets;
                    this.numPages = data.num_pages;
                    this.count = data.count;

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
            loadNew() {
                this.page++;
                console.log(this.page);
                axios.get('/seach',
                    {
                        params:
                            {
                                page: this.page
                            }
                    }
                ).then((response) => {
                    //  this.anketList.push(response.data);
                    let data = response.data;
                    let temp = data.ankets;
                    for (let i = 0; i < temp.length; i++) {
                        this.anketList.push(temp[i]);
                    }
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
</style>