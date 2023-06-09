/*
SQLyog Enterprise v13.1.1 (64 bit)
MySQL - 5.7.24 : Database - tahsin
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tahsin` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tahsin`;

/*Table structure for table `bukti` */

DROP TABLE IF EXISTS `bukti`;

CREATE TABLE `bukti` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `transactionid` int(11) DEFAULT NULL,
  `path` varchar(300) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bukti` */

/*Table structure for table `jadual` */

DROP TABLE IF EXISTS `jadual`;

CREATE TABLE `jadual` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_id` varchar(333) DEFAULT NULL,
  `title` varchar(333) DEFAULT NULL,
  `type` varchar(111) DEFAULT NULL,
  `hari` varchar(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `timer` int(11) DEFAULT '7',
  `adduser` varchar(111) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(111) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `jadual` */

insert  into `jadual`(`idno`,`kelas_id`,`title`,`type`,`hari`,`date`,`time`,`timer`,`adduser`,`adddate`,`upduser`,`upddate`) values 
(1,'1','Tahsin 6.0','weekly','Monday',NULL,'22:00:00',7,NULL,NULL,'hazman','2023-07-11 17:22:12'),
(2,'2','KELAS BERSEMUKA','weekly','Saturday',NULL,'09:00:00',7,'hazman','2023-07-11 17:31:40',NULL,NULL);

/*Table structure for table `kelas` */

DROP TABLE IF EXISTS `kelas`;

CREATE TABLE `kelas` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(333) DEFAULT NULL,
  `tambahan` varchar(11) DEFAULT NULL,
  `terbuka` varchar(11) DEFAULT NULL,
  `ketua` varchar(333) DEFAULT NULL,
  `pengajar` varchar(333) DEFAULT NULL,
  `adduser` varchar(333) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(333) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `bersemuka` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `kelas` */

insert  into `kelas`(`idno`,`name`,`tambahan`,`terbuka`,`ketua`,`pengajar`,`adduser`,`adddate`,`upduser`,`upddate`,`bersemuka`) values 
(1,'QC 6.0 MUNAWWARAH',NULL,NULL,'2','2',NULL,NULL,'hazman','2023-06-10 01:31:05',NULL),
(2,'KELAS BERSEMUKA',NULL,NULL,NULL,NULL,'hazman','2023-07-11 17:25:39',NULL,NULL,'1');

/*Table structure for table `kelas_detail` */

DROP TABLE IF EXISTS `kelas_detail`;

CREATE TABLE `kelas_detail` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jadual_id` int(11) NOT NULL,
  `type` varchar(111) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(111) NOT NULL,
  `pos` int(11) DEFAULT '0',
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(111) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `upduser` varchar(111) DEFAULT NULL,
  `surah` varchar(11) DEFAULT NULL,
  `ms` varchar(11) DEFAULT NULL,
  `remark` text,
  `rating` int(11) DEFAULT NULL,
  `surah2` varchar(11) DEFAULT NULL,
  `ms2` varchar(11) DEFAULT NULL,
  `marked` int(1) DEFAULT '0',
  `alasan` varbinary(333) DEFAULT NULL,
  PRIMARY KEY (`idno`,`kelas_id`,`user_id`,`jadual_id`,`type`,`date`,`time`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

/*Data for the table `kelas_detail` */

insert  into `kelas_detail`(`idno`,`kelas_id`,`user_id`,`jadual_id`,`type`,`date`,`time`,`status`,`pos`,`adddate`,`adduser`,`upddate`,`upduser`,`surah`,`ms`,`remark`,`rating`,`surah2`,`ms2`,`marked`,`alasan`) values 
(24,1,3,1,'weekly','2023-06-24','22:00:00','Hadir',1,'2023-06-21 18:20:38','hazman',NULL,NULL,'456','79',NULL,NULL,NULL,NULL,0,NULL),
(25,1,3,1,'weekly','2023-06-28','22:00:00','Hadir',1,'2023-06-28 17:05:40','hazman',NULL,NULL,'1212','1212','adssad\r\nsd\r\nds\r\nd\r\nsd\r\ns\r\nds\r\n23\r\n\r\n23\r\nd\r\nsd\r\nsd',4,'122','12',1,NULL),
(26,1,3,1,'weekly','2023-07-05','22:00:00','Hadir',6,'2023-07-04 13:39:43','hazman',NULL,NULL,'23','23','Uahsdsds dsdsd sdsdsdsdsd\r\n23dsdsdsdsd',3,'12','56',1,NULL),
(27,1,2,1,'weekly','2023-07-05','22:00:00','Hadir',2,'2023-07-04 16:35:37','Nadiyah',NULL,NULL,'21','21','Contoh 124',4,'12','65',1,NULL),
(28,1,9,1,'weekly','2023-07-05','22:00:00','Tidak Hadir',0,'2023-07-04 16:36:51','Wan.faiz',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL),
(30,1,18,1,'weekly','2023-07-05','22:00:00','Hadir',14,'2023-07-05 12:21:06','hasliana',NULL,NULL,'45','78',NULL,NULL,NULL,NULL,0,NULL),
(31,1,5,1,'weekly','2023-07-05','22:00:00','Hadir',1,'2023-07-05 15:39:44','Hafiz',NULL,NULL,'12','123',NULL,NULL,NULL,NULL,0,NULL),
(33,1,3,1,'weekly','2023-07-17','22:00:00','Hadir',1,'2023-07-13 18:09:12','hazman',NULL,NULL,'2','4',NULL,NULL,NULL,NULL,0,NULL),
(34,2,3,2,'weekly','2023-07-15','09:00:00','Tidak Hadir',0,'2023-07-13 18:24:35','hazman',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'sadsad'),
(35,1,2,1,'weekly','2023-07-17','22:00:00','Tidak Hadir',0,'2023-07-13 19:24:00','nadiyah',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'asdsadsad'),
(36,1,5,1,'weekly','2023-07-17','22:00:00','Hadir',3,'2023-07-13 19:24:20','hafiz',NULL,NULL,'12','32',NULL,NULL,NULL,NULL,0,NULL),
(37,1,4,1,'weekly','2023-07-17','22:00:00','Hadir',9,'2023-07-13 19:24:48','amirul',NULL,NULL,'23','23',NULL,NULL,NULL,NULL,0,NULL),
(38,1,8,1,'weekly','2023-07-17','22:00:00','Hadir',8,'2023-07-13 19:25:11','ismail',NULL,NULL,'12','12',NULL,NULL,NULL,NULL,0,NULL),
(39,2,8,2,'weekly','2023-07-15','09:00:00','Hadir',18,'2023-07-13 19:38:09','ismail',NULL,NULL,'45','45',NULL,NULL,NULL,NULL,0,NULL);

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `month` varchar(100) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `fullamt` decimal(11,2) DEFAULT NULL,
  `sumbangan` decimal(11,2) DEFAULT NULL,
  `kebajikan` decimal(11,2) DEFAULT NULL,
  `moreh` decimal(11,2) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `transactions` */

insert  into `transactions`(`idno`,`userid`,`month`,`year`,`fullamt`,`sumbangan`,`kebajikan`,`moreh`,`adddate`) values 
(4,1,'08','2021',30.00,30.00,0.00,0.00,'2021-08-09 17:15:20');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(333) DEFAULT NULL,
  `password` varchar(333) DEFAULT NULL,
  `name` varchar(333) DEFAULT NULL,
  `kelas` varchar(333) DEFAULT NULL,
  `type` varchar(333) DEFAULT NULL,
  `ajar` varchar(333) DEFAULT NULL,
  `setup` varchar(333) DEFAULT NULL,
  `telhp` varchar(333) DEFAULT NULL,
  `address` text,
  `telno` varchar(333) DEFAULT NULL,
  `postcode` varchar(333) DEFAULT NULL,
  `newic` varchar(333) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(333) DEFAULT NULL,
  `image` blob,
  `adduser` varchar(333) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(333) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `last_surah` varchar(333) DEFAULT NULL,
  `last_ms` varchar(333) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`name`,`kelas`,`type`,`ajar`,`setup`,`telhp`,`address`,`telno`,`postcode`,`newic`,`dob`,`gender`,`image`,`adduser`,`adddate`,`upduser`,`upddate`,`last_surah`,`last_ms`) values 
(2,'nadiyah','nadiyah','NURUL NADIYAH BT HAMID','1','ketua_pelajar','1','1',NULL,NULL,NULL,NULL,NULL,NULL,'Perempuan',NULL,NULL,NULL,'Nadiyah','2023-06-21 18:02:31',NULL,NULL),
(3,'hazman','hazman','HAZMAN B YUSOF','1','pelajar','1','1','01123191948','no 8 , jalan 3/4g\r\n43650 bandar baru bangi \r\nselangor',NULL,NULL,'870112435017','2023-06-21','Lelaki',NULL,NULL,NULL,'Hazman','2023-07-05 11:47:47',NULL,NULL),
(4,'amirul','amirul','MUHD AMIRUL B MAT HUSSAIN','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Hazman','2023-06-10 01:28:24',NULL,NULL),
(5,'hafiz','hafiz','MUHD HAFIZ BIN ZAABA','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Hazman','2023-06-10 01:28:34',NULL,NULL),
(6,'luqman','luqman','LUQMAN BIN MUHD JAFFRI','1','pelajar','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Hazman','2023-06-10 01:28:43',NULL,NULL),
(8,'ismail','ismail','ISMAIL BIN NORDIN','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Hazman','2023-06-10 01:28:51',NULL,NULL),
(9,'wan.faiz','wan.faiz','WAN FAIZ','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Hazman','2023-06-10 01:28:59',NULL,NULL),
(10,'faedzah','faedzah','FAEDZAH MUSTAPA','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Hazman','2023-06-10 01:29:05',NULL,NULL),
(11,'farhana','farhana','KHAIRUL FARHANA IDRIS','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Hazman','2023-06-10 01:29:12',NULL,NULL),
(12,'adilah','adilah','ADILAH LIYANA BT ADLI','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,'syazwani','syazwani','NUR SYAZWANI IZZATI BT HAMRAN','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,'fauziah','fauziah','FAUZIAH B DIN','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(16,'khazizah','khazizah','PN KHAZIZAH','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(17,'umiza','umiza','UMIZA BT HAMDAN','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(18,'hasliana','hasliana','HASLIANA','1','pelajar',NULL,NULL,'12','sadsad',NULL,NULL,'870112435017','1987-01-12','Lelaki',NULL,NULL,NULL,'hasliana','2023-07-05 13:18:16',NULL,NULL),
(20,'haziman','haziman','HAZIMAN','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(22,'rashidah','rashidah','RASHIDAH','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(23,'shikin','shikin','SHIKIN','1','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
