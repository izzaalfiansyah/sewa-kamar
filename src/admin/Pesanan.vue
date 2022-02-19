<template>
    <div class="card">
        <h3 class="text-2xl">Data Pesanan</h3>
        <hr class="mt-3 mb-3">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/5">
                <select v-model="length" class="form-control" v-on:change="show">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="w-full md:w-2/5"></div>
            <div class="w-full md:w-2/5">
                <input type="text" class="form-control" placeholder="Cari" v-model="search" v-on:keyup="show">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>Kamar</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Akhir</th>
                        <th>Total Bayar</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in pesanan">
                        <td>{{parseInt(i) + 1}}</td>
                        <td><a v-bind:href="'tel:' + item.nomor_telepon" class="text-blue-400 hover:text-blue-600">{{item.nama}}</a></td>
                        <td>{{item.kamar.nama}}</td>
                        <td>{{item.tanggal_mulai}}</td>
                        <td>{{item.tanggal_akhir}}</td>
                        <td>Rp.{{parseInt(item.bayar).toLocaleString('id-ID')}}</td>
                        <td class="text-center">
                            <div v-if="item.status == '1'">
                                <a href="javascript:void(0);" class="btn-green m-1" v-on:click="edit(item)">
                                    Perpanjang
                                </a>
                                <a href="javascript:void(0);" class="btn-blue m-1" v-on:click="checkout(item)">
                                    <i class="fa fa-check"></i>
                                </a>
                            </div>
                            <div v-else>
                                <a class="bg-yellow-500 p-2 text-white px-3" disabled="true">Selesai</a>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="pesanan.length <= 0">
                        <td colspan="7" align="center">empty pesanan data</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            Menampilkan {{jumlah}} dari {{total}} data pesanan
        </div>
        <div class="mt-3">
            <a href="javascript:void(0)" v-for="i in totalPage" v-bind:class="(i == pageNow ? 'btn-blue' : 'btn-green') + ' m-1'" v-on:click="() => {start = (i * length) - length; show()}">{{i}}</a>
        </div>
        <div v-if="modalPerpanjang">
            <div class="modal p-3">
                <form class="w-full md:w-1/3 card" v-on:submit.prevent="change">
                    <h3 class="text-2xl">Perpanjang Sewa Kamar</h3>
                    <hr class="mt-3 mb-3">
                    <input type="date" class="form-control" v-model="tanggal_mulai" disabled="true">
                    <input type="date" class="form-control" v-model="tanggal_akhir" v-on:change="cekTotal">
                    <input type="text" class="form-control" v-model="bayar" disabled="true">
                    <div class="text-right">
                        <button type="button" v-on:click="modalPerpanjang = false" class="btn-red">Batal</button>
                        <button type="submit" class="btn-blue">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import Swal from 'sweetalert2';
    import {notif} from '../main.js';

    export default {
        name: 'Pesanan',
        data() {
            return {
                pesanan: [],
                search: '',
                length: 10,
                start: 0,
                totalPage: 0,
                pageNow: 0,
                jumlah: 0,
                total: 0,
                modalPerpanjang: false,
                id: '',
                nama: '',
                nomor_telepon: '',
                kamar_id: '',
                tanggal_mulai: '',
                tanggal_akhir: '',
                bayar: '',
                status: '',
                kamar_harga: 0
            }
        },
        created() {
            this.show();
            document.title = 'Pesanan';
        },
        methods: {
            destroy() {
                this.id = '';
                this.nama = '';
                this.nomor_telepon = '';
                this.kamar_id = '';
                this.tanggal_mulai = '';
                this.tanggal_akhir = '';
                this.bayar = '';
                this.status = '';
            },
            show() {
                this.destroy();
                Axios.get(base_url + 'api/pesanan?length=' + this.length + '&start=' + this.start + '&search=' + this.search).then(result => {
                    const res = result.data;
                    this.pesanan = res.data;
                    this.totalPage = res.pagesTotal;
                    this.pageNow = res.pageNow;
                    this.jumlah = res.data.length;
                    this.total = res.recordsTotal;
                })
            },
            checkout(pesanan) {
                Swal.fire({
                    title: 'Checkout',
                    text: 'anda yakin konfirmasi checkout kamar?',
                    icon: 'question',
                    showCancelButton: true
                }).then(swal => {
                    if (swal.isConfirmed) {
                        Axios.put(base_url + 'api/pesanan/' + pesanan.id, {
                            nama: pesanan.nama,
                            nomor_telepon: pesanan.nomor_telepon,
                            kamar_id: pesanan.kamar_id,
                            tanggal_mulai: pesanan.tanggal_mulai,
                            tanggal_akhir: pesanan.tanggal_akhir,
                            status: '2'
                        }).then(result => {
                            const res = result.data;
                            if (res.error) {
                                notif(res.message, 'warning', true);
                            } else {
                                notif(res.message, 'success');
                                this.show();
                            }
                        });
                    }
                })
            },
            edit(item) {
                this.modalPerpanjang = true;
                this.id = item.id;
                this.nama = item.nama;
                this.nomor_telepon = item.nomor_telepon;
                this.kamar_id = item.kamar_id;
                this.tanggal_mulai = item.tanggal_mulai;
                this.tanggal_akhir = item.tanggal_akhir;
                this.bayar = 'Rp.' + parseInt(item.bayar).toLocaleString('id-ID');
                this.kamar_harga = item.kamar.harga;
            },
            cekTotal() {
                let total = 0;
                if (this.tanggal_akhir) {
                    const tanggal_mulai = new Date(this.tanggal_mulai);
                    const tanggal_akhir = new Date(this.tanggal_akhir);
                    total = (Date.parse(tanggal_akhir) - Date.parse(tanggal_mulai)) / (3600 * 24 * 1000);
                    total = total * this.kamar_harga;
                }
                this.bayar = 'Rp.' + total.toLocaleString('id-ID');
            },
            change() {
                Axios.put(base_url + 'api/pesanan/' + this.id, {
                    nama: this.nama,
                    nomor_telepon: this.nomor_telepon,
                    kamar_id: this.kamar_id,
                    tanggal_mulai: this.tanggal_mulai,
                    tanggal_akhir: this.tanggal_akhir,
                    status: '1'
                }).then(result => {
                    const res = result.data;
                    if (res.error) {
                        notif(res.message, 'warning', true);
                    } else {
                        this.modalPerpanjang = false;
                        notif(res.message, 'success');
                        this.show();
                    }
                });
            }
        }
    }
</script>