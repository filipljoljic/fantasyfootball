CREATE DATABASE  IF NOT EXISTS `fantasyfootball` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fantasyfootball`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: fantasyfootball
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fixtures`
--

DROP TABLE IF EXISTS `fixtures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fixtures` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `Teams` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Result` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Venue` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LeagueID` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `LeagueID` (`LeagueID`),
  CONSTRAINT `fixtures_ibfk_1` FOREIGN KEY (`LeagueID`) REFERENCES `leagues` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fixtures`
--

LOCK TABLES `fixtures` WRITE;
/*!40000 ALTER TABLE `fixtures` DISABLE KEYS */;
/*!40000 ALTER TABLE `fixtures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leagues`
--

DROP TABLE IF EXISTS `leagues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leagues` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Ranking` int DEFAULT NULL,
  `EntryFee` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leagues`
--

LOCK TABLES `leagues` WRITE;
/*!40000 ALTER TABLE `leagues` DISABLE KEYS */;
/*!40000 ALTER TABLE `leagues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foot` enum('left','right','both') COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detailed_position` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int NOT NULL,
  `nation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
INSERT INTO `players` VALUES (1,'Muhamed','Šahinović','both','GK','1',20,'Bosnia and Herzegovina'),(2,'Lovre','Rogić','both','GK','39',28,'Croatia'),(3,'Besim','Šerbečić','both','DF','21',25,'Bosnia and Herzegovina'),(4,'Samir','Zeljković','both','DF','6',26,'Bosnia and Herzegovina'),(5,'Vinko','Soldo','both','DF','24',25,'Croatia'),(6,'Miomir','Đuričković','both','DF','44',26,'Montenegro'),(7,'Muharem','Trako','both','DF','4',20,'Bosnia and Herzegovina'),(8,'Marin','Aničić','both','DF','28',34,'Bosnia and Herzegovina'),(9,'Elvir','Duraković','both','DF','3',23,'Bosnia and Herzegovina'),(10,'Slaviša','Radović','both','DF','23',30,'Serbia'),(11,'Amar','Beganović','both','DF','22',23,'Bosnia and Herzegovina'),(12,'Enedin','Mulalić','both','DF','30',19,'Bosnia and Herzegovina'),(13,'Ivan','Jelić Balta','both','MF','5',31,'Croatia'),(14,'Haris','Alisah','both','MF','15',19,'Bosnia and Herzegovina'),(15,'Mario','Vrančić','both','MF','8',34,'Bosnia and Herzegovina'),(16,'Muhamed','Buljubašić','both','MF','50',19,'Bosnia and Herzegovina'),(17,'Nemanja','Anđušić','both','MF','32',27,'Bosnia and Herzegovina'),(18,'Daniel','Avramovski','both','MF','27',28,'North Macedonia'),(19,'Mirza','Mustafić','both','MF','98',25,'Bosnia and Herzegovina'),(20,'Edin','Julardžija','both','MF','18',22,'Croatia'),(21,'Almedin','Ziljkić','both','FW','77',27,'Bosnia and Herzegovina'),(22,'Adalberto','Peñaranda','both','FW','10',26,'Venezuela'),(23,'Francis','Kyeremeh','both','FW','11',26,'Ghana'),(24,'Kevin','Viveros','both','FW','19',23,'Colombia'),(25,'Ajdin','Hasić','both','FW','17',22,'Bosnia and Herzegovina'),(26,'Renan','Oliveira','both','FW','9',26,'Brazil'),(27,'Hamza','Čataković','both','FW','7',26,'Bosnia and Herzegovina');
/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playerstatistics`
--

DROP TABLE IF EXISTS `playerstatistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `playerstatistics` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `PlayerID` int NOT NULL,
  `Goals` int DEFAULT NULL,
  `Assists` int DEFAULT NULL,
  `Injuries` int DEFAULT NULL,
  `MinutesPlayed` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `PlayerID` (`PlayerID`),
  CONSTRAINT `playerstatistics_ibfk_1` FOREIGN KEY (`PlayerID`) REFERENCES `players` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playerstatistics`
--

LOCK TABLES `playerstatistics` WRITE;
/*!40000 ALTER TABLE `playerstatistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `playerstatistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teamleague`
--

DROP TABLE IF EXISTS `teamleague`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teamleague` (
  `TeamID` int NOT NULL,
  `LeagueID` int NOT NULL,
  PRIMARY KEY (`TeamID`,`LeagueID`),
  KEY `LeagueID` (`LeagueID`),
  CONSTRAINT `teamleague_ibfk_1` FOREIGN KEY (`TeamID`) REFERENCES `teams` (`ID`),
  CONSTRAINT `teamleague_ibfk_2` FOREIGN KEY (`LeagueID`) REFERENCES `leagues` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teamleague`
--

LOCK TABLES `teamleague` WRITE;
/*!40000 ALTER TABLE `teamleague` DISABLE KEYS */;
/*!40000 ALTER TABLE `teamleague` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserID` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userleague`
--

DROP TABLE IF EXISTS `userleague`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userleague` (
  `UserID` int NOT NULL,
  `LeagueID` int NOT NULL,
  PRIMARY KEY (`UserID`,`LeagueID`),
  KEY `LeagueID` (`LeagueID`),
  CONSTRAINT `userleague_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  CONSTRAINT `userleague_ibfk_2` FOREIGN KEY (`LeagueID`) REFERENCES `leagues` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userleague`
--

LOCK TABLES `userleague` WRITE;
/*!40000 ALTER TABLE `userleague` DISABLE KEYS */;
/*!40000 ALTER TABLE `userleague` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DateJoined` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-13 19:20:13
