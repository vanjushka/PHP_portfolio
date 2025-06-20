-- MySQL dump 10.13  Distrib 9.3.0, for macos13.7 (arm64)
--
-- Host: localhost    Database: wdd324_demo
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `about_sections`
--

DROP TABLE IF EXISTS `about_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `about_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `about_sections`
--

LOCK TABLES `about_sections` WRITE;
/*!40000 ALTER TABLE `about_sections` DISABLE KEYS */;
INSERT INTO `about_sections` VALUES (3,'About me','I’m a freelance graphic designer and Web Design and Development student at SAE Zurich specializing in branding, web interfaces, and interactive visuals. I love aesthetics and strive to merge creativity with technology to make digital experiences beautiful. My passion lies in crafting seamless, functional, and visually compelling user experiences.',NULL,0,'2025-06-18 16:39:05'),(4,'Currently Working On','I\'m currently focusing on frontend development, refining my skills in JavaScript and UX/UI design. I’m also exploring 3D design and interactive web elements to push creative boundaries.',NULL,2,'2025-06-18 16:39:51'),(5,'Experience','2024\r\nWeb Design Intern at XYZ Agency\r\n2023\r\nFreelance Branding Designer\r\n2022–2024\r\nUI Designer for Startups',NULL,2,'2025-06-18 16:40:16'),(6,'Fun Facts','📍 My favourite place to be: Thailand\r\n🎵 My current playlist: Moroccan Drill & Latin Trap\r\n💡 Design inspiration: Brutalism meets minimalism\r\n🖤 Favorite color: Black (always)\r\n🥋 Training Muay Thai & MMA',NULL,6,'2025-06-18 16:44:41'),(7,'','','uploads/2025/06/18/6852f4d8abd401.82985645.png',0,'2025-06-18 16:47:31');
/*!40000 ALTER TABLE `about_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `project_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'uploads/2025/05/14/6824dfbf2f75c1.38588589.jpg','birb',NULL),(2,'uploads/2025/05/26/6834a81acea675.02599989.png','screenshot',NULL),(3,'uploads/2025/05/31/683ae4eff1abe9.00264677.png','screenshot',NULL),(4,'uploads/2025/05/31/683af23ed60a97.90750817.png','test',NULL),(5,'uploads/2025/05/31/683af23f00a409.37163117.png','test',NULL),(6,'uploads/2025/05/31/683af368b20289.48801453.png','test',NULL),(7,'uploads/2025/06/17/68517667411970.75495014.webp','test2',NULL),(8,'uploads/2025/06/17/68517dae1a54f6.56364142.webp','test3',5),(9,'uploads/2025/06/17/68517f5e5da337.12512398.webp','sdf',NULL),(10,'uploads/2025/06/17/68518170d69859.39353693.webp','test3',5),(11,'uploads/2025/06/17/68518bba14f641.21134596.webp','test2',3),(12,'uploads/2025/06/18/6852dfdfcc3a20.48829503.webp','test4',NULL),(13,'uploads/2025/06/18/6852f4d8abd401.82985645.png','portrait copy',NULL),(14,'uploads/2025/06/19/68543494a176e3.34464133.jpg','EMS Gym Glowup',8),(15,'uploads/2025/06/19/685435e24746d1.74732512.jpg','test4',7),(16,'uploads/2025/06/19/685436bcd95a02.24844435.jpg','Launch Physio Studio and Branding',9);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (8,'EMS Gym Glowup','Provided help for an EMS gym','Bionic Zürich','uploads/2025/06/19/68543494a176e3.34464133.jpg','https://www.bionic-sport.com/de/','2025-06-19 15:56:49'),(9,'Launch Physio Studio and Branding','Launched and branded a physiotherapist for high performance athletes in Koh Samui, Thailand','Recovery Samui','uploads/2025/06/19/685436bcd95a02.24844435.jpg','https://recoverysamui.com/home','2025-06-19 16:11:28');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_login`
--

DROP TABLE IF EXISTS `users_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_login`
--

LOCK TABLES `users_login` WRITE;
/*!40000 ALTER TABLE `users_login` DISABLE KEYS */;
INSERT INTO `users_login` VALUES (1,'Vanja','vanja@example.com','$2y$12$9BTLxAZbXktIs9rX4nUhd.KSeM99Bx0574oBMV0RZldcdNYBe.R0W'),(2,'patrick','patrick@emample.ch','$2y$12$VMKd8TWZUPdjQw2vLOm0NOrXU4MFsdek728CasyfAMkYFSw/zZKG6'),(3,'vanjatest','patrick@emample.ch','$2y$12$k6r/yJzj5wLxjq2QTji9wOxnmfgU7MQjByu2JIVJmdFnQD7U5eOWy'),(4,'patrick','patrick@emample.ch','$2y$12$b1vSx5C55EfpA3MlyhgQKuHn5me4JfLUxFb3PrmpkO3LizD1DgxIe'),(5,'jane','jane@doe.ch','$2y$12$Nbwks6iQC9HLdVy2YRE9oe684w1pApUGATPhzOJVdIvMik7NY30TC'),(6,'jonn','jon@doe.ch','$2y$12$d2W12h0a4HCqhMJSA7vqOe9tdTlz06QbGwqPMjt4A6aE19dO3/BSW');
/*!40000 ALTER TABLE `users_login` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-20 12:47:29
