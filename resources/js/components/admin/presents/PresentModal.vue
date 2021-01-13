<template>
    <div class="newMessageModal">
        <transition name="modal" @close="showModal = false">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="modal-body">
                            <slot name="body">
                                <p>
                                    <label>Подарок:</label>
                                    <input type="text" id="name" class="name" name="name" v-model="name">
                                </p>
                                <p>
                                    <label>Цена:</label> <input type="number" name="price" id="price" min="1"

                                                                v-model="price"
                                                                onkeypress="return isNumber(event)"
                                                                style="width: 50px">
                                </p>
                                <p>
                                    <label>Включен:</label> <input type="checkbox" name="enable" id="enable" value="" v-model="enable">
                                </p>
                                <p>
                                <div v-if="present!=null">
                                    <img width="200" height="200" :src="'/upload/presents/'+present.image">
                                </div>

                                <label>Изображение:</label><input type="file" name="image" class="file"
                                                                  ref="galerayFileInput"
                                                                  v-on:change="handleFileUploadGaleay()">
                                </p>
                                <br>


                            </slot>
                        </div>
                        <slot name="footer">
                            <button class="btn btn-primary" v-on:click="saveChange()">
                                Сохранить
                            </button>
                            <button class="btn btn-secondary" v-on:click="close()">
                                Закрыть
                            </button>
                        </slot>7
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            present: {
                type: Object,
                required: false,
                default: null,
            }
        },
        name: 'modal',
        mounted() {
            if (this.present != null) {
                console.log(this.present);
                this.name = this.present.name;
                this.price = this.present.price;
                this.enable=this.present.enabled;
            //    this.emit(this.present.enabled)

            }
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
                targets_show: false,
                interes_show: false,
                children_show: false,
                relation_show: false,
                galerayFile: '',
                name: "name",
                price: 100,
                enable:false,
            }
        },
        methods: {
            close() {
                this.$emit('closePresentModal')
            },
            findUserByid() {

            },
            saveChange() {

                let formData = new FormData();
                formData.append('file', this.galerayFile);
                formData.append('name', this.name);
                formData.append('price', this.price);
                formData.append('file', this.galerayFile);
                formData.append('enable', this.enable);
                if (this.present != null) {
                    formData.append('present', this.present.id);
                }
                axios.post('/admin/presents/list/store-present', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((response) => {
                    //this.getSettings();
            //         this.$emit('closePresentModal')
                    this.$emit('closePresentModal')
                });

            },

            handleFileUploadGaleay() {
                this.galerayFile = this.$refs.galerayFileInput.files[0];
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

    .file {
        display: block !important;
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

    .newMessageModal {
        position: fixed;
        bottom: 0;
        right: 0;
        z-index: 999;
        max-width: 100px !important;
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
