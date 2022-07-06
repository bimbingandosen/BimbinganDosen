/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.5.9-MariaDB : Database - bimbingan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `bimbingan`;

/*Table structure for table `bimbingan` */

DROP TABLE IF EXISTS `bimbingan`;

CREATE TABLE `bimbingan` (
  `id_bimbingan` int(225) NOT NULL AUTO_INCREMENT,
  `tgl_pengajuan` datetime NOT NULL,
  `status_bimbingan` int(225) DEFAULT 0,
  `tgl_bimbingan` datetime DEFAULT NULL,
  `id_mahasiswa` int(225) DEFAULT NULL,
  `judul_bimbingan` text DEFAULT NULL,
  `deskripsi_bimbingan` text DEFAULT NULL,
  `id_pembimbing` int(225) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  PRIMARY KEY (`id_bimbingan`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Data for the table `bimbingan` */

/*Table structure for table `dosen` */

DROP TABLE IF EXISTS `dosen`;

CREATE TABLE `dosen` (
  `id_dosen` int(225) NOT NULL AUTO_INCREMENT,
  `nama_dosen` varchar(225) NOT NULL,
  PRIMARY KEY (`id_dosen`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `dosen` */

insert  into `dosen`(`id_dosen`,`nama_dosen`) values 
(13,'Dani Hamdani S.Kom. , M.T');

/*Table structure for table `jadwal` */

DROP TABLE IF EXISTS `jadwal`;

CREATE TABLE `jadwal` (
  `id_jadwal` int(225) NOT NULL AUTO_INCREMENT,
  `id_mhs` int(225) DEFAULT NULL,
  `tgl_jadwal` datetime DEFAULT NULL,
  `jenis_kegiatan` varchar(225) DEFAULT NULL,
  `id_pembimbing` int(225) DEFAULT NULL,
  `status_jadwal` int(225) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `jadwal` */

/*Table structure for table `mahasiswa` */

DROP TABLE IF EXISTS `mahasiswa`;

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(225) NOT NULL AUTO_INCREMENT,
  `nama_mahasiswa` varchar(225) DEFAULT NULL,
  `nim_mahasiswa` varchar(225) DEFAULT NULL,
  `ttl_mahasiswa` date DEFAULT NULL,
  `alamat_mahasiswa` text DEFAULT NULL,
  `telp_mahasiswa` varchar(225) DEFAULT NULL,
  `email_mahasiswa` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id_mahasiswa`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `mahasiswa` */

insert  into `mahasiswa`(`id_mahasiswa`,`nama_mahasiswa`,`nim_mahasiswa`,`ttl_mahasiswa`,`alamat_mahasiswa`,`telp_mahasiswa`,`email_mahasiswa`) values 
(32,'Amir Malik Hidayatulloh','1116124042','1994-03-06','Komp. CBI C14 no 12','081320552938','amirmalik2503@gmail.com');

/*Table structure for table `pengumuman` */

DROP TABLE IF EXISTS `pengumuman`;

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(225) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(225) DEFAULT NULL,
  `tgl_pengumuman` date DEFAULT NULL,
  `judul_pengumuman` varchar(225) DEFAULT NULL,
  `deskripsi_pengumuman` text DEFAULT NULL,
  `type` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id_pengumuman`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `pengumuman` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id_users` int(225) NOT NULL AUTO_INCREMENT,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` varchar(225) NOT NULL,
  `id_role` int(225) NOT NULL,
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id_users`,`username`,`password`,`role`,`id_role`) values 
(0,'admin','admin','admin',0),
(22,'1116124042','12345','mahasiswa',32);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
