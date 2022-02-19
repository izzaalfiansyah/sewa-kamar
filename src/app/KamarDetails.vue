<template>
    <div class="p-5 md:ml-5 md:mr-5">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/3 w-full p-2">
                <div class="card">
                    <img v-bind:src="base_url + 'cdn/kamar/' + (kamar.foto ? kamar.foto : 'default.png')" style="width: 100%;">
                </div>
            </div>
            <div class="md:w-2/3 w-full p-2">
                <form v-on:submit.prevent="add" class="card">
                    <h3 class="text-2xl">Detail Kamar</h3>
                    <hr class="mt-3 mb-3">
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/2 p-2">
                            Nama: 
                            <h3 class="text-3xl">{{kamar.nama}}</h3>
                            <hr class="mb-3">
                            Tipe: 
                            <h3 class="text-3xl">{{kamar.tipe.nama}}</h3>
                            <hr class="mb-3">
                        </div>
                        <div class="w-full md:w-1/2 p-2">
                            Harga: 
                            <h3 class="text-3xl">{{parseInt(kamar.harga).toLocaleString('id-ID')}}</h3>
                            <hr class="mb-3">
                            Status: 
                            <h3 class="text-3xl">{{kamar.status == '1' ? 'Tersedia' : 'Kosong'}}</h3>
                            <hr class="mb-3">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/2 p-2">
                            Tanggal Mulai:
                            <input type="date" class="form-control" v-model="tanggal_mulai" v-on:change="cekTotal">
                            Tanggal Akhir:
                            <input type="date" class="form-control" v-model="tanggal_akhir" v-on:change="cekTotal">
                        </div>
                        <div class="w-full md:w-1/2 p-2">
                            Nama:
                            <input type="text" class="form-control" placeholder="Nama" v-model="nama">
                            Nomor Telepon:
                            <input type="text" class="form-control" placeholder="Nomor Telepon" v-model="nomor_telepon">
                            Total:
                            <input type="text" class="form-control" placeholder="Total Harga" disabled="true" v-model="total">
                        </div>
                    </div>
                    <hr class="mt-3 mb-3">
                    <div class="text-right">
                        <router-link tag="button" type="button" class="btn-red" to="/">Batal</router-link>
                        <button class="btn-blue" type="submit">Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {notif} from '../main.js';

    export default {
        name: 'KamarDetails',
        data() {
            return {
                kamar: {
                    tipe: {}
                },
                base_url: base_url,
                nama: '',
                nomor_telepon: '',
                tanggal_mulai: '',
                tanggal_akhir: '',
                total: 'Rp.0'
            }
        },
        created() {
            this.showKamar();
        },
        methods: {
            showKamar() {
                Axios.get(base_url + 'api/kamar/' + this.$route.params.id).then(result => {
                    this.kamar = result.data;
                });
            },
            cekTotal() {
                let total = 0;
                if (this.tanggal_mulai && this.tanggal_akhir) {
                    const tanggal_mulai = new Date(this.tanggal_mulai);
                    const tanggal_akhir = new Date(this.tanggal_akhir);
                    let hari = (Date.parse(tanggal_akhir) - Date.parse(tanggal_mulai)) / (24 * 3600 * 1000);
                    console.log(hari);
                    total = parseInt(this.kamar.harga) * hari;
                }
                this.total = 'Rp.' + total.toLocaleString('id-ID');
            },
            add() {
                Axios.post(base_url + 'api/pesanan', {
                    nama: this.nama,
                    kamar_id: this.$route.params.id,
                    nomor_telepon: this.nomor_telepon,
                    tanggal_mulai: this.tanggal_mulai,
                    tanggal_akhir: this.tanggal_akhir
                }).then(result => {
                    const res = result.data;
                    if (res.error) {
                        notif(res.message, 'warning', true);
                    } else {
                        notif(res.message, 'success');
                        this.$route.push('/pesanan/' + res.data_id);
                    }
                })
            }
        }
    }
</script>