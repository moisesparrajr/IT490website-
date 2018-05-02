-- MySQL dump 10.13  Distrib 5.7.21, for Linux (i686)
--
-- Host: localhost    Database: p_LeagueDB
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Table structure for table `Champions_Data`
--

DROP TABLE IF EXISTS `Champions_Data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Champions_Data` (
  `championName` varchar(255) DEFAULT NULL,
  `winrate` float unsigned DEFAULT NULL,
  `gamesPlayedWithChampion` int(10) unsigned DEFAULT NULL,
  `releaseDate` int(11) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `accountID` int(11) DEFAULT NULL,
  KEY `accountID` (`accountID`),
  CONSTRAINT `Champions_Data_ibfk_1` FOREIGN KEY (`accountID`) REFERENCES `LoL_Data` (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Champions_Data`
--

LOCK TABLES `Champions_Data` WRITE;
/*!40000 ALTER TABLE `Champions_Data` DISABLE KEYS */;
INSERT INTO `Champions_Data` VALUES ('test',0.5,5,5,'test',5),('test',0.5,5,5,'test',5);
/*!40000 ALTER TABLE `Champions_Data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `LoL_Data`
--

DROP TABLE IF EXISTS `LoL_Data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `LoL_Data` (
  `rank` varchar(255) DEFAULT NULL,
  `wins` int(10) unsigned DEFAULT NULL,
  `losses` int(10) unsigned DEFAULT NULL,
  `veteran` tinyint(1) DEFAULT NULL,
  `inactive` tinyint(1) DEFAULT NULL,
  `playerOrTeamName` varchar(255) DEFAULT NULL,
  `playerOrTeamID` varchar(255) DEFAULT NULL,
  `leaguePoints` int(10) unsigned DEFAULT NULL,
  `summonerLvl` int(11) DEFAULT NULL,
  `lastModificationDate` int(10) unsigned DEFAULT NULL,
  `accountID` int(11) NOT NULL,
  `rank_solo` varchar(255) DEFAULT NULL,
  `rank_flex_sr` varchar(255) DEFAULT NULL,
  `rank_flex_tt` varchar(255) DEFAULT NULL,
  `tier_solo` varchar(255) DEFAULT NULL,
  `tier_flex_sr` varchar(255) DEFAULT NULL,
  `tier_flex_tt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`accountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `LoL_Data`
--

LOCK TABLES `LoL_Data` WRITE;
/*!40000 ALTER TABLE `LoL_Data` DISABLE KEYS */;
INSERT INTO `LoL_Data` VALUES ('test',5,5,1,1,'test','test',5,5,5,5,NULL,NULL,NULL,NULL,NULL,NULL),('myrank',20,1,0,0,'myteamName','myteamID',2000,3,1519512965,6,NULL,NULL,NULL,NULL,NULL,NULL),('bronze',32,7,0,0,'team noobs','team noobs id',3000,8,1519514527,7,NULL,NULL,NULL,NULL,NULL,NULL),('I',138,108,0,0,'Dyrus','5908',356,70,NULL,32766,'I','Unranked','Unranked','MASTER','Unranked','Unranked'),('0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,81,NULL,49504659,NULL,NULL,NULL,NULL,NULL,NULL),('I',6,4,0,0,'Abyss Love','76249593',0,93,NULL,233184060,'Unranked','Unranked','Unranked','Unranked','Unranked','Unranked');
/*!40000 ALTER TABLE `LoL_Data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matches_BannedChamps`
--

DROP TABLE IF EXISTS `Matches_BannedChamps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matches_BannedChamps` (
  `gameID` int(10) unsigned DEFAULT NULL,
  `pickTurn` int(11) DEFAULT NULL,
  `championId` int(11) DEFAULT NULL,
  `teamId` int(11) DEFAULT NULL,
  KEY `gameID` (`gameID`),
  CONSTRAINT `Matches_BannedChamps_ibfk_1` FOREIGN KEY (`gameID`) REFERENCES `Matches_Data` (`gameID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matches_BannedChamps`
--

LOCK TABLES `Matches_BannedChamps` WRITE;
/*!40000 ALTER TABLE `Matches_BannedChamps` DISABLE KEYS */;
/*!40000 ALTER TABLE `Matches_BannedChamps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matches_Data`
--

DROP TABLE IF EXISTS `Matches_Data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matches_Data` (
  `gameID` int(10) unsigned NOT NULL,
  `gameStartTime` int(10) unsigned DEFAULT NULL,
  `platformID` varchar(255) DEFAULT NULL,
  `gameMode` varchar(255) DEFAULT NULL,
  `mapID` int(11) DEFAULT NULL,
  `gameType` varchar(255) DEFAULT NULL,
  `gameLength` int(11) DEFAULT NULL,
  PRIMARY KEY (`gameID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matches_Data`
--

LOCK TABLES `Matches_Data` WRITE;
/*!40000 ALTER TABLE `Matches_Data` DISABLE KEYS */;
INSERT INTO `Matches_Data` VALUES (1,1,'test','test',1,'test',1);
/*!40000 ALTER TABLE `Matches_Data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matches_Observers`
--

DROP TABLE IF EXISTS `Matches_Observers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matches_Observers` (
  `gameID` int(10) unsigned DEFAULT NULL,
  `encryptionKey` varchar(255) DEFAULT NULL,
  KEY `gameID` (`gameID`),
  CONSTRAINT `Matches_Observers_ibfk_1` FOREIGN KEY (`gameID`) REFERENCES `Matches_Data` (`gameID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matches_Observers`
--

LOCK TABLES `Matches_Observers` WRITE;
/*!40000 ALTER TABLE `Matches_Observers` DISABLE KEYS */;
/*!40000 ALTER TABLE `Matches_Observers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matches_Participants`
--

DROP TABLE IF EXISTS `Matches_Participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matches_Participants` (
  `gameID` int(10) unsigned DEFAULT NULL,
  `participant` int(10) unsigned DEFAULT NULL,
  KEY `gameID` (`gameID`),
  CONSTRAINT `Matches_Participants_ibfk_1` FOREIGN KEY (`gameID`) REFERENCES `Matches_Data` (`gameID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matches_Participants`
--

LOCK TABLES `Matches_Participants` WRITE;
/*!40000 ALTER TABLE `Matches_Participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `Matches_Participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StreamerRatings`
--

DROP TABLE IF EXISTS `StreamerRatings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StreamerRatings` (
  `ratingID` int(11) NOT NULL AUTO_INCREMENT,
  `twitchID` varchar(255) DEFAULT NULL,
  `personalID` int(11) DEFAULT NULL,
  `rating` float unsigned DEFAULT NULL,
  `userComment` varchar(2048) DEFAULT NULL,
  `timeCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ratingID`),
  KEY `personalID` (`personalID`),
  KEY `twitchID` (`twitchID`),
  CONSTRAINT `StreamerRatings_ibfk_1` FOREIGN KEY (`personalID`) REFERENCES `Users` (`personalID`),
  CONSTRAINT `StreamerRatings_ibfk_2` FOREIGN KEY (`twitchID`) REFERENCES `Twitch_Data` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StreamerRatings`
--

LOCK TABLES `StreamerRatings` WRITE;
/*!40000 ALTER TABLE `StreamerRatings` DISABLE KEYS */;
INSERT INTO `StreamerRatings` VALUES (1,'dummytwitch',1,5,'Wow your stream is really great','2018-03-04 01:15:29');
/*!40000 ALTER TABLE `StreamerRatings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Twitch_Data`
--

DROP TABLE IF EXISTS `Twitch_Data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Twitch_Data` (
  `startedAt` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `viewerCount` int(10) unsigned DEFAULT NULL,
  `streamType` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `thumbnailURL` varchar(255) DEFAULT NULL,
  `userID` varchar(255) DEFAULT NULL,
  `gameID` varchar(255) DEFAULT NULL,
  UNIQUE KEY `userID` (`userID`),
  KEY `streamType` (`streamType`),
  CONSTRAINT `Twitch_Data_ibfk_1` FOREIGN KEY (`streamType`) REFERENCES `Twitch_StreamTypes` (`streamType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Twitch_Data`
--

LOCK TABLES `Twitch_Data` WRITE;
/*!40000 ALTER TABLE `Twitch_Data` DISABLE KEYS */;
INSERT INTO `Twitch_Data` VALUES ('time','title',5,'','language','thumbnailURL.com/image','dummytwitch','LeagueOfLegends'),('time','my stream title',22,'live','english','url.com','secretTwitchID','LeagueOfLegends'),('time','incredible streamer does things',3200,'vodcast','french','www.website.com/image.png','testtwitch','LeagueOfLegends');
/*!40000 ALTER TABLE `Twitch_Data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Twitch_StreamTypes`
--

DROP TABLE IF EXISTS `Twitch_StreamTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Twitch_StreamTypes` (
  `streamType` varchar(255) NOT NULL,
  PRIMARY KEY (`streamType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Twitch_StreamTypes`
--

LOCK TABLES `Twitch_StreamTypes` WRITE;
/*!40000 ALTER TABLE `Twitch_StreamTypes` DISABLE KEYS */;
INSERT INTO `Twitch_StreamTypes` VALUES (''),('live'),('vodcast');
/*!40000 ALTER TABLE `Twitch_StreamTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `personalID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tokenID` varchar(255) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `lastActivity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `twitchID` varchar(255) DEFAULT NULL,
  `accountID` int(11) DEFAULT NULL,
  `ratingCount` int(11) DEFAULT '0',
  `averageRating` float DEFAULT '0',
  `streamerSchedule` varchar(2048) DEFAULT NULL,
  `lastNotified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isStreaming` tinyint(1) DEFAULT '0',
  `summonerName` varchar(50) DEFAULT NULL,
  `summonerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`personalID`),
  UNIQUE KEY `twitchID` (`twitchID`),
  UNIQUE KEY `summonerID` (`accountID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'dummy@data.com','securepassword','dummytoken',0,'2018-03-08 23:52:40','dummytwitch',NULL,0,0,NULL,'2018-03-04 01:08:57',0,NULL,NULL),(2,'secret@agent.com','topsecretpasswd','secretToken',0,'2018-03-08 23:52:40','secretTwitchID',NULL,0,0,NULL,'2018-03-04 01:08:57',0,NULL,NULL),(3,'test@test.com','testpasswd','testtoken',0,'2018-03-08 23:52:40','testtwitch',NULL,0,0,NULL,'2018-03-04 01:08:57',0,NULL,NULL),(4,'not@twitch.com','pass','token',0,'2018-03-04 01:08:57',NULL,NULL,0,0,'I stream on mondays from 8-11am because I hate myself.','2018-03-04 01:08:57',0,NULL,NULL),(5,'test','test',NULL,0,'2018-04-02 18:10:33',NULL,233184060,0,0,NULL,'2018-03-08 22:08:39',0,'abyss love',76249593),(6,'Dyrus','Dyrus',NULL,0,'2018-03-09 20:27:58',NULL,32766,0,0,NULL,'2018-03-09 06:38:12',0,'Dyrus',5908),(7,'user','pass',NULL,0,'2018-03-10 15:27:35','dontcare',NULL,0,0,NULL,'2018-03-10 15:27:35',0,NULL,NULL),(8,'Testing1','$2y$10$aL0CHQh/ta3oBhUdPliCNu2ZVQVGvFdySJXQgYv6Ncuth0ZtmS4M2',NULL,0,'2018-03-29 19:46:24','DrDisRespectLive',NULL,0,0,NULL,'2018-03-29 19:46:24',0,NULL,NULL),(9,'this','$2y$10$9CxQJkpHIEFeTrLWjENBL.0iME7uZ3ZaAnCDqI9pY81j6eF/K3bOy',NULL,0,'2018-03-31 20:39:10','twitch',NULL,0,0,NULL,'2018-03-31 20:39:10',0,NULL,NULL),(10,'User','$2y$10$gSuYc2d9xZVn.4BFVjB2WOuXzuUMCfFNED3nBM0VuVqCCX4i.WAjO',NULL,0,'2018-03-31 22:48:06','twitchID',NULL,0,0,NULL,'2018-03-31 22:48:06',0,NULL,NULL),(12,'testuser','$2y$10$7W4rTKreaSjoDYEcnP69x.emeyOuxLs1Zh61LEr/UDa80TVjaPkfe',NULL,0,'2018-03-31 23:07:48','twitchtwitch',NULL,0,0,NULL,'2018-03-31 23:07:48',0,NULL,NULL),(13,'newuser','$2y$10$fJZCt/TI9poXbFma8AUSauhRq3E3cIV2U2TpqXYM4LU67qk/8quoW',NULL,0,'2018-03-31 23:09:02','newtwitch',NULL,0,0,NULL,'2018-03-31 23:09:02',0,NULL,NULL),(16,'newuser11','$2y$10$VRHfHSQP5Fk2RwcehNiggeHk7wJFjf4spwi0XR96u6y/AVgYCZMsm',NULL,0,'2018-03-31 23:24:09','newtwitch11',NULL,0,0,NULL,'2018-03-31 23:24:09',0,NULL,NULL),(23,'testuser1','$2y$10$B46KIYQI8/D4qRaUUz2/.eTnerisUVRIYRUQL/3o0YRUPPXyhTzYq',NULL,0,'2018-03-31 23:56:08','testtwitch1',NULL,0,0,NULL,'2018-03-31 23:56:08',0,NULL,NULL),(26,'testuser11','$2y$10$7/CoWzH0gaCUKWxau4e64uncQ2VLfCq6L7uQQeMq9gaB7OFlSASU2',NULL,0,'2018-03-31 23:59:48','testtwitch11',NULL,0,0,NULL,'2018-03-31 23:59:48',0,NULL,NULL),(29,'testuser111','$2y$10$IUoV7GdmHjRp7NYiSteZsOhaNJMPOrBKRb6CPOnY.PQUgusvpBxIK',NULL,0,'2018-04-01 00:02:08','testtwitch111',NULL,0,0,NULL,'2018-04-01 00:02:08',0,NULL,NULL),(31,'newuser123','$2y$10$LTfVJfSuDBCoHvHUkPG9E.l6YZk17XDvak0Dkv7zX/by.oFpjxdD.',NULL,0,'2018-04-01 00:08:25','twitch123',NULL,0,0,NULL,'2018-04-01 00:08:25',0,NULL,NULL),(32,'newuser1234','$2y$10$l.HUcpeioXwEGDN4UVRfTOhDyx7pIH5VDHb7qepZEcCt2tzaOp7JW',NULL,0,'2018-04-01 00:11:58','twitch1234',NULL,0,0,NULL,'2018-04-01 00:11:58',0,NULL,NULL),(33,'newuser12345','$2y$10$FSU0s3/nfmC9zH5tolWImexne3uVNYCD2C/4FAslm3A33Ck7FGtP6',NULL,0,'2018-04-01 00:13:50','twitch12345',NULL,0,0,NULL,'2018-04-01 00:13:50',0,NULL,NULL),(38,'newuser123456','$2y$10$NbkEslvVV.of/NsSltrwteOkpLApkS7O5TGWf88g9ca8Gcqfy.qN.',NULL,0,'2018-04-02 13:10:30','twitch123456',NULL,0,0,NULL,'2018-04-02 13:10:30',0,NULL,NULL),(49,'newuser1234567','$2y$10$1cHYIFRQP/cpvzoZd5WhBOmPKtRvbmVU32iiILChluilWKmOD4VEy',NULL,0,'2018-04-02 13:29:10','twitch1234567',NULL,0,0,NULL,'2018-04-02 13:29:10',0,NULL,NULL),(51,'1user','$2y$10$XUkSzN6gxdSWE4.sF06m7ObE0jMI6m1oTfMN2TG3y2T1GjG67SHMW',NULL,0,'2018-04-02 13:31:39','1twitch',NULL,0,0,NULL,'2018-04-02 13:31:39',0,NULL,NULL);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Watching`
--

DROP TABLE IF EXISTS `Watching`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Watching` (
  `watchID` int(11) NOT NULL AUTO_INCREMENT,
  `watchedTwitchID` varchar(255) NOT NULL,
  `viewerPersonalID` int(11) DEFAULT NULL,
  PRIMARY KEY (`watchID`),
  KEY `watchedTwitchID` (`watchedTwitchID`),
  KEY `viewerPersonalID` (`viewerPersonalID`),
  CONSTRAINT `Watching_ibfk_1` FOREIGN KEY (`watchedTwitchID`) REFERENCES `Twitch_Data` (`userID`),
  CONSTRAINT `Watching_ibfk_2` FOREIGN KEY (`viewerPersonalID`) REFERENCES `Users` (`personalID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Watching`
--

LOCK TABLES `Watching` WRITE;
/*!40000 ALTER TABLE `Watching` DISABLE KEYS */;
INSERT INTO `Watching` VALUES (1,'dummytwitch',1);
/*!40000 ALTER TABLE `Watching` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-02 14:58:10
