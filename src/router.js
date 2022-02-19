import Home from './app/Home.vue';
import Admin from './app/Admin.vue';

// Home
import Auth from './app/Auth.vue';
import Index from './app/Index.vue';
import KamarDetails from './app/KamarDetails.vue';
import PesananDetails from './app/PesananDetails.vue';

// Admin
import Dashboard from './admin/Dashboard.vue';
import User from './admin/User.vue';
import UserAdd from './admin/UserAdd.vue';
import UserDetails from './admin/UserDetails.vue';
import Kamar from './admin/Kamar.vue';
import Pesanan from './admin/Pesanan.vue';
import Ulasan from './admin/Ulasan.vue';
import Akun from './admin/Akun.vue';
import Galeri from './admin/Galeri.vue';

export default [
    {
        path: '/',
        component: Home,
        children: [
            {
                path: '/',
                component: Index
            },
            {
                path: '/auth',
                component: Auth
            },
            {
                path: '/kamar/:id',
                component: KamarDetails
            },
            {
                path: '/pesanan/:id',
                component: PesananDetails
            }
        ]
    },
    {
        path: '/admin',
        component: Admin,
        children: [
            {
                path: '/',
                component: Dashboard
            },
            {
                path: 'user',
                component: User
            },
            {
                path: 'user/add',
                component: UserAdd
            },
            {
                path: 'user/:id',
                component: UserDetails
            },
            {
                path: 'kamar',
                component: Kamar
            },
            {
                path: 'pesanan',
                component: Pesanan
            },
            {
                path: 'ulasan',
                component: Ulasan
            },
            {
                path: 'akun',
                component: Akun
            },
            {
                path: 'galeri',
                component: Galeri
            }
        ]
    }
];