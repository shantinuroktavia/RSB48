-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2013 at 04:38 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bukuk426_bukukuliah`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktor_sistem`
--

CREATE TABLE IF NOT EXISTS `aktor_sistem` (
  `ID` int(35) NOT NULL AUTO_INCREMENT,
  `isAdmin` varchar(3) NOT NULL DEFAULT '0',
  `Username` varchar(35) NOT NULL,
  `Nama` varchar(40) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Lokasi` varchar(25) NOT NULL DEFAULT 'Jakarta',
  `Reputasi` int(11) DEFAULT '0',
  `Deskripsi` text,
  `MulaiBlokir` datetime DEFAULT NULL,
  `SelesaiBlokir` datetime DEFAULT NULL,
  `AlasanBlokir` varchar(500) DEFAULT NULL,
  `URLFoto` varchar(200) DEFAULT NULL,
  `isAlphaTester` tinyint(4) NOT NULL DEFAULT '0',
  `Jumlah_Rater` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `aktor_sistem`
--

INSERT INTO `aktor_sistem` (`ID`, `isAdmin`, `Username`, `Nama`, `Email`, `Password`, `Lokasi`, `Reputasi`, `Deskripsi`, `MulaiBlokir`, `SelesaiBlokir`, `AlasanBlokir`, `URLFoto`, `isAlphaTester`, `Jumlah_Rater`) VALUES
(1, '1', 'irfan92', 'Muhammad Irfan Nasution', 'irfan.nasution@live.com', 'f98c261b7807521d75c131c3f4666940', '7', 16, '													That was a legend.. wait for it.. dary																																																																																																									', NULL, NULL, NULL, 'uploads/fUemvBejU1hWL5flMOiX.jpg', 1, 2),
(22, '0', 'mady92', 'mady mady', 'mady@gmail.com', 'd2f49831d57d5e31e410c8108bed2215', '8', 0, 'Someone at different time continuum... Fans of syfy channel', NULL, NULL, NULL, 'uploads/mady92-diagram-47.png', 1, 0),
(3, '0', 'melyana', 'Liliana Tanoesudibyo', 'mely@yahoo.co.id', '9c85538bf722fc660a44325ba63fb72f', '5', 0, 'Ingin mencoba sistem ini.																								', NULL, NULL, NULL, 'uploads/p25BJgAeqQmDHDlAtBjm.PNG', 0, 0),
(24, '0', 'mercia01', 'mercia noviana', 'mercia_a@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', '8', 20, 'fasilkom', NULL, NULL, NULL, 'uploads/mercia01-kepang air.PNG', 0, 1),
(5, '0', 'ahmadahfa', 'Ahmad Ahfa Fanani', 'ahmadahfa@gmail.com', '5825e9386a353dc44698240dfa4010dc', '22', 18, '													A student of University of Indonesia												', '2013-05-14 00:00:00', '2013-05-15 00:00:00', '', 'uploads/bNFegCgGPWjoKz7YhwYI.jpg', 1, 2),
(7, '1', 'admin', 'Administrator', 'support@buku-kuliah.com', '4f36296f2aedf8ba42407a7dd9645430', '5', 0, NULL, NULL, NULL, NULL, 'uploads/admin.jpg', 0, 0),
(9, '0', 'markonah', 'Marissa Komarina Hortenz', 'redjam_sanctuary@yahoo.com', '327d0a341559b1eef01969c09d13e7dc', '5', 9, '													There\\''s no such a book that is good to everybody.																																																												', NULL, NULL, NULL, 'uploads/g5VshWzDgsGtt0kdwQ3o.png', 1, 2),
(15, '0', 'irfan91', 'Muhammad Irfan Nasution', 'mhd.irfan@ui.ac.id', 'f98c261b7807521d75c131c3f4666940', '5', 0, 'lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ip', '2013-05-26 00:00:00', '2013-06-01 00:00:00', 'bot user', 'uploads/irfan91-messi_1324491f.jpg', 0, 0),
(27, '0', 'Amalia', 'Maghfirotul Amalia', 'maghfirotul_amalia@yahoo.com', 'e37ca159d47db7d4e32eaa425eb10dfb', '7', 0, 'I am...', NULL, NULL, NULL, 'uploads/Amalia-img1.jpg', 0, 0),
(21, '0', 'lololala', 'Galang Rambo Anarki', 'lrigvrkr@sharklasers.com', '9aaaab6cb0a3e03a7e2995257b561774', '22', 4, '																																																																																											saya adalah lolo																																																																																				', NULL, NULL, NULL, 'uploads/JKC6tUHcqOgzM2ixeV8x.jpg', 0, 3),
(4, '0', 'firliasandyta', 'Firlia Sandyta', 'firliasandyta@gmail.com', 'd0674e8ba7edb51e20dd146490ea8dde', '7', 19, '													Ilmu Komputer UI												', NULL, NULL, NULL, 'uploads/mEKwLNqfIhMBMDV2RctG.jpg', 0, 1),
(40, '2', 'admin_vini', 'Admin Vini', 'viniagrameizi@gmail.com', '68f32b150814dd2ae4313d0f9a5bfdeb', '7', 0, '', NULL, NULL, NULL, 'uploads/viniagrameizi-DSC03572.JPG', 0, 0),
(29, '0', 'mawarmelati', 'Mawar Melati', 'gvabtowz@sharklasers.com', 'fcea920f7412b5da7be0cf42b8c93759', '1', 7, 'Saya adalah mahasiswa Ilmu Komputer yang sangat suka maen komputer																																																																																												', NULL, NULL, NULL, 'uploads/mawarmelati-akhwat tangguh.jpeg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `ID` int(10) NOT NULL COMMENT 'Foreign key terhadap AKTOR_SISTEM',
  `IDBuku` int(10) NOT NULL AUTO_INCREMENT,
  `Judul` varchar(100) NOT NULL,
  `Penerbit` varchar(50) NOT NULL,
  `URLFoto` varchar(200) NOT NULL,
  `Edisi` int(3) DEFAULT NULL,
  `Pengarang` varchar(50) NOT NULL,
  `Th_Terbit` year(4) NOT NULL,
  `Rating` int(10) NOT NULL DEFAULT '0',
  `Status` tinyint(4) NOT NULL DEFAULT '0',
  `Jumlah_Rater` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDBuku`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`ID`, `IDBuku`, `Judul`, `Penerbit`, `URLFoto`, `Edisi`, `Pengarang`, `Th_Terbit`, `Rating`, `Status`, `Jumlah_Rater`) VALUES
(3, 4, 'Kalkulus Menggunakan MAPLE', 'Erlangga', 'http://fkip.unai.edu/wp-content/uploads/maple.gif', 3, 'Dr. Horasdia Saragih', 2008, 20, 0, 1),
(9, 27, 'Sophie\\''s World', 'Berkley Books', 'uploads/r9Xdx4z7PXtLqvcxVtAe.png', 1, ' Jostein Gaarder', 1991, 16, 0, 2),
(9, 29, 'The Science of Fractal Images', 'Springer-Verlag', 'uploads/Y0SurArEeOFqoOq8s4KO.jpg', 1, 'Heinz-Otto Peitgen, Dietmar Saupe', 1988, 17, 1, 2),
(1, 59, 'Klingon Dictionary', 'Geek corp', 'uploads/Rk0AwfuywEKVZDnzwfE0.jpg', 1, 'Marc Okrand', 2009, 20, 0, 1),
(4, 71, 'Pengantar Komputasi Numerik', 'Salemba Empat', 'uploads/WuPzrZZOPq6iAiP3MIOM.jpg', 3, 'Prof. Choi Siwon, S.Kom, M.Kom', 2009, 0, 0, 0),
(1, 37, 'Big Java', 'John Wiley & Sons', 'uploads/5COrhsVAcSjzieRHNVFL.jpg', 3, 'Cay Horstmann', 2007, 20, 1, 2),
(5, 34, 'Mastering AutoCAD', 'Gramodyaria Grafika', 'uploads/uWun08talrjAevL2XJVd.jpg', 5, 'Dr. Agus Harimurty Rumangkang', 2013, 0, 0, 0),
(4, 70, 'Troubleshooting You Web Page', 'Woolim Entertainment', 'uploads/6y6F0Xw4fLllPMVtiYDu.jpg', 2, 'Prof. Kim Myungsoo, P.hd', 2010, 0, 0, 0),
(9, 28, 'The Principles of Quantum Mechanics', 'Oxford University Press', 'uploads/AgizxhSRC0M5W46YcTkZ.jpg', 1, 'P. A. M. Dirac', 1981, 18, 0, 3),
(14, 45, 'Epidemioloigi Penyakit Menular', 'Graha Cipta', 'uploads/PflkszVI0Cvea5Dmfvc7.PNG', 1, 'Nur Nasrot', 2010, 10, 0, 1),
(9, 79, 'Introduction to Game Development', 'Cengage Learning', 'uploads/jbK2MvRQw6muvw213dge.jpg', 2, 'Steve Rabin', 2010, 19, 0, 1),
(21, 65, 'Arsitektur Interior', 'Googledia', 'uploads/0WvZW6AVUyuB44BZmFtO.jpg', 10, 'Prof. Kim Myungsoo, P.hd', 1945, 0, 0, 0),
(5, 72, '89', 'Mediko hayamuti', 'uploads/jHYzYlYc2XtfiSYdl1de.jpg', 1, 'Sakura Kie', 1999, 0, 0, 0),
(5, 73, 'Al-Kahfi', 'Barokah Press', 'uploads/AwxyjOEBTQnpNulEW9F3.jpg', 1, 'Bukhori Abdulla, Lc.', 2001, 0, 0, 0),
(4, 69, 'How To make Yourself Happy', 'Erlangga', 'uploads/epXlxRuch1LSAilMPLbG.jpg', 1, 'Firlia Sandyta', 2013, 15, 0, 1),
(5, 62, 'Physics in Fiction', 'Mc Grow Hell', 'uploads/If1Xqr8nH9456oLzzydh.jpg', 90, 'Stephen Meyer', 2000, 19, 0, 1),
(21, 66, 'L\\''s Bravo Viewtiful', 'Woolim Entertainment', 'uploads/W4N6D7IeCyM4nTFtNEwa.jpg', 1, 'Kim Myungsoo', 2013, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `id_feed` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `isi_feed` varchar(200) NOT NULL,
  `waktu_feed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `induk_feed` int(11) DEFAULT NULL,
  `tipe_feed` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0: log, 1: pertanyaan, 2:komentar',
  `id_lokasi` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_feed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=207 ;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id_feed`, `id_user`, `isi_feed`, `waktu_feed`, `induk_feed`, `tipe_feed`, `id_lokasi`) VALUES
