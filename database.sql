/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.37-MariaDB : Database - knowledgecity
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`knowledgecity` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `knowledgecity`;

/*Table structure for table `student_groups` */

DROP TABLE IF EXISTS `student_groups`;

CREATE TABLE `student_groups` (
  `GroupId` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(160) NOT NULL,
  PRIMARY KEY (`GroupId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `student_groups` */

insert  into `student_groups`(`GroupId`,`GroupName`) values (1,'Default Group'),(2,'Developer Group');

/*Table structure for table `students` */

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `StudentId` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(160) NOT NULL,
  `LastName` varchar(160) NOT NULL,
  `Code` varchar(255) NOT NULL,
  `GroupId` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`StudentId`),
  UNIQUE KEY `Code` (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `students` */

insert  into `students`(`StudentId`,`FirstName`,`LastName`,`Code`,`GroupId`) values (1,'Bernardo','Santini','kctest00201',1),(2,'George','Quebedo','kctest00202',1),(3,'Rob','Shnnelder','kctest00203',2),(4,'Terry','Curz','kctest00204',2),(5,'David','Curz','kctest00205',2),(6,'David','Simth','kctest00206',1),(7,'Jony','Simth','kctest00207',1),(8,'Rob','Simth','kctest00208',2),(9,'Herry','Portan','kctest00209',1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`UserId`,`UserName`,`Password`) values (1,'Admin','e64b78fc3bc91bcbc7dc232ba8ec59e0');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
