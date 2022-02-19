<template>
    <div>
        <div class="text-center md:ml-5 md:mr-5 p-5">
            <div class="flex flex-col md:flex-row justify-end">
                <div class="w-full md:w-1/3">
                    <input type="text" class="form-control" v-model="search_kamar" placeholder="Cari Kamar" v-on:keyup="showKamar">
                </div>
            </div>
            <div class="flex flex-col md:flex-row">
                <div v-for="item in kamar" class="md:w-1/5 w-full m-2">
                    <div class="card hover:shadow-lg bg-gray-100">
                        <img v-bind:src="base_url + 'cdn/kamar/' + (item.foto ? item.foto : 'default.png')" style="width: 100%;">
                        <div class="p-3">
                            <h3 class="text-xl">{{item.nama}}</h3>
                            <span class="mt-3 text-red-400">Rp. {{ parseInt(item.harga).toLocaleString('id-ID') }}</span>
                        </div>
                        <router-link class="btn-blue w-full" tag="button" :to="'/kamar/' + item.id">Lihat</router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-5 mt-5 bg-white text-center">
            <h3 class="text-2xl">Galeri Kami</h3>
            <br class="mt-3 mb-3">
            <div class="flex col md:flex-row justify-center">
                <div v-for="item in galeri" class="w-1/2 md:w-1/4 p-1">
                    <img v-bind:src="base_url + 'cdn/galeri/' + item.foto" style="width: 100%; height: 250px; object-fit: cover;">
                </div>
            </div>
        </div>
        <div class="md:ml-5 md:mr-5 mt-5 p-5 text-center">
        </div>
        <div class="mt-5 text-center md:p-5">
            <form class="md:ml-5 md:mr-5 bg-white p-5" v-on:submit.prevent="addUlasan">
                <h3 class="text-2xl">Komentar</h3>
                <hr class="mt-3 mb-3">
                <input type="email" placeholder="Email Anda" class="form-control" v-model="ulasan.email">
                <textarea rows="7" class="form-control" style="resize: none;" placeholder="Masukkan Komentar/Ulasan" v-model="ulasan.teks"></textarea>
                <button class="btn-blue w-full" type="submit">
                    <i class="fa fa-paper-plane"></i>
                    Kirim
                </button>
            </form>
        </div>
        <div class="p-5 text-right">
            Email: <a href="mailto:iansyah724@gmail.com">iansyah724@gmail.com</a><br> 
            Telp: <a href="tel:082330538264">+62 82330538264</a>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {notif} from '../main.js';

    export default {
        name: 'Index',
        data() {
            return {
                kamar: [],
                galeri: [],
                base_url: base_url,
                search_kamar: '',
                ulasan: {
                    email: '',
                    teks: ''
                }
            }
        },
        created() {
            this.showKamar();
            this.showGaleri();
            document.title = 'Home';
        },
        methods: {
            showKamar() {
                Axios.get(base_url + 'api/kamar?search=' + this.search_kamar).then(result => {
                    this.kamar = result.data;
                })
            },
            showGaleri() {
                Axios.get(base_url + 'api/galeri').then(result => {
                    this.galeri = result.data;
                })
            },
            addUlasan() {
                Axios.post(base_url + 'api/ulasan', {
                    email: this.ulasan.email,
                    teks: this.ulasan.teks
                }).then(result => {
                    const res = result.data;
                    if (res.error) {
                        notif(res.message, 'warning', true);
                    } else {
                        notif(res.message, 'success');
                        this.ulasan.teks = '';
                        this.ulasan.email = '';
                    }
                });
            }
        }
    }
</script>