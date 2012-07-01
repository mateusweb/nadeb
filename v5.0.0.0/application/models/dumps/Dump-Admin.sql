DROP TABLE IF EXISTS `controllers`;
CREATE TABLE  `controllers` (
  `idController` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `label` varchar(45) DEFAULT NULL,
  `taskType` varchar(100) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `display` set('menu','sideBar') DEFAULT NULL,
  PRIMARY KEY (`idController`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `actions`;
CREATE TABLE  `actions` (
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

DROP TABLE IF EXISTS `groups`;
CREATE TABLE  `groups` (
  `idGroup` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `permission` varchar(100) DEFAULT NULL,
  `controllers` text,
  PRIMARY KEY (`idGroup`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE  `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `idGroup` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  KEY `user_groups` (`idGroup`),
  CONSTRAINT `user_groups` FOREIGN KEY (`idGroup`) REFERENCES `groups` (`idGroup`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sample`;
CREATE TABLE  `sample` (
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



LOCK TABLES `controllers` WRITE;
INSERT INTO `controllers` VALUES (17,'Controllers','Controllers','read,write',2,'menu'),(18,'Groups','Grupos','read,write',3,'menu'),(19,'Users','Usuários','read,write',2,'menu'),(20,'Actions','Ações','read,write',4,''),(21,'Sample','Sample','read,write',1,'sideBar');
UNLOCK TABLES;

LOCK TABLES `groups` WRITE;
INSERT INTO `groups` VALUES (2,'Admin','0,0,0,0,0','17,18,19,20,21'),(3,'Nadeb','2,2,2,2,2','17,18,19,20,21');
UNLOCK TABLES;

LOCK TABLES `actions` WRITE;
INSERT INTO `actions` VALUES 
(14,17,'Inserir','admin/controllers/edit/','write',0),(15,18,'Listar','admin/groups/list/','read',0),(16,18,'Inserir','admin/groups/edit/','write',0),(17,19,'Listar','admin/users/list/','read',0),(18,19,'Inserir','admin/users/edit/','write',0),(19,20,'Listar','admin/actions/list/','read',0),(20,20,'Inserir','admin/actions/edit/','write',0),(21,21,'Listar','admin/sample/list/','read',0),(22,21,'Inserir','admin/sample/edit/','write',0);
UNLOCK TABLES;

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (3,3,'Mateus Martins','mateusweb@gmail.com','oPŠ.÷¹ˆ¿?oŒ4['),(4,3,'Nadeb','nadeb','Ù!ê‚º8N§Ú');
UNLOCK TABLES;

-- usuário padrão
-- user: nadeb
-- psw: asdqwe123