-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Nov 2024 pada 01.36
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
-- Database: `db_masjid`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `id` int(11) NOT NULL,
  `nama_donatur` varchar(100) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tanggal_donasi` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`id`, `nama_donatur`, `jumlah`, `tanggal_donasi`, `keterangan`) VALUES
(5, 'patan', 90000.00, '2024-11-19 06:16:04', 'berkah'),
(6, 'putra', 900000.00, '2024-11-26 01:11:46', 'semoga berkah\r\n'),
(7, 'putra', 12000.00, '2024-11-26 01:50:33', 'donate');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `keterangan` text NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemasukan`
--

INSERT INTO `pemasukan` (`id`, `tanggal`, `jumlah`, `keterangan`, `kategori`, `amount`) VALUES
(42, '2024-11-19', 20000, ' pemberian masjid baitul nawwam ', 'Donasi', 0.00),
(43, '2024-11-26', 9000, ' pemberian masjid baitul nawwam ', 'Donasi', 0.00),
(44, '2024-11-30', 120000, 'pppp', 'Infak', 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `jumlah` decimal(15,0) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `deskripsi`, `jumlah`, `tanggal`, `kategori`, `amount`, `gambar`) VALUES
(39, 'membersihkan tempat wudhu', 250000, '2024-11-11', 'Pemeliharaan', 0.00, 'gambar/Untitled.jpg'),
(40, 'pembangunan mimbar masjid', 90000, '2024-11-26', 'Kebutuhan Operasional', 0.00, 'gambar/Memahami Proses Pembuatan Mimbar Masjid.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `type` enum('income','expense') NOT NULL,
  `description` text DEFAULT NULL,
  `date` date NOT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `profile_picture` varchar(255) DEFAULT 'default_profile.png',
  `email` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`, `profile_picture`, `email`, `role`) VALUES
(11, 'putra', '$2y$10$hGnj./asMJ0Q.JBZ0Crk2.msZ3Hq3ePTjzsRjW4.Qk81J87Gknbp6', 1, 'default_profile.jpeg', '', 'user'),
(13, 'cnc', '$2y$10$3mSSFexuLupJ3kYqaLG4BeSHL9ZX9QakNhLSGiInpJZfNoqwkE/Ea', 1, 'default_profile.jpeg', '', 'user'),
(14, 'yanto', '$2y$10$jhBIswuduS3MuIGyplOPru74iHy7gli7fTMSWi3wghmZl.wi18tF2', 1, 'default_profile.jpeg', '', 'user'),
(15, 'abdian', '$2y$10$Ffod4SlidsC9KkCsGj7a/.sKLYJzL2y8vn9aSIP1yRLjDLVw8MhA.', 1, 'default_profile.jpeg', '', 'user'),
(16, 'yanti', '$2y$10$M9GRRX3BQ5.uJ8Jy2kys4u2bD3e0v97io2iF1ADh4ucn8TsyrDJzm', 1, 'default_profile.jpeg', '', 'user'),
(17, 'nur', '$2y$10$A259SLcD0fCtiQW4AwykGehpNWmwW0MocevOLpGboME633q5xxdLq', 1, 'default_profile.jpeg', '', 'user'),
(18, 'put', '$2y$10$YJ/0c9wUYCAq3sKqKS7neeAopKWo9Guwwn8CzNMXYz2xfQJCauOhW', 1, 'gambar/WhatsApp Image 2024-10-26 at 11.17.09_a5a72643.jpg', '', 'user'),
(20, 'warga', '$2y$10$4OUhAURe5Q40y3SuZ5ONIeX0H.DyVrCXTn3oZb75cz/TrF3Pty41C', 1, 'gambar/WhatsApp Image 2024-10-26 at 11.17.13_d0669585.jpg', 'p@gmail.com', 'user'),
(21, 'dejja', '$2y$10$RZ3Yry9in.XU/SZM3eV16uPot5nwmWuH.GOM7qUR3HoNb4wSiaEam', 1, 'gambar/WhatsApp Image 2024-10-09 at 13.13.29_c693e226.jpg', 'deja@gmail.com', 'user'),
(22, 'avy', '$2y$10$hnSETEjRGReh2P8YvVkDiOfmKAnswz3j/c8eqaroJZPX00jIA/Itu', 1, 'default_profile.png', 'avy@gmail.com', 'user'),
(23, 'p', '$2y$10$O24mx0iJ/1zlaaKvbEYAGOJBVOtxMBZsg2uN.k2VSU7Z/fEaSsXfC', 1, 'default_profile.png', '', 'user'),
(24, 'api', '$2y$10$sxPRwH77Q6s50dAXl4FtkewHfS5QhHoYb2hagvCzSFTAdxoTZVBPm', 1, 'default_profile.png', 'api@gmail.com', 'user'),
(30, 'pragos', '$2y$10$Kj4CEwHyS453exHGAkkcdeyr.8pd11WBTGeACc7wuEiMBiJgl.ggK', 1, 'default_profile.png', 'pragos@gmail.com', 'user'),
(31, 'adminku', '$2y$10$icGXvMKRwixpKqUwhy6JvuMNYVqrieMayE7VrkA1.JxGZ4q6oaCrm', 1, 'gambar/WhatsApp Image 2024-10-26 at 11.17.25_0a8ba414.jpg', 'abdiansaputra022@gmail.com', 'admin'),
(32, 'arip', '$2y$10$a8Fs8FxwNWZU3SWY0m.PK.BKJJwn7G9r.VkQFkH4JJNfSADHcVWFK', 1, 'default_profile.png', 'arip@gmail.com', 'user'),
(33, 'sabil', '$2y$10$Z6SsK5I3tdNscBMHEH83zeollxMAtvmRb9qxByO5s47whEKMQts5S', 1, 'default_profile.png', 'sabil@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
