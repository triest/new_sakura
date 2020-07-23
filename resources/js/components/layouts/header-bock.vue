<template>
    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <a class="text-muted" href="#">Subscribe</a>
                </div>
                <div class="col-4 text-center">
                    <a class="blog-header-logo text-dark" href="#">Large</a>
                </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <div class="multi-language">
                        <a class="multi-language-current" href="#"> <img height="60px"
                                                                         :src="user.profile_url"></a>
                        <ul class="multi-language-sub">
                            <li><a href="/lk/profile"><img src="/home/img/flags_ru.png">Настройки</a></li>
                            <li><a v-on:click="logout()" href="#"><img src="/home/img/flags_ru.png"> Выйти</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

        </header>

    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return {

                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            };
        },
        mounted() {
            console.log("headder2")
            console.log(this.user)
        },
        methods: {
            logout() {
                axios.post('logout').then(response => {
                    if (response.status === 302 || 401) {
                        console.log('logout')
                        location.reload();
                        document.location.reload();
                    }
                    else {
                        document.location.reload();
                        location.reload();
                    }
                }).catch(error => {
                    document.location.reload();
                    location.reload();
                });
            }
        }
    }
</script>

<style scoped>

</style>