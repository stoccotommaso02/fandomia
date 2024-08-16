-- MySQL dump 10.13  Distrib 8.4.0, for Linux (x86_64)
--
-- Host: localhost    Database: testdb
-- ------------------------------------------------------
-- Server version	8.4.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Books`
--

DROP TABLE IF EXISTS `Books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Books` (
  `id` int unsigned NOT NULL,
  `author` varchar(50) NOT NULL,
  `pages` int unsigned DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `Books_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Books`
--

LOCK TABLES `Books` WRITE;
/*!40000 ALTER TABLE `Books` DISABLE KEYS */;
INSERT INTO `Books` VALUES (1,'Author 20',513,'Fiction'),(2,'Author 08',322,'Fiction'),(3,'Author 18',217,'Mystery'),(4,'Author 02',491,'Sci-Fi'),(5,'Author 18',270,'Fiction'),(6,'Author 15',135,'Non-fiction'),(7,'Author 02',348,'Non-fiction'),(8,'Author 04',555,'Fiction'),(9,'Author 07',344,'Mystery'),(10,'Author 05',365,'Fantasy'),(11,'Author 05',248,'Sci-Fi'),(12,'Author 19',282,'Fiction'),(13,'Author 01',159,'Mystery'),(14,'Author 01',473,'Sci-Fi'),(15,'Author 18',398,'Non-fiction'),(16,'Author 14',364,'Mystery'),(17,'Author 08',188,'Sci-Fi'),(18,'Author 01',554,'Mystery'),(19,'Author 18',531,'Sci-Fi'),(20,'Author 14',335,'Non-fiction'),(21,'Author 02',321,'Fiction'),(22,'Author 16',485,'Mystery'),(23,'Author 10',477,'Non-fiction'),(24,'Author 07',399,'Fiction'),(25,'Author 12',395,'Non-fiction');
/*!40000 ALTER TABLE `Books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Categories` (
  `product_id` int unsigned NOT NULL,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`product_id`,`category_name`),
  CONSTRAINT `Categories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comics`
--

DROP TABLE IF EXISTS `Comics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comics` (
  `id` int unsigned NOT NULL,
  `author` varchar(50) NOT NULL,
  `pages` int unsigned DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `Comics_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comics`
--

LOCK TABLES `Comics` WRITE;
/*!40000 ALTER TABLE `Comics` DISABLE KEYS */;
INSERT INTO `Comics` VALUES (63,'Comic Author 11',117,'Manga'),(64,'Comic Author 14',64,'Superhero'),(65,'Comic Author 11',29,'Horror'),(66,'Comic Author 05',60,'Manga'),(67,'Comic Author 13',119,'Superhero'),(68,'Comic Author 14',109,'Graphic Novel'),(69,'Comic Author 17',90,'Horror'),(70,'Comic Author 16',116,'Graphic Novel'),(71,'Comic Author 11',38,'Manga'),(72,'Comic Author 05',116,'Manga'),(73,'Comic Author 04',37,'Graphic Novel'),(74,'Comic Author 10',34,'Manga'),(75,'Comic Author 04',101,'Graphic Novel'),(76,'Comic Author 12',21,'Graphic Novel'),(77,'Comic Author 20',78,'Superhero'),(78,'Comic Author 10',51,'Superhero'),(79,'Comic Author 12',74,'Superhero'),(80,'Comic Author 09',33,'Manga'),(81,'Comic Author 10',40,'Humor'),(82,'Comic Author 11',92,'Superhero'),(83,'Comic Author 02',48,'Superhero'),(84,'Comic Author 19',30,'Humor'),(85,'Comic Author 12',66,'Humor'),(86,'Comic Author 17',37,'Graphic Novel'),(87,'Comic Author 13',106,'Graphic Novel');
/*!40000 ALTER TABLE `Comics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Music`
--

DROP TABLE IF EXISTS `Music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Music` (
  `id` int unsigned NOT NULL,
  `artist` varchar(50) NOT NULL,
  `length` int unsigned DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `format` enum('cd','vinyl','other') DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `Music_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Music`
--

LOCK TABLES `Music` WRITE;
/*!40000 ALTER TABLE `Music` DISABLE KEYS */;
INSERT INTO `Music` VALUES (32,'Artist 15',58,'Pop','vinyl'),(33,'Artist 14',48,'Jazz','cd'),(34,'Artist 09',33,'Electronic','vinyl'),(35,'Artist 20',46,'Jazz','cd'),(36,'Artist 15',36,'Pop','vinyl'),(37,'Artist 19',53,'Pop','other'),(38,'Artist 05',36,'Electronic','cd'),(39,'Artist 15',69,'Rock','other'),(40,'Artist 02',61,'Jazz','other'),(41,'Artist 15',31,'Rock','cd'),(42,'Artist 03',61,'Pop','vinyl'),(43,'Artist 18',84,'Electronic','other'),(44,'Artist 15',70,'Rock','other'),(45,'Artist 15',30,'Electronic','vinyl'),(46,'Artist 05',85,'Rock','vinyl'),(47,'Artist 15',56,'Rock','cd'),(48,'Artist 15',35,'Pop','other'),(49,'Artist 16',44,'Electronic','vinyl'),(50,'Artist 14',39,'Classical','cd'),(51,'Artist 07',52,'Electronic','cd'),(52,'Artist 08',43,'Rock','other'),(53,'Artist 07',56,'Pop','other'),(54,'Artist 02',53,'Classical','vinyl'),(55,'Artist 01',37,'Jazz','vinyl'),(56,'Artist 08',65,'Electronic','vinyl');
/*!40000 ALTER TABLE `Music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `product_type` enum('book','music','comic','videogame') NOT NULL,
  `status` enum('available','not available') DEFAULT NULL,
  `sale_percentage` tinyint unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
