-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Des 2025 pada 04.40
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simbs`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul_buku` varchar(50) NOT NULL,
  `id_kategori` int(50) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `cover_buku` varchar(255) NOT NULL,
  `tahun_terbit` varchar(150) NOT NULL,
  `nama_penulis` varchar(100) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `judul_buku`, `id_kategori`, `deskripsi`, `cover_buku`, `tahun_terbit`, `nama_penulis`, `tanggal_input`) VALUES
(1, 'Madilog', 1, 'Buku ini mmebahas tentang materialisme, dialektika dan logika sebagai dasar untuk berpikir kritis dan ilmiah', 'cover_1764378352_9709.jpeg', '1943', 'Tan Malaka', '2025-11-29 08:05:52'),
(2, 'Laut Bercerita', 2, 'buku yang menceritakan berbagai sudut pandang dari peristiwa penculikan aktivis tahun 1998', 'cover_1764381936_9539.jpeg', '2017', 'Leila S. Chudori', '2025-11-29 09:05:36'),
(3, 'Aksi Massa', 3, 'Merupakan buku yang berisi tentang  strategi revolusi dengan aksi massa yang terencana dan terorganisir', 'cover_1764382150_6868.jpeg', '1926', 'tan malaka', '2025-11-29 09:09:10'),
(4, 'Sejarah Dunia Yang Disembunyikan', 1, 'Buku ini bersifat spekulatif dan kontroversial, yang membuat para pembaca mempertanyaan kembali tentang sejarah dunia', 'cover_1764382457_4569.jpeg', '2007', 'Jonathan Blackk', '2025-11-29 09:14:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(250) NOT NULL,
  `deskripsi` varchar(400) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`, `tanggal_input`) VALUES
(1, 'nonfiksi', 'buku ini berisi mengenai eksplorasi provokatif dengan tujuan agar pembaca mempertanyakan kembali tentang sejarah', '2025-11-29 08:04:40'),
(2, 'fiksi sejarah', 'menceritakan berbagai sudut pandang peristiwa penculikan aktivis tahun 1998', '2025-11-29 08:04:40'),
(3, 'sosial politik', 'membahas tentang strategi revolusi melalui aksi massa yang terencana dan terorganisir', '2025-11-29 08:04:40'),
(4, 'filsafat', 'membahas tentang materialisme, dialektika dan logika sebagai dasar untuk berpikir kritis dan ilmiah', '2025-11-29 08:04:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `tanggal_register` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `prodi`, `tanggal_register`) VALUES
(1, 'dhitiny', '$2y$10$Y4aRfMfV.n/xg9V2qFIPHu60PAdFnl9SgnUVjjcW.kzchDWY//Mpy', 'diiwon93@gmail.com', '', '2025-11-29 04:52:57'),
(2, 'ariq', '$2y$10$dCdj3dMERPAvLO5s./RB8OQOTxBMKg7.POjqgpo1954gfo8Cc1EjC', 'ariq123@gmail.com', '', '2025-11-29 07:17:59');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
