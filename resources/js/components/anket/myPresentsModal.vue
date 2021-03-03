<template>
    <transition name="modal" @close="showModal = false">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            <b>Подарки</b>
                        </slot>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" v-on:click="close()">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <div v-for="present in gifts">
                                <table>
                                    <tr>
                                        <td style="vertical-align:middle;"><img width="200" height="200"
                                                                                :src="'/upload/presents/'+present.image" :title="present.name">
                                        </td>
                                        <td style="vertical-align:middle;" width="100">
                                            <table>
                                                <tr>
                                                    <td> {{present.user_name}} <a :href="present.id"><img class="avatar_image" :src="present.user_avatar_url"/></a>
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </slot>
                    </div>
                    <slot name="footer">
                        <a v-on:click="close()" style="cursor: pointer">
                            Закрыть
                        </a>
                    </slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {

            gifts: {
                type: Array,
                required: false,
                default: []
            },
            user: {
                type: Object,
                required: false,
                default: null
            }

        },
        mounted() {
            // this.getPresentsList();
            //  console.log(this.user);
        //    console.log(this.gifts);
           // this.getPresents();
        },
        data() {
            return {
                presents: [],
                currentAnket: '',
                userMoney: '',
                showModal: true
            }
        },
        methods: {
            close() {
                this.$emit('closeRequest')
            },

            getPresents() {
                axios.get('/presents/get-anket-presents', {params: {user_id: this.user.id}}
                ).then((response) => {
                    //  this.anketList.push(response.data);
                    let data = response.data;
                    let temp = data.presents;
                    if (typeof myVar !== 'undefined') {
                        for (let i = 0; i < temp.length; i++) {
                            this.presents.push(temp[i]);
                        }
                    }
                })
            },
            makePresent(present_id) {
                let formData = new FormData();
                formData.append('present_id', present_id);
                formData.append('user_id', this.user.id);
                axios.post('/presents/make', formData
                ).then(function () {

                }).catch(function () {
                    // Alert("Ошибка! Попробуйте еще раз или обратитесь к администрации")
                    console.log("error");
                })
                this.close();

            }

        }
    }
</script>

<style scoped>
    textarea {
        width: 90%; /* Ширина поля в процентах */
        height: 200px; /* Высота поля в пикселах */
        resize: none; /* Запрещаем изменять размер */
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 600px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .avatar_image {
        display: flex;
        width: 60px;
        height: 60px;
        overflow: hidden;
        align-items: center;
        border-radius: 50%;
        border: 1px solid #329BF0;
        position: relative;

    }

    .avatar_image {
        border-radius: 50% !important;
    }

    .avatar_image:hover {
        cursor: pointer;
    }


</style>
