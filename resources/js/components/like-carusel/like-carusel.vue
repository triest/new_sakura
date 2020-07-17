<template>
    <div class="panel panel-default panel-body">

        <div v-if="item!=null" class="col-lg-6 col-md-6 col-sm-6 col-xs-5 box-shadow">
            <div>
                <div style="width: 500px;  margin-left: auto;  margin-right: auto;  left: 50%;top: 50%;">

                    <a :href="/anket/+item.id">
                        <img :src="item.profile_url" height="500px" width="350px">
                    </a>

                </div>
                <button class="btn-primary" v-on:click="like()"
                        style="position: absolute; margin-top: -130px; margin-left: 50px" title="Нравитья">
                    ✓
                </button>
                <button class="btn-secondary" v-on:click="skip()"
                        style="position: absolute; margin-top: -130px; margin-left: 150px" title="Нейтрально">
                    N
                </button>
                <button class="btn-danger" v-on:click="dislike()"
                        style="position: absolute; margin-top: -130px;  margin-left: 250px" title="Не нравиться">×
                </button>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9 box-shadow">
                <div class="cell">
                    <div class="cell-overflow">
                        <b> {{item.name}},1 {{item.age}}</b>
                        <p v-if="city!=null">
                            <small>{{city.name}}</small>
                        </p>
                        <p v-if="online=='null'"> {{item.last_login}}
                        <p v-else>
                            {{lastLogin}}
                        </p>
                        <div v-if="targets.length">
                            <b>Цель знакомства</b>
                            <div v-for="item in targets">
                                {{item.name}},
                            </div>
                        </div>
                        <div v-if="interets.length">
                            <b>Интересы</b>
                            <div v-for="item in interets">
                                {{item.name}},
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            Нет анкет. Вы поставили лайки всем подходящим пользователям в городе. Попробуйте изменить настройки поиска
        </div>
    </div>
</template>

<script>
    export default {
        name: "kikeCarusel",
        mounted() {
            this.getAnket();
        },
        data() {
            return {
                mainImage: null,
                girl_id: null,
                anketList: [],
                item: null,
                online: null,
                city: null,
                targets: [],
                interets: [],
                lastLogin: null,
            }
        },
        methods:
            {
                getAnket() {
                    axios.get('like-carusel/getAnket')
                        .then((response) => {
                            this.item = response.data.ankets;
                            this.online = response.data.online;
                            this.city = response.data.city;
                            this.targets = response.data.targets;
                            this.interets = response.data.interets;
                            this.interets = response.data.interets;
                            this.lastLogin = response.data.lastLogin
                        });
                },
                like() {
                    console.log("like");
                    axios.get('like-carusel/newLike', {
                        params: {
                            user_id: this.item.id,
                            action: "like",
                        }
                    })
                        .then((response) => {
                            this.getAnket();
                        });
                },
                dislike() {
                    axios.get('like-carusel/newLike', {
                        params: {
                            user_id: this.item.id,
                            action: "dislike",
                        }
                    })
                        .then((response) => {
                            this.getAnket();
                        });
                },
                skip() {
                    axios.get('like-carusel/newlike', {
                        params: {
                            user_id: this.item.id,
                            action: "skip",
                        }
                    })
                        .then((response) => {
                            this.getAnket();
                        });
                },

            }
    }


</script>

<style scoped>
    .btn-primary {
        background-color: #44c767;
        border-radius: 50%;
        border: 1px solid #18ab29;
        display: inline-block;
        cursor: pointer;
        color: #ffffff;
        font-family: Arial;
        font-size: 22px;
        padding: 16px 18px;
        text-decoration: none;
        text-shadow: 0px 1px 0px #2f6627;

    }

    .btn-primary:hover {
        background-color: #5cbf2a;
    }

    .btn-primary:active {
        position: relative;
        top: 1px;
    }

    .btn-secondary {
        background-color: #2a38c7;
        border-radius: 50%;
        border: 1px solid #0300af;
        display: inline-block;
        cursor: pointer;
        color: #ffffff;
        font-family: Arial;
        font-size: 22px;
        padding: 16px 18px;
        text-decoration: none;
        text-shadow: 0px 1px 0px #2a38c7;
    }

    .btn-secondary:hover {
        background-color: #110aaf;
    }

    .btn-secondary:active {
        position: relative;
        top: 1px;
    }

    .btn-danger {
        background-color: #ee001e;
        border-radius: 50%;
        border: 1px solid #ee001e;
        display: inline-block;
        cursor: pointer;
        color: #ffffff;
        font-family: Arial;
        font-size: 22px;
        padding: 16px 18px;
        text-decoration: none;
        text-shadow: 0px 1px 0px #2f6627;
    }

    .btn-danger:hover {
        background-color: #b30011;
    }

    .btn-danger:active {
        position: relative;
        top: 1px;
    }

</style>