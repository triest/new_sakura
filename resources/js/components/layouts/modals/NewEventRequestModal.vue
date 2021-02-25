<template>
  <div class="modal fade" id="eventRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Подарки</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <label for="text"></label>
          <textarea name="text" id="text" v-model="text" placeholder="Текст сообщения"></textarea>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: {

        },
      name: 'presentModal',
        mounted() {
            this.getPresents();
        },
        data() {
            return {
                presents: [],
                currentAnket: '',
                userMoney: '',
                showModal: true,
                text:'',
            }
        },
        methods: {
            close() {

                this.$emit('closeRequest')
            },
            getPresents() {
                axios.get('/api/presents/',
                ).then((response) => {
                    //  this.anketList.push(response.data);
                    let data = response.data;
                    let temp = data.presents;
                    for (let i = 0; i < temp.length; i++) {
                        this.presents.push(temp[i]);
                    }
                })
            },
            makePresent(present_id) {


                let formData = new FormData();
                formData.append('present_id', present_id);
                formData.append('user_id', this.user.id);
                formData.append('text', this.text);
                axios.post('/api/presents/make', formData
                ).then((response) => {
                      console.log(response.data.result);
                  Alert("Подарок подарен")
                    }
                ).catch(function () {
                    Alert("Ошибка! Попробуйте еще раз или обратитесь к администрации")
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
</style>
