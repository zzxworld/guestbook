-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: guestbook
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) DEFAULT NULL,
  `ip` int(11) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `content` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`),
  KEY `email` (`email`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (17,'test@test',2130706433,'Test','ip2long() will return FALSE for the IP 255.255.255.255 in PHP 5 &lt;= 5.0.2, and -1 on 64-bits systems in PHP 5 &lt;=5.2.4. It was fixed in PHP 5.2.5 where it returns 4294967295. 32-bit systems will return -1 due to the integer value overflowing.','2017-08-08 09:08:22',NULL),(18,'adfadf@adfadadf',2130706433,'','adfadfadfadf','2017-08-08 10:08:07',NULL),(19,'adfadf@adfadadf',2130706433,'','adfadfadfadf','2017-08-08 10:08:12',NULL),(20,'adfadf@adfadadf',2130706433,'','adfadfadfadfadf','2017-08-08 10:08:18',NULL),(21,'adfadf@adfadadf',2130706433,'','adfadfadfadf','2017-08-08 10:08:27',NULL),(22,'adfadf@adfadadf',2130706433,'','adfadfadf','2017-08-08 10:08:37',NULL),(23,'adfadf@adfadadf',2130706433,'','adfadfdafadfadf','2017-08-08 10:08:44',NULL),(24,'adfadf@adfadadf',2130706433,'','adfadfadfadf','2017-08-08 10:08:52',NULL),(25,'adfadf@adfadadf',2130706433,'','adfadfadfa','2017-08-08 10:36:31',NULL),(26,'adfadf@adfadadf',2130706433,'','adfadfadfadf','2017-08-08 10:39:12',NULL);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-08 18:39:48
