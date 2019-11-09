-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: trialrun2
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'user1','password','Pablo','Picasso'),(2,'user2','password','Joel','Bloom'),(3,'test','pass','test','test'),(4,'test','pass','test','test'),(5,'test','pass','test','test'),(6,'test','pass','test','test'),(7,'test','pass','test','test'),(8,'test','pass','test','test'),(9,'test','pass','test','test'),(10,'test','pass','test','test'),(11,'test','pass','test','test'),(12,'test','test','test','test'),(13,'test','test','test','test'),(14,'test','test','test','test'),(15,'test','test','test','test'),(16,'test','test','test','test'),(17,'test','test','test','test'),(18,'test','test','test','test'),(19,'test','test','test','test'),(20,'test','test','test','test'),(21,'test','test','test','test'),(22,'test','test','test','test'),(23,'test','test','test','test'),(24,'test','test','test','test'),(25,'test','test','test','test'),(26,'test','test','test','test'),(27,'test','test','test','test'),(28,'test','test','test','test'),(29,'test','test','test','test'),(30,'test','test','test','test'),(31,'test','test','test','test'),(32,'test','test','test','test'),(33,'test','test','test','test'),(34,'test','test','test','test'),(35,'test','test','test','test'),(36,'test','test','test','test'),(37,'test','test','test','test'),(38,'test','test','test','test'),(39,'test','test','test','test'),(40,'test','test','test','test'),(41,'test','test','test','test'),(42,'test','test','test','test'),(43,'test','test','test','test'),(44,'mandingo','password','man','dingo'),(45,'pacman','pacman','pacman','pacman'),(46,'pacwoman','password','pacwoman','pacwoman'),(47,'loop','password','loop','loop'),(48,'fruity','password','fruity','fruity'),(49,'why','password','why','why');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_trackers`
--

DROP TABLE IF EXISTS `currency_trackers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency_trackers` (
  `userid` int(11) NOT NULL,
  `tracker_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_tracked` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tracker_id`),
  KEY `fk_accounts_currency_trackers` (`userid`),
  CONSTRAINT `fk_accounts_currency_trackers` FOREIGN KEY (`userid`) REFERENCES `accounts` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_trackers`
--

LOCK TABLES `currency_trackers` WRITE;
/*!40000 ALTER TABLE `currency_trackers` DISABLE KEYS */;
INSERT INTO `currency_trackers` VALUES (1,1,'BTC'),(1,2,'ETH'),(1,3,'BCH'),(1,4,'LTC'),(1,5,'XRP'),(1,6,'EOS');
/*!40000 ALTER TABLE `currency_trackers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `investments`
--

DROP TABLE IF EXISTS `investments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `investments` (
  `investment_id` int(11) NOT NULL AUTO_INCREMENT,
  `portfolio_id` int(11) NOT NULL,
  `base_currency` varchar(255) DEFAULT NULL,
  `target_currency` varchar(255) DEFAULT NULL,
  `amount_invested` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`investment_id`),
  KEY `fk_portfolio_investments` (`portfolio_id`),
  CONSTRAINT `fk_portfolio_investments` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolio` (`portfolio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investments`
--

LOCK TABLES `investments` WRITE;
/*!40000 ALTER TABLE `investments` DISABLE KEYS */;
INSERT INTO `investments` VALUES (1,1,'BTC','USD',50.00),(2,1,'EOS','USD',4.00),(3,1,'LTC','USD',1.00),(4,1,'DASH','USD',1.00),(5,4,'XLM','USD',230.00),(6,4,'XMR','USD',10.00);
/*!40000 ALTER TABLE `investments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portfolio` (
  `userid` int(11) NOT NULL,
  `portfolio_id` int(11) NOT NULL AUTO_INCREMENT,
  `available_balance` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`portfolio_id`),
  KEY `fk_accounts_portfolio` (`userid`),
  CONSTRAINT `fk_accounts_portfolio` FOREIGN KEY (`userid`) REFERENCES `accounts` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES (1,1,355.00),(2,2,500.00),(44,3,750.00),(45,4,124.80),(46,5,750.00),(47,6,750.00),(45,7,124.80),(45,8,124.80),(45,9,124.80),(45,10,124.80),(48,48,750.00),(49,49,750.00);
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-08 22:02:18
