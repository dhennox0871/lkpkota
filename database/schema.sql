-- phpMyAdmin SQL Dump
-- Database: `db_lkpkota`

CREATE DATABASE IF NOT EXISTS `db_lkpkota`;
USE `db_lkpkota`;

-- --------------------------------------------------------

--
-- Table structure for table `lkp_institutions`
--

CREATE TABLE `lkp_institutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nilek` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` text,
  `leader_name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif',
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lkp_institutions`
--

INSERT INTO `lkp_institutions` (`id`, `nilek`, `name`, `address`, `leader_name`, `phone`, `email`, `website`, `status`, `logo`) VALUES
(1, '05103.4.1.0001', 'LKP Citra Komputer Malang', 'Jl. Guntur No.33, Oro Oro Dowo, Klojen, Kota Malang, Jawa Timur 65112', 'Admin Citra', '081234567890', 'info@lkpcitrakomputer.com', 'www.lkpcitrakomputer.com', 'Aktif', NULL),
(2, '05103.4.1.0002', 'LKP Wearnes Education Center Malang', 'Jl. Jakarta No.38, Penanggungan, Klojen, Kota Malang, Jawa Timur 65113', 'Budi Santoso', '0341555666', 'info@wearneseducation.com', 'www.wearneseducation.com', 'Aktif', NULL),
(3, '05103.4.1.0003', 'LKP Kampung Inggris Malang', 'Jl. MT. Haryono Ruko Dinoyo Permai, Kota Malang', 'Siti Aminah', '085612345678', 'hello@kampunginggrismalang.com', 'www.kampunginggrismalang.com', 'Aktif', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lkp_programs`
--

CREATE TABLE `lkp_programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lkp_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`lkp_id`) REFERENCES `lkp_institutions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lkp_programs`
--

INSERT INTO `lkp_programs` (`id`, `lkp_id`, `program_name`) VALUES
(1, 1, 'Desain Grafis'),
(2, 1, 'Administrasi Perkantoran'),
(3, 1, 'Digital Marketing / Social Media'),
(4, 1, 'AutoCAD'),
(5, 2, 'Informatika & Komputer'),
(6, 2, 'Robotika'),
(7, 3, 'TOEFL Preparation'),
(8, 3, 'Speaking English');
