<template>
    <div class="h-screen bg-gray-100">
        <div class="w-full p-4 text-white bg-gradient-to-r from-blue-400 to-blue-300 shadow-lg md:text-left text-center sticky">
            <router-link class="text-xl" to="/">SEWA KAMAR</router-link>
            <router-link :to="{path: '/auth'}" class="float-right">
                <i class="fa fa-lock"></i>
            </router-link>
        </div>
        <div class="bg-gray-100">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import {notif} from '../main.js';

    export default {
        name: 'Home',
        data() {
            return {
                kamar: []
            }
        },
        created() {
            if (localStorage.getItem('id')) {
                this.$router.push('/admin');
            }
        }
    }
</script>