INSERT INTO `Products` VALUES (1,'Book 01',52.05,'2022-11-22','book','available',0),(2,'Book 02',40.51,'2020-06-11','book','available',0),(3,'Book 03',15.67,'2022-06-29','book','available',0),(4,'Book 04',39.61,'2021-07-11','book','available',0),(5,'Book 05',25.82,'2020-10-28','book','available',0),(6,'Book 06',25.77,'2020-11-15','book','available',0),(7,'Book 07',44.63,'2022-10-06','book','available',0),(8,'Book 08',54.93,'2022-09-05','book','available',0),(9,'Book 09',19.24,'2021-10-23','book','available',0),(10,'Book 10',35.88,'2020-07-26','book','available',0),(11,'Book 11',30.78,'2022-08-29','book','not available',0),(12,'Book 12',23.82,'2022-06-16','book','available',0),(13,'Book 13',54.52,'2021-12-03','book','available',0),(14,'Book 14',48.21,'2020-08-15','book','available',0),(15,'Book 15',15.23,'2020-11-09','book','not available',0),(16,'Book 16',46.72,'2020-12-11','book','available',0),(17,'Book 17',56.43,'2021-07-20','book','available',0),(18,'Book 18',32.63,'2022-07-31','book','available',0),(19,'Book 19',16.98,'2022-08-05','book','available',0),(20,'Book 20',56.96,'2022-12-04','book','not available',0),(21,'Book 21',28.80,'2022-02-03','book','available',0),(22,'Book 22',46.20,'2021-08-01','book','available',0),(23,'Book 23',48.16,'2021-03-22','book','available',0),(24,'Book 24',35.83,'2021-01-07','book','not available',0),(25,'Book 25',46.21,'2020-07-10','book','available',0),(32,'Album 01',22.10,'2020-02-18','music','available',0),(33,'Album 02',18.06,'2021-11-26','music','available',0),(34,'Album 03',18.11,'2021-09-26','music','available',0),(35,'Album 04',10.88,'2020-08-28','music','available',0),(36,'Album 05',31.68,'2022-10-02','music','available',0),(37,'Album 06',30.68,'2021-07-17','music','not available',0),(38,'Album 07',19.21,'2021-01-27','music','available',0),(39,'Album 08',28.56,'2022-06-05','music','available',0),(40,'Album 09',6.15,'2020-05-01','music','available',0),(41,'Album 10',31.17,'2020-02-11','music','available',0),(42,'Album 11',27.62,'2020-02-23','music','available',0),(43,'Album 12',27.85,'2022-08-03','music','not available',0),(44,'Album 13',22.06,'2022-03-30','music','not available',0),(45,'Album 14',32.92,'2021-08-23','music','available',0),(46,'Album 15',8.17,'2022-01-12','music','not available',0),(47,'Album 16',14.72,'2021-03-20','music','not available',0),(48,'Album 17',6.95,'2020-06-19','music','available',0),(49,'Album 18',18.35,'2021-06-07','music','not available',0),(50,'Album 19',30.12,'2020-01-27','music','available',0),(51,'Album 20',34.42,'2020-03-17','music','available',0),(52,'Album 21',30.08,'2022-11-08','music','available',0),(53,'Album 22',17.10,'2020-10-13','music','not available',0),(54,'Album 23',26.01,'2020-08-18','music','available',0),(55,'Album 24',8.98,'2022-05-31','music','available',0),(56,'Album 25',26.49,'2022-02-08','music','available',0),(63,'Comic 01',19.63,'2020-11-30','comic','available',0),(64,'Comic 02',20.04,'2022-04-09','comic','available',0),(65,'Comic 03',12.79,'2021-01-19','comic','available',0),(66,'Comic 04',22.45,'2021-10-26','comic','available',0),(67,'Comic 05',10.29,'2020-03-19','comic','available',0),(68,'Comic 06',17.12,'2021-01-04','comic','available',0),(69,'Comic 07',11.86,'2020-04-19','comic','available',0),(70,'Comic 08',6.27,'2022-09-11','comic','available',0),(71,'Comic 09',21.44,'2020-08-05','comic','available',0),(72,'Comic 10',5.82,'2021-11-12','comic','available',0),(73,'Comic 11',6.50,'2021-03-24','comic','available',0),(74,'Comic 12',22.61,'2022-10-23','comic','not available',0),(75,'Comic 13',13.45,'2022-11-28','comic','available',0),(76,'Comic 14',5.31,'2020-12-17','comic','available',0),(77,'Comic 15',21.64,'2021-06-12','comic','available',0),(78,'Comic 16',7.88,'2022-11-21','comic','available',0),(79,'Comic 17',5.89,'2020-03-09','comic','not available',0),(80,'Comic 18',18.91,'2022-11-05','comic','available',0),(81,'Comic 19',13.85,'2020-09-18','comic','available',0),(82,'Comic 20',17.31,'2021-06-06','comic','available',0),(83,'Comic 21',10.48,'2022-03-27','comic','available',0),(84,'Comic 22',10.93,'2022-04-14','comic','available',0),(85,'Comic 23',11.52,'2022-08-02','comic','available',0),(86,'Comic 24',6.68,'2021-04-01','comic','available',0),(87,'Comic 25',23.20,'2020-02-27','comic','available',0),(94,'Game 01',40.09,'2020-10-06','videogame','available',0),(95,'Game 02',23.37,'2020-05-01','videogame','available',0),(96,'Game 03',27.26,'2022-12-28','videogame','available',0),(97,'Game 04',29.39,'2022-07-04','videogame','available',0),(98,'Game 05',55.14,'2022-11-16','videogame','not available',0),(99,'Game 06',57.44,'2020-07-28','videogame','not available',0),(100,'Game 07',26.79,'2021-03-17','videogame','available',0),(101,'Game 08',32.62,'2020-03-10','videogame','available',0),(102,'Game 09',46.32,'2020-07-17','videogame','available',0),(103,'Game 10',24.55,'2022-04-27','videogame','available',0),(104,'Game 11',33.23,'2020-03-07','videogame','available',0),(105,'Game 12',35.32,'2022-12-04','videogame','available',0),(106,'Game 13',48.66,'2021-03-09','videogame','available',0),(107,'Game 14',58.82,'2021-01-25','videogame','available',0),(108,'Game 15',31.62,'2022-07-04','videogame','available',0),(109,'Game 16',21.53,'2020-10-14','videogame','not available',0),(110,'Game 17',28.31,'2021-04-27','videogame','available',0),(111,'Game 18',43.47,'2020-07-24','videogame','not available',0),(112,'Game 19',33.02,'2020-04-13','videogame','available',0),(113,'Game 20',27.71,'2021-06-08','videogame','available',0),(114,'Game 21',45.47,'2022-03-21','videogame','available',0),(115,'Game 22',49.11,'2020-10-23','videogame','not available',0),(116,'Game 23',21.23,'2021-12-11','videogame','not available',0),(117,'Game 24',52.55,'2021-11-01','videogame','available',0),(118,'Game 25',30.45,'2021-05-05','videogame','available',0),(119,'Vitae laborum ullam.',26.11,'2019-10-12','book','not available',48),(120,'Consequuntur consequuntur atque reiciendis.',29.14,'2023-09-06','book','not available',31),(121,'Tempore placeat.',29.19,'2022-08-26','book','available',22),(122,'Et odit dignissimos mollitia.',12.05,'2022-02-24','book','not available',48),(123,'Totam at saepe quae quos.',29.68,'2025-04-04','book','not available',34),(124,'Quas provident aperiam.',7.47,'2024-04-10','book','available',4),(125,'Ipsum aspernatur eum magni ut.',13.84,'2016-06-22','book','available',20),(126,'Repellendus molestiae vitae nobis.',29.17,'2024-08-13','book','not available',30),(127,'Nemo enim deleniti delectus.',6.56,'2025-01-16','book','not available',35),(128,'Perspiciatis consectetur.',22.76,'2017-03-01','book','not available',50),(129,'Saepe minima maxime doloremque.',25.70,'2018-04-13','book','not available',21),(130,'Laudantium odit praesentium voluptatem.',22.59,'2020-09-12','book','available',4),(131,'Nesciunt excepturi deleniti accusamus.',10.97,'2019-03-26','book','available',9),(132,'Ex repellendus aut.',7.01,'2017-02-09','book','available',20),(133,'Perspiciatis ad odio non nemo.',12.54,'2021-04-10','book','not available',18),(134,'Non deserunt.',25.36,'2017-10-07','book','not available',34),(135,'Vel ad.',16.12,'2021-11-10','book','available',38),(136,'Dolore officia.',12.26,'2020-07-30','book','not available',12),(137,'Iusto nisi praesentium hic.',16.91,'2019-01-17','book','available',5),(138,'Ratione culpa.',28.08,'2017-05-17','book','not available',5);
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reservation`
--

DROP TABLE IF EXISTS `Reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `username` varchar(25) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` char(11) NOT NULL,
  `notes` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `username` (`username`),
  CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`),
  CONSTRAINT `Reservation_ibfk_2` FOREIGN KEY (`username`) REFERENCES `Users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservation`
