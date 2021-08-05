CREATE DATABASE  IF NOT EXISTS `elms` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `elms`;
-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: elms
-- ------------------------------------------------------
-- Server version	8.0.22

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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `department_id` int NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `user_type` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_id_UNIQUE` (`emp_id`),
  KEY `fk_users_departments1_idx` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,231123,'Azhar','uddin','azharsheikh760@gmail.com','$2y$10$UgF5TZVOf28MnqdFxpWC3ekyZDY9MlieUTz6YMqdJAyVhpqyQaT4C',1,'final_pyhsical_model.JPG',1,1,'2021-06-24 14:32:33'),(20,147896,'valarR','morghulis','valar@gmail.com','$2y$10$gOIclxSXutVIp5Nz6QiMYeUqfhzJg6jTTvfzEKzb6FlBpKW/6QHNi',18,'logical_model.png',0,1,'2021-07-16 18:30:56'),(24,321456,'valarDOha','MOrgha','valar21@gmail.com','$2y$10$wePzm9wbK0EZ9I03kPP7E.D.TpSEfbEFdf8kRUi34YK7UieQK8o02',90,'default.jpg',1,1,'2021-07-24 17:03:07'),(25,852369,'Ajju','Paji','ajjupaji@gmail.com','$2y$10$u1w4qnnXW3om8l25uBc..e5VUAMhY6SkCsX4.ZtRjKeBBSpU3OXwy',88,'azhar.jpg',0,2,'2021-07-25 16:02:47'),(26,123654,'Mohtashim','bengali','bengal@gmail.com','$2y$10$OkIuV06dGOzCpW/ImP9Xs.MqEZA2UZHkYEDU.csab20e18T.YGW8a',91,'default.jpg',0,1,'2021-07-26 15:12:08'),(28,333333,'bilal','wahid','bilal@gmail.com','$2y$10$tf6Z5phd88.jVOzStTSQKufTw7RI0onGxmA0OYSSlwHSmx7JHUqt6',89,'default.jpg',0,0,'2021-07-28 17:36:08'),(29,999999,'Chiken','LegPiece','chiken@gmail.com','$2y$10$OkIuV06dGOzCpW/ImP9Xs.MqEZA2UZHkYEDU.csab20e18T.YGW8a',2,'default.jpg',1,0,'2021-07-28 17:41:08');
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

-- Dump completed on 2021-08-05 13:12:24
