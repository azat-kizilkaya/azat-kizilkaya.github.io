-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 05 Oca 2026, 20:06:53
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `e_ticaret_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_kullanicilar`
--

CREATE TABLE `tbl_kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `eposta` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `dogrulama_kodu` varchar(10) DEFAULT NULL,
  `durum` int(11) DEFAULT 0,
  `sifre_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tbl_kullanicilar`
--

INSERT INTO `tbl_kullanicilar` (`kullanici_id`, `ad`, `eposta`, `sifre`, `dogrulama_kodu`, `durum`, `sifre_token`) VALUES
(1, 'sami yusuf kaya', 'syk04@gmail.com', '12345', NULL, 0, NULL),
(2, 'yunus', 'fixbelieve8@gmail.com', '12345', '928651', 0, NULL),
(3, 'azat', 'kizilkayazat980@gmail.com', 'Neslihan33', '209953', 1, NULL),
(5, 'kaan turkmen', 'kaanturkmen98@gmail.com', '12345', NULL, 1, NULL),
(6, 'muhammed enes', 'muhammeteneseski@gmail.com', '12345', '678436', 0, NULL),
(19, 'mertkzlr29', 'mertkzlr04@gmail.com', '$2y$10$aNtj75YnDR6rrjLsIBVDMee3f8OtQWAeGfbc/Umep7N2QFsV2OgIO', NULL, 1, NULL),
(20, 'koray kösem', 'koraykosem1@gmail.com', '$2y$10$8fNSDd8GRLUFGKtFf/Wk3.w115W0pb74oJjvVPbpnIHsZyRFPrAU2', NULL, 1, NULL),
(21, 'ömer', 'lomer0668@gmail.com', '$2y$10$6djBhTy0oq/Wfd6v7nzUHetQDkdBNeE2I8k47I6AyVTV8iyuadHIC', NULL, 1, NULL),
(22, 'azat', 'omer31@gmail.com', '$2y$10$laKjlX9vUErcKbxBysBJfurV26jR/COcoGCJLJuSmc2LgYGdMWn0e', '444667', 0, NULL),
(24, 'vedo', 'vedat0123k@gmail.com', '$2y$10$V4GlYvoBbqnbQWSIVuKd8epnCovnY750D7.xsa6lXk4gKxK5dsFZy', '112638', 0, NULL),
(27, 'vedo', 'vedat01234k@gmail.com', '$2y$10$7Vh660vtRKR5zwyf4tMG1urJOOaYd7U6Tbn16vaZxiGeUnLJXSt22', '982091', 0, NULL),
(28, 'kuti', 'kutaykaya010@gmail.com', '$2y$10$Q2xpD84kEz1s2ONWnszkU.bZ9l/5gMY3c.vmxe1HuQDwlxkRsygDi', '185287', 0, NULL),
(30, 'vedo', 'vedat01234k@gmail.com', '0404', '245411', 0, NULL),
(31, 'vedo', 'vedat01234k@gmail.com', '0404', '258092', 0, NULL),
(42, 'azat', 'azatbaba350@gmail.com', '$2y$10$DwLUsxGJ/4MtBNiKcHJCy.zkO2TYVALyxn5n2HUpqBltD6ZdococG', NULL, 1, NULL),
(43, 'vedat', 'kizilkayavedat01@gmail.com', '$2y$10$Ldn82gHcA3C4FEBlgm.IU./D6szP5qQSsXkv00KgmBn.EiiJvPyge', '882131', 0, NULL),
(44, 'alan', 'alanbaba35@gmail.com', '$2y$10$FrkS1MxQNGS/83mfKNPpf.hlCNRF4owlYYylUQUyrTp88hPQXoaVC', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_kuponlar`
--

