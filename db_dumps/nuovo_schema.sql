
DROP TABLE IF EXISTS `Reservation`;
DROP TABLE IF EXISTS `Videogames`;
DROP TABLE IF EXISTS `Music`;
DROP TABLE IF EXISTS `Books`;
DROP TABLE IF EXISTS `Comics`;
DROP TABLE IF EXISTS `Products`;
DROP TABLE IF EXISTS `Users`;

CREATE TABLE `Users` (
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY(`email`)
);

CREATE TABLE `Products` (
  `id` int unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) unsigned DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `product_type` enum('Libro', 'Musica', 'Fumetto', 'Videogioco') NOT NULL,
  `status` enum('Disponibile', 'Non disponibile') DEFAULT NULL,
  `sale_percentage` tinyint unsigned DEFAULT 0,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

CREATE TABLE `Books` (
  `id` int unsigned NOT NULL,
  `Autore` varchar(50) NOT NULL,
  `Pagine` int unsigned DEFAULT NULL,
  `Genere` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `Products`(`id`)
);

CREATE TABLE `Music` (
  `id` int unsigned NOT NULL,
  `Artista` varchar(50) NOT NULL,
  `Durata (minuti)` int unsigned DEFAULT NULL,
  `Genere` varchar(50) DEFAULT NULL,
  `Formato` enum('CD', 'Vinile', 'Altro'),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `Products`(`id`)
);

CREATE TABLE `Comics` (
  `id` int unsigned NOT NULL,
  `Autore` varchar(50) NOT NULL,
  `Pagine` int unsigned DEFAULT NULL,
  `Genere` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `Products`(`id`)
);

CREATE TABLE `Videogames` (
  `id` int unsigned NOT NULL,
  `Sviluppatore` varchar(50) NOT NULL,
  `Genere` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `Products`(`id`)
);

