<template>
    <div class="card">
        <h3 class="text-2xl">Data Ulasan</h3>
        <hr class="mt-3 mb-3">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Ulasan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in ulasan">
                        <td>{{parseInt(i) + 1}}</td>
                        <td><a v-bind:href="'mailto:' + item.email" class="text-blue-400 hover:text-blue-600">{{item.email}}</a></td>
                        <td>{{item.teks.length > 30 ? item.teks.slice(0, 30) + '...' : item.teks}}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" class="btn-green" v-on:click="details(item)">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                    <tr v-if="ulasan.length <= 0">
                        <td colspan="4" align="center">ulasan not found</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="modalDetails">
            <div class="modal">
                <div class="card w-full md:w-1/2">
                    <div class="flex">
                        <div class="flex-1">
                            <h3 class="text-2xl">Detail Ulasan</h3>
                        </div>
                        <div class="flex-1 text-right">
                            {{ulasan_created_at}}
                        </div>
                    </div>
                    <hr class="mt-3 mb-3">
                    <p>{{ulasan_teks}}</p>
                    <div class="text-right">
                        <button class="btn-blue" v-on:click="modalDetails = false">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';

    export default {
        name: 'Ulasan',
        data() {
            return {
                ulasan: [],
                ulasan_teks: '',
                ulasan_created_at: '',
                modalDetails: false
            }
        },
        created() {
            this.show();
            document.title = 'Ulasan'
        },
        methods: {
            show() {
                Axios.get(base_url + 'api/ulasan').then(result => {
                    const res = result.data;
                    this.ulasan = res.data;
                })
            },
            details(ulasan) {
                this.ulasan_teks = ulasan.teks;
                this.ulasan_created_at = ulasan.created_at;
                this.modalDetails = true;
            }
        }
    }
</script>