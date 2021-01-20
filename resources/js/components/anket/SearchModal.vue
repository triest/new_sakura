<template>
  <div class="filterSettingsModal">
      <div class="col-lg-3 col-md-4 col-sm-6  justify-content-center col-xs-9 box-shadow">
        <transition name="modal" @close="showModal = false">
          <div class="modal-mask">
            <div class="modal-wrapper">
              <div class="modal-container">
                <div class="modal-body">

                  <div class="form-group row">
                    <label for="meet" class="col-sm-2 col-form-label">Ищу</label>
                    <div class="col-sm-10">
                      <select id="meet" class="form-control" name="meet" v-model="meet">
                        <option value="female">Девушку</option>
                        <option value="male">Парня</option>
                        <option value="nomatter">неважно</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="from" class="col-sm-2 col-form-label">Возраст</label>
                    <div class="col-sm-2">
                      <input type="number" class="form-control" name="from" id="from" min="18"
                             :max="maxAge"
                             v-model="from"
                             onkeypress="return isNumber(event)"
                             style="width: 75px">
                    </div>
                    <div class="col-sm-1">
                      до
                    </div>
                    <div class="col-sm-1">
                      <input type="number" class="form-control" name="to" id="to" :min="minAge"
                             :max="100"
                             v-model="to"
                             onkeypress="return isNumber(event)" style="width: 75px">
                    </div>
                  </div>
                  <fieldset class="form-group">
                    <div class="row">
                      <label class="col-sm-2 pt-0">Цели</label>
                      <div class="col-sm-10">

                        <div class="form-check" v-for="item in targets">
                          <input class="form-check-input" type="checkbox" :id="item.id"
                                 :value="item.id"
                                 v-model="select2targets">
                          {{ item.name }}
                        </div>
                      </div>
                    </div>
                  </fieldset>
                  <fieldset class="form-group">
                    <div class="row">
                      <label class="col-sm-2 pt-0">Интересы</label>
                      <div class="col-sm-10">

                        <div class="form-check" v-for="item in interest">
                          <input class="form-check-input" type="checkbox" name="gridRadios"
                                 :id="item.id" :value="item.id" v-model="select2inters">
                          {{ item.name }}
                        </div>
                      </div>
                    </div>
                  </fieldset>
                  <fieldset class="form-group">
                    <div class="row">
                      <label class="col-sm-2 pt-0">Дети</label>
                      <div class="col-sm-10">

                        <div class="form-check" v-for="item in children">
                          <input class="form-check-input" type="radio" name="gridRadios"
                                 id="gridRadios1" :value="item.id" v-model="select2children"
                                 checked>
                            {{ item.name }}
                        </div>
                      </div>
                    </div>
                  </fieldset>

                  <fieldset class="form-group">
                    <div class="row">
                      <label class="col-sm-2 pt-0">Отношения</label>
                      <div class="col-sm-10">

                        <div class="form-check" v-for="item in relation">
                          <input class="form-check-input" type="radio" name="gridRadios2"
                                 id="gridRadios2" :value="item.id" v-model="select2relation"
                                 checked>
                            {{ item.name }}
                        </div>
                      </div>
                    </div>
                  </fieldset>
                  <button class="btn btn-primary" v-on:click="saveChange()">
                    Сохранить
                  </button>
                  <button class="btn btn-secondary" v-on:click="close()">
                    Закрыть
                  </button>

                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
  </div>
</template>

<script>
export default {
  props: {},
  name: 'modal',
  mounted() {
    this.getSettings();
  },
  /* считаем выделенные*/
  computed: {
    countSelectedTargets: function () {
      return this.select2targets.length
    },
    countSelectedInteres: function () {
      return this.select2inters.length
    },
    countSelectedChildren: function () {
      if (this.select2children != null) {
        return true;
      } else {
        return false;
      }
    },
    countSelectedRelation: function () {

    },
    // вычисляем макс
    minAge: function () {
      return this.from
    },
    maxAge: function () {
      return this.to
    }
  },
  data() {
    return {
      seach: "",
      from: "18",
      to: "18",
      targets: "",
      interest: " ",
      relation: "",
      meet: "",
      children: [],
      select2targets: [],
      select2inters: [],
      select2children: null,
      select2relation: [],
      searchSettings: null,
      targets_show: true,
      interes_show: true,
      children_show: false,
      relation_show: false,
    }
  },
  methods: {
    close() {
      this.$emit('closeSeachModal')
    },
    findUserByid() {

    },
    saveChange() {
      axios.post('/seach/savesettings', {
        meet: this.meet,
        from: this.from,
        to: this.to,
        interests: this.select2inters,
        children: this.select2children,
        targets: this.select2targets,
        relation: this.select2relation,
      }).then((response) => {
        //this.getSettings();
        this.$emit('closeSeachModal')
      });

    },
    getSettings() {
      axios.get('seach/getsettings')
          .then((response) => {
            let res = response.data.data;

            this.targets = res.targets;
            this.select2targets = res.selectedTargets;
            this.select2inters = res.selectedInterest;
            this.interest = res.interests;
            this.children = res.children;
            this.searchSettings = res.searchSettings;
            this.relation = res.relations;
            this.smoking = res.smoking;
            this.from = this.searchSettings.age_from;
            this.to = this.searchSettings.age_to;
            this.select2children = this.searchSettings.children;
            this.select2relation = this.searchSettings.relation;
            this.meet = this.searchSettings.meet;
          }).then(function () {

      })


    },
    show(input) {

      switch (input) {
        case "target":
          this.targets_show = !this.targets_show;
          break;
        case "interes":
          this.interes_show = !this.interes_show;
          break;
        case "children":
          this.children_show = !this.children_show;
          break;

        case "relations":

          this.relation_show = !this.relation_show;
          break;
      }
    },


  },
};
</script>

<style>
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
  width: calc(100vw - 30px);
  height: calc(100vh - 100px);
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
  max-width: calc(100vh - 50px);
  max-height: calc(100vh - 20px);
  overflow: scroll;
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

.filterSettingsModal {
  position: fixed;
  bottom: 0;
  right: 0;
  z-index: 999;

}

input.apple-switch {
  position: relative;
  appearance: none;
  outline: none;
  width: 50px;
  height: 30px;
  background-color: #ffffff;
  border: 1px solid #D9DADC;
  border-radius: 50px;
  box-shadow: inset -20px 0 0 0 #ffffff;
  transition-duration: 200ms;
}

input.apple-switch:after {
  content: "";
  position: absolute;
  top: 1px;
  left: 1px;
  width: 26px;
  height: 13px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.2);
}

input.apple-switch:checked {
  border-color: #4ED164;
  box-shadow: inset 20px 0 0 0 #4ED164;
}

input.apple-switch:checked:after {
  left: 20px;
  box-shadow: -2px 4px 3px rgba(0, 0, 0, 0.05);
}

.bounce-enter-active {
  animation: bounce-in .5s;
}

.bounce-leave-active {
  animation: bounce-in .5s reverse;
}

@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.5);
  }
  100% {
    transform: scale(1);
  }
}

.v-fade {
  transition: all 4s ease-out;
}


</style>
