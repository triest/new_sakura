<template>
    <div>
        <div style="margin-left: auto;   margin-right: auto">
            wq
            <button class="btn btn-primary" v-on:click="openPresentModal()">Создать подарок</button>
            <div v-for="item in presents_list">
                <!--ipad в горизонтальном виде md  -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-9 box-shadow">
                    <a :href="/anket/+item.id">
                        <img width="200" height="200" :src="'/upload/presents/'+item.image">
                    </a>
                    <div class="cell">
                        <div class="cell-overflow">
                            {{item.name}},
                        </div>
                        {{item.age}}
                    </div>
                </div>
            </div>
            <div class="notfound" v-if="!presents_list.length">
                Подарков не найдено.
            </div>
            <br>
            <present-modal v-if="showPresentModal" @closePresentModal="closePresentModal()"
                           @closeNewMessageAlert="closeNewMessageAlert()"></present-modal>
        </div>
    </div>
</template>

<script>
    import PresentModal from './PresentModal'

    export default {

        mounted() {
            this.getPresentsList()
        },
        data() {
            return {
                presents_list: [],
                showPresentModal: false,
            }
        },
        components: {PresentModal},

        methods: {
            getPresentsList() {
                axios.get('/admin/presents/list',
                    {
                        params:
                            {
                                page: this.page
                            }
                    }
                ).then((response) => {
                    //  this.anketList.push(response.data);
                    let data = response.data;
                    let temp = data.presents;
                    for (let i = 0; i < temp.length; i++) {
                        this.presents_list.push(temp[i]);
                    }
                })
            },
            openPresentModal() {
                this.showPresentModal = true;
            },
            closePresentModal() {
                this.showPresentModal = false;
            }

        }
    }
</script>

<style scoped>

</style>