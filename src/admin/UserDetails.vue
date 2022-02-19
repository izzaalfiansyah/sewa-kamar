<template>
    <form v-on:submit.prevent="update" class="card">
        <h3 class="text-2xl">Edit User</h3>
        <hr class="mt-3 mb-3">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2 p-2">
                Username: 
                <input type="text" class="form-control" placeholder="Username" v-model="username">
                Nama:
                <input type="text" class="form-control" placeholder="Nama" v-model="nama">
            </div>
            <div class="w-full md:w-1/2 p-2">
                Email:
                <input type="email" class="form-control" placeholder="Email" v-model="email">
                Nomor Telepon:
                <input type="text" class="form-control" placeholder="Nomor Telepon" v-model="nomor_telepon">
                Level:
                <select v-model="level" class="form-control">
                    <option value="">- Pilih Level -</option>
                    <option value="1">Admin</option>
                    <option value="2">Petugas</option>
                </select>
            </div>
        </div>
        <hr class="mt-3 mb-3">
        <div class="text-right">
            <router-link tag="button" type="button" to="/admin/user" class="btn-red">Kembali</router-link>
            <button type="submit" class="btn-blue">Simpan</button>
        </div>
    </form>
</template>

<script>
    import Axios from 'axios';
    import {notif} from '../main.js';

    export default {
        name: 'UserDetails',
        data() {
            return {
                username: '',
                nama: '',
                email: '',
                nomor_telepon: '',
                level: ''
            }
        },
        created() {
            this.show();
        },
        methods: {
            show() {
                Axios.get(base_url + 'api/user/' + this.$route.params.id).then(result => {
                    this.username = result.data.username;
                    this.nama = result.data.nama;
                    this.email = result.data.email;
                    this.nomor_telepon = result.data.nomor_telepon;
                    this.level = result.data.level;
                })
            },
            update() {
                if (this.password == this.password_confirm) {
                    Axios.put(base_url + 'api/user/' + this.$route.params.id, {
                        username: this.username,
                        password: this.password,
                        nama: this.nama,
                        email: this.email,
                        nomor_telepon: this.nomor_telepon,
                        level: this.level
                    }).then(result => {
                        const res = result.data;
                        if (res.error) {
                            notif(res.message, 'warning', true);
                        } else {
                            notif(res.message, 'success');
                            this.show();
                        }
                    })   
                } else {
                    notif('password confirm must same with password', 'warning', true);
                }
            }
        }
    }
</script>