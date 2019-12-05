-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: trialrun3
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'user1','$2y$10$D7Lt4vs2f3aVCq2.XMPJWO.7fY7cD1lDdAxdnYrpz/BxDpC.uvRoi','Pablo','Picasso'),(2,'user2','$2y$10$2KufIARmhdsBU4ohBMqAmurdoy0fNvJnMbG2EsKR5wlGLqAlUFOz.','Joel','Bloom'),(3,'test','$2y$10$kGiVcwtNwx7sPJqTvZRqwO4KYxgB4.0aEeHkZhaqv68mirub3ijX6','test','test'),(4,'test','$2y$10$5BCnzx7gYsmjcYhnMFrqPOcEKmMxbneN5Gp5NPRqf/UjQIkhDRGA.','test','test'),(5,'test','$2y$10$TYwib57XXJob7SfwA4ZwFu.WrTRMfqY5.sB5AcOPGAQr06qcz.c3e','test','test'),(6,'test','$2y$10$UQFdptYKBBj8nYHPVQ9aEu6HkkxF0X0xrKldT8XW5LwejMO38epOC','test','test'),(7,'test','$2y$10$uHohKqdj0W/VSCpEPqtjHuaNFdCUcN0moh8ch1pzV1FS4aV2k07K.','test','test'),(8,'test','$2y$10$0yc2/QyrYIH2HeAy1kj59OLk/C3E4dXP0u2IRp8zHWJdpLrnhfRqS','test','test'),(9,'test','$2y$10$opqSLxpZDafRyb3ZHovdPORp1daDjwMYpvpeUJqTGQsAnNH8GBqzW','test','test'),(10,'test','$2y$10$qGogkBTp.6JHjzGmEl4jMeXmPEv/Hvw3H.bBqeydKD3Xdo0jdUn6m','test','test'),(11,'test','$2y$10$VBzXqZOesbRrrsjGY0TjJOKBY3X5.o4dRcTC.uvVpjQz68eoGXx9C','test','test'),(12,'test','$2y$10$eDDw.hs0C6.dMwt/lo7gJuZ8r9qKtJyhdEk/ioEtHJd5eK0f8X13a','test','test'),(13,'test','$2y$10$hjxdgibFGXsdgGWSBTQMmump7j8UJlBfP4maFqghJchBtNdjh4oGm','test','test'),(14,'test','$2y$10$JFjSarWLHhlI63bX/j0Ep.EtIunps2FoL6o19U7xWGYCNbb0gwIJK','test','test'),(15,'test','$2y$10$gtrta7oXJgtjbzCaiYSrjugyiXEMtuYZY0M48TJx6l6t2fiKwlIou','test','test'),(16,'test','$2y$10$nqNebknWHpSnc6sGDkMPyeOLr3jZQ4OA3HAfz2w74ezGK8XGVIq0q','test','test'),(17,'test','$2y$10$dog1eCUWvRV8QOZYS06B5uesBcbaV8p1mvV/lZWF0F03Cduto96Lm','test','test'),(18,'test','$2y$10$54x4a3mjILR7yayXL8w0EuVscP4oMUkv7Adc63pgRsB2YHCsdkDpW','test','test'),(19,'test','$2y$10$3wwzzpyVKVxt9PPCoXD/nO1U2vpT7KlpSv58QOx9/hlV0wneC4uIq','test','test'),(20,'test','$2y$10$iqO3oWOrWcrC2NhZQI/wN.VFPHWvHKhi952QQC7abi4mBUEhG/.M.','test','test'),(21,'test','$2y$10$MW.qemJtZZ/fOEbsARKeMeANkLD.9CuED4ht4LNi6xtKCogVwF4q.','test','test'),(22,'test','$2y$10$RmCB81UV/yJ4XgFZJpscOOb1U9amP3xawTJmeGockuwLzPb4MNhDi','test','test'),(23,'test','$2y$10$97Aih9Y9fy1AZVSOsVnuF.f6eVjRjzcgtL6tXhC/Au7uAjCpLOEJ.','test','test'),(24,'test','$2y$10$ke25qCtAgr3E88Tr66Unx.o.n5WpkDj3CD2iBRW0o1MZj35vTpNxG','test','test'),(25,'test','$2y$10$g6lLhtMyE091Ttwo.gw1qebYq9yMy5.EHAEEFSVk5owQw1Ac8sH8y','test','test'),(26,'test','$2y$10$VcSXpak9PuD0cnL9239H0u5dX2rmyLKmq8.EO3ZMaxXSKYYWTftl.','test','test'),(27,'test','$2y$10$n9jUo7deUHaL5WndVr2Pj.jsn.8A2anyZwTR.uxDbr2NY2onCs3R.','test','test'),(28,'test','$2y$10$QjUkLKH0/WgHtuhH/922kOuwTWhRMUDkCoozDvPS7IKWlatbhzdfG','test','test'),(29,'test','$2y$10$WjznD4chqzUpxPBFucKz3eiai4LraSrfrwSftalt75ZcVy.WTnBcy','test','test'),(30,'test','$2y$10$yMA5.D4ep8pvVovc3w3yV.azHM6nZ6RmZvHurygc84kttcUVcq6TG','test','test'),(31,'test','$2y$10$adJnHz87fnvoMcJzltlfL.BFUx8Cb.wFPsqepGqfzBgmwyddSn5Q2','test','test'),(32,'test','$2y$10$Mdb9UCKJShkxhqDw9s4bNuZSa5ofS.RknATDA5BxF.1PVS15ean9u','test','test'),(33,'test','$2y$10$ZmwTGOQn3yHZ6/kn4l6Oruj4xHA3Yhl.26uEqh2bQxNd1UaAYFj1y','test','test'),(34,'test','$2y$10$qU9htuEiOMwBJK.P/NJwluNYaGqqKZoBtX.//hdW/hwHcvHtpVP7y','test','test'),(35,'test','$2y$10$C/PQWJAr6tzMnDvazZFF/uR0HZJxoBosgoHThGwojWfKortyYAfcO','test','test'),(36,'test','$2y$10$QaDo3tASC3wGG9YVN0LvOulg.xmxroGSmZccKihUc0RV.CrYkE7mC','test','test'),(37,'test','$2y$10$jqdb2Td0kkVu4XTnk482nueqBd0aDCVbzpHmsGwWxXxEES7NvCpxe','test','test'),(38,'test','$2y$10$gcCAtjNmrQiLKv16Rq1eP.It5Bi5OAZ8DwvnKbXIJOUtxspYXBwCG','test','test'),(39,'test','$2y$10$qBw0dpfiqCzWpdTdoVetB.ALLLjC.gHJhgXYPf9VvRY3jwoAS2.qq','test','test'),(40,'test','$2y$10$uqPjB94rv1cMIdxWMp4NMeLuZ0HyMmgeSW3/ayLQz1mjADYg.JhgG','test','test'),(41,'test','$2y$10$Nuym4kp7Pr4IUcqltOOmi.ylbGN69KPm0ewA.V0AeffYwHkXGm/lm','test','test'),(42,'test','$2y$10$ge2rQCOJL9NhkPFWaLVlK.KHDVyGsoaz7NS5QdsH3ySrcc/VAQ6Mi','test','test'),(43,'test','$2y$10$m/VcOAcFBYvfWyU412.HP.WxeWCcPu71NpG7a3iWorVAncHqZuiI2','test','test'),(44,'mandingo','$2y$10$3eNFI4L/BYuxePOqWrzwT.tMHS6oJ3fzaMWyRjjuOgh5FtbeN0BgW','man','dingo'),(45,'pacman','$2y$10$PFr1TbCVNkTv8pR1FzBNOuvm9LIvDAmaI.AHrZ9ebPHpRSJKLeQMq','pacman','pacman'),(46,'pacwoman','$2y$10$Xy1dGFSZiiJ85oyIKV1e2.T6BzpBI6zsAgefA4ua1Y3wmKvfRzwy6','pacwoman','pacwoman'),(47,'loop','$2y$10$qS1Z6xko.ZcchIZ0p8hl2u03F.puRMYBZsnYzqHofRTCpm8Px47g.','loop','loop'),(48,'fruity','$2y$10$23jjRVibwrTIPgSgg6iH5eY.26J5AEge9H9RWXERA7Jyl11nDZXQi','fruity','fruity'),(49,'why','$2y$10$7shiVaIgHXhtLhUPuC5.suRyse.tAeGjUXjNrhpYncyBB5oHMJ3n2','why','why'),(50,'jim123','$2y$10$ThReNYt.WP/fOZkjBASjIumXu6HObTVVQK.bwnfF.kj9sC0ul/rsa','Jim','Halpert'),(51,'lala','$2y$10$yHnYwM4jAGQH/PW0CdX2ZOsFcnC8EUXd/bfiVAHthQTDtmUioeBUC','tele','tubby'),(52,'whynot123','$2y$10$darnkhNHObWPrzyzgjW9Y.4MpOywWRK/vYO8eJSv/FZXARmN/GZDu','why','not'),(53,'guyman','$2y$10$fEyhutRlU8H3vp4w9368VO1.V.hssjij0QfqZa3RC3ggDoyqll2Ia','Guy','Man'),(54,'pleasework','$2y$10$t5VhzmyHpzp2/ESqYaje/el0Otb7vkzN/TvJM5a8xiGCaUhsIa42i','Please','Work'),(55,'pacman2','$2y$10$CC5OrpldJeLTtuz26gOzO.UYJrEfu7nepdFpNjcgg0GeydQrnLTsK','Pac','Boy'),(56,'johngreen','$2y$10$hT54CGAHpPOXnc8IDYTFruMXsrWNA6GWXFpzf/PUu/lyhjBjK02zK','john','green'),(57,'markgreen','$2y$10$9ESEpntLDcaBZ5ZeDkJ7JecC.xBEBlxI748KB/xHs5svuPdiuKsI2','mark','green'),(58,'pam','$2y$10$yTCEfgdv3NjFHJpXOetujOSBlXT5IZSboBSBvl/DhPf6kKb46JG/S','pam','halpert'),(59,'mario','$2y$10$CZsl02wLCBbv8nvK8IQQ7OAnWc2MFrmm7vYoUUsA47CjzN2du6chG','super','mario'),(60,'fullhouse','$2y$10$Tg7eYtPORPJKso4xcUFx/.8sE1rUXCe4E5rkHHzdnmksZHixzPco6','full','house'),(61,'tom','$2y$10$ktCXGJU3d1qKFvq3FoYaqOAmF4q8LrfoeRvFaRl0evSjAlqYo0FbW','tom','jerry'),(62,'tom2','$2y$10$wocHOFQiVFd5nWf0gFCjHuQBTQpODT7gVO.GRZZu27EzX62C6Xr9O','tom','jerry'),(63,'tom2','$2y$10$93sjZDtQkK.EEt8k5XHlV.WRf/xfrpw5t0pmt6ebV0Qdbe8vD0HFG','tom','jerry'),(64,'test20','$2y$10$/7B8cDIKjib3xEl4sU7ppeAgwYFowje3oQgVqvwa6DRICD93jvbBG','test20','test'),(65,'test20','$2y$10$z6QL7O5evpAaxKsU2re4VeokN1dNbtq3SWWqdRojtNNFaIa/jrAKm','test20','test'),(66,'person101','$2y$10$JE43QjslAIhHpxf1hGAnGeqCjDMGjC5YjV5H12LUjDzIDxhapP4Ei','person','man'),(67,'reybel24','$2y$10$uJrNqaYtV1W6lapFOz8yn.sA3I7Wl5eqdzJ0XovmX6MbmXFcmzRTG','Reybel','Candelaria'),(68,'rey1','$2y$10$uO6X9U3UTCwXLxxpzyKGr.u5Axy/l3UohZvXigkutTqaa2D5HXYl6','rey','anything'),(69,'testt56','$2y$10$LpAN9v.j.Du/PC5HWG03OenPds9z3k.umlvxppWT4jd8QO.oLSi1O','test','testt');
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investments`
--

LOCK TABLES `investments` WRITE;
/*!40000 ALTER TABLE `investments` DISABLE KEYS */;
INSERT INTO `investments` VALUES (1,1,'BTC','USD',50.00),(2,1,'EOS','USD',4.00),(3,1,'LTC','USD',1.00),(4,1,'DASH','USD',1.00),(5,4,'XLM','USD',230.00),(6,4,'XMR','USD',10.00),(7,50,'QTUM','USD',5.70),(8,50,'ZEC','USD',15.00),(9,50,'ETH','USD',0.50),(10,1,'ETC','USD',30.00),(11,52,'ZEC','USD',15.00),(12,52,'XTZ','USD',4.00),(13,54,'XRP','USD',1.50),(14,54,'DASH','USD',3.00),(15,1,'XRP','USD',30.00),(16,55,'LTC','USD',2.40),(17,55,'BSV','USD',0.80),(18,55,'XMR','USD',4.80),(19,67,'LINK','USD',30.00),(20,68,'XRP','USD',2.00),(21,68,'BCH','USD',0.50),(22,68,'ETH','USD',2.50),(23,69,'DASH','USD',5.00),(24,69,'BSV','USD',3.20),(25,69,'BTC','USD',0.00);
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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES (1,1,234.40),(2,2,500.00),(44,3,750.00),(45,4,124.80),(46,5,750.00),(47,6,750.00),(45,7,124.80),(45,8,124.80),(45,9,124.80),(45,10,124.80),(48,48,750.00),(49,49,750.00),(50,50,91.16),(51,51,750.00),(52,52,191.12),(53,53,750.00),(54,54,543.56),(55,55,252.77),(56,56,750.00),(57,57,750.00),(58,58,750.00),(59,59,750.00),(60,60,750.00),(61,61,750.00),(62,62,750.00),(63,63,750.00),(64,64,750.00),(65,65,750.00),(66,66,750.00),(67,67,657.93),(68,68,150.02),(69,69,220.79);
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

-- Dump completed on 2019-12-04 20:31:22