CREATE TABLE `tbl_kuponlar` (
  `id` int(11) NOT NULL,
  `kod` varchar(50) NOT NULL,
  `indirim_orani` int(3) NOT NULL,
  `gecerlilik_tarihi` date NOT NULL,
  `aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tbl_kuponlar`
--

INSERT INTO `tbl_kuponlar` (`id`, `kod`, `indirim_orani`, `gecerlilik_tarihi`, `aktif`) VALUES
(1, 'FORSY10', 10, '2025-12-31', 1),
(3, 'sami30', 30, '2027-12-25', 1),
(4, 'KORAY20', 20, '2029-01-19', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_renkler`
--

CREATE TABLE `tbl_renkler` (
  `renk_id` int(11) NOT NULL,
  `ad` varchar(50) NOT NULL,
  `hex_kodu` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `tbl_renkler`
--

INSERT INTO `tbl_renkler` (`renk_id`, `ad`, `hex_kodu`) VALUES
(1, 'Siyah', '#000000'),
(2, 'Beyaz', 'white'),
(3, 'Kırmızı', NULL),
(4, 'Haki Yeşil', NULL),
(5, 'Antrasit', NULL),
(6, 'gri', '#808080'),
(8, 'yeşil', '#008000'),
(9, 'green', '#008000'),
(12, 'blue', '# 1E90F'),
(14, 'white', '#FFFFFF'),
(15, 'black', NULL),
(16, 'bordo', '#e90003'),
(18, 'lacivert', '#072d81'),
(20, 'red', '#ff0000'),
(26, 'kahverengi', '#996219');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_siparisler`
--

CREATE TABLE `tbl_siparisler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `toplam_tutar` decimal(10,2) NOT NULL,
  `durum` varchar(50) DEFAULT 'Hazırlanıyor',
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tbl_siparisler`
--

INSERT INTO `tbl_siparisler` (`id`, `kullanici_id`, `toplam_tutar`, `durum`, `tarih`) VALUES
(1, 1, 1500.00, 'Kargoya Verildi', '2025-12-17 00:14:27'),
(2, 1, 3596.97, 'Hazırlanıyor', '2025-12-17 11:21:05'),
(3, 3, 500.00, 'Hazırlanıyor', '2026-01-05 18:21:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_siparis_parcalari`
--

CREATE TABLE `tbl_siparis_parcalari` (
  `id` int(11) NOT NULL,
  `siparis_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  `renk` varchar(50) DEFAULT NULL,
  `beden` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_urunler`
--

CREATE TABLE `tbl_urunler` (
  `urun_id` int(11) UNSIGNED NOT NULL,
  `ad` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `img_url` varchar(255) DEFAULT NULL,
  `img_hover_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `tbl_urunler`
--

INSERT INTO `tbl_urunler` (`urun_id`, `ad`, `aciklama`, `kategori`, `fiyat`, `stok`, `img_url`, `img_hover_url`) VALUES
(9, 'Laon Smart Erkek Polo Tişört Siyah', '', 'T-Shirt', 279.90, 55, '6940019b6aa2c-1t.jpg', '11'),
(10, 'Tuna Modern Grafik T- Shirt Beyaz', '', 'T-Shirt', 799.99, 60, '6941e3eed42ad-tuna-modern-grafik-t-shirt-beyaz-9128-erkek-basic-tisort-lufian-410567-91-B.jpg', '12'),
(11, 'Sara Erkek Uzun Kol T- Shırt Açık Kahve', '', 'T-Shirt', 999.99, 70, '6941e27398711-sara-erkek-uzun-kol-t-shirt-acik-kahve-erkek-bisiklet-yaka-tisort-lufian-404846-96-B.jpg', '13'),
(24, 'Vernon Smart Erkek Polo Tişört Çimen Yeşili', '', 'T-Shirt', 899.99, 17, '6941c746eb013-vernon-smart-erkek-polo-tisort-cimen-yesili-erkek-polo-yaka-tisort-lufian-412579-94-B.jpg', '26'),
(36, 'Beli Lastikli Ekoseli Gri Pijama', '', 'Eşofman Altı', 399.00, 31, '693f1d0e82314-beli-lastikli-ekoseli-gri-pijama-2d239-.jpg', '42'),
(37, 'Biyeli Eşofman Altı', '', 'Eşofman Altı', 899.00, 44, '694921a90e0af-693ebb0fc574a-1.b.jpg', '43'),
(38, 'Basic Ayarlanabilir Paça Bordo Eşofman Altı', 'Sıcak tutan fleece kumaşlı açık gri alt.', 'Eşofman Altı', 455.00, 27, '693f1a3fce8e4-1.f.jpg', '44'),
(39, 'Ayarlanabilir Paça Basic Yeşil Baggy Eşofman Altı', '', 'Eşofman Altı', 500.00, 37, '693eca33a2e7f-1.c.jpg', '693'),
(40, 'Siyah Baggy Eşofman Altı', '', 'Eşofman Altı', 599.99, 10, '693ec5e0197bc-6.a.jpg', '693');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_urun_gorselleri`
--

CREATE TABLE `tbl_urun_gorselleri` (
  `gorsel_id` int(11) NOT NULL,
  `urun_id` int(11) UNSIGNED NOT NULL,
  `urun_renk_id` int(11) DEFAULT NULL,
  `gorsel_url` varchar(255) NOT NULL,
  `sira` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `tbl_urun_gorselleri`
--

INSERT INTO `tbl_urun_gorselleri` (`gorsel_id`, `urun_id`, `urun_renk_id`, `gorsel_url`, `sira`) VALUES
(5, 40, NULL, '693ebdf5797c4-3.a.jpg', 1),
(6, 40, NULL, '693ebe11dab4f-4.a.jpg', 2),
(7, 40, NULL, '693ebe2065b19-5.a.jpg', 3),
(8, 40, NULL, '693ebe36ae4d2-6.a.jpg', 4),
(9, 40, NULL, '693ec0340cbf1-2.a.jpg', 5),
(10, 40, 5, '693ec59be82a7-5.a.jpg', 1),
(11, 40, 5, '693ec5a30f1ed-3.a.jpg', 2),
(12, 40, 5, '693ec5a843489-2.a.jpg', 3),
(13, 40, 5, '693ec5ac998d5-4.a.jpg', 4),
(14, 40, 7, '693ec6c578fcb-2.b.jpg', 1),
(15, 40, 7, '693ec6cab7146-3.b.jpg', 2),
(16, 40, 7, '693ec6ceb984a-4.b.jpg', 3),
(17, 40, 7, '693ec6d2c40ad-5.b.jpg', 4),
(18, 40, 7, '693ec6d72dba6-6.b.jpg', 5),
(19, 40, 5, '693ec8dcc3d47-6.a.jpg', 5),
(23, 39, 9, '693f0debdb8b9-2.c.jpg', 1),
(24, 39, 9, '693f0df2ec09d-3.c.jpg', 2),
(25, 39, 9, '693f0dfa97961-4.c.jpg', 3),
(26, 39, 10, '693f1898044c9-2.d.jpg', 1),
(27, 39, 10, '693f189d68cd1-3.d.jpg', 2),
(28, 39, 10, '693f18a77f7bb-4.d.jpg', 3),
(29, 38, 11, '693f1a24893d5-2.f.jpg', 1),
(30, 38, 11, '693f1a2991210-3.f.jpg', 2),
(31, 38, 11, '693f1a2d970fa-4.f.jpg', 3),
(32, 38, 11, '693f1a326eac2-1.f.jpg', 4),
(33, 38, 12, '693f1b56d35d4-2.e.jpg', 1),
(34, 38, 12, '693f1b5d0e6f6-3.e.jpg', 2),
(35, 38, 12, '693f1b6a1598e-4.e.jpg', 3),
(36, 37, 13, '693f1c2339b9d-biyeli-esofman-alti-a5dcc-.jpg', 1),
(37, 37, 13, '693f1c282a960-biyeli-esofman-alti-e59f93.jpg', 2),
(38, 37, 14, '693f1c8cc9fc7-biyeli-esofman-alti-e-b6a8.jpg', 1),
(39, 37, 14, '693f1c91d1b01-biyeli-esofman-alti-7-0845.jpg', 2),
(40, 37, 14, '693f1c9619dcb-biyeli-esofman-alti-4a8a-8.jpg', 3),
(41, 36, 15, '693f1d4cae98d-beli-lastikli-ekoseli-siyah-pijama-fa0-40.jpg', 1),
(42, 36, 15, '693f1d5852083-beli-lastikli-ekoseli-gri-pijama-2d239-.jpg', 2),
(43, 36, 15, '693f1d77378f8-beli-lastikli-ekoseli-siyah-pijama-a5-773.jpg', 3),
(44, 9, 17, '694001adb1a49-2t.jpg', 1),
(45, 9, 17, '694001b1269a0-1t.jpg', 2),
(46, 9, 17, '694001b54287b-3t.jpg', 3),
(47, 9, 17, '694001b87849d-4t.jpg', 4),
(48, 9, 18, '694001c1b82ae-1s.jpg', 1),
(49, 9, 18, '694001c616c99-2s.jpg', 2),
(50, 9, 18, '694001cad7ef3-3s.jpg', 3),
(51, 9, 18, '694001cf26e64-4s.jpg', 4),
(52, 24, 19, '6941c7808115a-vernon-smart-erkek-polo-tisort-cimen-yesili-erkek-polo-yaka-tisort-lufian-412579-94-B.jpg', 1),
(53, 24, 19, '6941c786223b9-vernon-smart-erkek-polo-tisort-cimen-yesili-erkek-polo-yaka-tisort-lufian-412580-94-B.jpg', 2),
(54, 24, 19, '6941c78ad40a3-vernon-smart-erkek-polo-tisort-cimen-yesili-erkek-polo-yaka-tisort-lufian-412581-94-B.jpg', 3),
(55, 24, 19, '6941c7901a2a1-vernon-smart-erkek-polo-tisort-cimen-yesili-erkek-polo-yaka-tisort-lufian-412582-94-B.jpg', 4),
(56, 24, 20, '6941c79d0b161-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412555-94-B.jpg', 1),
(57, 24, 20, '6941c7a28c5ab-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412556-94-B.jpg', 2),
(58, 24, 20, '6941c7a7dbe22-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412557-94-B.jpg', 3),
(59, 24, 20, '6941c7ac927d8-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412558-94-B.jpg', 4),
(60, 11, 21, '6941e28446cfa-sara-erkek-uzun-kol-t-shirt-acik-kahve-erkek-bisiklet-yaka-tisort-lufian-404847-96-B.jpg', 1),
(61, 11, 21, '6941e28a5a5c2-sara-erkek-uzun-kol-t-shirt-acik-kahve-erkek-bisiklet-yaka-tisort-lufian-404848-96-B.jpg', 2),
(62, 11, 21, '6941e28f96c6f-sara-erkek-uzun-kol-t-shirt-acik-kahve-erkek-bisiklet-yaka-tisort-lufian-404849-96-B.jpg', 3),
(63, 11, 22, '6941e2a9be2bb-sara-erkek-uzun-kol-t-shirt-siyah-erkek-basic-tisort-lufian-405339-97-B.jpg', 1),
(64, 11, 22, '6941e2c75cf96-sara-erkek-uzun-kol-t-shirt-siyah-erkek-basic-tisort-lufian-405340-97-B.jpg', 2),
(65, 11, 22, '6941e2d41c296-sara-erkek-uzun-kol-t-shirt-siyah-erkek-basic-tisort-lufian-405341-97-B.jpg', 3),
(66, 10, 23, '6941e40045501-tuna-modern-grafik-t-shirt-beyaz-9128-erkek-basic-tisort-lufian-410568-91-B.jpg', 1),
(67, 10, 23, '6941e4095ae42-tuna-modern-grafik-t-shirt-beyaz-9128-erkek-basic-tisort-lufian-410569-91-B.jpg', 2),
(68, 10, 23, '6941e40ea4e19-tuna-modern-grafik-t-shirt-beyaz-9128-erkek-basic-tisort-lufian-410570-91-B.jpg', 3),
(69, 10, 24, '6941e42326a9a-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412556-94-B.jpg', 1),
(70, 10, 24, '6941e42f34090-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412557-94-B.jpg', 2),
(71, 10, 24, '6941e433844a3-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412558-94-B.jpg', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_urun_renkleri`
--

CREATE TABLE `tbl_urun_renkleri` (
  `urun_renk_id` int(11) NOT NULL,
  `urun_id` int(11) UNSIGNED NOT NULL,
  `renk_id` int(11) NOT NULL,
  `renk_ana_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `tbl_urun_renkleri`
--

INSERT INTO `tbl_urun_renkleri` (`urun_renk_id`, `urun_id`, `renk_id`, `renk_ana_img`) VALUES
(5, 40, 1, '693ec64d9939f-1.a.jpg'),
(7, 40, 6, '693ec6a74d2e6-1.b.jpg'),
(9, 39, 9, '693f0de43f447-1.c.jpg'),
(10, 39, 14, '693f18928a4e1-1.d.jpg'),
(11, 38, 16, '693f1a1eefe72-1.f.jpg'),
(12, 38, 18, '693f1b8828540-1.e.jpg'),
(13, 37, 1, '693f1c1d8d6bd-biyeli-esofman-alti-5-4902.jpg'),
(14, 37, 6, '693f1c8501960-biyeli-esofman-alti-f-475c.jpg'),
(15, 36, 6, '693f1d401bc86-beli-lastikli-ekoseli-siyah-pijama-a5-773.jpg'),
(17, 9, 1, '694001a94147d-1t.jpg'),
(18, 9, 20, '694001bda74b4-1s.jpg'),
(19, 24, 9, '6941c77c9749b-vernon-smart-erkek-polo-tisort-cimen-yesili-erkek-polo-yaka-tisort-lufian-412579-94-B.jpg'),
(20, 24, 12, '6941c796e81cc-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412555-94-B.jpg'),
(21, 11, 26, '6941e2803c29d-sara-erkek-uzun-kol-t-shirt-acik-kahve-erkek-bisiklet-yaka-tisort-lufian-404846-96-B.jpg'),
(22, 11, 15, '6941e2c12b9c0-sara-erkek-uzun-kol-t-shirt-siyah-erkek-basic-tisort-lufian-405338-97-B.jpg'),
(23, 10, 2, '6941e3f7072c5-tuna-modern-grafik-t-shirt-beyaz-9128-erkek-basic-tisort-lufian-410567-91-B.jpg'),
(24, 10, 18, '6941e41bad392-vernon-smart-erkek-polo-tisort-indigo-erkek-polo-yaka-tisort-lufian-412555-94-B.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tbl_yoneticiler`
--

CREATE TABLE `tbl_yoneticiler` (
  `id` int(11) NOT NULL,
  `kullanici_ad` varchar(50) NOT NULL,
  `eposta` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tbl_yoneticiler`
--

INSERT INTO `tbl_yoneticiler` (`id`, `kullanici_ad`, `eposta`, `sifre`) VALUES
(1, 'Admin Azat', 'forsy04@gmail.com', '123456');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tbl_kullanicilar`
--
ALTER TABLE `tbl_kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `tbl_kuponlar`
--
ALTER TABLE `tbl_kuponlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tbl_renkler`
--
ALTER TABLE `tbl_renkler`
  ADD PRIMARY KEY (`renk_id`),
  ADD UNIQUE KEY `ad` (`ad`);

--
-- Tablo için indeksler `tbl_siparisler`
--
ALTER TABLE `tbl_siparisler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tbl_siparis_parcalari`
--
ALTER TABLE `tbl_siparis_parcalari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tbl_urunler`
--
ALTER TABLE `tbl_urunler`
  ADD PRIMARY KEY (`urun_id`);

--
-- Tablo için indeksler `tbl_urun_gorselleri`
--
ALTER TABLE `tbl_urun_gorselleri`
  ADD PRIMARY KEY (`gorsel_id`),
  ADD KEY `urun_id` (`urun_id`),
  ADD KEY `fk_urun_renk_gorsel` (`urun_renk_id`);

--
-- Tablo için indeksler `tbl_urun_renkleri`
--
ALTER TABLE `tbl_urun_renkleri`
  ADD PRIMARY KEY (`urun_renk_id`),
  ADD KEY `urun_id` (`urun_id`),
  ADD KEY `renk_id` (`renk_id`);

--
-- Tablo için indeksler `tbl_yoneticiler`
--
ALTER TABLE `tbl_yoneticiler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tbl_kullanicilar`
--
ALTER TABLE `tbl_kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_kuponlar`
--
ALTER TABLE `tbl_kuponlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_renkler`
--
ALTER TABLE `tbl_renkler`
  MODIFY `renk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_siparisler`
--
ALTER TABLE `tbl_siparisler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_siparis_parcalari`
--
ALTER TABLE `tbl_siparis_parcalari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_urunler`
--
ALTER TABLE `tbl_urunler`
  MODIFY `urun_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_urun_gorselleri`
--
ALTER TABLE `tbl_urun_gorselleri`
  MODIFY `gorsel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_urun_renkleri`
--
ALTER TABLE `tbl_urun_renkleri`
  MODIFY `urun_renk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `tbl_yoneticiler`
--
ALTER TABLE `tbl_yoneticiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `tbl_urun_gorselleri`
--
ALTER TABLE `tbl_urun_gorselleri`
  ADD CONSTRAINT `fk_urun_renk_gorsel` FOREIGN KEY (`urun_renk_id`) REFERENCES `tbl_urun_renkleri` (`urun_renk_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_urun_gorselleri_ibfk_1` FOREIGN KEY (`urun_id`) REFERENCES `tbl_urunler` (`urun_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `tbl_urun_renkleri`
--
ALTER TABLE `tbl_urun_renkleri`
  ADD CONSTRAINT `tbl_urun_renkleri_ibfk_1` FOREIGN KEY (`urun_id`) REFERENCES `tbl_urunler` (`urun_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_urun_renkleri_ibfk_2` FOREIGN KEY (`renk_id`) REFERENCES `tbl_renkler` (`renk_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
