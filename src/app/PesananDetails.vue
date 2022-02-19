<template>
    <div class="p-4">
        <div class="flex text-center justify-center mt-5">
            <div class="w-full md:w-1/3">
                print bukti pesanan
                <div id="view-print" class="p-3">
                    <div class="card">
                        <h3 class="text-2xl">Pesanan Kamar</h3>
                        <hr class="mt-3 mb-3">
                        <div align="center">
                            <img v-bind:src="base_url + 'icon.png'" class="rounded" style="width: 50%;">
                        </div>
                        <br class="mt-2 mb-2">
                        <h3 class="text-xl">Kamar: {{pesanan.kamar.nama}}</h3>
                        <hr class="mt-3 mb-3">
                        <h3 class="text-xl">{{pesanan.nama}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <a class="btn-green mr-2" href="#/">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>
            <a class="btn-blue ml-2" onclick="print('div#view-print')" href="javascript:void(0);">
                <i class="fa fa-print"></i>
                Print
            </a>
        </div>
    </div>
</template>

<script>
    import Axios from 'axios';

    export default {
        name: 'PesananDetails',
        data() {
            return {
                base_url: base_url,
                pesanan: {
                    kamar: {}
                }
            }
        },
        created() {
            this.show();
        },
        methods: {
            show() {
                Axios.get(base_url + 'api/pesanan/' + this.$route.params.id).then(result => {
                    this.pesanan = result.data;
                })
            }
        }
    }
</script>