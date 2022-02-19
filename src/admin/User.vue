<template>
    <div class="card">
        <div class="flex">
            <div class="flex-1">
                <h3 class="text-2xl">Data User</h3>
            </div>
            <div class="flex-1 text-right">
                <router-link class="btn-blue" to="/admin/user/add">
                    <i class="fa fa-plus"></i>
                    Tambah
                </router-link>
            </div>
        </div>
        <hr class="mt-3 mb-3">
        <div class="flex md:flex-row flex-col justify-end">
            <div class="md:w-1/3 w-full">
                <input type="text" class="form-control" placeholder="Search" v-model="search" v-on:keyup="show">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr class="hover:bg-gray-100">
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in user" class="hover:bg-gray-100">
                        <td>{{ parseInt(i) + 1 }}</td>
                        <td>{{ item.username }}</td>
                        <td>{{ item.nama }}</td>
                        <td>{{ item.level == '1' ? 'Admin' : 'Petugas' }}</td>
                        <td class="text-center">
                            <router-link class="btn-green" :to="'/admin/user/' + item.id">
                                <i class="fa fa-search"></i>
                            </router-link>
                            <a href="javascript:void(0);" class="btn-red" v-on:click="remove(item)">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <tr v-if="user.length <= 0">
                        <td colspan="5" align="center">empty data user</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import Swal from 'sweetalert2';
    import {notif} from '../main.js';

    export default {
        name: 'User',
        data() {
            return {
                user: [],
                search: ''
            }
        },
        created() {
            document.title = 'User';
            this.show();
        },
        methods: {
            show() {
                Axios.get(base_url + 'api/user?search=' + this.search).then(result => {
                    this.user = result.data;
                });
            },
            remove(user) {
                Swal.fire({
                    title: 'Delete user',
                    html: 'Are you sure to delete <strong>' + user.username + '</strong>',
                    icon: 'question',
                    showCancelButton: true
                }).then(swal => {
                    if (swal.isConfirmed) {
                        Axios.delete(base_url + 'api/user/' + user.id).then(result => {
                            const res = result.data;
                            if (res.error) {
                                notif(res.message, 'warning', true);
                            } else {
                                notif(res.message, 'success');
                                this.show();
                            }
                        })
                    }
                })
            }
        }
    }
</script>