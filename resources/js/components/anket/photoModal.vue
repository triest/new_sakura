<template>
  <div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Recipient:</label>
              <input type="text" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Message:</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Send message</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>


export default {
    props: {
        photo: {
            type: Object,
            required: false
        },
        photos: {
            type: Array,
            required: false,
            default: null
        }
    },
    name: 'modal',
    mounted() {
    //    this.checkScroll()

    },
    computed: {
        number: function () {
            let index = this.arrayKeySearch(this.photos, this.photo.id);
            return index + 1;
        }
    },
    data() {
        return {
            MessageText: "",
            message: "",
            showPhotoModal: false,
            scrollNext: false,
            scrollPrevision: false,
            index: null
        }
    },
    methods: {
      show() {
        //$(this.$el).modal();
      },
    },
};
</script>

<style scoped>

.modal-container {
    width: auto;
    height: auto;
    overflow-x: hidden;
    overflow-y: hidden;
    /*height:300px;*/
    /*      margin: 0px auto;
          padding: 20px 30px;
          background-color: #fff;
          border-radius: 2px;
          box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
          transition: all .3s ease;
          font-family: Helvetica, Arial, sans-serif;
          overflow: hidden*/
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.album-image {
    width: auto;
    height: auto;
    max-height: 80ch;
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

.album-image {
    width: 80ch;
}

/*
    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
*/

.newMessageModal {
    position: fixed;
    bottom: 0;
    right: 0;
}

.modal-container {
    bottom: 0;
    left: 0;
    height: 80%;
    width: 80%;
    margin: auto;
    position: absolute;
    right: 0;
    text-align: center;
    top: 0;
}

.avatar {
    height: 30%;
}

.container img {
    max-width: 100%;
}

.close_modal_button {
    position: relative;
    right: -60%;
}

</style>
