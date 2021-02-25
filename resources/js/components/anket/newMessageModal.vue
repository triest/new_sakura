<template>
  <div  class="modal fade"    id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="staticBackdropLabel">    <img :src="'/'+user.photo_profile_url" height="30px" width="30px">
            {{user.name}},{{user.age}}</div>
          <button type="button" id="close" class="close"  data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <textarea v-model="MessageText" placeholder="Введите сообщение!"></textarea>
        </div>
        <div class="modal-footer">
          <a class="btn btn-primary" v-on:click="send()">Отправить</a>
          <a class="btn btn-secondary" data-dismiss="modal">Закрыть</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user:{
      type: Object,
      required: false
    }
  },
  name: 'modal',
  mounted() {
    //console.log(this.id);
  },
  data() {
    return {
      MessageText: "",
      message: "",
      modalShow: true
    }
  },
  methods: {
    findUserByid() {

    },
    send() {
      console.log("send")
      axios.post('/api/contact/conversation/sendModal', {
        contact_id: this.user.id,
        text: this.MessageText
      }).then((response) => {
        this.MessageText = "";
        document.getElementById('close').click();
    //    $('#staticBackdrop').modal('hide');

      });
    }
  },
};
</script>

