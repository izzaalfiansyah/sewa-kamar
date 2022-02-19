<template>
    <form v-on:submit.prevent="add" class="card">
        <h3 class="text-2xl">Tambah User</h3>
        <hr class="mt-3 mb-3">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2 p-2">
                Username: 
                <input type="text" class="form-control" placeholder="Username" v-model="username">
                Nama:
                <input type="text" class="form-control" placeholder="Nama" v-model="nama">
                Email:
                <input type="email" class="form-control" placeholder="Email" v-model="email">
                Nomor Telepon:
                <input type="text" class="form-control" placeholder="Nomor Telepon" v-model="nomor_telepon">
            </div>
            <div class="w-full md:w-1/2 p-2">
                Level:
                <select v-model="level" class="form-control">
                    <option value="">- Pilih Level -</option>
                    <option value="1">Admin</option>
                    <option value="2">Petugas</option>
                </select>
                Password:
                <input type="password" class="form-control" placeholder="Password" v-model="password">
                Password (Konfirmasi):
                <input type="password" class="form-control" placeholder="Password (Konfirmasi)" v-model="password_confirm">
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
        name: 'UserAdd',
        data() {
            return {
                username: '',
                password: '',
                password_confirm: '',
                nama: '',
                email: '',
                nomor_telepon: '',
                level: ''
            }
        },
        methods: {
            add() {
                if (this.password == this.password_confirm) {
                    Axios.post(base_url + 'api/user', {
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
                            this.$router.push('/admin/user/' + res.data_id);
                        }
                    })   
                } else {
                    notif('password confirm must same with password', 'warning', true);
                }
            }
        }
    }
</script>