--

LOCK TABLES `Reservation` WRITE;
/*!40000 ALTER TABLE `Reservation` DISABLE KEYS */;
INSERT INTO `Reservation` VALUES (1,105,'user1@email.com','2024-08-28','10:00-11:00',''),(2,96,'user1@email.com','2024-08-29','12:00-13:00',''),(3,96,'user1@email.com','2024-09-03','10:00-11:00','');
/*!40000 ALTER TABLE `Reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `username` varchar(25) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES ('iulius@gmail.com',''),('iulius2@mail.com','d-mase24'),('iulius3@mail.com','todaro24'),('iulius4@gmail.com','d-mase24'),('todaro@gmail.com','D-mase24'),('user1@email.com','password1'),('user10@email.com','password10'),('user2@email.com','password2'),('user3@email.com','password3'),('user4@email.com','password4'),('user5@email.com','password5'),('user6@email.com','password6'),('user7@email.com','password7'),('user8@email.com','password8'),('user9@email.com','password9');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Videogames`
--

DROP TABLE IF EXISTS `Videogames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Videogames` (
  `id` int unsigned NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `developer` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `Videogames_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Videogames`
--

LOCK TABLES `Videogames` WRITE;
/*!40000 ALTER TABLE `Videogames` DISABLE KEYS */;
INSERT INTO `Videogames` VALUES (94,'Adventure','Developer 07'),(95,'Sports','Developer 16'),(96,'Sports','Developer 02'),(97,'Strategy','Developer 16'),(98,'Sports','Developer 02'),(99,'FPS','Developer 11'),(100,'Strategy','Developer 06'),(101,'Sports','Developer 16'),(102,'Sports','Developer 02'),(103,'Strategy','Developer 18'),(104,'RPG','Developer 17'),(105,'Sports','Developer 10'),(106,'RPG','Developer 03'),(107,'FPS','Developer 05'),(108,'RPG','Developer 04'),(109,'FPS','Developer 01'),(110,'RPG','Developer 14'),(111,'Adventure','Developer 17'),(112,'FPS','Developer 19'),(113,'Sports','Developer 18'),(114,'RPG','Developer 03'),(115,'RPG','Developer 13'),(116,'Strategy','Developer 08'),(117,'Strategy','Developer 10'),(118,'Sports','Developer 10');
/*!40000 ALTER TABLE `Videogames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Wishlist`
--

DROP TABLE IF EXISTS `Wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Wishlist` (
  `user_username` varchar(25) NOT NULL,
  `product_id` int unsigned NOT NULL,
  PRIMARY KEY (`user_username`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `Wishlist_ibfk_1` FOREIGN KEY (`user_username`) REFERENCES `Users` (`username`),
  CONSTRAINT `Wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Wishlist`
--

LOCK TABLES `Wishlist` WRITE;
/*!40000 ALTER TABLE `Wishlist` DISABLE KEYS */;
INSERT INTO `Wishlist` VALUES ('user2@email.com',2),('user10@email.com',3),('user8@email.com',3),('user9@email.com',4),('user1@email.com',5),('user6@email.com',5),('user8@email.com',6),('user1@email.com',7),('user4@email.com',7),('user9@email.com',7),('user2@email.com',8),('user9@email.com',9),('user5@email.com',10),('user4@email.com',11),('user7@email.com',11),('user7@email.com',13),('user7@email.com',14),('user3@email.com',15),('user4@email.com',15),('user2@email.com',16),('user4@email.com',16),('user4@email.com',17),('user1@email.com',18),('user2@email.com',21),('user4@email.com',21),('user3@email.com',32),('user4@email.com',32),('user5@email.com',32),('user3@email.com',33),('user7@email.com',33),('user10@email.com',34),('user10@email.com',35),('user5@email.com',35),('user3@email.com',36),('user10@email.com',37),('user2@email.com',37),('user10@email.com',39),('user2@email.com',39),('user3@email.com',39),('user1@email.com',42),('user7@email.com',42),('user3@email.com',43),('user8@email.com',43),('user1@email.com',44),('user6@email.com',45),('user2@email.com',47),('user2@email.com',49),('user5@email.com',49),('user9@email.com',50),('user6@email.com',52),('user8@email.com',52),('user1@email.com',53),('user10@email.com',54),('user2@email.com',56),('user6@email.com',56),('user8@email.com',56),('user8@email.com',65),('user4@email.com',66),('user7@email.com',66),('user10@email.com',67),('user3@email.com',67),('user4@email.com',67),('user6@email.com',68),('user3@email.com',69),('user9@email.com',69),('user9@email.com',70),('user3@email.com',72),('user9@email.com',72),('user3@email.com',74),('user4@email.com',74),('user1@email.com',75),('user2@email.com',75),('user4@email.com',76),('user2@email.com',77),('user8@email.com',79),('user3@email.com',80),('user3@email.com',82),('user2@email.com',83),('user7@email.com',83),('user6@email.com',87),('user6@email.com',94),('user8@email.com',96),('user10@email.com',97),('user10@email.com',98),('user5@email.com',98),('user8@email.com',98),('user10@email.com',99),('user5@email.com',100),('user7@email.com',101),('user3@email.com',103),('user7@email.com',103),('user8@email.com',103),('user1@email.com',104),('user10@email.com',104),('user5@email.com',104),('user2@email.com',108),('user8@email.com',108),('user1@email.com',109),('user3@email.com',110),('user6@email.com',110);
/*!40000 ALTER TABLE `Wishlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-16 11:24:28
