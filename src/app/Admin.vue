<template>
    <div class="h-screen bg-gray-100 relative">
        <nav class="w-full p-4 text-white bg-gradient-to-r from-blue-400 to-blue-300 shadow-lg md:text-left text-center sticky top-0 z-20">
            <a href="javascript:void(0)" class="float-left md:hidden" v-on:click="toggleSidebar">
                <i class="fa fa-bars"></i>
            </a>
            <span class="text-xl">SEWA KAMAR</span>
            <a href="javascript:void(0)" class="float-right" v-on:click="logout">
                <i class="fa fa-door-open"></i>
            </a>
        </nav>
        <div class="flex flex-col md:flex-row min-h-full bg-gray-100">
            <div class="w-4/6 md:w-1/5 bg-blue-400 min-h-full shadow shadow-lg md:sticky fixed hidden md:block z-10" id="sidebar">
                <ul class="mt-3">
                    <li>
                        <div v-on:click="toggleSidebar">
                        <router-link to="/admin" class="p-3 flex flex-row text-white hover:bg-blue-300 focus:bg-blue-300">
                            <i class="fa fa-home inline-block w-1/5 text-center"></i>
                            <span class="inline-block w-4/5">Dashboard</span>
                        </router-link>
                        </div>
                    </li>
                    <li v-if="level == '1'">
                        <div v-on:click="toggleSidebar">
                        <router-link to="/admin/user" class="p-3 flex flex-row text-white hover:bg-blue-300 focus:bg-blue-300">
                            <i class="fa fa-users inline-block w-1/5 text-center"></i>
                            <span class="inline-block w-4/5">User</span>
                        </router-link>
                        </div>
                    </li>
                    <li v-if="level == '1'">
                        <div v-on:click="toggleSidebar">
                        <router-link to="/admin/kamar" class="p-3 flex flex-row text-white hover:bg-blue-300 focus:bg-blue-300">
                            <i class="fa fa-map inline-block w-1/5 text-center"></i>
                            <span class="inline-block w-4/5">Kamar</span>
                        </router-link>
                        </div>
                    </li>
                    <li>
                        <div v-on:click="toggleSidebar">
                        <router-link to="/admin/pesanan" class="p-3 flex flex-row text-white hover:bg-blue-300 focus:bg-blue-300">
                            <i class="fa fa-book inline-block w-1/5 text-center"></i>
                            <span class="inline-block w-4/5">Pesanan</span>
                        </router-link>
                        </div>
                    </li>
                    <li>
                        <div v-on:click="toggleSidebar">
                        <router-link to="/admin/ulasan" class="p-3 flex flex-row text-white hover:bg-blue-300 focus:bg-blue-300">
                            <i class="fa fa-info inline-block w-1/5 text-center"></i>
                            <span class="inline-block w-4/5">Ulasan</span>
                        </router-link>
                        </div>
                    </li>
                    <li>
                        <div v-on:click="toggleSidebar">
                        <router-link to="/admin/galeri" class="p-3 flex flex-row text-white hover:bg-blue-300 focus:bg-blue-300">
                            <i class="fa fa-book-open inline-block w-1/5 text-center"></i>
                            <span class="inline-block w-4/5">Galeri</span>
                        </router-link>
                        </div>
                    </li>
                    <li>
                        <div v-on:click="toggleSidebar">
                        <router-link to="/admin/akun" class="p-3 flex flex-row text-white hover:bg-blue-300 focus:bg-blue-300">
                            <i class="fa fa-cog inline-block w-1/5 text-center"></i>
                            <span class="inline-block w-4/5">Akun</span>
                        </router-link>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="p-5 w-full md:w-4/5">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        name: 'Admin',
        data() {
            return {
                level: localStorage.getItem('level')
            }
        },
        created() {
            this.auth();
        },
        methods: {
            auth() {
                if (!localStorage.getItem('id')) {
                    this.$router.push('/');
                }
            },
            toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('hidden');
            },
            logout() {
                Swal.fire({
                    title: 'Logout',
                    text: 'Are you sure to logout?',
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonText: 'Batal'
                }).then(swal => {
                    if (swal.isConfirmed) {
                        localStorage.setItem('id', '');
                        this.$router.push('/');
                    }
                })
            }
        }
    }
</script>