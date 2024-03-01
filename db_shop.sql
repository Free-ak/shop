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
-- Table structure for table `type_of_light_reflector`
--

DROP TABLE IF EXISTS `type_of_light_reflector`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_light_reflector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(200) ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_of_light_reflector`
--

LOCK TABLES `type_of_light_reflector` WRITE;
/*!40000 ALTER TABLE `type_of_light_reflector` DISABLE KEYS */;
INSERT INTO `type_of_light_reflector` (`id`,`descr`) 
VALUES 
(0,"не выбрано"),
(1, "Рефлектор"),
(2, "Галогеновая линза"),
(3, "Led модуль"),
(5,"Bi-led модуль"),
(6,"Xenon линза"),
(7,"Bi-xenon линза"),
(8,"Полоса");
/*!40000 ALTER TABLE `type_of_light_reflector` ENABLE KEYS */;
UNLOCK TABLES;


-- Table structure for table `type_of_light_reflector`
--

DROP TABLE IF EXISTS `type_of_light_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_light_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(200) ,
  `power` int,
  `lumen` int,
  `voltage` int,
  `glow_temperature` int,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_of_light_source`
--

LOCK TABLES `type_of_light_source` WRITE;
/*!40000 ALTER TABLE `type_of_light_source` DISABLE KEYS */;


INSERT INTO `type_of_light_source` (`descr`, `power`, `lumen`, `voltage`, `glow_temperature`) VALUES
('Автомобильная лампа', null, null, null, null),
('LED', 100, 3000, 12, 5500),
('LED', 100, 3000, 12, 6000),
('LED', 100, 3000, 12, 4300),
('LED', 50, 4500, 12, 6000),
('LED', 15, 500, 12, 2000),
('LED', 15, 500, 12, 1000),
('Ксенон', 35, 2800, 80, 3000),
('Ксенон', 35, 3000, 80, 5000),
('Ксенон', 35, 2600, 80 , 6000),
('Ксенон', 50, 3800, 80, 3000),
('Ксенон', 50, 3900, 80, 5000),
('Ксенон', 50, 3600, 80, 6000),
('Галоген', 55, 1000, 12, 3000),
('Галоген', 55, 1000, 12, 4300),
('Галоген', 21, 250, 12, 1000),
('Галоген', 21, 250, 12, 2000),
('LED', 15, 500, 12, 5500),
('LED', 15, 250, 12, 5500);
/*!40000 ALTER TABLE `type_of_light_source` ENABLE KEYS */;
UNLOCK TABLES;


-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(200) ,
  `type_of_light_reflector` int,
  `type_of_light_source` int,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`descr`,  `type_of_light_source`,`type_of_light_reflector`) 
VALUES 
('Не выбрано', 0, 0),
('Ближний свет', 1,5),
('Ближний свет', 2,5 ),
('Ближний свет', 3,5 ),
('Ближний свет', 4,7 ),
('Ближний свет', 7, 7),
('Ближний свет', 8, 7),
('Ближний свет', 9,7 ),
('Ближний свет', 10,7 ),
('Дальний свет', 13,1),
('Дальний свет', 4,3 ),
('Поворотник', 15,1 ),
('Поворотник', 15,8 ),
('Задний ход', 6,1 ),
('Задний ход', 16,8 ),
('Дхо', 17,8 ),
('Габаритные огни', 18,8 );
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

-- Table structure for table `type_of_light_product`
--
DROP TABLE IF EXISTS `type_of_light_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_light_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(200) ,
  `Поворотник` int UNSIGNED null,
  `Ближний свет` int UNSIGNED null,
  `Дальний свет` int UNSIGNED null,
  `Габаритные огни` int UNSIGNED null,
  `ДХО` int UNSIGNED null,
  `Задний ход` int UNSIGNED null,
  `Противотуманная фара` int UNSIGNED null,
  `Противотуманный фонарь` int UNSIGNED null,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_of_light_product`
--

LOCK TABLES `type_of_light_product` WRITE;
/*!40000 ALTER TABLE `type_of_light_product` DISABLE KEYS */;
INSERT INTO `type_of_light_product` (`descr`, `Поворотник`, `Ближний свет`, `Дальний свет`, `Габаритные огни`, `ДХО`, `Задний ход`, `Противотуманная фара`, `Противотуманный фонарь`) 
VALUES 
('Передние Bi-led фары', 6, 2, 5, 10, 10, NULL, NULL, NULL),
('Передние Bi-xenon фары', 15, 3, 3, 10, 10, NULL, NULL, NULL),
('Задние фонари', 8, NULL, NULL, 10, NULL, 17, NULL, 16),
('Дневные ходовые огни', NULL, NULL, NULL, NULL, 15, NULL, NULL, NULL),
('Задний ход и габаритные огни', NULL, NULL, NULL, 10, NULL, 17, NULL, NULL);
/*!40000 ALTER TABLE `type_of_light_product` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimation` int NOT NUll,
  `product_id` int NOT NUll,
  `user_id` int ,
  `descr` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` (`estimation`, `product_id`, `user_id`, `descr`) 
VALUES 
(0,0,Null,"не выбрано"),
(5, 1, 11, "Все понравилось"),
(4, 2, 12, "Пойдет"),
(5, 3, 14, "Установилось по штатным местам"),
(5, 4, 19, "Все работает"),
(4, 4, 20, "Под пиво пойдет");
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NUll,
  `user_id` int,
  `descr` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` (`product_id`, `user_id`, `descr`) 
