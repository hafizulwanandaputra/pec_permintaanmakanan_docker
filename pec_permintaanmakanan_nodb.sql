-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Waktu pembuatan: 10 Jul 2024 pada 07.44
-- Versi server: 8.0.27
-- Versi PHP: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pec_permintaanmakanan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int NOT NULL,
  `id_petugas` int NOT NULL,
  `tanggal` date NOT NULL,
  `nama_menu` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `jadwal_makan` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `protein_hewani` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `protein_nabati` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sayur` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `buah` varchar(256) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan`
--

CREATE TABLE `permintaan` (
  `id` int NOT NULL,
  `id_menu` int NOT NULL,
  `nama_pasien` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(28) COLLATE utf8mb4_general_ci NOT NULL,
  `kamar` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_tindakan` text COLLATE utf8mb4_general_ci NOT NULL,
  `diet` text COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int NOT NULL,
  `nama_petugas` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_menu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `session_history`
--

CREATE TABLE `session_history` (
  `id` int NOT NULL,
  `username` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipaddress` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `useragent` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `fullname` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(512) COLLATE utf8mb4_general_ci NOT NULL,
  `profilephoto` varchar(512) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(128) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `fullname`, `username`, `password`, `profilephoto`, `role`) VALUES
(1, 'Administrator', 'admin', '$2y$10$MUBihudQiQ0sXkO1qPxqP.hFy3RGfeoijpRR2I4U8Y/x0kgzIII5O', NULL, 'Master Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD UNIQUE KEY `nama_menu` (`nama_menu`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indeks untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_menu_2` (`id_menu`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `nama_petugas` (`nama_petugas`);

--
-- Indeks untuk tabel `session_history`
--
ALTER TABLE `session_history`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `session_history`
--
ALTER TABLE `session_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
