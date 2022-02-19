-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Feb 2022 pada 04.58
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_kamar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `foto` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id`, `foto`) VALUES
(3, '106c285852654e6bcab2.jpg'),
(5, '9f2c05c3b3c83b890271.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tipe_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `foto` varchar(25) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1 = tersedia, 2 = kosong'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`id`, `nama`, `tipe_id`, `harga`, `foto`, `status`) VALUES
(4, 'A-001', 1, 100000, 'efb82476ef4a6646ba36.png', '1'),
(5, 'B-001', 2, 50000, '', '1'),
(6, 'A-002', 1, 70000, 'a3be386eb7bcb72c0cd2.png', '1'),
(7, 'B-002', 2, 30000, '74505569df248050b0c4.png', '1'),
(8, 'B-003', 2, 20000, 'ad8cc285ced67d990410.png', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nomor_telepon` varchar(30) NOT NULL,
  `kamar_id` bigint(20) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `bayar` int(11) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1 = proses, 2 = selesai'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama`, `nomor_telepon`, `kamar_id`, `tanggal_mulai`, `tanggal_akhir`, `bayar`, `status`) VALUES
(1, 'Ricky Ahmad Mahbubi', '085273725389', 5, '2020-02-07', '2020-02-10', 150000, '2'),
(2, 'Mohammad Rafly Azzuhri', '082330447654', 4, '2021-02-13', '2021-02-14', 100000, '2'),
(3, 'Muhammad Izza Alfiansyah', '08126543534', 4, '2021-02-16', '2021-02-18', 200000, '2'),
(4, 'Ricky Ahmad', '08254542673', 5, '2021-02-13', '2021-02-15', 100000, '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tipe_kamar`
--

CREATE TABLE `tipe_kamar` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tipe_kamar`
--

INSERT INTO `tipe_kamar` (`id`, `nama`) VALUES
(1, 'A'),
(2, 'B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `teks` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id`, `email`, `teks`, `created_at`) VALUES
(1, 'rikiriki@gmail.com', 'Sangat Memuaskan', '2021-02-11 05:19:49'),
(2, 'iansyahalvey@gmail.com', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam debitis cum temporibus, voluptas accusantium itaque quod saepe voluptatibus reiciendis nemo, error beatae rerum ipsum repellat facere laudantium quisquam illo similique.', '2021-02-11 05:35:06'),
(3, 'saifulmunir@gmail.com', 'Saya harap pelayanannya menjadi lebih baik', '2021-02-11 05:41:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_telepon` varchar(20) NOT NULL,
  `level` enum('1','2') NOT NULL COMMENT '1 = admin, 2 = petugas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `email`, `nomor_telepon`, `level`) VALUES
(1, 'superadmin', '$2y$10$3COr8tLPub2UwZKK3oiH9OqFakrzgfuEHfTge.sZMnHUJe9clRlHy', 'Muhammad Izza Alfiansyah', 'iansyah724@gmail.com', '082330538264', '1'),
(3, 'rikiriki', '$2y$10$8xXEBYtEkySBMtTzGyvqj..pl0Dp9eINI4I.L0jpE2qybNjuJt3PG', 'Ricky Ahmad Mahbubi', 'rikiriki@gmail.com', '085253747547', '2');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