VALUES 
(0,null,"не выбрано"),
(1, 11, "Работает без ошибок?"),
(2, 12, "Где находится завод производитель?"),
(3, 14, "Установка по штатным местам?"),
(4, 19, "Нужно ли регулировать фары?"),
(4, 20, "Вы занимаетесь установкой?");

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `manufacturer_country`
--

DROP TABLE IF EXISTS `manufacturer_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturer_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manufacturer_country`
--

LOCK TABLES `manufacturer_country` WRITE;
/*!40000 ALTER TABLE `manufacturer_country` DISABLE KEYS */;
INSERT INTO `manufacturer_country` VALUES (0,' не выбрано'),(1,'Россия'),(2,'Китай'),(3,'Тайвань'),(4,'Германия'),(5,'Польша');
/*!40000 ALTER TABLE `manufacturer_country` ENABLE KEYS */;
UNLOCK TABLES;

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
  `name` varchar(200) ,
  `descr` text,
  `type_of_light_product` int,
  `price` decimal(10,2) DEFAULT NULL,
  `discount_id` int(11) NOT NULL COMMENT 'id акции или скидки',
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` int(11) NOT NULL COMMENT 'количество',
  `carbrand` INT UNSIGNED NOT NULL,
  `carmodel` INT UNSIGNED NOT NULL,
  `country` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`name`, `descr`, `type_of_light_product`, `price`, `discount_id`, `date_add`, `amount`, `carbrand`, `carmodel`, `country`)
VALUES
('Передние Bi-led фары Chevrolet Cruze', 'Передние Bi-led фары', 1, 100.00, 1, NOW(), 10, 1, 1, 1),
('Передние Bi-xenon фары BMW 2-series', 'Передние Bi-xenon фары', 2, 200.00, 2, NOW(), 20, 2, 20, 2),
('Задние фонари Ford Focus', 'Задние фонари', 3, 150.00, 0, NOW(), 15, 3, 30, 3),
('Дневные ходовые огни Audi A6', 'Дневные ходовые огни', 4, 120.00, 0, NOW(), 25, 4, 40, 4),
('Задний ход и габаритные огни Skoda Octavia', 'Задний ход и габаритные огни', 5, 80.00, 0, NOW(), 30, 5, 50, 5),
('Передние Bi-led фары Chevrolet Cruze', 'Передние Bi-led фары', 1, 100.00, 1, NOW(), 10, 1, 1, 1),
('Передние Bi-xenon фары BMW 2-series', 'Передние Bi-xenon фары', 2, 200.00, 2, NOW(), 20, 2, 20, 2),
('Задние фонари Ford Focus', 'Задние фонари', 3, 150.00, 0, NOW(), 15, 3, 30, 3),
('Дневные ходовые огни Audi A6', 'Дневные ходовые огни', 4, 120.00, 0, NOW(), 25, 4, 40, 4),
('Задний ход и габаритные огни Skoda Octavia', 'Задний ход и габаритные огни', 5, 80.00, 0, NOW(), 30, 5, 50, 5),
('Передние Bi-led фары Chevrolet Cruze', 'Передние Bi-led фары', 1, 100.00, 1, NOW(), 10, 1, 1, 1),
('Передние Bi-xenon фары BMW 2-series', 'Передние Bi-xenon фары', 2, 200.00, 2, NOW(), 20, 2, 20, 2),
('Задние фонари Ford Focus', 'Задние фонари', 3, 150.00, 0, NOW(), 15, 3, 30, 3),
('Дневные ходовые огни Audi A6', 'Дневные ходовые огни', 4, 120.00, 0, NOW(), 25, 4, 40, 4),
('Задний ход и габаритные огни Skoda Octavia', 'Задний ход и габаритные огни', 5, 80.00, 0, NOW(), 30, 5, 50, 5),
('Передние Bi-led фары Chevrolet Cruze', 'Передние Bi-led фары', 1, 100.00, 1, NOW(), 10, 1, 1, 1),
('Передние Bi-xenon фары BMW 2-series', 'Передние Bi-xenon фары', 2, 200.00, 2, NOW(), 20, 2, 20, 2),
('Задние фонари Ford Focus', 'Задние фонари', 3, 150.00, 0, NOW(), 15, 3, 30, 3),
('Дневные ходовые огни Audi A6', 'Дневные ходовые огни', 4, 120.00, 0, NOW(), 25, 4, 40, 4),
('Задний ход и габаритные огни Skoda Octavia', 'Задний ход и габаритные огни', 5, 80.00, 0, NOW(), 30, 5, 50, 5);
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
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `car_brand` int (11) DEFAULT NULL,
  `car_model` int (11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `surname`, `name`, `middlename`, `rank`, `phone`, `address`, `password`, `login`, `date_reg`, `email`, `level`, `car_brand`, `car_model`) VALUES
(1,'Чибис','Инна','Геннадьевна','администратор','7913020000','ул.Знойная,45-26','admin','admin',NULL,NULL,10,NULL,NULL),
(11,'Фенисов','Кузьма','','','794132164981','ул.Жвойского, 56-602','fen','fen',NULL,NULL,1,NULL,NULL),
(12,'2234','','','','2234','2234','2234','2234',NULL,NULL,0,NULL,NULL),
(14,'Зимний','Иван','','','','','zim','zim',NULL,NULL,2,NULL,NULL),
(19,'Лукин','Лука','Лукич','','','','luk','luk',NULL,NULL,1,NULL,NULL),
(20,'Жигалин','Петр','Аркадьевич','','791616161146','','tttt','ggg',NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_message`
--

DROP TABLE IF EXISTS `student_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_message` (
    `student_message_id` int unsigned not null auto_increment primary key,
    `student_id` int unsigned not null,
    `student_message_date` datetime,
    `student_message_text` text,
    FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_message`
--

-- LOCK TABLES `student_message` WRITE;
-- /*!40000 ALTER TABLE `users` student_message KEYS */;
-- /*!40000 ALTER TABLE `users` ENABLE KEYS */;
-- UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
-- Dump completed on 2024-02-12  1:07:15
