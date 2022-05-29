-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: filmi
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `film`
--

DROP TABLE IF EXISTS `film`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `film` (
  `FID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `runtime` int(11) NOT NULL,
  `director` varchar(30) DEFAULT NULL,
  `imdb` float NOT NULL,
  `rt` int(11) NOT NULL,
  PRIMARY KEY (`FID`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film`
--

LOCK TABLES `film` WRITE;
/*!40000 ALTER TABLE `film` DISABLE KEYS */;
INSERT INTO `film` VALUES (1,'test',123,123,'asd',7.6,89),(2,'asd',123,123,'asd',2,12),(3,'test1',123,123,'asddas',2,23),(17,'asd123',23,32,'asd',2,23),(18,'123',21,3,'asd',2,3),(19,'123214',1231,123,'fasf',2,23),(20,'Tenet',123,132,'asdsad',7.5,60),(22,'Dune',2021,155,'Denis',8.1,83),(23,'nov film 2',2021,144,'asd',9.4,24),(24,'nov film 3',41,42,'asdsad',8,23),(25,'124214',123,42,'asd',4,24),(26,'test123123123',23,23,'asddas',2,2),(27,'test321',2021,215,'Christopher Nolan',8,8),(28,'jgf',2021,14,'asdfasf',4,4),(29,'kjhfgds',2021,142,'241',4,4),(31,'fat',42,42,'Christopher Nolan',4,4),(32,'zz',2021,31,'anzeee',4,4),(33,'zzzzzzzzzz',2021,32,'421',4,4),(34,'zzzzzzzzzzzzzzzzzz1',2021,2,'asdfasf',4,4),(35,'tzzzzzz23',2021,213,'Christopher Nolan',4,4),(36,'zz',2011,69,'jan Mrak',9,99),(38,'233333333',2333333,232,'kmsad',9,9),(39,'&lt;script&gt;alert(&quot;test&quot;);&lt;/script&gt;',4,4,'jks',5,5);
/*!40000 ALTER TABLE `film` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `mail` char(30) NOT NULL,
  `password_hash` char(60) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'asd','asd@asd.com','$2y$11$YNVyfSidmJeE/Hx6YQODs.F4b8l/24fcoG2N0A4rWra45flWtyuZ2',1,'2022-05-19 20:43:44'),(2,'asd123','asd@asd.asdasd','$2y$11$mKoBraxiK3gBWtE0JxTCm.dAepeFVKoMvptO3N2etP9ZBYxNrhXkq',1,'2022-05-26 13:49:01');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userfilm`
--

DROP TABLE IF EXISTS `userfilm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userfilm` (
  `FID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `watched` tinyint(1) NOT NULL,
  PRIMARY KEY (`UID`,`FID`),
  KEY `FID` (`FID`),
  CONSTRAINT `userfilm_ibfk_1` FOREIGN KEY (`FID`) REFERENCES `film` (`FID`),
  CONSTRAINT `userfilm_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userfilm`
--

LOCK TABLES `userfilm` WRITE;
/*!40000 ALTER TABLE `userfilm` DISABLE KEYS */;
INSERT INTO `userfilm` VALUES (17,1,1),(22,1,0),(23,1,1),(24,1,1),(25,1,1),(26,1,1),(27,1,1),(29,1,1),(31,1,1),(32,1,1),(33,1,1),(35,1,1),(38,1,1);
/*!40000 ALTER TABLE `userfilm` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-29 18:51:28
