-- MySQL dump 10.13  Distrib 5.7.20, for osx10.12 (x86_64)
--
-- Host: localhost    Database: marathon
-- ------------------------------------------------------
-- Server version	5.7.20

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
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `bibid` int(11) NOT NULL,
  `checkpoint_id` int(11) NOT NULL,
  `server_time` datetime NOT NULL,
  `lap1_time` bigint(20) NOT NULL,
  `lap2_time` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  KEY `checkpoint_id` (`checkpoint_id`,`server_time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup_runner`
--

DROP TABLE IF EXISTS `backup_runner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_runner` (
  `checkpoint_id` int(11) NOT NULL,
  `bibid` int(11) NOT NULL,
  `lap1_time` int(11) NOT NULL,
  `lab2_time` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `time` datetime NOT NULL,
  KEY `checkpoint_id` (`checkpoint_id`,`bibid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `checkpoints`
--

DROP TABLE IF EXISTS `checkpoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `checkpoints` (
  `checkpoint_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `time_init` bigint(20) NOT NULL,
  `last_ping` bigint(20) NOT NULL,
  `distance` float NOT NULL,
  `server_init` bigint(11) NOT NULL,
  `password` varchar(25) NOT NULL,
  PRIMARY KEY (`checkpoint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmd_log`
--

DROP TABLE IF EXISTS `cmd_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmd_log` (
  `checkpoint_id` int(11) NOT NULL,
  `cmd` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `client_time` datetime NOT NULL,
  KEY `checkpoint_id` (`checkpoint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participants` (
  `bibid` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `sex` varchar(10) NOT NULL DEFAULT 'Male',
  `email` varchar(70) NOT NULL,
  `ph_no` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `college` text NOT NULL,
  `econtact_name` varchar(50) NOT NULL,
  `econtact` varchar(12) NOT NULL,
  `allergy` text,
  PRIMARY KEY (`bibid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `race_details`
--

DROP TABLE IF EXISTS `race_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race_details` (
  `name` varchar(50) NOT NULL,
  `racer_count` int(11) NOT NULL,
  `no_checkpoint` int(11) NOT NULL,
  `race_status` int(11) NOT NULL,
  `server_time` bigint(20) NOT NULL,
  `distance` float NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `racers`
--

DROP TABLE IF EXISTS `racers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `racers` (
  `bibid` int(11) NOT NULL,
  `checkpoint_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `lap1_time` bigint(20) NOT NULL DEFAULT '0',
  `lap2_time` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bibid`,`checkpoint_id`),
  CONSTRAINT `ra_part_contraint_1` FOREIGN KEY (`bibid`) REFERENCES `participants` (`bibid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-10 11:45:33