CREATE TABLE `Reservation` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` char(11) NOT NULL,
  `notes` varchar(500) DEFAULT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`product_id`) REFERENCES `Products`(`id`),
  FOREIGN KEY(`email`) REFERENCES `Users`(`email`)
);


INSERT INTO `Users` VALUES ('iulius@gmail.com',''),('iulius2@mail.com','d-mase24'),('iulius3@mail.com','todaro24'),('iulius4@gmail.com','d-mase24'),('todaro@gmail.com','D-mase24'),('user1@email.com','password1'),('user10@email.com','password10'),('user2@email.com','password2'),('user3@email.com','password3'),('user4@email.com','password4'),('user5@email.com','password5'),('user6@email.com','password6'),('user7@email.com','password7'),('user8@email.com','password8'),('user9@email.com','password9');
INSERT INTO `Products` VALUES (1,'Book 01',52.05,'2022-11-22','Libro','Disponibile',0, 'Prova descrizione su db'),(2,'Book 02',40.51,'2020-06-11','Libro','Disponibile',0, ''),(3,'Book 03',15.67,'2022-06-29','Libro','Disponibile',0, ''),(4,'Book 04',39.61,'2021-07-11','Libro','Disponibile',0, ''),(5,'Book 05',25.82,'2020-10-28','Libro','Disponibile',0, ''),(6,'Book 06',25.77,'2020-11-15','Libro','Disponibile',0, ''),(7,'Book 07',44.63,'2022-10-06','Libro','Disponibile',0, ''),(8,'Book 08',54.93,'2022-09-05','Libro','Disponibile',0, ''),(9,'Book 09',19.24,'2021-10-23','Libro','Disponibile',0, ''),(10,'Book 10',35.88,'2020-07-26','Libro','Disponibile',0, ''),(11,'Book 11',30.78,'2022-08-29','Libro','Non disponibile',0, ''),(12,'Book 12',23.82,'2022-06-16','Libro','Disponibile',0, ''),(13,'Book 13',54.52,'2021-12-03','Libro','Disponibile',0, ''),(14,'Book 14',48.21,'2020-08-15','Libro','Disponibile',0, ''),(15,'Book 15',15.23,'2020-11-09','Libro','Non disponibile',0, ''),(16,'Book 16',46.72,'2020-12-11','Libro','Disponibile',0, ''),(17,'Book 17',56.43,'2021-07-20','Libro','Disponibile',0, ''),(18,'Book 18',32.63,'2022-07-31','Libro','Disponibile',0, ''),(19,'Book 19',16.98,'2022-08-05','Libro','Disponibile',0, ''),(20,'Book 20',56.96,'2022-12-04','Libro','Non disponibile',0, ''),(21,'Book 21',28.80,'2022-02-03','Libro','Disponibile',0, ''),(22,'Book 22',46.20,'2021-08-01','Libro','Disponibile',0, ''),(23,'Book 23',48.16,'2021-03-22','Libro','Disponibile',0, ''),(24,'Book 24',35.83,'2021-01-07','Libro','Non disponibile',0, ''),(25,'Book 25',46.21,'2020-07-10','Libro','Disponibile',0, ''),(32,'Album 01',22.10,'2020-02-18','Musica','Disponibile',0, ''),(33,'Album 02',18.06,'2021-11-26','Musica','Disponibile',0, ''),(34,'Album 03',18.11,'2021-09-26','Musica','Disponibile',0, ''),(35,'Album 04',10.88,'2020-08-28','Musica','Disponibile',0, ''),(36,'Album 05',31.68,'2022-10-02','Musica','Disponibile',0, ''),(37,'Album 06',30.68,'2021-07-17','Musica','Non disponibile',0, ''),(38,'Album 07',19.21,'2021-01-27','Musica','Disponibile',0, ''),(39,'Album 08',28.56,'2022-06-05','Musica','Disponibile',0, ''),(40,'Album 09',6.15,'2020-05-01','Musica','Disponibile',0, ''),(41,'Album 10',31.17,'2020-02-11','Musica','Disponibile',0, ''),(42,'Album 11',27.62,'2020-02-23','Musica','Disponibile',0, ''),(43,'Album 12',27.85,'2022-08-03','Musica','Non disponibile',0, ''),(44,'Album 13',22.06,'2022-03-30','Musica','Non disponibile',0, ''),(45,'Album 14',32.92,'2021-08-23','Musica','Disponibile',0, ''),(46,'Album 15',8.17,'2022-01-12','Musica','Non disponibile',0, ''),(47,'Album 16',14.72,'2021-03-20','Musica','Non disponibile',0, ''),(48,'Album 17',6.95,'2020-06-19','Musica','Disponibile',0, ''),(49,'Album 18',18.35,'2021-06-07','Musica','Non disponibile',0, ''),(50,'Album 19',30.12,'2020-01-27','Musica','Disponibile',0, ''),(51,'Album 20',34.42,'2020-03-17','Musica','Disponibile',0, ''),(52,'Album 21',30.08,'2022-11-08','Musica','Disponibile',0, ''),(53,'Album 22',17.10,'2020-10-13','Musica','Non disponibile',0, ''),(54,'Album 23',26.01,'2020-08-18','Musica','Disponibile',0, ''),(55,'Album 24',8.98,'2022-05-31','Musica','Disponibile',0, ''),(56,'Album 25',26.49,'2022-02-08','Musica','Disponibile',0, ''),(63,'Comic 01',19.63,'2020-11-30','Fumetto','Disponibile',0, ''),(64,'Comic 02',20.04,'2022-04-09','Fumetto','Disponibile',0, ''),(65,'Comic 03',12.79,'2021-01-19','Fumetto','Disponibile',0, ''),(66,'Comic 04',22.45,'2021-10-26','Fumetto','Disponibile',0, ''),(67,'Comic 05',10.29,'2020-03-19','Fumetto','Disponibile',0, ''),(68,'Comic 06',17.12,'2021-01-04','Fumetto','Disponibile',0, ''),(69,'Comic 07',11.86,'2020-04-19','Fumetto','Disponibile',0, ''),(70,'Comic 08',6.27,'2022-09-11','Fumetto','Disponibile',0, ''),(71,'Comic 09',21.44,'2020-08-05','Fumetto','Disponibile',0, ''),(72,'Comic 10',5.82,'2021-11-12','Fumetto','Disponibile',0, ''),(73,'Comic 11',6.50,'2021-03-24','Fumetto','Disponibile',0, ''),(74,'Comic 12',22.61,'2022-10-23','Fumetto','Non disponibile',0, ''),(75,'Comic 13',13.45,'2022-11-28','Fumetto','Disponibile',0, ''),(76,'Comic 14',5.31,'2020-12-17','Fumetto','Disponibile',0, ''),(77,'Comic 15',21.64,'2021-06-12','Fumetto','Disponibile',0, ''),(78,'Comic 16',7.88,'2022-11-21','Fumetto','Disponibile',0, ''),(79,'Comic 17',5.89,'2020-03-09','Fumetto','Non disponibile',0, ''),(80,'Comic 18',18.91,'2022-11-05','Fumetto','Disponibile',0, ''),(81,'Comic 19',13.85,'2020-09-18','Fumetto','Disponibile',0, ''),(82,'Comic 20',17.31,'2021-06-06','Fumetto','Disponibile',0, ''),(83,'Comic 21',10.48,'2022-03-27','Fumetto','Disponibile',0, ''),(84,'Comic 22',10.93,'2022-04-14','Fumetto','Disponibile',0, ''),(85,'Comic 23',11.52,'2022-08-02','Fumetto','Disponibile',0, ''),(86,'Comic 24',6.68,'2021-04-01','Fumetto','Disponibile',0, ''),(87,'Comic 25',23.20,'2020-02-27','Fumetto','Disponibile',0, ''),(94,'Game 01',40.09,'2020-10-06','Videogioco','Disponibile',0, ''),(95,'Game 02',23.37,'2020-05-01','Videogioco','Disponibile',0, ''),(96,'Game 03',27.26,'2022-12-28','Videogioco','Disponibile',0, ''),(97,'Game 04',29.39,'2022-07-04','Videogioco','Disponibile',0, ''),(98,'Game 05',55.14,'2022-11-16','Videogioco','Non disponibile',0, ''),(99,'Game 06',57.44,'2020-07-28','Videogioco','Non disponibile',0, ''),(100,'Game 07',26.79,'2021-03-17','Videogioco','Disponibile',0, ''),(101,'Game 08',32.62,'2020-03-10','Videogioco','Disponibile',0, ''),(102,'Game 09',46.32,'2020-07-17','Videogioco','Disponibile',0, ''),(103,'Game 10',24.55,'2022-04-27','Videogioco','Disponibile',0, ''),(104,'Game 11',33.23,'2020-03-07','Videogioco','Disponibile',0, ''),(105,'Game 12',35.32,'2022-12-04','Videogioco','Disponibile',0, ''),(106,'Game 13',48.66,'2021-03-09','Videogioco','Disponibile',0, ''),(107,'Game 14',58.82,'2021-01-25','Videogioco','Disponibile',0, ''),(108,'Game 15',31.62,'2022-07-04','Videogioco','Disponibile',0, ''),(109,'Game 16',21.53,'2020-10-14','Videogioco','Non disponibile',0, ''),(110,'Game 17',28.31,'2021-04-27','Videogioco','Disponibile',0, ''),(111,'Game 18',43.47,'2020-07-24','Videogioco','Non disponibile',0, ''),(112,'Game 19',33.02,'2020-04-13','Videogioco','Disponibile',0, ''),(113,'Game 20',27.71,'2021-06-08','Videogioco','Disponibile',0, ''),(114,'Game 21',45.47,'2022-03-21','Videogioco','Disponibile',0, ''),(115,'Game 22',49.11,'2020-10-23','Videogioco','Non disponibile',0, ''),(116,'Game 23',21.23,'2021-12-11','Videogioco','Non disponibile',0, ''),(117,'Game 24',52.55,'2021-11-01','Videogioco','Disponibile',0, ''),(118,'Game 25',30.45,'2021-05-05','Videogioco','Disponibile',0, ''),(119,'Vitae laborum ullam.',26.11,'2019-10-12','Libro','Non disponibile',48, '');
INSERT INTO `Books` VALUES (1,'Author 20',513,'Fiction'),(2,'Author 08',322,'Fiction'),(3,'Author 18',217,'Mystery'),(4,'Author 02',491,'Sci-Fi'),(5,'Author 18',270,'Fiction'),(6,'Author 15',135,'Non-fiction'),(7,'Author 02',348,'Non-fiction'),(8,'Author 04',555,'Fiction'),(9,'Author 07',344,'Mystery'),(10,'Author 05',365,'Fantasy'),(11,'Author 05',248,'Sci-Fi'),(12,'Author 19',282,'Fiction'),(13,'Author 01',159,'Mystery'),(14,'Author 01',473,'Sci-Fi'),(15,'Author 18',398,'Non-fiction'),(16,'Author 14',364,'Mystery'),(17,'Author 08',188,'Sci-Fi'),(18,'Author 01',554,'Mystery'),(19,'Author 18',531,'Sci-Fi'),(20,'Author 14',335,'Non-fiction'),(21,'Author 02',321,'Fiction'),(22,'Author 16',485,'Mystery'),(23,'Author 10',477,'Non-fiction'),(24,'Author 07',399,'Fiction'),(25,'Author 12',395,'Non-fiction');
INSERT INTO `Comics` VALUES (63,'Comic Author 11',117,'Manga'),(64,'Comic Author 14',64,'Superhero'),(65,'Comic Author 11',29,'Horror'),(66,'Comic Author 05',60,'Manga'),(67,'Comic Author 13',119,'Superhero'),(68,'Comic Author 14',109,'Graphic Novel'),(69,'Comic Author 17',90,'Horror'),(70,'Comic Author 16',116,'Graphic Novel'),(71,'Comic Author 11',38,'Manga'),(72,'Comic Author 05',116,'Manga'),(73,'Comic Author 04',37,'Graphic Novel'),(74,'Comic Author 10',34,'Manga'),(75,'Comic Author 04',101,'Graphic Novel'),(76,'Comic Author 12',21,'Graphic Novel'),(77,'Comic Author 20',78,'Superhero'),(78,'Comic Author 10',51,'Superhero'),(79,'Comic Author 12',74,'Superhero'),(80,'Comic Author 09',33,'Manga'),(81,'Comic Author 10',40,'Humor'),(82,'Comic Author 11',92,'Superhero'),(83,'Comic Author 02',48,'Superhero'),(84,'Comic Author 19',30,'Humor'),(85,'Comic Author 12',66,'Humor'),(86,'Comic Author 17',37,'Graphic Novel'),(87,'Comic Author 13',106,'Graphic Novel');
INSERT INTO `Music` VALUES (32,'Artist 15',58,'Pop','Vinile'),(33,'Artist 14',48,'Jazz','CD'),(34,'Artist 09',33,'Electronic','Vinile'),(35,'Artist 20',46,'Jazz','CD'),(36,'Artist 15',36,'Pop','Vinile'),(37,'Artist 19',53,'Pop','Altro'),(38,'Artist 05',36,'Electronic','CD'),(39,'Artist 15',69,'Rock','Altro'),(40,'Artist 02',61,'Jazz','Altro'),(41,'Artist 15',31,'Rock','CD'),(42,'Artist 03',61,'Pop','Vinile'),(43,'Artist 18',84,'Electronic','Altro'),(44,'Artist 15',70,'Rock','Altro'),(45,'Artist 15',30,'Electronic','Vinile'),(46,'Artist 05',85,'Rock','Vinile'),(47,'Artist 15',56,'Rock','CD'),(48,'Artist 15',35,'Pop','Altro'),(49,'Artist 16',44,'Electronic','Vinile'),(50,'Artist 14',39,'Classical','CD'),(51,'Artist 07',52,'Electronic','CD'),(52,'Artist 08',43,'Rock','Altro'),(53,'Artist 07',56,'Pop','Altro'),(54,'Artist 02',53,'Classical','Vinile'),(55,'Artist 01',37,'Jazz','Vinile'),(56,'Artist 08',65,'Electronic','Vinile');
INSERT INTO `Videogames` VALUES (94,'Adventure','Developer 07'),(95,'Sports','Developer 16'),(96,'Sports','Developer 02'),(97,'Strategy','Developer 16'),(98,'Sports','Developer 02'),(99,'FPS','Developer 11'),(100,'Strategy','Developer 06'),(101,'Sports','Developer 16'),(102,'Sports','Developer 02'),(103,'Strategy','Developer 18'),(104,'RPG','Developer 17'),(105,'Sports','Developer 10'),(106,'RPG','Developer 03'),(107,'FPS','Developer 05'),(108,'RPG','Developer 04'),(109,'FPS','Developer 01'),(110,'RPG','Developer 14'),(111,'Adventure','Developer 17'),(112,'FPS','Developer 19'),(113,'Sports','Developer 18'),(114,'RPG','Developer 03'),(115,'RPG','Developer 13'),(116,'Strategy','Developer 08'),(117,'Strategy','Developer 10'),(118,'Sports','Developer 10');
INSERT INTO `Reservation` VALUES (1,105,'user1@email.com','2024-08-28','10:00-11:00',''),(2,96,'user1@email.com','2024-08-29','12:00-13:00',''),(3,96,'user1@email.com','2024-09-03','10:00-11:00','');