(1, 1, 'Ini merupakan feed pertama yang disimpan disistem...', '2013-05-23 18:35:02', NULL, '1', 5),
(2, 1, 'Ini merupakan komentar pertama... :)', '2013-05-23 18:36:20', 1, '2', 5),
(3, 1, 'Teman-teman C4, \nJumat ini ngumpul nggak buat testing???', '2013-05-23 18:37:43', NULL, '1', 5),
(4, 1, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=59''>"Klingon Dictionary"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-23 19:35:30', NULL, '0', 5),
(5, 5, 'Sudah integrasi tuh', '2013-05-24 06:22:08', NULL, '1', 5),
(6, 5, 'Mau comment silahkan aja', '2013-05-24 06:22:45', 5, '2', 5),
(7, 5, 'lllllllllllllllllllllll', '2013-05-24 06:27:29', 5, '2', 5),
(8, 4, 'Cempaaaattttt!!', '2013-05-24 06:38:04', NULL, '1', 5),
(9, 4, 'wahhhhh, boleh pinjam ga??', '2013-05-24 06:39:01', 4, '2', 5),
(10, 2, 'hamba harus jaga rumah, maafkan', '2013-05-24 06:50:02', 3, '2', 5),
(11, 2, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=60''>"Introduction to Game Development"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resen', '2013-05-24 07:13:24', NULL, '0', 5),
(12, 7, 'Dear member Buku-Kuliah.com,\nHari Sabtu, 13-13-2013 akan ada gathering I.\n:D', '2013-05-24 07:28:49', NULL, '1', 5),
(13, 7, 'rdfwegtwef', '2013-05-24 07:29:22', NULL, '1', 5),
(14, 7, 'fsdtgergfsdg', '2013-05-24 07:29:27', NULL, '1', 5),
(15, 7, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,', '2013-05-24 07:30:31', NULL, '1', 5),
(16, 7, 'Kuis dari MC dijawab dengan benar oleh @ndundupan. Selamat Pandu dapat souvenir dari CompFest #FantasticJourney pic.twitter.com/6Yrf49kfxa', '2013-05-24 07:32:23', NULL, '1', 5),
(17, 7, 'yeahhhhhhh :D', '2013-05-24 07:33:46', 1, '2', 5),
(18, 5, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=61''>"Physics of Star Trek"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 07:54:14', NULL, '0', 5),
(19, 5, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=62''>"Physics in Fiction"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 08:01:25', NULL, '0', 5),
(20, 1, 'Hallo anak depok.....', '2013-05-24 08:11:04', NULL, '1', 7),
(21, 4, 'haloo palembang!! :D', '2013-05-24 08:15:32', NULL, '1', -1),
(22, 5, 'mana suaranyaaaa', '2013-05-24 08:19:38', NULL, '1', 17),
(23, 4, 'haloooo Dyta si siniii Palembang :D\napo kabarnyoo??\nwong kito galo', '2013-05-24 08:20:43', NULL, '1', 17),
(24, 4, 'huoooo', '2013-05-24 08:21:50', 22, '2', NULL),
(25, 5, 'wong kito galau', '2013-05-24 08:22:53', NULL, '1', 17),
(26, 5, 'Whoy whoy wong depok', '2013-05-24 08:23:58', NULL, '1', 7),
(27, 5, 'wakakakakkakak depok dimulai', '2013-05-24 08:24:54', NULL, '1', 0),
(28, 5, 'Medan bergoyang', '2013-05-24 08:32:01', NULL, '1', 14),
(29, 1, 'hola.......', '2013-05-24 08:33:56', NULL, '1', 7),
(30, 5, 'Mataram mana suaranyaaaaaaaa', '2013-05-24 08:34:15', NULL, '1', 13),
(31, 1, 'Halo anak medan....', '2013-05-24 08:34:44', NULL, '1', 14),
(32, 1, 'Halo bengkulu...', '2013-05-24 08:35:54', NULL, '1', 6),
(33, 1, 'halo bengkulu...', '2013-05-24 08:38:11', NULL, '1', 6),
(34, 5, 'Arek Suroboyo.......................!!! Bonek mania.', '2013-05-24 08:38:15', NULL, '1', 22),
(35, 5, 'surabaaaaaaaaaayyyyyyyyyyyyaaaaa', '2013-05-24 08:38:51', NULL, '1', 22),
(36, 1, 'bengkuluuuuuuuuuuuu', '2013-05-24 08:40:13', NULL, '1', 6),
(37, 5, 'bengkulu mana suaranyaaaa, ', '2013-05-24 08:40:35', NULL, '1', 6),
(38, 5, 'Bengkulu oh bengkulu', '2013-05-24 08:43:02', NULL, '1', 6),
(39, 5, 'Palu tunjukkan wajahmu', '2013-05-24 08:44:01', NULL, '1', 18),
(40, 5, 'hay kupanggggggggggg', '2013-05-24 08:44:25', NULL, '1', 10),
(41, 5, 'neng akang tetah sadayana', '2013-05-24 08:44:58', NULL, '1', 4),
(42, 5, 'Buku-buku arek Surabaya paling top', '2013-05-24 08:49:10', NULL, '1', 22),
(43, 5, 'Jayapuraaaaaaaaaaaaaa', '2013-05-24 08:49:56', NULL, '1', 9),
(44, 5, 'beta sonde pernah terlambat lagi ke sekolah', '2013-05-24 08:50:29', NULL, '1', 9),
(45, 5, 'ya iyalahaaaaa', '2013-05-24 08:50:39', NULL, '1', 9),
(46, 5, 'masak gag percaya sih', '2013-05-24 08:50:49', NULL, '1', 9),
(47, 5, 'setiap manado rancak banaaa', '2013-05-24 08:51:10', NULL, '1', 12),
(48, 5, 'ggggggggggggggggggggggggggggg bisa lahg', '2013-05-24 08:51:30', NULL, '1', 12),
(49, 5, 'surabaya kososng gaaaaaaaaaaaaak?', '2013-05-24 08:52:00', NULL, '1', 22),
(50, 5, 'Semangaaaat kakak', '2013-05-24 08:53:17', NULL, '1', 9),
(51, 5, 'lalalalal jayapuraa', '2013-05-24 08:53:38', NULL, '1', 9),
(52, 5, 'pasti gag bisa gag sih', '2013-05-24 08:53:59', NULL, '1', 20),
(53, 5, 'mau kalau udah ada satu feeed', '2013-05-24 08:54:28', NULL, '1', 20),
(54, 5, 'coba neh abis refresh', '2013-05-24 08:55:02', NULL, '1', 7),
(55, 5, 'haruskah yang kamu yang meminjamnya\n', '2013-05-24 08:55:30', NULL, '1', 7),
(56, 5, 'ready to get it', '2013-05-24 08:56:34', NULL, '1', 5),
(57, 5, 'ready to get it', '2013-05-24 08:56:44', NULL, '1', 5),
(58, 5, 'llllllllllllllllllllllllllllllllllllllllll', '2013-05-24 08:57:58', NULL, '1', 5),
(59, 5, 'ggggggggggggggggggggggggggggggggggggggggg', '2013-05-24 08:58:23', NULL, '1', 5),
(60, 5, 'kupang dimano kau berado', '2013-05-24 08:58:50', NULL, '1', 10),
(61, 5, 'but not post', '2013-05-24 08:58:58', NULL, '1', 10),
(62, 5, 'nmnmnmnmnmnmnmnmnnmnm', '2013-05-24 08:59:16', NULL, '1', 10),
(63, 5, 'aduh,  masih ngebug', '2013-05-24 09:00:03', NULL, '1', 10),
(64, 4, 'lalalalallaalalallallsaldladlamldladaldad', '2013-05-24 09:01:40', NULL, '1', 0),
(65, 5, 'sudo tidak galau', '2013-05-24 09:03:03', NULL, '1', 17),
(66, 5, 'siaaaaaaaaaaaaaaaaaaaaaaaaaaap', '2013-05-24 09:03:59', NULL, '1', 15),
(67, 5, 'kkkkkkkkkkkkkkkkkkkkk', '2013-05-24 09:04:48', NULL, '1', 16),
(68, 5, 'pantai losaaariiii', '2013-05-24 09:05:17', NULL, '1', 11),
(69, 5, 'masakakakak 3', '2013-05-24 09:05:35', NULL, '1', 11),
(70, 4, 'pantaiiiiiiiiiiiiiiii losarii, pengen ke sana :p', '2013-05-24 09:06:01', NULL, '1', 11),
(71, 5, 'jayaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2013-05-24 09:06:28', NULL, '1', 9),
(72, 5, 'llllooooollllkkkkkk', '2013-05-24 09:07:25', NULL, '1', 9),
(73, 5, 'uuuuuuuuuuuuuuuuuuuuu', '2013-05-24 09:07:46', NULL, '1', 9),
(74, 5, 'anak medan disiniiiiii', '2013-05-24 09:09:09', NULL, '1', 14),
(75, 1, 'hola ambon.....', '2013-05-24 09:11:44', NULL, '1', 1),
(76, 5, 'palangkaraya, empek-empek aslinyooo', '2013-05-24 09:11:52', NULL, '1', 16),
(77, 5, 'in appropiate', '2013-05-24 09:12:08', NULL, '1', 16),
(78, 5, '2222222222222222222222', '2013-05-24 09:12:15', NULL, '1', 16),
(79, 1, 'lalalalalalalalalalalalalalalalalalalala', '2013-05-24 09:12:45', NULL, '1', 1),
(80, 1, 'llalallalallalalall', '2013-05-24 09:13:39', NULL, '1', 1),
(81, 4, 'apaan nih bugnya :o', '2013-05-24 09:14:26', NULL, '1', 23),
(82, 5, 'manadoooooooooooooooooooo', '2013-05-24 09:15:35', NULL, '1', 12),
(83, 4, 'udah direfresh!', '2013-05-24 09:16:07', NULL, '1', 18),
(84, 5, 'hfqgfoiqwfoqwgfoiqwhf', '2013-05-24 09:16:21', NULL, '1', 12),
(85, 4, 'loh kok ga bisa??', '2013-05-24 09:16:55', NULL, '1', 18),
(86, 5, 'macam mana pulaaaaaa', '2013-05-24 09:17:11', NULL, '1', 13),
(87, 4, 'kalo all location gimana?', '2013-05-24 09:17:30', NULL, '1', 0),
(88, 5, 'bengkulu ngebug yaaaaa', '2013-05-24 09:17:41', NULL, '1', 6),
(89, 4, 'all location', '2013-05-24 09:17:58', NULL, '1', 0),
(90, 4, 'kenapa C-Boxnya ilang?????????????/ :o', '2013-05-24 09:19:09', NULL, '1', 0),
(91, 5, 'you are a criminal', '2013-05-24 09:21:07', NULL, '1', 8),
(92, 5, 'yooooooooooooooooooooooooooo', '2013-05-24 09:21:16', NULL, '1', 8),
(93, 5, 'iiiiiiiikkkkkkkkkkkkkkkkkkk', '2013-05-24 09:21:40', NULL, '1', 8),
(94, 5, 'fanani ngepost deh', '2013-05-24 09:22:35', NULL, '1', 8),
(95, 5, 'djkfqwgifg', '2013-05-24 09:22:49', NULL, '1', 8),
(96, 4, 'masuk kok ini :D', '2013-05-24 09:23:24', 95, '2', NULL),
(97, 5, 'Oprathing System : Windows 7, Windows 8, Windows Server 2008 R2 or newer.', '2013-05-24 09:27:26', NULL, '1', 5),
(98, 4, 'masih ada bug kah?', '2013-05-24 09:28:10', NULL, '1', 0),
(99, 5, 'Oprathing System : Windows 7, Windows 8, Windows Server 2008 R2 or newer.', '2013-05-24 09:28:40', NULL, '1', 10),
(100, 5, 'Oprathing System : Windows 7, Windows 8, Windows Server 2008 R2 or newer.3', '2013-05-24 09:28:51', NULL, '1', 10),
(101, 5, 'jjooooooooooooooooooooooooo', '2013-05-24 09:29:14', NULL, '1', 10),
(102, 5, 'banda aceh', '2013-05-24 09:29:49', NULL, '1', 2),
(103, 5, 'cobammmvmvmmvm', '2013-05-24 09:32:25', NULL, '1', 23),
(104, 5, 'cfccccccccccccccccccccccc', '2013-05-24 09:33:13', NULL, '1', 23),
(105, 5, 'ddddddddddddddddddddddddddddd', '2013-05-24 09:33:20', NULL, '1', 23),
(106, 7, 'seduduuududududu sedu mie gelas', '2013-05-24 09:38:52', NULL, '1', 5),
(107, 7, 'seduduuududududu sedu mie gelas', '2013-05-24 09:38:53', NULL, '1', 5),
(108, 7, 'seduduuududududu sedu mie gelas', '2013-05-24 09:39:13', NULL, '1', 5),
(109, 7, 'seduduuududududu sedu mie gelas', '2013-05-24 09:39:28', NULL, '1', 5),
(110, 1, 'lkajlkjdlaskjdlkasldkjaslkjlaskjdlk', '2013-05-24 09:40:42', NULL, '1', 4),
(111, 5, 'wong kitooooo galoon', '2013-05-24 09:42:38', NULL, '1', 17),
(112, 5, 'Semangat Kakaknyaaa yg ada di JOGJA. Maju terus UGM #eh', '2013-05-24 09:55:55', NULL, '1', 23),
(113, 5, 'udah kiai kakakka', '2013-05-24 10:01:31', NULL, '1', 13),
(114, 7, 'tes tes biji kates\nhalo saya di Pekanbaru', '2013-05-24 10:36:10', NULL, '1', 19),
(115, 9, 'Aku Ingin [Sapardi Djoko Damono]\n\nAku ingin mencintaimu dengan sederhana: dengan kata yang tak sempat diucapkan kayu kepada api yang menjadikannya abu', '2013-05-24 10:41:00', NULL, '1', 5),
(116, 9, '\nAku ingin mencintaimu dengan sederhana: dengan isyarat yang tak sempat disampaikan awan kepada hujan yang menjadikannya tiada', '2013-05-24 10:41:19', 115, '2', NULL),
(117, 7, 'kau adalahhh anugrah terindaaaahhh yang pernah kutemuii ~~~~ :p', '2013-05-24 10:49:27', 115, '2', NULL),
(118, 7, 'www.google.com', '2013-05-24 10:51:04', 115, '2', NULL),
(119, 7, 'http://buku-kuliah.com/betalive/view.php?p=halaman-utama.tpt', '2013-05-24 10:51:17', 115, '2', NULL),
(120, 7, '<a href="www.google.com"></a>', '2013-05-24 10:52:05', 115, '2', NULL),
(121, 7, '"<div class=''feed'' style=''display:none''> \\', '2013-05-24 10:53:08', 115, '2', NULL),
(122, 7, '<a href="www.google.com">google</a>', '2013-05-24 10:54:09', 115, '2', NULL),
(123, 7, '</div>', '2013-05-24 10:54:29', 115, '2', NULL),
(124, 5, '<a href="hwttp://google.com"></a></div>', '2013-05-24 10:54:31', NULL, '1', 5),
(125, 5, 'hyaaaaaaaa hahaha hahahahahah', '2013-05-24 11:01:56', NULL, '1', 9),
(126, 5, 'okey guys, UATing', '2013-05-24 11:02:15', NULL, '1', 9),
(127, 5, 'Saya baru saja menambahkan Bendungan Katulampa: trilogy perjuangan kebangkitan Nasional', '2013-05-24 11:03:03', NULL, '1', 4),
(128, 5, 'hjsahfqfg', '2013-05-24 11:11:38', 127, '2', NULL),
(129, 5, '""', '2013-05-24 11:12:24', 127, '2', NULL),
(130, 4, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=63''>"Chemistry"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 11:30:05', NULL, '0', NULL),
(131, 4, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=64''>"Chemisrty"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 11:31:57', NULL, '0', NULL),
(132, 4, 'Saya baru saja menghapus buku Chemistry dari direpositori saya.', '2013-05-24 11:32:31', NULL, '0', NULL),
(133, 21, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=65''>"Arsitektur Interior"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 11:59:00', NULL, '0', NULL),
(134, 21, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=66''>"L\\''s Bravo Viewtiful"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 12:23:24', NULL, '0', NULL),
(135, 21, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=67''>"Sistem Operasi"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 12:33:32', NULL, '0', NULL),
(136, 21, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=68''>"buat dihapus"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 12:47:58', NULL, '0', NULL),
(137, 21, 'Saya baru saja menghapus buku buat dihapus dari direpositori saya.', '2013-05-24 12:49:44', NULL, '0', NULL),
(138, 5, '""', '2013-05-24 13:02:27', 137, '2', NULL),
(139, 5, 'http://www.fooo.com', '2013-05-24 13:02:45', 137, '2', NULL),
(140, 21, 'apaan sih', '2013-05-24 13:15:03', 137, '2', NULL),
(141, 21, 'Halo warga Jaya pura', '2013-05-24 13:15:22', NULL, '1', 9),
(142, 21, 'Yah kok dihapus??', '2013-05-24 13:16:34', 132, '2', NULL),
(143, 4, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=69''>"How To make Yourself Happy"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 13:43:55', NULL, '0', NULL),
(144, 4, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=70''>"Troubleshooting You Web Page"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 13:45:11', NULL, '0', NULL),
(145, 4, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=71''>"Pengantar Komputasi Numerik"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-24 13:47:33', NULL, '0', NULL),
(146, 7, 'OK', '2013-05-25 00:15:04', 66, '2', NULL),
(147, 1, 'Kalo ada bugs, laporin ke gw jam 11++ ya..\nvia telfon, sms, atau media apalah itu...', '2013-05-25 00:37:07', NULL, '1', 7),
(148, 5, 'udah siap tuh lihat komplainnya', '2013-05-25 01:49:47', NULL, '1', 22),
(149, 5, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=72''>"89"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-25 01:54:46', NULL, '0', NULL),
(150, 5, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=73''>"Al-Kahfi"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-25 02:08:29', NULL, '0', NULL),
(151, 24, 'adakah buku Analisis Numerik?', '2013-05-25 05:26:09', NULL, '1', 8),
(152, 4, 'mau yang mana?', '2013-05-25 05:57:18', 151, '2', NULL),
(153, 4, 'mau yang mana?', '2013-05-25 05:58:55', 151, '2', NULL),
(154, 1, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=74''>"dummy book"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-25 06:11:24', NULL, '0', 7),
(155, 4, 'hay, pinjem dun', '2013-05-25 06:14:16', 154, '2', NULL),
(156, 4, 'lllllla\n', '2013-05-25 06:14:38', 154, '2', NULL),
(157, 23, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=75''>"how to program"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-25 06:26:30', NULL, '0', 7),
(158, 23, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=76''>"how to program"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-25 06:26:30', NULL, '0', 7),
(159, 25, 'ada yang jomblo hari ini?', '2013-05-25 06:43:27', NULL, '1', 5),
(160, 25, 'wow banget coy', '2013-05-25 06:46:41', 154, '2', NULL),
(161, 25, 'w', '2013-05-25 06:48:32', 154, '2', NULL),
(162, 25, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=77''>"jkljlk7"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-25 07:15:56', NULL, '0', 5),
(163, 25, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=78''>"ini coba"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-05-25 07:18:50', NULL, '0', 5),
(164, 25, 'komen gaib abad ini', '2013-05-25 07:22:49', 163, '2', NULL),
(165, 7, 'gaibnya coba ilang', '2013-05-25 07:23:18', 163, '2', NULL),
(166, 7, 'untuku gaib', '2013-05-25 07:23:26', NULL, '1', 5),
(167, 25, 'coba komen', '2013-05-25 07:23:39', 166, '2', NULL),
(168, 7, 'lalalala', '2013-05-25 07:23:55', 166, '2', NULL),
(169, 26, 'jhjhkj jjj', '2013-05-25 07:29:22', NULL, '1', 1),
(170, 1, 'Buat teman2 lain yang udah daftar terus nggak bisa login, maaf ya...\nSoalnya sekarang lagi kami "tutup" sistemnya,, masih banyak bug soalnya,,,', '2013-05-25 13:27:15', NULL, '1', 7),
(171, 23, 'I''ll forward this to all crews of uss enterprise, captain.', '2013-05-25 22:28:40', 170, '2', NULL),
(172, 1, 'Nice. Thank you captain...', '2013-05-25 22:33:16', 170, '2', NULL),
(173, 23, 'Tes notifikasi...', '2013-05-25 22:33:51', 145, '2', NULL),
(174, 23, 'tes buat fitur notifikasi', '2013-05-25 22:34:14', 127, '2', NULL),
(175, 1, 'Saya baru saja memberi resensi untuk buku berjudul "Physics in Fiction"', '2013-05-25 22:41:54', NULL, '0', 7),
(176, 9, 'Saya baru saja menghapus buku Dora The You Don\\\\\\\\\\\\\\''t Say dari direpositori saya.', '2013-05-26 13:04:52', NULL, '0', 5),
(177, 9, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=79''>"Introduction to Game Development"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resen', '2013-05-26 13:11:42', NULL, '0', 5),
(178, 1, 'Ini kok bnyak bgt backslashnya pyong??? ', '2013-05-26 21:56:28', 176, '2', NULL),
(179, 28, 'who is the captain anyway??', '2013-05-27 01:29:53', 170, '2', NULL),
(180, 5, 'Saya baru saja memberi resensi untuk buku berjudul "Physics in Fiction"', '2013-05-27 14:03:33', NULL, '0', 22),
(181, 5, 'ada2', '2013-05-27 14:13:56', 151, '2', NULL),
(182, 5, 'modus', '2013-05-27 14:14:13', 145, '2', NULL),
(183, 7, 'Adakah yang punya buku "Introduction to Histology"', '2013-05-28 04:55:20', NULL, '1', 5),
(184, 9, 'itu kayanye gara-gara ada ''', '2013-05-28 05:56:18', 176, '2', NULL),
(185, 9, 'nah â™¥ ', '2013-05-28 05:57:15', 145, '2', NULL),
(186, 28, 'tes notifikasi....', '2013-05-28 06:07:35', 175, '2', NULL),
(187, 1, 'ok...', '2013-05-28 06:08:44', 175, '2', NULL),
(188, 23, 'Ada buku ''daa'' nggak???', '2013-05-28 06:20:01', NULL, '1', 7),
(189, 23, 'Ada buku daa nggak didepok??', '2013-05-28 06:20:39', NULL, '1', 7),
(190, 23, 'tes tes tes ', '2013-05-28 06:21:10', NULL, '1', 7),
(191, 23, 'tes tes tes ', '2013-05-28 06:21:25', NULL, '1', 7),
(192, 7, 'ada, hubungi nempyong...', '2013-05-28 06:22:27', 189, '2', NULL),
(193, 9, 'Saya baru saja memberi resensi untuk buku berjudul "Klingon Dictionary"', '2013-05-29 13:10:02', NULL, '0', 5),
(194, 7, 'marko, buku saya ga dibalikin nih ;)', '2013-05-29 13:11:18', 193, '2', NULL),
(195, 9, 'lah kan udah. kok amnesia sih -_-', '2013-05-29 13:11:56', 193, '2', NULL),
(196, 29, 'Saya baru saja menambahkan buku berjudul <a href=''controller.php?dispatch=info-buku&id=80''>"Morfologi"</a> direpositori saya. Lihat profil saya untuk memberikan rating dan resensi.', '2013-06-02 14:56:06', NULL, '0', 1),
(197, 29, 'Saya baru saja menghapus buku Morfologi dari direpositori saya.', '2013-06-02 15:13:34', NULL, '0', 1),
(198, 29, 'Saya baru saja memberi resensi untuk buku berjudul "How To make Yourself Happy"', '2013-06-02 15:15:32', NULL, '0', 1),
(199, 29, 'saya sedang mencari buku tentang Kriptografi dan keamanan informasi. Ada yang punya?', '2013-06-02 15:22:29', NULL, '1', 1),
(200, 29, 'saya boleh pinjam bukunya?', '2013-06-02 15:26:23', 177, '2', NULL),
(201, 4, 'Saya punya, tapi sedang dipinjam orang lain. Kemungkinan minggu depan dibalikin', '2013-06-02 15:40:53', 199, '2', NULL),
(202, 7, 'ada yang punya buku tentang CMMI DEV?', '2013-11-20 03:18:26', NULL, '1', 0),
(203, 7, 'ada yang punya buku tentang CMMI DEV?', '2013-11-20 03:18:36', NULL, '1', 0),
(204, 7, 'Saya baru saja memberi resensi untuk buku berjudul "89"', '2013-11-20 03:22:15', NULL, '0', 0),
(205, 7, 'Mungkin ada yang punya buku tentang CMMI Dev?', '2013-11-20 03:23:52', NULL, '1', 0),
(206, 7, 'Mungkin ada yang punya buku tentang CMMI Dev?', '2013-11-20 03:25:44', NULL, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `follow_feed`
--

CREATE TABLE IF NOT EXISTS `follow_feed` (
  `id_user` int(11) NOT NULL,
  `id_feed` int(11) NOT NULL,
  UNIQUE KEY `id_user` (`id_user`,`id_feed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `follow_feed`
--

INSERT INTO `follow_feed` (`id_user`, `id_feed`) VALUES
(1, 176),
(4, 199),
(5, 145),
(5, 151),
(7, 189),
(7, 193),
(9, 145),
(23, 127),
(23, 145),
(23, 170),
(28, 170),
(28, 175),
(29, 177);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE IF NOT EXISTS `kategori` (
  `IDKategori` int(10) NOT NULL AUTO_INCREMENT,
  `Nama_kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`IDKategori`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`IDKategori`, `Nama_kategori`) VALUES
(11, 'Teknik Mesin & Dirgantara'),
(10, 'Pertambangan & Perminyakan'),
(9, 'Farmasi'),
(8, 'Agrikultur & Kehutanan'),
(7, 'Ekonomi & Manajemen'),
(6, 'Arsitektur & Desain'),
(5, 'Elektro & Informatika'),
(4, 'Ilmu Hukum'),
(3, 'Ilmu Budaya& Sastra'),
(2, 'Sosial & Politik'),
(1, 'MIPA'),
(12, 'Ilmu Kebumian & Astronomi'),
(13, 'Teknik Industri'),
(14, 'Teknik Sipil & Lingkungan'),
(15, 'Pertanian & Peternakan'),
(16, 'Psikologi'),
(17, 'Administrasi Negara'),
(18, 'Pendidikan & Ilmu Keguruan'),
(19, 'Kedokteran & Kesehatan'),
(20, 'Ilmu Agama');

-- --------------------------------------------------------

--
-- Table structure for table `keluhan`
--

CREATE TABLE IF NOT EXISTS `keluhan` (
  `ID` int(10) NOT NULL COMMENT 'Foreign key terhadap AKTOR_SISTEM',
  `IDKeluhan` int(10) NOT NULL AUTO_INCREMENT,
  `Isi_Keluhan` text NOT NULL,
  `Waktu_Keluhan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IDPenerima` int(11) NOT NULL COMMENT 'Foreign key terhadap ID pengguna',
  `status_keluhan` enum('solved','not solved') NOT NULL DEFAULT 'not solved',
  PRIMARY KEY (`IDKeluhan`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `keluhan`
--

INSERT INTO `keluhan` (`ID`, `IDKeluhan`, `Isi_Keluhan`, `Waktu_Keluhan`, `IDPenerima`, `status_keluhan`) VALUES
(1, 1, '[irfan92] tes tes tes', '2013-05-22 10:09:16', 0, 'not solved'),
(9, 49, 'user ini spam inbox saya :\\''(', '2013-05-29 12:53:58', 5, 'not solved'),
(1, 3, 'buku saya ndak dipulangin min...', '2013-05-22 10:10:07', 5, 'solved'),
(4, 4, '[ahmadahfa] itu udah dibikin template block, delete, sama newsfeed', '2013-05-22 10:11:15', 0, 'not solved'),
(4, 6, '[irfan92] itu subject buat system\\''s bug harus diisi nama???\r\nga kan? \r\ncuma ngetesss', '2013-05-22 10:17:48', 0, 'not solved'),
(23, 48, 'Buku saya tidak dipulangin,...', '2013-05-28 06:23:58', 9, 'solved'),
(5, 8, '[jok] hgjkg,jh', '2013-05-22 11:11:21', 0, 'not solved'),
(4, 9, '[ahmadahfa] dasgagagafdsgdsgs', '2013-05-23 05:29:19', 0, 'not solved'),
(5, 11, '[sistem] kkkkjjjj', '2013-05-24 07:30:57', 0, 'not solved'),
(4, 12, '[pjn] bmjbnm,l', '2013-05-24 08:05:15', 0, 'not solved'),
(4, 13, '[lala] saclfmas;lfm\\''aspofc', '2013-05-24 08:12:16', 0, 'solved'),
(4, 14, '[czxcZ] cxzcXC', '2013-05-24 08:15:04', 0, 'not solved'),
(4, 15, '[mau complaint] alalalalaala', '2013-05-24 10:28:01', 0, 'not solved'),
(1, 16, '[alsdlaskdjlasj] lkjllkasjldkajsdlkjasljlaskjlkasjldkjsaldkjasaskdjasl', '2013-05-24 12:29:30', 0, 'not solved'),
(21, 17, '[ngebug] min ini masih ngebug looo', '2013-05-24 13:01:43', 0, 'not solved'),
(21, 18, 'ini orang emang ngeselin parah Min, ngejunk mulu tuh di chat hahah', '2013-05-24 13:02:24', 2, 'not solved'),
(4, 30, 'Saya tidak suka dengan tampilannya Min', '2013-05-24 14:18:56', 2, 'solved'),
(9, 50, 'orang ini kok bukunya ada yang aneh', '2013-05-29 13:09:04', 5, 'not solved'),
(21, 33, 'PPL uyeaaahhhhh, dummy dummy dummy', '2013-05-24 03:08:12', 2, 'solved'),
(3, 34, 'buku kuliah dot com is so coool', '2013-05-28 23:09:39', 4, 'solved'),
(15, 38, 'ini diaaa ngasal parah', '2013-05-23 20:20:25', 0, 'not solved'),
(15, 39, 'Admini admin admin admin', '2013-05-20 19:16:25', 0, 'not solved'),
(4, 40, 'sdjksdcnmxzncdsoifv;sdfvisdo[fvsdv', '2013-05-22 17:00:25', 0, 'not solved'),
(29, 51, 'dia sering sekali ngejunk di newsfeed >,<', '2013-06-02 15:29:11', 5, 'solved'),
(29, 52, '[saran] Min, saran buat fitur online chatnya ya, dibagusin lagi :)', '2013-06-02 15:30:38', 0, 'not solved');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE IF NOT EXISTS `log_aktivitas` (
  `IDAktivitas` int(10) NOT NULL AUTO_INCREMENT,
  `ID` int(11) NOT NULL COMMENT 'Foreign key terhadap aktor_sistem',
  `IsiAktivitas` text NOT NULL,
  `WaktuAktivitas` datetime NOT NULL,
  PRIMARY KEY (`IDAktivitas`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE IF NOT EXISTS `lokasi` (
  `id_lokasi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(50) NOT NULL,
  PRIMARY KEY (`id_lokasi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`) VALUES
(1, 'Ambon'),
(2, 'Banda Aceh'),
(3, 'Bandar Lampung'),
(4, 'Bandung'),
(5, 'Banjarmasin'),
(6, 'Bengkulu'),
(7, 'Depok'),
(8, 'Jakarta'),
(9, 'Jayapura'),
(10, 'Kupang'),
(11, 'Makasar'),
(12, 'Manado'),
(13, 'Mataram'),
(14, 'Medan'),
(15, 'Padang'),
(16, 'Palangkaraya'),
(17, 'Palembang'),
(18, 'Palu'),
(19, 'Pekanbaru'),
(20, 'Pontianak'),
(21, 'Semarang'),
(22, 'Surabaya'),
(23, 'Yogyakarta');

-- --------------------------------------------------------

--
-- Table structure for table `memiliki_kategori`
--

CREATE TABLE IF NOT EXISTS `memiliki_kategori` (
  `IDBuku` int(10) NOT NULL COMMENT 'Foreign key terhdap BUKU',
  `IDKategori` int(10) NOT NULL COMMENT 'Foreign key terhadap KATEGORI',
  KEY `IDKategori` (`IDKategori`),
  KEY `IDBuku` (`IDBuku`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memiliki_kategori`
--

INSERT INTO `memiliki_kategori` (`IDBuku`, `IDKategori`) VALUES
(24, 11),
(70, 5),
(72, 14),
(20, 5),
(59, 3),
(59, 5),
(18, 5),
(18, 8),
(18, 10),
(73, 20),
(71, 5),
(1, 8),
(1, 10),
(1, 11),
(24, 5),
(24, 13),
(27, 2),
(28, 1),
(29, 1),
(66, 10),
(31, 7),
(32, 6),
(34, 6),
(34, 5),
(35, 6),
(35, 5),
(36, 10),
(36, 9),
(37, 1),
(37, 5),
(72, 13),
(72, 1),
(72, 12),
(65, 6),
(45, 19),
(79, 5),
(69, 16),
(62, 2),
(62, 1),
(62, 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id_notif` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_pemberi` int(11) NOT NULL,
  `id_obj` int(11) NOT NULL,
  `tipe_notif` enum('review','feed','follow') NOT NULL,
  `waktu_notif` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_notif` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_notif`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notif`, `id_user`, `id_pemberi`, `id_obj`, `tipe_notif`, `waktu_notif`, `status_notif`) VALUES
(1, 1, 23, 170, 'feed', '2013-05-25 22:28:40', '1'),
(2, 23, 1, 170, 'follow', '2013-05-25 22:33:16', '1'),
(3, 4, 23, 145, 'feed', '2013-05-25 22:33:51', '0'),
(4, 5, 23, 127, 'feed', '2013-05-25 22:34:14', '1'),
(5, 5, 1, 62, 'review', '2013-05-25 22:41:54', '1'),
(6, 9, 1, 176, 'feed', '2013-05-26 21:56:28', '1'),
(7, 23, 28, 170, 'follow', '2013-05-27 01:29:53', '1'),
(8, 1, 28, 170, 'feed', '2013-05-27 01:29:53', '1'),
(9, 24, 5, 151, 'feed', '2013-05-27 14:13:56', '0'),
(10, 23, 5, 145, 'follow', '2013-05-27 14:14:13', '0'),
(11, 4, 5, 145, 'feed', '2013-05-27 14:14:13', '0'),
(12, 1, 9, 176, 'follow', '2013-05-28 05:56:18', '1'),
(13, 5, 9, 145, 'follow', '2013-05-28 05:57:15', '0'),
(14, 23, 9, 145, 'follow', '2013-05-28 05:57:15', '0'),
(15, 4, 9, 145, 'feed', '2013-05-28 05:57:15', '0'),
(16, 1, 28, 175, 'feed', '2013-05-28 06:07:35', '1'),
(17, 28, 1, 175, 'follow', '2013-05-28 06:08:44', '1'),
(18, 23, 7, 189, 'feed', '2013-05-28 06:22:27', '1'),
(19, 1, 9, 59, 'review', '2013-05-29 13:10:02', '1'),
(20, 9, 7, 193, 'feed', '2013-05-29 13:11:18', '1'),
(21, 7, 9, 193, 'follow', '2013-05-29 13:11:56', '1'),
(22, 4, 29, 69, 'review', '2013-06-02 15:15:32', '0'),
(23, 9, 29, 177, 'feed', '2013-06-02 15:26:23', '0'),
(24, 29, 4, 199, 'feed', '2013-06-02 15:40:53', '1'),
(25, 5, 7, 72, 'review', '2013-11-20 03:22:16', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE IF NOT EXISTS `pesan` (
  `ID` int(10) NOT NULL COMMENT 'Foreign key terhadap aktor_sistem',
  `IDPesan` int(10) NOT NULL AUTO_INCREMENT,
  `Isi_Pesan` text NOT NULL,
  `Status_Pesan` tinyint(1) NOT NULL,
  `Waktu_Pesan` datetime NOT NULL,
  `IDPenerima` int(10) NOT NULL COMMENT 'Foreign key terhadap aktor_sistem',
  PRIMARY KEY (`IDPesan`),
  KEY `ID` (`ID`),
  KEY `IDPenerima` (`IDPenerima`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`ID`, `IDPesan`, `Isi_Pesan`, `Status_Pesan`, `Waktu_Pesan`, `IDPenerima`) VALUES
(1, 10, 'Hai fan.....', 1, '2013-04-08 11:26:12', 1),
(2, 16, 'Me gabutsta', 1, '2013-04-09 02:15:40', 1),
(4, 17, 'ini ngetes aja Fan hehe', 1, '2013-04-12 14:45:33', 1),
(4, 21, 'testing lagi\\r\\n', 1, '2013-04-13 11:29:37', 1),
(4, 22, 'Salam kenal balik eaaaaaak :p', 1, '2013-04-13 11:45:59', 5),
(2, 23, 'review buku calculus lu typo cuy', 1, '2013-04-13 21:48:56', 5),
(7, 24, '[Pemblokiran Akun] Selamat malam, saudara irfan.\\r\\nDengan ini kami laporkan bahwa akun anda telah kami blokir selama tiga hari terhitung sejak hari ini pukul 00:08 atas laporan penyalahgunaan pinjaman buku. \\r\\n\\r\\nJika laporan tsb tidak benar, silahkan hubungi kami segera agar dapat kami proses secepatnya. Terima kasih.\\r\\n\\r\\n\\r\\n==========\\r\\nModerator\\r\\n==========', 1, '2013-04-14 00:10:42', 1),
(1, 25, '[[Pemblokiran Akun]] Selamat malam, saudara irfan.rnDengan ini kami laporkan bahwa akun anda telah kami blokir selama tiga hari terhitung sejak hari ini pukul 00:08 atas laporan penyalahgunaan pinjaman buku.rnrnJika laporan tsb tidak benar, silahkan hubungi kami segera agar dapat kami proses secepatnya. Terima kasih.rnrnrn==========rnModeratorrn==========', 1, '2013-04-14 00:25:05', 7),
(7, 26, '[aaaa] tes <br />rntes', 1, '2013-04-14 00:27:30', 7),
(7, 27, '[[Pemblokiran Akun]] Selamat malam, saudara ahmad.\\r\\nDengan ini kami laporkan bahwa akun anda telah kami blokir selama tiga hari terhitung sejak hari ini pukul 00:08 atas laporan penyalahgunaan pinjaman buku. \\r\\n\\r\\nJika laporan tsb tidak benar, silahkan hubungi kami segera agar dapat kami proses secepatnya. Terima kasih.\\r\\n\\r\\n\\r\\n==========\\r\\nModerator\\r\\n==========', 1, '2013-04-14 00:55:17', 5),
(1, 30, '[Tes Pesan] Siapa ini?', 1, '2013-04-14 01:15:50', 9),
(9, 31, '[[Tes Pesan]] Kaka lupa sama Marissa yah :\\\\\\''((\\r\\n\\r\\nReply ngga dialihin ke halaman ini aja juga?\\r\\nisi \\\\\\''to\\\\\\''-nya ke si yang ngirim, subject \\\\\\"[reply] subject pesan yang dibales\\\\\\"?', 1, '2013-04-14 01:23:33', 1),
(4, 33, '[tess] tesstesstess, ngebug gaaa????', 1, '2013-04-14 13:22:02', 5),
(7, 37, '[lalla] test', 1, '2013-04-14 17:30:55', 7),
(7, 38, '[Sabar] Sabar ya,maklum sistemnya baru jadi', 1, '2013-04-14 17:31:30', 5),
(5, 39, '[Terima Kasih] Oke Admin', 1, '2013-04-14 17:33:22', 7),
(1, 40, '[Tes tes tes] halo fan', 1, '2013-04-14 18:01:02', 1),
(5, 41, '[testing] saya sedang UAT fitur pesan', 1, '2013-04-14 19:21:00', 7),
(7, 42, '[Pemblokiran Akun] Melalui pesan ini, kami beritahukan bahwa akun anda telah kami blokir.\\r\\n\\r\\n\\r\\n===========\\r\\nAdministrator\\r\\n===========', 1, '2013-04-15 00:10:09', 1),
(2, 46, '[Itu fitnah!] No admin no! Itu fitnah! >:\\\\\\''(', 1, '2013-04-16 12:34:30', 7),
(2, 47, '[[buku Fractal]] yah bukan buku mar', 1, '2013-04-16 12:36:08', 9),
(2, 48, '[Terserah dyta] Proud of you', 1, '2013-04-16 12:39:01', 5),
(2, 49, '[[Account dibajak]] Account saya dibajak itu min kemarin.\\r\\nUkh kok saya terus sih min <:\\\\\\''(', 1, '2013-04-16 12:41:59', 7),
(4, 51, '[REPLY MESSAGE] fsdgfdsgf', 1, '2013-04-16 12:50:32', 5),
(1, 52, '[REPLY MESSAGE] Hallo fan....', 1, '2013-04-16 12:51:46', 1),
(12, 54, '[Halo] :*', 1, '2013-04-16 14:11:00', 5),
(12, 55, '[Hai Lagi] Haaai', 1, '2013-04-16 14:11:48', 5),
(12, 56, '[       ]      ', 1, '2013-04-16 14:14:07', 5),
(12, 57, '[hai ganteng] Haaai', 1, '2013-04-16 14:15:00', 12),
(12, 58, '[REPLY MESSAGE] hai juggaa', 1, '2013-04-16 14:15:44', 12),
(14, 59, '[hay] salam kenal', 1, '2013-04-16 20:11:52', 5),
(3, 60, '[Salam Kenal] Hay', 1, '2013-04-16 20:25:19', 9),
(9, 61, '[REPLY MESSAGE] Hay juga...\\r\\nKamu anak mana yaaa :D', 1, '2013-04-16 20:26:11', 3),
(3, 62, '[REPLY MESSAGE] jkt, asl pls?', 1, '2013-04-16 20:27:19', 9),
(9, 63, '[haaah?] Aduuuh maksud kamu apa sih :0\\r\\nI dun undelztand ( \\\\\\''3\\\\\\'')', 1, '2013-04-16 20:29:52', 3),
(3, 64, 'agfav ', 1, '2013-04-16 20:35:24', 5),
(4, 66, 'hahahaha', 1, '2013-04-16 21:03:32', 9),
(4, 68, 'sjbfsaobfoaiwshf0[wqafawsf', 1, '2013-04-16 21:21:44', 9),
(5, 69, '00000', 1, '2013-04-16 21:21:51', 5),
(4, 71, 'trus gue mesti bilang wooww gitu??', 1, '2013-04-16 21:23:37', 9),
(4, 72, 'kemana aja boyeeeeee XD', 1, '2013-04-16 21:24:16', 5),
(1, 74, 'Tes 1 2 3 <script>alert(hahaha);</script>', 1, '2013-04-17 22:12:28', 1),
(7, 76, '<a href=\\\\\\"http://google.com\\\\\\">LaLAL</a>', 1, '2013-04-17 23:00:02', 5),
(1, 77, 'Ngapaen lu??', 1, '2013-04-18 00:29:13', 1),
(1, 78, 'tes beberapa karakter', 1, '2013-04-18 01:37:17', 1),
(2, 80, 'mar baca ini dong :3\\r\\nhttp://2.bp.blogspot.com/-eLcDgTEc3_s/USOsZX4ZSaI/AAAAAAAAAJo/ABL4mGoKzxE/s1600/Lolita_Vladimir_Nabokov_unabridged_Jeremy_Irons_compact_discs.jpg\\r\\nkul parah', 1, '2013-04-18 12:29:02', 9),
(9, 120, '[pinjam buku] pinjam buku how to be happynya dong :)', 1, '2013-05-29 20:07:46', 4),
(17, 82, 'Selamat malam saudara irfan.\\r\\n\\r\\nSaya fans berat anda', 1, '2013-04-18 12:46:08', 1),
(2, 83, 'moomomomomomo', 1, '2013-04-18 12:46:29', 9),
(2, 84, '                                        ', 1, '2013-04-18 12:48:46', 9),
(17, 87, '[Tes buat UAT] Halo fan,, pa kbar??', 1, '2013-04-18 12:51:21', 1),
(17, 89, '[REPLY MESSAGE] asdasdasdasdasdasdasasdasd', 1, '2013-04-18 13:03:05', 1),
(17, 91, '[REPLY MESSAGE] tes\\r\\ntes\\r\\ntes\\r\\ntes\\r\\ntes', 1, '2013-04-18 13:12:44', 1),
(17, 92, '[REPLY MESSAGE] tes tes tes tes', 1, '2013-04-18 13:14:26', 1),
(17, 93, '[REPLY MESSAGE] tes\\r\\ntes\\r\\ntes\\r\\n\\r\\ntes\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\ntes\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\ntes', 1, '2013-04-18 13:18:25', 1),
(2, 95, '[REPLY MESSAGE] yang di FB sempet liatkah?\\r\\n1) yang tadi gue bilang, pas daftar buku sama edit buku, publisher bisa spasi semua\\r\\n2) message kosong = subject+content spasi semua\\r\\n3) sekali, cuma sekali, pas save ngedit buku ntagh kenapa kelempar ke halaman utama \\\\\\"You\\\\\\''re not authorized\\\\\\"', 1, '2013-04-18 13:26:45', 1),
(2, 96, '[REPLY MESSAGE] sip uda fix semua yang tadi gue tanya', 1, '2013-04-18 13:29:09', 1),
(2, 97, '[nanananana] siapa saya siapa kamu', 1, '2013-04-18 13:29:59', 9),
(2, 99, '[REPLY MESSAGE] nah itulah\\r\\ngue lupa karena gue ngerasa ngga melakukan sesuatu yang aneh\\r\\ntapi dari berkali-kali ngutak-ngatik buku ngga pernah nyasar lagi tuh', 1, '2013-04-18 13:43:17', 1),
(7, 107, '[keren] kereeen', 0, '2013-05-24 19:22:33', 5),
(1, 102, '[tes tes] tes\\r\\ntes\\r\\ntes\\r\\n\\r\\n\\r\\ntes\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\ntes', 1, '2013-04-21 17:44:53', 1),
(23, 114, '[REPLY MESSAGE] kok kok', 1, '2013-05-25 13:32:21', 7),
(9, 119, '[pinjam buku] hai firlia, pinjam bukunya yang how to be happy dong. Saya juga di Depok :)', 1, '2013-05-29 19:53:23', 4),
(1, 104, '[[penghapusan akun]] tes tes tes', 0, '2013-04-25 10:41:53', 11),
(5, 105, '[Permohonan Internship] gfh hgfh', 1, '2013-04-25 14:08:16', 7),
(5, 106, '[REPLY MESSAGE] hdhhgfghf', 0, '2013-04-25 14:09:01', 14),
(7, 108, '[suka suka] </div>', 1, '2013-05-24 19:27:15', 5),
(21, 109, '[UAT2 uooooooo] haloooooooooooooo', 1, '2013-05-24 19:53:58', 5),
(5, 111, '[REPLY MESSAGE] hy galang', 1, '2013-05-24 19:59:45', 21),
(5, 112, '[REPLY MESSAGE] hay galang 2', 1, '2013-05-24 20:00:00', 21),
(29, 121, '[Mau pinjam buku] Halo Markonah mau pinjam buku yang judulnya The Science of Fractal Image donk :)', 0, '2013-06-02 22:09:12', 9),
(4, 122, '[pinjam buku] Mau pinjam buku kamu yang Morfologi itu dong :)', 1, '2013-06-02 22:43:05', 29),
(29, 123, '[REPLY MESSAGE] oh, oke boleh kok.', 0, '2013-06-02 22:48:16', 4);

-- --------------------------------------------------------

--
-- Table structure for table `rater_buku`
--

CREATE TABLE IF NOT EXISTS `rater_buku` (
  `IDBuku` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  PRIMARY KEY (`IDBuku`,`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rater_buku`
--

INSERT INTO `rater_buku` (`IDBuku`, `ID`) VALUES
(1, 1),
(1, 5),
(1, 7),
(1, 9),
(1, 13),
(8, 1),
(14, 5),
(14, 7),
(15, 4),
(15, 7),
(17, 1),
(17, 7),
(19, 5),
(20, 4),
(20, 5),
(21, 2),
(22, 1),
(24, 5),
(26, 2),
(26, 5),
(26, 7),
(27, 1),
(27, 9),
(28, 1),
(28, 9),
(29, 1),
(29, 9),
(32, 5),
(33, 1),
(37, 1),
(37, 9),
(41, 12),
(42, 12),
(45, 14),
(48, 3),
(48, 4),
(51, 1),
(51, 2),
(51, 9),
(52, 17),
(54, 2),
(59, 1),
(60, 2),
(62, 7),
(67, 21),
(68, 21),
(69, 29),
(77, 23),
(79, 9);

-- --------------------------------------------------------

--
-- Table structure for table `rater_pengguna`
--

CREATE TABLE IF NOT EXISTS `rater_pengguna` (
  `IDPemberi` int(11) NOT NULL,
  `IDPenerima` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rater_pengguna`
--

INSERT INTO `rater_pengguna` (`IDPemberi`, `IDPenerima`) VALUES
(1, 2),
(17, 5),
(9, 2),
(1, 4),
(7, 1),
(4, 1),
(4, 2),
(4, 9),
(21, 4),
(7, 5),
(7, 17),
(7, 2),
(7, 23),
(21, 23),
(23, 21),
(7, 21),
(25, 21),
(7, 24),
(9, 4),
(29, 9),
(5, 29);

-- --------------------------------------------------------

--
-- Table structure for table `resensi`
--

CREATE TABLE IF NOT EXISTS `resensi` (
  `IDBuku` int(10) NOT NULL COMMENT 'Foreign key terhadap BUKU',
  `IDResensi` int(10) NOT NULL AUTO_INCREMENT,
  `IDPemberi` int(10) NOT NULL COMMENT 'Foreign key terhadap aktor_sistem, siapa yang ngasih resensi',
  `Isi_Resensi` text NOT NULL,
  `Waktu_Resensi` datetime NOT NULL,
  PRIMARY KEY (`IDResensi`),
  KEY `IDBuku` (`IDBuku`),
  KEY `IDPemberi` (`IDPemberi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `resensi`
--

INSERT INTO `resensi` (`IDBuku`, `IDResensi`, `IDPemberi`, `Isi_Resensi`, `Waktu_Resensi`) VALUES
(1, 1, 5, 'Buku ini sangat bagus, mudah dimengerti dan enak dibaca.', '2013-02-26 12:00:00'),
(2, 2, 1, 'Buku ini sangat bagus, visualisasinya menarik :)', '2012-04-09 12:11:20'),
(73, 106, 5, 'thats coool book', '2013-05-25 09:08:29'),
(12, 6, 1, 'Some random book i throw', '2013-04-09 17:36:02'),
(72, 105, 5, 'Perhitungan fisika quantum berdimensi 14 di ruang vektor menembus angkasa yang fantastis dan masih perlu eksperiment yang bersahabat.', '2013-05-25 08:54:46'),
(0, 13, 1, 'barney stinson banget... :)', '2013-04-12 22:40:05'),
(59, 117, 9, 'wah tampak menarik. sudah lama saya ingin jadi alien tapi bingung sama bahasanya :D', '2013-05-29 20:10:02'),
(18, 17, 1, 'Foto bukunya keren ya... Hahaha', '2013-04-13 01:42:20'),
(1, 18, 1, 'Terima kasih atas reviewnya. Btw buku ini kemaren anda yang pinjam kn ya?? kok belum dikembaliin   :|', '2013-04-13 06:18:59'),
(20, 21, 5, 'Simple Book, but really comprehensive', '2013-04-13 11:43:30'),
(24, 25, 5, 'A Beautiful Book', '2013-04-13 19:39:51'),
(27, 27, 9, 'Sebenarnya, kategori buku ini adalah filsafat. Buku yang wajib dibaca semua orang yang mempelajari ataupun menggemari filsafat.', '2013-04-14 01:04:47'),
(28, 28, 9, 'Buku yang harus dibaca oleh siapapun yang memiliki ketertarikan terhadap mekanika kuantum.', '2013-04-14 01:11:01'),
(29, 29, 9, 'Buku yang menarik, meskipun belum semenarik fractal itu sendiri.', '2013-04-14 01:15:55'),
(71, 103, 4, 'rumusnya sangat rumit ', '2013-05-24 20:47:33'),
(70, 102, 4, 'Buku yang sangat bagus', '2013-05-24 20:45:11'),
(69, 101, 4, 'Untuk kalian yang ga bahagia! baca ini!', '2013-05-24 20:43:55'),
(59, 84, 1, 'The official guide to klingon phrases and words.', '2013-05-24 02:35:30'),
(1, 36, 1, 'Buku ini sangat menarik', '2013-04-14 18:26:45'),
(62, 114, 1, 'Kayaknya bagus nih... pinjam donk (kalo beneran ada)...', '2013-05-26 05:41:54'),
(28, 38, 1, 'Buku ini sangat menarik.. Rate 5 dah...', '2013-04-14 19:07:49'),
(32, 39, 5, 'Graet Book in Auto CAD. Theory and practical. Really complete.', '2013-04-14 19:15:48'),
(62, 116, 5, '@Muhammad Boleh2, cek PM yaaaa :)', '2013-05-27 21:03:33'),
(34, 41, 5, 'Great Book', '2013-04-14 19:35:06'),
(35, 42, 5, 'Great Book', '2013-04-14 19:35:29'),
(36, 43, 1, 'Just a simple book', '2013-04-14 19:56:14'),
(37, 44, 1, 'No one brews up a better Java guide than Cay Horstmann and in this Third Edition of Big Java he''s perfected his recipe. Thoroughly updated to include Java 6, the Third Edition of Horstmann''s bestselling text helps you absorb computing concepts and programming principles, develop strong problem-solving skills, and become a better programmer, all while exploring the elements of Java that are needed to write real-life programs.A top-notch introductory text for beginners, "Big Java," Third Edition is also a thorough reference for students and professionals alike to Java technologies, Internet programming, database access, and many other areas of computer science.', '2013-04-14 22:13:54'),
(28, 83, 9, 'Daichuki daichuki daichuki', '2013-05-06 13:22:17'),
(79, 115, 9, 'Good intro to a game development world', '2013-05-26 20:11:42'),
(65, 90, 21, 'untuk interior rumah', '2013-05-24 18:59:00'),
(34, 63, 5, '<a href=#>Ref</a>', '2013-04-16 21:04:50'),
(34, 64, 5, '<a href=\\"http://www.google.com\\">Ref</a>', '2013-04-16 21:05:26'),
(34, 65, 5, '<img src=\\"images/icon.jpg\\" alt=\\"Smiley face\\" height=\\"42\\" width=\\"42\\">', '2013-04-16 21:06:15'),
(37, 66, 1, 'Coti ni yang dibawah gw... :)', '2013-04-17 21:56:47'),
(45, 57, 14, 'Masalah kesehatan bagi masyarakat umum masih sangat rawan. Walaupun pada beberapa tahun terakhir ini sejumlah penyakit menular tertentu dapat diatasi, timbul pula masalah baru dalam bidang kesehatan masyarakat baik yang berhubungan dengan penyakit menular dan tidak menular maupun yang erat hubungannya dengan gangguan kesehatan lainnya.\nDewasa ini banyak penyakit menular yang telah mampu diatasi bahkan dibasmi berkat kemajuan teknologi dalam mengatasi masalah lingkungan bilogis yang erat hubungannya dengan penyakit menular.', '2013-04-16 18:40:09'),
(62, 87, 5, 'Cool, you will find the real of you!', '2013-05-24 15:01:25'),
(59, 94, 5, '  bIlugh .  yIja\\''Qo\\''     ', '2013-05-24 19:09:51'),
(59, 95, 5, 'hmmmmmmmmmmmmmmmmm', '2013-05-24 19:10:36'),
(59, 96, 5, 'ini yg benarrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '2013-05-24 19:11:22'),
(66, 97, 21, 'Sangat bagus! Teope Begete', '2013-05-24 19:23:24'),
(69, 119, 29, 'Buku yang sangat menarik, wajib dibaca biar ga galau dan ngeluh terus-', '2013-06-02 22:15:32'),
(72, 120, 7, 'Walaupun ini buku udah lumayan lama, tapi ilmunya masih sangat relevan.\r\nSangat bagus untuk referensi perkuliahan.. :)', '2013-11-20 04:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `reset_data`
--

CREATE TABLE IF NOT EXISTS `reset_data` (
  `ID` int(11) NOT NULL,
  `Hash` varchar(20) NOT NULL,
  `Expire_Time` datetime NOT NULL,
  PRIMARY KEY (`Hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reset_data`
--

INSERT INTO `reset_data` (`ID`, `Hash`, `Expire_Time`) VALUES
(18, '2Ql0hLS3nNeO2PSfxZeN', '2013-04-18 14:41:34'),
(17, '3iKUdDFg6yAukPSCIbmu', '2013-04-18 11:56:12'),
(1, 'gmoJea4X69gUDfQxxzod', '2013-04-12 05:02:04'),
(4, 'kbUHAED7jgf5ibfh3LxA', '2013-04-16 18:12:01'),
(1, 'LQZ10lxULfAeBTVtZ4Zz', '2013-04-12 05:03:55'),
(4, 'o7ngSE1nX0MHF5jAvnbS', '2013-04-13 20:05:12'),
(4, 'PrdpzN8yS0b5nKQ1U4hr', '2013-04-13 19:58:01'),
(29, 'RKjdebCZXW8iYMCDctvs', '2013-06-02 23:14:18'),
(15, 'UjLdCdveTIU97G9XXd4J', '2013-04-18 11:48:46'),
(5, 'XaQQgdQVU3PKS8KfVpCu', '2013-04-13 20:14:45'),
(5, 'xPSojYGvOweGJI6imXR7', '2013-04-14 19:06:01'),
(20, 'XRP7u1JVL5JACKJx0WyV', '2013-05-24 14:19:18'),
(1, 'ZvAAqUjrllyYxzzNB0d0', '2013-05-27 15:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `sistem`
--

CREATE TABLE IF NOT EXISTS `sistem` (
  `ID` tinyint(4) NOT NULL,
  `mode` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sistem`
--

INSERT INTO `sistem` (`ID`, `mode`) VALUES
(0, 1),
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `Tag` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `IDBuku` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Foreign key terhadap BUKU',
  KEY `IDBuku` (`IDBuku`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`Tag`, `IDBuku`) VALUES
('Akuntansi', '6'),
('C++', '7'),
('Kalkulus', '4'),
('Kalkulus', '9'),
('Kebidanan', '11'),
('Kesehatan', '10'),
('Komunikasi', '1'),
('Komunikasi', '3'),
('Komunikasi', '5'),
('Matematika', '4'),
('Matematika', '9'),
('Organisasi', '1'),
('Organisasi', '3'),
('Organisasi', '5'),
('Pariwisata', '2'),
('Pemrograman', '7'),
('Perusahaan', '1'),
('Perusahaan', '5'),
('Array', '12'),
('cs', '13'),
(' math', '13'),
(' discrete', '13'),
(' startrek', '59'),
('klingon', '59'),
(' cs', '18'),
('ilkom', '18'),
(' geek', '59'),
('programming', '20'),
('ilmu komputer', '20'),
('Matematika', '71'),
(' Programming', '70'),
('foto', '23'),
('gambar', '23'),
('foto', '24'),
('gambar', '24'),
('it', '24'),
('editor', '24'),
('algorithm', '25'),
('filsafat', '27'),
('fisika', '28'),
(' mekanika kuantum', '28'),
(' matematika', '29'),
('fractal', '29'),
('Ekonomi', '31'),
(' Akuntansi', '31'),
('design', '32'),
('raster', '32'),
('interior', '32'),
('rancang bangun', '32'),
('design', '34'),
('raster', '34'),
('interior', '34'),
('rancang bangun', '34'),
('design', '35'),
('raster', '35'),
('interior', '35'),
('rancang bangun', '35'),
('dummy', '36'),
(' cinta', '72'),
(' programming', '37'),
('java', '37'),
(' cerita', '72'),
('kalkulus', '72'),
('oke', '73'),
('Korea', '66'),
('arsitektur', '65'),
('dokter', '45'),
('penyakit', '45'),
('kesehatan', '45'),
(' Gamedev', '79'),
('Game', '79'),
(' Infinite', '66'),
('Web', '70'),
('Psikologi', '69'),
('fisika', '62'),
(' dimensi', '62'),
(' galaxy', '62'),
(' Fotografi', '66');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
