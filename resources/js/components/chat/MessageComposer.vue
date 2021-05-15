<template>
    <div class="composer">
      <div class="input-group">
        <textarea v-model="message" @keydown.enter="send" placeholder="Введите сообщение!"></textarea>
          <div class="asdf">
              <button type="button" class="btn btn-primary pull-right" @click="send"><i class="fa fa-paper-plane"></i></button>
          </div>
      </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: ''
            };
        },
        methods: {
            send(e) {
                e.preventDefault();

                if (this.message == '') {
                    return;
                }
                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
    .composer textarea {
        width: 100%;
        resize: none;
        border-radius: 3px;
        border: 1px solid lightgray;
        padding: 6px;
    }
    .asdf {
        margin-left:auto;
        margin-right:0;
    }

</style>
