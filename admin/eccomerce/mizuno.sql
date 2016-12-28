-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2016 at 09:56 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mizuno`
--

-- --------------------------------------------------------

--
-- Table structure for table `konfirmasi_bayar`
--

CREATE TABLE IF NOT EXISTS `konfirmasi_bayar` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idorder` int(10) NOT NULL,
  `nama_bank` varchar(200) NOT NULL,
  `atas_nama` varchar(200) NOT NULL,
  `norek` varchar(100) NOT NULL,
  `transferke` varchar(200) NOT NULL,
  `nominal` varchar(50) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE IF NOT EXISTS `order_detail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tokenpay` varchar(100) NOT NULL,
  `idproduct` int(10) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `iddetail` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `nama_detail` varchar(200) NOT NULL,
  `qty` mediumint(5) NOT NULL,
  `price` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `tokenpay`, `idproduct`, `sku`, `iddetail`, `name`, `nama_detail`, `qty`, `price`) VALUES
(1, '10000001', 1, 'JA100001', 11, 'Jogger Airflex Osaka', 'Green#38', 1, 419800),
(2, '10000001', 1, 'JA100001', 12, 'Jogger Airflex Osaka', 'Green#39', 1, 419800);

-- --------------------------------------------------------

--
-- Table structure for table `order_header`
--

CREATE TABLE IF NOT EXISTS `order_header` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `idmember` int(10) NOT NULL,
  `idbank` mediumint(3) NOT NULL,
  `payment_metod` varchar(100) NOT NULL,
  `orderamount` int(11) NOT NULL,
  `shippingcost` int(7) NOT NULL,
  `weight` mediumint(4) NOT NULL,
  `discountamount` double NOT NULL,
  `status_payment` varchar(50) NOT NULL,
  `status_delivery` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `kurir` varchar(100) NOT NULL,
  `resinumber` varchar(200) NOT NULL,
  `vouchercode` varchar(100) NOT NULL,
  `nama_penerima` varchar(200) NOT NULL,
  `phone_penerima` varchar(100) NOT NULL,
  `address_penerima` text NOT NULL,
  `country_penerima` varchar(100) NOT NULL,
  `provinsi_penerima` varchar(200) NOT NULL,
  `kabupaten_penerima` varchar(200) NOT NULL,
  `kota_penerima` varchar(200) NOT NULL,
  `tokenpay` varchar(100) NOT NULL,
  `bca_tokenid` varchar(30) NOT NULL,
  `kode_trxno_klikpay1` varchar(150) NOT NULL,
  `kode_trxno_klikpay2` varchar(150) NOT NULL,
  `kode_unik` int(4) NOT NULL,
  `konfirmasi_bayar_byadmin` mediumint(3) NOT NULL,
  `tanggal_konfirmasi` varchar(100) NOT NULL,
  `konfirmasi_kirim_byadmin` mediumint(3) NOT NULL,
  `tanggal_konfirmasi_kirim` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order_header`
--

INSERT INTO `order_header` (`id`, `date`, `idmember`, `idbank`, `payment_metod`, `orderamount`, `shippingcost`, `weight`, `discountamount`, `status_payment`, `status_delivery`, `note`, `kurir`, `resinumber`, `vouchercode`, `nama_penerima`, `phone_penerima`, `address_penerima`, `country_penerima`, `provinsi_penerima`, `kabupaten_penerima`, `kota_penerima`, `tokenpay`, `bca_tokenid`, `kode_trxno_klikpay1`, `kode_trxno_klikpay2`, `kode_unik`, `konfirmasi_bayar_byadmin`, `tanggal_konfirmasi`, `konfirmasi_kirim_byadmin`, `tanggal_konfirmasi_kirim`) VALUES
(1, '2016-01-19 10:11:00', 1, 1, 'BANK TRANSFER', 839600, 7000, 1, 100000, 'Confirmed', 'Shipped', 'cepat diproses', 'JNE REG', '100201000010', 'ABCD10001MZ', 'Ranto Lim', '08978353279', 'Kmp. kajangan ds.Gaga kec.Pakuhaji\r\nSepatan', 'Indonesia', 'Banten', 'Tangerang', '1', '10000001', '', '', '', 0, 1, '20-01-2016 10:12:52', 1, '20-01-2016 10:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `status_detailorder`
--

CREATE TABLE IF NOT EXISTS `status_detailorder` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idorder` int(10) NOT NULL,
  `description` text COLLATE latin1_general_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
