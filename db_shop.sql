-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: shop
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB

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
-- Table structure for table `car_brand`
--

DROP TABLE IF EXISTS `car_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_brand`
--

LOCK TABLES `car_brand` WRITE;
/*!40000 ALTER TABLE `car_brand` DISABLE KEYS */;
INSERT INTO `car_brand` VALUES (0,' не выбрано'),(1,'Chevrolet'),(2,'BMW'),(3,'Ford'),(4,'Audi'),(5,'Skoda');
/*!40000 ALTER TABLE `car_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_model`
--

DROP TABLE IF EXISTS `car_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `car_brand` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_model`
--

LOCK TABLES `car_model` WRITE;
/*!40000 ALTER TABLE `car_model` DISABLE KEYS */;
INSERT INTO `car_model` VALUES (0,' не выбрано',0),(1,'Cruze',1),(20,'2-series',2),(30,'Focus',3),(40,'A6',4),(50,'Octavia',5);
/*!40000 ALTER TABLE `car_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(10,2) NOT NULL,
  `start` date NOT NULL,
  `stop` date NOT NULL,
  `name` varchar(200) NOT NULL COMMENT 'название акции/скидки',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='скидки и акции';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
INSERT INTO `discounts` VALUES (1,5.00,'2010-06-01','2025-12-31','подарочная'),(2,10.00,'2023-04-01','2023-12-31','Скидка'),(5,1.00,'2023-10-01','2023-10-31','новая');
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ord_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (17,5,27,1.00,451.00,1),(18,5,25,2.00,285.00,1),(20,5,24,2.00,105.00,1),(22,5,28,1.00,2100.00,1),(25,8,27,3.00,270.00,1),(28,7,28,1.00,2100.00,20),(29,7,25,1.00,769.50,20),(30,10,24,8.00,2700.00,1),(31,10,28,2.00,4200.00,1),(32,9,28,1.00,4200.00,20),(33,9,25,1.00,3000.00,20),(34,9,27,1.00,4800.00,20),(35,13,33,1.00,220.50,1),(36,11,33,1.00,220.50,19),(37,11,25,1.00,3000.00,19),(38,11,28,1.00,4200.00,19),(39,12,25,1.00,3000.00,19),(40,12,32,1.00,5400.00,19),(41,12,34,1.00,87.00,19),(42,13,28,1.00,4200.00,1),(43,14,33,2.00,220.50,11),(44,14,25,2.00,3000.00,11),(45,14,28,1.00,4200.00,11),(46,15,26,1.00,4200.00,19),(47,15,32,1.00,6850.00,19),(48,15,38,1.00,5040.00,19);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `descr` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `levels`
--

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
INSERT INTO `levels` VALUES (1,'пользователь'),(2,'менеджер'),(10,'администратор');
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'2023-12-04 19:29:00',1,1),(2,'2023-12-02 19:16:52',19,0),(3,'2023-12-02 21:30:58',20,0),(5,'2023-12-26 08:31:14',1,0),(6,'2023-10-26 08:31:26',1,0),(7,'2022-11-26 08:38:57',20,0),(8,'2023-11-30 08:30:39',1,0),(9,'2023-11-14 13:53:48',20,0),(10,'2023-04-22 08:08:06',1,0),(11,'2023-12-22 20:17:44',19,0),(12,'2023-10-22 20:17:59',19,0),(13,'2023-11-24 17:23:01',1,0),(14,'2023-12-24 17:39:32',11,0),(15,'2023-12-28 12:58:31',19,0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `descr` text DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount_id` int(11) NOT NULL COMMENT 'id акции или скидки',
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `weight` int(11) NOT NULL COMMENT 'масса',
  `length` int(11) NOT NULL COMMENT 'длина',
  `width` int(11) NOT NULL COMMENT 'ширина',
  `height` int(11) NOT NULL COMMENT 'высота',
  `amount` int(11) NOT NULL COMMENT 'количество',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (24,'Стекло правой фары для Chevrolet Cruze 2008-2015','',NULL,2500.00,0,'2022-10-05 11:35:20',0,0,0,0,0),(25,'Стекло на левую фару для Chevrolet Cruze 2008-2015','',NULL,300.00,0,'2022-10-13 08:37:16',0,0,0,0,1),(26,'Стекло на левую фару для Audi A3 2013-2016 дорестайлинг','',NULL,4200.00,0,'2022-11-11 11:37:58',0,0,0,0,3),(27,'Стекло на левую фару для Skoda Superb 2 2009-2013 дорестайлинг','',NULL,3150.00,1,'2022-09-07 08:23:28',0,0,0,0,5),(28,'Стекло правой фары для Skoda Octavia A5 2008-2013 рестайлинг','',NULL,2750.00,0,'2022-10-13 11:42:33',0,0,0,0,4),(32,'Стекло на левую фару для Audi A3 2016-2020 рестайлинг','Базовая единица: шт\r\n    Для замены на оригинальных фарах Audi A3 2016-2020 рестайлинг',NULL,6850.00,0,'2023-04-14 09:30:14',0,0,0,0,7),(33,'Стекло на левую фару для Ford Focus 3 2015-2018 рестайлинг',NULL,NULL,2600.00,2,'2023-04-22 09:56:49',0,0,0,0,14),(34,'Стекло правой фары для Mercedes Viano Vito W639 2010-2015 рестайлинг','',NULL,3600.00,0,'2023-04-22 09:58:42',0,0,0,0,7),(35,'Стекло правой фары для Audi Q3 2015-2018 рестайлинг','Базовая единица: шт\r\n    Для замены на оригинальных фарах Audi Q3 2015-2018 рестайлинг',NULL,5800.00,0,'2023-12-23 14:37:22',0,0,0,0,2),(36,'Стекло на левую фару для BMW 3 G20 2018','',NULL,11200.00,0,'2023-12-23 14:37:58',0,0,0,0,7),(37,'Стекло правой фары для BMW 3 E46 Sedan 1996-2003 дорестайлинг','Для замены на оригинальных фарах (БМВ) BMW 3 серии E46 Sedan 1996-2003 дорестайлинг',NULL,1900.00,0,'2023-12-23 14:39:00',0,0,0,0,8),(38,'Стекло на левую фару для BMW 1 F20 F21 2011-2015','',NULL,5600.00,2,'2023-12-23 14:40:24',0,0,0,0,6),(39,'Стекло на левую фару для Jaguar XJ 2010-2015','',NULL,8300.00,0,'2023-12-28 11:58:22',0,0,0,0,2);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `descr` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` VALUES (0,'открыт'),(1,'закрыт'),(2,'удален'),(4,'отменен'),(5,'ожидает доставку');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(100) DEFAULT NULL COMMENT 'фамилия',
  `name` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `rank` varchar(200) DEFAULT NULL COMMENT 'должность',
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `date_reg` datetime DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Чибис','Инна','Геннадьевна','администратор','7913020000','ул.Знойная,45-26','admin','admin',NULL,NULL,10),(11,'Фенисов','Кузьма','','','794132164981','ул.Жвойского, 56-602','fen','fen',NULL,NULL,1),(12,'2234','','','','2234','2234','2234','2234',NULL,NULL,0),(14,'Зимний','Иван','','','','','zim','zim',NULL,NULL,2),(19,'Лукин','Лука','Лукич','','','','luk','luk',NULL,NULL,1),(20,'Жигалин','Петр','Аркадьевич','','791616161146','','tttt','ggg',NULL,NULL,1);
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

-- Dump completed on 2024-02-12  1:07:15
