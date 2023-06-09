/*
SQLyog Community v12.5.0 (32 bit)
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
  `adduser` varchar(111) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(111) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `jadual` */

insert  into `jadual`(`idno`,`kelas_id`,`title`,`type`,`hari`,`date`,`time`,`adduser`,`adddate`,`upduser`,`upddate`) values 
(1,'1','45','weekly','isnin',NULL,'23:49:00',NULL,NULL,NULL,NULL),
(2,'1','qweqweqweqweqweqweqweqweqweqweqwe','date',NULL,'2023-06-05','22:30:00',NULL,NULL,NULL,NULL);

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
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `kelas` */

insert  into `kelas`(`idno`,`name`,`tambahan`,`terbuka`,`ketua`,`pengajar`,`adduser`,`adddate`,`upduser`,`upddate`) values 
(1,'asdsad','1','1','kelas_3','naqib',NULL,NULL,NULL,NULL);

/*Table structure for table `kelas_detail` */

DROP TABLE IF EXISTS `kelas_detail`;

CREATE TABLE `kelas_detail` (
  `idno` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jadual_id` int(11) DEFAULT NULL,
  `type` varchar(111) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `adduser` varchar(333) DEFAULT NULL,
  `surah` varchar(333) DEFAULT NULL,
  `ms` varchar(333) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`idno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kelas_detail` */

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
  `address1` varchar(333) DEFAULT NULL,
  `address2` varchar(333) DEFAULT NULL,
  `address3` varchar(333) DEFAULT NULL,
  `telno` varchar(333) DEFAULT NULL,
  `postcode` varchar(333) DEFAULT NULL,
  `newic` varchar(333) DEFAULT NULL,
  `image` blob,
  `adduser` varchar(333) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `upduser` varchar(333) DEFAULT NULL,
  `upddate` datetime DEFAULT NULL,
  `last_surah` varchar(333) DEFAULT NULL,
  `last_ms` varchar(333) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`name`,`kelas`,`type`,`ajar`,`setup`,`telhp`,`address1`,`address2`,`address3`,`telno`,`postcode`,`newic`,`image`,`adduser`,`adddate`,`upduser`,`upddate`,`last_surah`,`last_ms`) values 
(1,'azila','azila','NOR AZILA MOHD NOOR','1','naqib','1','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(2,'nadiyah','nadiyah','NURUL NADIYAH BT HAMID',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(3,'hazman','hazman','HAZMAN B YUSOF\r\n','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(4,'amirul','amirul','MUHD AMIRUL B MAT HUSSAIN\r\n','','','1','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(5,'hafiz','hafiz','MUHD HAFIZ BIN ZAABA\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(6,'luqman','luqman','LUQMAN BIN MUHD JAFFRI\r\n','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(8,'ismail','ismail','ISMAIL BIN NORDIN\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(9,'wan.faiz','wan.faiz','WAN FAIZ\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(10,'faedzah','faedzah','FAEDZAH MUSTAPA\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(11,'farhana','farhana','KHAIRUL FARHANA IDRIS\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(12,'adilah','adilah','ADILAH LIYANA BT ADLI\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(13,'syazwani','syazwani','NUR SYAZWANI IZZATI BT HAMRAN\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(14,'fauziah','fauzaih','FAUZIAH B DIN\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(15,'shariffa','shariffa','PN SHARIFFA\r\n','kelas_4','pelajar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(16,'khazizah','khazizah','PN KHAZIZAH\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(17,'umiza','umiza','UMIZA BT HAMDAN\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(18,'haslina','haslina','HASLIANA\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(20,'haziman','haziman','HAZIMAN\r\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
