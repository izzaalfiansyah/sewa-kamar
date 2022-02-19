<template>
    <div class="card">
        <div class="flex">
            <div class="flex-1">
                <h3 class="text-2xl">Data Kamar</h3>
            </div>
            <div class="flex-1 text-right">
                <button class="btn-blue" v-on:click="modalTambah = true">
                    <i class="fa fa-plus"></i>
                    Tambah
                </button>
            </div>
        </div>
        <hr class="mt-3 mb-3">
        <div class="flex flex-col md:flex-row justify-end">
            <div class="w-full md:w-1/3">
                <input type="text" class="form-control" placeholder="Search" v-model="search" v-on:keyup="show">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in kamar">
                        <td align="center">{{parseInt(i) + 1}}</td>
                        <td align="center">{{item.nama}}</td>
                        <td align="center">Rp. {{parseInt(item.harga).toLocaleString('id-ID')}}</td>
                        <td align="center">
                            <img v-bind:src="base_url + 'cdn/kamar/' + (item.foto ? item.foto : 'default.png')" style="width: 100px; height: 100px; max-width: none;">
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0);" class="btn-green" v-on:click="details(item)">
                                <i class="fa fa-search"></i>
                            </a>
                            <a href="javascript:void(0);" class="btn-red" v-on:click="remove(item)">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <tr v-if="kamar.length <= 0">
                        <td colspan="5" align="center">empty data kamar</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="modalTambah">
            <div class="modal overflow-y-auto p-3">
                <form class="card w-full md:w-1/3" v-on:submit.prevent="add">
                    <h3 class="text-2xl">Tambah Kamar</h3>
                    <hr class="mt-3 mb-3">
                    <input type="text" class="form-control" placeholder="Nama" v-model="nama">
                    <select class="form-control" v-model="tipe_id">
                        <option value="">- Pilih Tipe -</option>
                        <option v-for="item in tipe_kamar" v-bind:value="item.id">{{item.nama}}</option>
                    </select>
                    <input type="number" class="form-control" placeholder="Harga" v-model="harga">
                    <select class="form-control" v-model="status">
                        <option value="">- Pilih Status -</option>
                        <option value="1">Tersedia</option>
                        <option value="2">Kosong</option>
                    </select>
                    <input type="file" accept="image/*" class="form-control" placeholder="Pilih Foto" v-on:change="changeFoto('foto-tambah')" name="foto-tambah">
                    <div class="bg-gray-200 mb-3 p-1" align="center" style="height: 200px;">
                        <img v-bind:src="image_src" class="h-full" id="foto-tambah">
                    </div>
                    <div class="text-right">
                        <button class="btn-red" type="button" v-on:click="modalTambah = false">Batal</button>
                        <button type="submit" class="btn-blue">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="modalEdit">
            <div class="modal overflow-y-auto p-3">
                <form class="card w-full md:w-1/3" v-on:submit.prevent="edit">
                    <h3 class="text-2xl">Edit Kamar</h3>
                    <hr class="mt-3 mb-3">
                    <input type="text" class="form-control" placeholder="Nama" v-model="nama">
                    <select class="form-control" v-model="tipe_id">
                        <option value="">- Pilih Tipe -</option>
                        <option v-for="item in tipe_kamar" v-bind:value="item.id">{{item.nama}}</option>
                    </select>
                    <input type="number" class="form-control" placeholder="Harga" v-model="harga">
                    <select class="form-control" v-model="status">
                        <option value="">- Pilih Status -</option>
                        <option value="1">Tersedia</option>
                        <option value="2">Kosong</option>
                    </select>
                    <input type="file" accept="image/*" class="form-control" placeholder="Pilih Foto" v-on:change="changeFoto('foto-edit')" name="foto-edit">
                    <div class="bg-gray-200 mb-3 p-1" align="center" style="height: 200px;">
                        <img v-bind:src="image_src" class="h-full" id="foto-edit">
                    </div>
                    <div class="text-right">
                        <button class="btn-red" type="button" v-on:click="() => {modalEdit = false; destroy()}">Batal</button>
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
    import {notif, readFile} from '../main.js';

    export default {
        name: 'Kamar',
        data() {
            return {
                kamar: [],
                modalTambah: false,
                modalEdit: false,
                image_src: '',
                id: '',
                nama: '',
                tipe_id: '',
                harga: '',
                status: '',
                cropper: null,
                tipe_kamar: [],
                base_url: base_url,
                search: ''
            }
        },
        created() {
            document.title = 'Kamar';
            this.show();
            this.showTipeKamar();
        },
        methods: {
            destroy() {
                this.id = '';
                this.nama = '';
                this.tipe_id = '';
                this.harga = '';
                this.status = '';
                this.image_src = '';
            },
            show() {
                this.destroy();
                Axios.get(base_url + 'api/kamar?search=' + this.search).then(result => {
                    this.kamar = result.data;
                })
            },
            showTipeKamar() {
                Axios.get(base_url + 'api/tipe-kamar').then(result => {
                    this.tipe_kamar = result.data;
                })
            },
            remove(kamar) {
                Swal.fire({
                    title: 'Delete Kamar',
                    html: 'Are you sure to delete kamar <strong>' + kamar.nama + '</strong>',
                    icon: 'question',
                    showCancelButton: true
                }).then(swal => {
                    if (swal.isConfirmed) {
                        Axios.delete(base_url + 'api/kamar/' + kamar.id).then(result => {
                            const res = result.data;
                            if (res.error) {
                                notif(res.message, 'warning', true);
                            } else {
                                notif(res.message, 'success');
                                this.show();
                            }
                        })
                    }
                });
            },
            changeFoto(selector) {
                readFile('[name=' + selector + ']', (data) => {
                    this.image_src = data;
                });
                setTimeout(() => {
                    const img = document.getElementById(selector.toString());
                    if (this.cropper) {
                        this.cropper.destroy();
                    }
                    this.cropper = new Cropper(img, {
                        aspectRatio: 1
                    });
                }, 400);
            },
            add() {
                Axios.post(base_url + 'api/kamar', {
                    nama: this.nama,
                    tipe_id: this.tipe_id,
                    harga: this.harga,
                    status: this.status,
                    foto: this.cropper ? this.cropper.getCroppedCanvas({height: 800, widht: 800}).toDataURL('image/png') : ''
                }).then(result => {
                    const res = result.data;
                    if (res.error) {
                        notif(res.message, 'warning', true);
                    } else {
                        notif(res.message, 'success');
                        this.modalTambah = false;
                        this.show();
                    }
                })
            },
            details(kamar) {
                this.id = kamar.id;
                this.nama = kamar.nama;
                this.tipe_id = kamar.tipe_id;
                this.harga = kamar.harga;
                this.status = kamar.status;
                this.image_src = kamar.foto ? base_url + 'cdn/kamar/' + kamar.foto : '';
                this.modalEdit = true;
            },
            edit() {
                Axios.put(base_url + 'api/kamar/' + this.id, {
                    nama: this.nama,
                    tipe_id: this.tipe_id,
                    harga: this.harga,
                    status: this.status,
                    foto: this.cropper ? this.cropper.getCroppedCanvas({height: 800, widht: 800}).toDataURL('image/png') : ''
                }).then(result => {
                    const res = result.data;
                    if (res.error) {
                        notif(res.message, 'warning', true);
                    } else {
                        notif(res.message, 'success');
                        this.modalEdit = false;
                        this.show();
                    }
                })
            }
        }
    }
</script>