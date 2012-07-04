-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.50-community


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema sample
--

CREATE DATABASE IF NOT EXISTS sample;
USE sample;

--
-- Definition of table `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
  `idAction` int(11) NOT NULL AUTO_INCREMENT,
  `idController` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `taskType` varchar(20) DEFAULT NULL,
  `order` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`idAction`),
  KEY `controllers_actions` (`idController`),
  CONSTRAINT `controllers_actions` FOREIGN KEY (`idController`) REFERENCES `controllers` (`idController`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actions`
--

/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` (`idAction`,`idController`,`name`,`link`,`taskType`,`order`) VALUES 
 (13,17,'Listar','admin/controllers/list/','read',0),
 (14,17,'Inserir','admin/controllers/edit/','write',0),
 (15,18,'Listar','admin/groups/list/','read',0),
 (16,18,'Inserir','admin/groups/edit/','write',0),
 (17,19,'Listar','admin/users/list/','read',0),
 (18,19,'Inserir','admin/users/edit/','write',0),
 (19,20,'Listar','admin/actions/list/','read',0),
 (20,20,'Inserir','admin/actions/edit/','write',0),
 (21,21,'Listar','admin/sample/list/','read',0),
 (22,21,'Inserir','admin/sample/edit/','write',0);
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;


--
-- Definition of table `controllers`
--

DROP TABLE IF EXISTS `controllers`;
CREATE TABLE `controllers` (
  `idController` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `label` varchar(45) DEFAULT NULL,
  `taskType` varchar(100) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `display` set('menu','sideBar') DEFAULT NULL,
  PRIMARY KEY (`idController`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `controllers`
--

/*!40000 ALTER TABLE `controllers` DISABLE KEYS */;
INSERT INTO `controllers` (`idController`,`name`,`label`,`taskType`,`order`,`display`) VALUES 
 (17,'Controllers','Controllers','read,write',1,'menu'),
 (18,'Groups','Grupos','read,write',2,'menu'),
 (19,'Users','Usuários','read,write',3,'menu'),
 (20,'Actions','Actions','read,write',4,''),
 (21,'Sample','Sample','read,write',5,'sideBar');
/*!40000 ALTER TABLE `controllers` ENABLE KEYS */;


--
-- Definition of table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `idGroup` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `permission` varchar(100) DEFAULT NULL,
  `controllers` text,
  PRIMARY KEY (`idGroup`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`idGroup`,`name`,`permission`,`controllers`) VALUES 
 (2,'Admin','0,0,0,2,2','17,18,19,20,21'),
 (3,'Nadeb','2,2,2,2,2','17,18,19,20,21');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


--
-- Definition of table `sample`
--

DROP TABLE IF EXISTS `sample`;
CREATE TABLE `sample` (
  `idSample` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `htmlBody` text,
  `picture` varchar(100) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `options1` varchar(45) DEFAULT NULL,
  `options2` varchar(45) DEFAULT NULL,
  `folder` varchar(100) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `active` int(11) DEFAULT '1',
  `insertDate` datetime DEFAULT NULL,
  PRIMARY KEY (`idSample`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sample`
--

/*!40000 ALTER TABLE `sample` DISABLE KEYS */;
INSERT INTO `sample` (`idSample`,`type`,`title`,`body`,`htmlBody`,`picture`,`date`,`options1`,`options2`,`folder`,`order`,`active`,`insertDate`) VALUES 
 (1,'01','Teste 1','Meu conteúdo de teste 1','Meu conteúdo <strong>HTML </strong>de teste 1','0e9c3eec00f2840db7d3c91a8b3a14bc.jpg','Teste','01','01,02,03','78cac5bfb7f5a5cddc61cf882f5e873c',0,1,NULL),
 (2,'02','Teste 2','Meu conteúdo de teste 2','Meu conteúdo <strong>HTML </strong>de teste 2','927cbf519a495d13c6fc14c5e472f366.jpg','Teste','04','03,04','3cad50c54fe1d57d13b5c2cc4e9b8de5',0,1,NULL),
 (3,'03','Teste 3','Meu conteúdo de teste 3','Meu conteúdo <strong>HTML </strong>de teste 3',NULL,'Teste','03','02,03','413a2d170d0da05d35d2c18ccf41ea3b',0,1,NULL),
 (4,'04','Teste 4','Meu conteúdo de teste 4','Meu conteúdo <strong>HTML </strong>de teste 4',NULL,'Teste','04','01,04','37b3c4ab0dfe6754f92f7287464e61c5',0,1,NULL);
/*!40000 ALTER TABLE `sample` ENABLE KEYS */;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `idGroup` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  KEY `user_groups` (`idGroup`),
  CONSTRAINT `user_groups` FOREIGN KEY (`idGroup`) REFERENCES `groups` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`idUser`,`idGroup`,`name`,`email`,`password`) VALUES 
 (2,2,'Cliente','cliente@cliente.com','ÚÛ#xLTÅ{ÐÉ¤ƒçF'),
 (3,3,'Mateus Martins','mateusweb@gmail.com','oPŠ.÷¹ˆ¿?oŒ4['),
 (4,2,'Sun','admin@sun-mrm.com.br','PdvÄMÿÄ•±ŽpYÁ');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
