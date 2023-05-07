CREATE DATABASE  IF NOT EXISTS `ai2m` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `ai2m`;
-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: aim2
-- ------------------------------------------------------
-- Server version	5.7.42-log

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Hot drinks'),(2,'Cold drinks');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(45) COLLATE utf8_bin NOT NULL,
  `room` varchar(45) COLLATE utf8_bin NOT NULL,
  `ext` int(11) NOT NULL,
  `status` enum('processing','out for delivery','done') COLLATE utf8_bin DEFAULT 'processing',
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `comment` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (4,'1997-09-12','1',1,'out for delivery',1,990,''),(5,'1997-09-12','1',1,'out for delivery',1,1120,''),(6,'1997-09-12','2',2,'out for delivery',1,1990,''),(7,'1997-09-12','2',2,'out for delivery',1,1990,''),(8,'1997-09-12','2',3,'out for delivery',1,260,''),(10,'1997-09-12','3',2,'out for delivery',1,1080,''),(12,'1997-09-12','1',22,'out for delivery',1,1220,'Nope'),(13,'1997-09-12','12',3,'out for delivery',1,640,'Extra milk with coffee'),(14,'1997-09-12','120',55,'out for delivery',1,1170,'Mohammed adel'),(15,'1997-09-12','1111111',31,'processing',1,1400,'Trying'),(24,'1997-09-12','11',22,'processing',1,1640,'test'),(25,'1997-09-12','12',32,'processing',1,440,'hello'),(26,'1997-09-12','12',32,'processing',1,330,'mooo'),(27,'1997-09-12','123',321,'out for delivery',2,790,'Nothing to say'),(29,'1997-09-12','12',32,'processing',1,960,'lol'),(31,'1997-09-12','12',22,'processing',1,1060,'second aniation'),(32,'1997-09-12','3331',2221,'out for delivery',1,1240,'3 animation'),(34,'1997-09-12','21',321,'out for delivery',1,1070,'Special offers'),(35,'1997-09-12','1',1,'out for delivery',2,1050,'user ehab');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_product` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `sub_total` float DEFAULT NULL,
  KEY `order_id_idx` (`order_id`),
  KEY `product_id_idx` (`product_id`),
  CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` VALUES (5,5,3,NULL),(5,4,2,NULL),(5,6,4,NULL),(6,8,7,910),(6,7,3,390),(6,6,3,360),(6,4,3,330),(7,8,7,910),(7,4,3,330),(7,6,3,360),(7,7,3,390),(8,6,1,120),(8,5,1,140),(10,5,2,280),(10,4,4,440),(10,6,3,360),(12,4,4,440),(12,5,3,420),(12,6,3,360),(13,5,2,280),(13,6,3,360),(14,5,2,280),(14,3,1,110),(14,6,1,120),(14,4,4,440),(14,2,1,110),(14,1,1,110),(15,6,2,240),(15,5,2,280),(15,3,6,660),(15,4,1,110),(15,1,1,110),(24,5,8,1120),(24,8,4,520),(25,1,4,440),(26,2,3,330),(27,5,4,560),(27,4,1,110),(27,6,1,120),(29,5,1,140),(29,6,5,600),(29,2,1,110),(29,1,1,110),(31,5,1,140),(31,6,4,480),(31,3,1,110),(31,2,3,330),(34,8,1,130),(34,7,3,390),(34,2,3,330),(34,1,1,110),(34,3,1,110),(35,2,4,440),(35,5,1,140),(35,6,3,360),(35,1,1,110);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(45) COLLATE utf8_bin NOT NULL,
  `is_available` tinyint(1) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `category_id_idx` (`category_id`),
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Tea',110,'tea.webp',1,1),(2,'Sunshine',110,'sun_shine.png',1,2),(3,'Milk',110,'milk.jpg',1,1),(4,'Nescafe',110,'nescafe.jpg',1,1),(5,'Orange juice',140,'juice.jpg',1,2),(6,'Coffee',120,'coffee.jpeg',1,1),(7,'Hot chocolate',130,'hot_chocolate.jpg',1,1),(8,'Hot borio',130,'hot_borio.jpg',1,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `password` varchar(45) COLLATE utf8_bin NOT NULL,
  `room_no` int(11) NOT NULL,
  `ext` int(11) NOT NULL,
  `secret_key` varchar(45) COLLATE utf8_bin NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `profile_picture` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'mario','mario@gmail.com','123',123,123,'123',1,'1682739722.jpeg'),(2,'Ehab','ehab@gmail.com','123',123,123,'123',0,'');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-07 21:57:31
