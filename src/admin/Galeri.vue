<template>
    <div class="card">
        <div class="flex">
            <div class="flex-1">
                <h3 class="text-2xl">Data Galeri</h3>
            </div>
            <div class="flex-1 text-right">
                <button class="btn-blue" v-on:click="modalTambah = true">
                    <i class="fa fa-plus"></i>
                    Tambah
                </button>
            </div>
        </div>
        <hr class="mt-3 mb-3">
        <div class="flex flex-col md:flex-row">
            <div v-for="item in galeri" class="w-full md:w-1/4">
                <div class="card">
                    <img v-bind:src="base_url + 'cdn/galeri/' + item.foto" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="mt-3 text-center">
                        <small>{{item.foto}}</small>
                        <div>
                            <button class="btn-red w-full" v-on:click="remove(item)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="galeri.length <= 0" align="center">
            empty data galeri
        </div>
        <div v-if="modalTambah">
            <div class="modal p-3">
                <form class="card w-full md:w-1/3" v-on:submit.prevent="add">
                    <h3 class="text-2xl">Tambah Galeri</h3>
                    <hr class="mt-3 mb-3">
                    <input type="file" name="tambah-foto" v-on:change="changeFoto('tambah-foto')" class="form-control">
                    <div class="bg-gray-100 p-2" style="height: 250px" align="center">
                        <img src="" style="height: 100%;" id="tambah-foto">
                    </div>
                    <div class="text-right mt-3">
                        <button class="btn-red" type="button" v-on:click="modalTambah = false">Batal</button>
                        <button type="submit" class="btn-blue">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';
    import {notif, readFile} from '../main.js';
    import Swal from 'sweetalert2';

    export default {
        name: 'Galeri',
        data() {
            return {
                galeri: [],
                modalTambah: false,
                cropper: null,
                base_url: base_url
            }
        },
        created() {
            this.show();
            document.title = 'Galeri';
        },
        methods: {
            show() {
                Axios.get(base_url + 'api/galeri').then(result => {
                    this.galeri = result.data;
                })
            },
            changeFoto(selector) {
                var img = document.getElementById(selector);
                readFile('[name=' + selector + ']', (data) => {
                    img.src = data;
                });
                setTimeout(() => {
                    if (this.cropper) {
                        this.cropper.destroy();
                    }
                    this.cropper = new Cropper(img);
                }, 400);
            },
            add() {
                Axios.post(base_url + 'api/galeri', {
                    foto: this.cropper ? this.cropper.getCroppedCanvas().toDataURL('image/png') : ''
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
            remove(galeri) {
                Swal.fire({
                    title: 'Delete Galeri',
                    html: 'are you sure to delete <strong>' + galeri.foto + '</strong> ?',
                    icon: 'question',
                    showCancelButton: true
                }).then(swal => {
                    if (swal.isConfirmed) {
                        Axios.delete(base_url + 'api/galeri/' + galeri.id).then(result => {
                            const res = result.data;
                            notif(res.message, 'success');
                            this.show();
                        })
                    }
                })
            }
        }
    }
</script>