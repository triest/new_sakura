<template>
  <transition name="modal" @close="showModal = false">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              <b>Новая заявка на событие {{ eventRequest.event.name }}!</b>
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              {{ eventRequest.user.name }}
              <a target="_blank" :href="/anket/+eventRequest.user.id">
                <img width="250" height="250" :src="eventRequest.user.photo_profile_url">
                <div class="cell">
                  <div class="cell-overflow">
                    {{ eventRequest.user.name }}, {{ eventRequest.user.age }}
                  </div>
                </div>
              </a>
              <a class="btn btn-primary" @click="accept(eventRequest.id)">
                Принять
              </a>
              <a class="btn btn-danger" @click="reject(eventRequest.id)">
                Отклонить
              </a>

            </slot>
          </div>
          <slot name="footer">
            <a v-on:click="close()">
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
    eventRequest: {
      type: Object,
      required: true,
      default: null
    }

  },
  mounted() {
    console.log(this.eventRequest);
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

    accept(req_id) {
      axios.get('/api/events/accept', {
            params: {
              action: 'accept',
              req_id: req_id,
            }
          }
      )
          .then((response) => {
            this.$emit('closeRequest')
          });
    },
    reject(req_id) {

      axios.get('/api/events/denied', {
            params: {
              action: 'denied',
              req_id: req_id,
            }
          }
      )
          .then((response) => {
            this.$emit('closeRequest')
          });

    },

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
