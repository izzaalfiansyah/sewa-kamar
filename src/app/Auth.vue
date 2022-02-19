<template>
    <div>
        <div class="flex h-full justify-center items-center">
            <form class="card w-full md:w-1/4" style="margin: 60px auto;" v-on:submit.prevent="login"> 
                <div class="text-center">
                    <h3 class="text-2xl">Login</h3>
                </div>
                <hr class="mt-3 mb-3">
                <input type="text" class="form-control" placeholder="Username" v-model="username">
                <input type="password" class="form-control" placeholder="Password" v-model="password">
                <hr class="mt-3 mb-3">
                <button type="submit" class="btn-blue w-full">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    import {notif} from '../main.js';
    import Axios from 'axios';

    export default {
        name: 'Auth',
        data() {
            return {
                username: '',
                password: ''
            }
        },
        created() {
            document.title = 'Login';
            if (localStorage.getItem('id')) {
                this.$router.push('/admin');
            }
        },
        methods: {
            login() {
                Axios.post(base_url + 'api/login', {
                    username: this.username,
                    password: this.password
                }).then(result => {
                    const res = result.data;
                    if (res.error) {
                        notif(res.message, 'warning', true);
                    } else {
                        notif(res.message, 'success').then(swal => {
                            localStorage.setItem('id', res.data.id);
                            localStorage.setItem('level', res.data.level);
                            this.$router.push('/admin');
                        })
                    }
                })
            }
        }
    }
</script>