-- MySQL dump 10.13  Distrib 9.0.1, for macos14.4 (arm64)
--
-- Host: localhost    Database: advert_db
-- ------------------------------------------------------
-- Server version	9.0.1

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admins_user_id_foreign` (`user_id`),
  CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,1,'2024-08-09 23:35:23','2024-08-09 23:35:23',NULL),(2,2,'2024-08-09 23:35:23','2024-08-09 23:35:23',NULL),(3,1,'2024-08-19 23:13:06','2024-08-19 23:13:06',NULL),(4,2,'2024-08-19 23:13:06','2024-08-19 23:13:06',NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agencies`
--

DROP TABLE IF EXISTS `agencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pack_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agencies_user_id_foreign` (`user_id`),
  KEY `agencies_pack_id_foreign` (`pack_id`),
  CONSTRAINT `agencies_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agencies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agencies`
--

LOCK TABLES `agencies` WRITE;
/*!40000 ALTER TABLE `agencies` DISABLE KEYS */;
INSERT INTO `agencies` VALUES (1,'khalid agency',3,'2024-08-09 23:35:23','2024-08-09 23:35:23',NULL,'kwait',NULL,'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f',NULL),(2,'omar agency',7,'2024-08-10 13:43:38','2024-08-10 13:43:38',NULL,'arabia saoudi',NULL,'https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f','https://www.google.com/url?sa=t&source=web&rct=j&opi=89978449&url=https://laravel-angular.io/&ved=2ahUKEwi6tvTmzYGIAxXTfKQEHdvwBZkQFnoECBwQAQ&usg=AOvVaw0zJ9rCkI7NzWVDhDOslf1f',NULL),(3,'re',4,'2024-08-19 17:34:10','2024-08-19 17:51:12',NULL,'eee',NULL,' ','xxx',' ','edd','zzz',NULL),(4,NULL,8,'2024-08-19 17:52:13','2024-08-19 17:52:13',NULL,NULL,NULL,'amir','amir',NULL,NULL,NULL,NULL),(5,'amin',9,'2024-08-19 17:54:50','2024-08-19 17:55:01',NULL,'sami',NULL,' ',' ',' ',' ',' ',NULL),(6,' ',1,'2024-08-19 22:06:06','2024-08-19 22:06:06',NULL,'-',NULL,' ',' ',' ',' ',' ',NULL),(7,'Agent Smith',3,'2024-08-19 23:13:06','2024-08-19 23:13:06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,' ',22,'2024-08-19 23:58:16','2024-08-19 23:58:16',NULL,'-',NULL,' ',' ',' ',' ',' ',NULL),(9,'brahim@fff.coi',24,'2024-08-20 11:36:15','2024-08-20 11:36:15',NULL,'21212112',NULL,'2121','211212','211212','2121','211221',NULL),(10,'Kenyon Graves',25,'2024-08-20 11:38:51','2024-08-20 11:38:51',NULL,'Dolores sint non lab',NULL,'Occaecat fugiat des','Quae laboriosam fug','Amet ipsa nulla ve','Placeat in excepteu','Eum quia laborum ull',NULL),(11,'Dexter Boyle',26,'2024-08-20 11:40:20','2024-08-20 11:40:20',NULL,'Assumenda voluptatem',NULL,'Voluptatem voluptat','Nemo velit deserunt','Duis eos odio sit q','Eum et laborum Maxi','Eu eiusmod fuga Dol',NULL),(12,NULL,34,'2024-10-04 18:07:33','2024-10-04 18:07:33',NULL,NULL,NULL,'','','','','',NULL),(13,'Maxine Chapman',35,'2024-10-05 05:03:07','2024-10-05 05:03:07',NULL,'Dolorem sunt sint',NULL,'Voluptas ut rerum ab','Dolore blanditiis vo','Commodo odit recusan','Aperiam et aspernatu','Quod tempora impedit',NULL);
/*!40000 ALTER TABLE `agencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snapchat_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pack_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agents_agency_id_foreign` (`agency_id`),
  KEY `agents_user_id_foreign` (`user_id`),
  KEY `agents_pack_id_foreign` (`pack_id`),
  CONSTRAINT `agents_agency_id_foreign` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `agents_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `packs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (1,'Agent Smith',1,3,'2024-08-09 23:35:23','2024-08-09 23:35:23',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Agent Smith',2,3,'2024-08-19 23:13:06','2024-08-19 23:13:06',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Sloane Sweeney',11,27,'2024-08-20 11:41:38','2024-08-20 11:41:38',NULL,'Molestiae animi ani',NULL,'Hic officia nobis la','Tempore incidunt c','Non irure esse omni','Maiores esse dolor o','Beatae reprehenderit',NULL),(4,'Knox Boyle',11,28,'2024-08-20 11:41:47','2024-08-20 11:41:47',NULL,'Id tempor expedita',NULL,'Molestiae unde incid','Natus ex explicabo','Aut velit non tempor','Quis aut velit eos','Rem qui ea aut magna',NULL),(5,'Kirk Francis',11,30,'2024-08-20 23:51:22','2024-08-20 23:51:22',NULL,'Dolor atque cupidita',NULL,'Deserunt omnis quibu','Ad totam qui sunt et','Ut iste illum commo','Consequat Tenetur v','Laboris reiciendis q',NULL),(6,'Joan Norman',11,31,'2024-08-20 23:51:54','2024-08-20 23:51:54',NULL,'Ut enim sequi libero',NULL,'Nulla soluta exercit','Perferendis eligendi','Ipsum ipsa ut occa','Cum tempora optio a','Molestias consequat',NULL),(7,'Hadley Cortez',11,32,'2024-08-21 00:14:26','2024-08-21 00:29:37',NULL,'Ipsam do iste quo la',NULL,'Commodi dignissimos','Adipisicing laborios','Dolore corrupti qui0000','Consequat Consequat','Cupidatat sapiente u',NULL),(8,'Willow Atkinson',11,33,'2024-08-21 00:30:12','2024-08-21 00:30:12',NULL,'Aut laboris molestia',NULL,'Voluptate modi venia','Ducimus nesciunt e','Soluta accusamus et','Aliquip magni magna','Qui quibusdam placea',NULL),(9,'Lenore Colon',13,39,'2024-10-05 05:28:46','2024-10-05 05:28:46',NULL,'Qui distinctio Unde',NULL,'Autem qui cumque rep','Itaque corporis volu','Labore saepe soluta','Quaerat quibusdam do','Enim et tempore est',NULL),(12,'test',13,42,'2024-10-05 05:59:22','2024-10-05 05:59:22',NULL,'brahim@gmail.com',NULL,'brahim@gmail.com','brahim@gmail.com','brahim@gmail.com','brahim@gmail.com','brahim@gmail.com',NULL);
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2016_06_01_000001_create_oauth_auth_codes_table',1),(4,'2016_06_01_000002_create_oauth_access_tokens_table',1),(5,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(6,'2016_06_01_000004_create_oauth_clients_table',1),(7,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(8,'2019_08_19_000000_create_failed_jobs_table',1),(9,'2019_12_14_000001_create_personal_access_tokens_table',1),(10,'2024_07_19_235041_create_admins_table',1),(11,'2024_07_19_235054_create_agencies_table',1),(12,'2024_07_19_235208_create_agents_table',1),(13,'2024_07_19_235228_create_notifications_table',1),(14,'2024_08_09_001222_create_packs_table',1),(15,'2024_08_09_001227_add_fields_to_agencies',1),(16,'2024_08_20_122138_add_fields_to_agents',2),(17,'2024_10_02_174428_create_snapchat_ads_table',3),(18,'2024_10_02_174429_create_snapchat_ads_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_id` bigint unsigned DEFAULT NULL,
  `received_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_sender_id_foreign` (`sender_id`),
  KEY `notifications_received_id_foreign` (`received_id`),
  CONSTRAINT `notifications_received_id_foreign` FOREIGN KEY (`received_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'ikcek','jfdsjfsd','newndew',3,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packs`
--

DROP TABLE IF EXISTS `packs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `months` int DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `nb_product_private` decimal(8,2) DEFAULT NULL,
  `advantages` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packs`
--

LOCK TABLES `packs` WRITE;
/*!40000 ALTER TABLE `packs` DISABLE KEYS */;
/*!40000 ALTER TABLE `packs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'advert','3773bd6bf92d2700b3f185d28ee8a524fc0a35ce08884df5522c5ee110f2f50e','[\"*\"]',NULL,NULL,'2024-08-09 23:38:00','2024-08-09 23:38:00'),(2,'App\\Models\\User',1,'advert','a22c171ead97ba26c9f60643ff7f3a17e795d198b97cc506b6d14e44f8274b6c','[\"*\"]',NULL,NULL,'2024-08-10 11:22:46','2024-08-10 11:22:46'),(3,'App\\Models\\User',1,'advert','3e44daead1f871a80cac5edf20f2e5c8cb7464a9f44cbfe257d11cdfc1ef4cca','[\"*\"]',NULL,NULL,'2024-08-10 13:43:21','2024-08-10 13:43:21'),(4,'App\\Models\\User',1,'advert','784c03e279ecfa9169b778ce6b73d91c0a17645de7258538ca9e467b3806c659','[\"*\"]',NULL,NULL,'2024-08-19 16:44:54','2024-08-19 16:44:54'),(5,'App\\Models\\User',1,'advert','829e6315809f06b77d280a1f44e25aa81e95cfd5e07aea6bab3511c1e48150b0','[\"*\"]',NULL,NULL,'2024-08-19 21:29:10','2024-08-19 21:29:10'),(6,'App\\Models\\User',1,'advert','f92575099bded5e8590e260d01a07e930db85c7aaa49cff6d32388238e786e24','[\"*\"]',NULL,NULL,'2024-08-19 21:32:56','2024-08-19 21:32:56'),(7,'App\\Models\\User',1,'advert','5542fd0fa160bdd31a1e55d45f1932c7f536f03b4eb7e24b19ab9214214ddb85','[\"*\"]',NULL,NULL,'2024-08-19 21:36:26','2024-08-19 21:36:26'),(8,'App\\Models\\User',1,'advert','2a97d0c2d9ec9c627330f1c75bfd0afdade14303feb7645be7cda0cede3f7eb9','[\"*\"]',NULL,NULL,'2024-08-19 21:38:57','2024-08-19 21:38:57'),(9,'App\\Models\\User',1,'advert','000841d58f5490c22550128f8ac67b5d3e7c13339f98c4fff2ecde98c6e6edc5','[\"*\"]',NULL,NULL,'2024-08-19 21:39:29','2024-08-19 21:39:29'),(10,'App\\Models\\User',1,'advert','47e9d384f56bbebf833526f956d1b5e3bd4172df79f7be62826dc442c3a89164','[\"*\"]',NULL,NULL,'2024-08-19 21:43:30','2024-08-19 21:43:30'),(11,'App\\Models\\User',3,'advert','f331f4da3053de672b70a2488daa552667de5096eadbc822a58c2449d78458a6','[\"*\"]',NULL,NULL,'2024-08-19 23:11:49','2024-08-19 23:11:49'),(12,'App\\Models\\User',2,'advert','6984185d9cdea729ef8701118634187b9b66178cb733d9227dadb5ef2f7ce17b','[\"*\"]',NULL,NULL,'2024-08-19 23:12:46','2024-08-19 23:12:46'),(13,'App\\Models\\User',22,'advert','a4460f127ba05d801bec940b093ca00bbb0017ce22d0fc86d1f2b5cb2e512e8d','[\"*\"]',NULL,NULL,'2024-08-19 23:13:15','2024-08-19 23:13:15'),(14,'App\\Models\\User',22,'advert','e44863b89d94543c5c532f7f297d5037f6525592b0404530be0d4c5a85dbd337','[\"*\"]',NULL,NULL,'2024-08-19 23:13:34','2024-08-19 23:13:34'),(15,'App\\Models\\User',22,'advert','b1d642c37b431194556742a7ab2e521c263e549622f44dbf1aa7ea92c3b3e71d','[\"*\"]',NULL,NULL,'2024-08-19 23:15:29','2024-08-19 23:15:29'),(16,'App\\Models\\User',22,'advert','2ad00423b08f4e1b74468f0f9e24ce750050b4f46e8eef7ee10d80cae1d069ed','[\"*\"]',NULL,NULL,'2024-08-19 23:36:43','2024-08-19 23:36:43'),(17,'App\\Models\\User',22,'advert','c612961efc692caf32e75de2af89c19469ceb29781bd0d6a9adb39d6044c8da2','[\"*\"]',NULL,NULL,'2024-08-20 10:35:12','2024-08-20 10:35:12'),(18,'App\\Models\\User',22,'advert','ca64e0139a79a4495c58904403c5ea9c4603299a37aa2f0fdc14e40db4d3a014','[\"*\"]',NULL,NULL,'2024-08-20 11:14:21','2024-08-20 11:14:21'),(19,'App\\Models\\User',26,'advert','4afa5166011495374af4299a23042eaa7047d898622444f2c1679fdc3eff7a65','[\"*\"]',NULL,NULL,'2024-08-20 11:52:15','2024-08-20 11:52:15'),(20,'App\\Models\\User',26,'advert','026c8ea8e041ffa9e62cd3970523c280a642bd16645846d1d2e0e0e5079232ab','[\"*\"]',NULL,NULL,'2024-08-20 11:59:05','2024-08-20 11:59:05'),(21,'App\\Models\\User',26,'advert','ce9a55e72eabd5cc56ab982ca0189ca1f28e81515d73059ba50703bd16aac167','[\"*\"]',NULL,NULL,'2024-08-20 16:30:32','2024-08-20 16:30:32'),(22,'App\\Models\\User',26,'advert','c2a21a6c3164be0b61a67b1318e13606696ebed953aaf856c521fcec96757b66','[\"*\"]',NULL,NULL,'2024-08-20 23:02:26','2024-08-20 23:02:26'),(23,'App\\Models\\User',26,'advert','4c68734c15b73d02b369329456069836584ca34941708b9c5843cffbc65e05c1','[\"*\"]',NULL,NULL,'2024-08-21 00:43:30','2024-08-21 00:43:30'),(24,'App\\Models\\User',33,'advert','a838b567a59c30c1d48c67dd7febaeb57baa622b1462391893a1e833d3a49273','[\"*\"]',NULL,NULL,'2024-08-21 00:46:04','2024-08-21 00:46:04'),(25,'App\\Models\\User',33,'advert','7506130cc916f2f25e337ca85584009c57af8727c649da630b256e453de1536a','[\"*\"]',NULL,NULL,'2024-08-21 00:51:17','2024-08-21 00:51:17'),(26,'App\\Models\\User',22,'advert','b8cc5db92e37f2c50ff181d23f216f8fcea0f484493dc76f44f060d41b6a97b6','[\"*\"]',NULL,NULL,'2024-08-21 00:51:56','2024-08-21 00:51:56'),(27,'App\\Models\\User',22,'advert','f82f67a7ebe9a84ee208cd5d2c0a8f69994435a49d92170555f1da297eff6d52','[\"*\"]',NULL,NULL,'2024-08-25 20:06:29','2024-08-25 20:06:29'),(28,'App\\Models\\User',25,'advert','c6104623c33c8e8b6af8508633b328b1d2a1f0dda3a2f3842bf37a44218c4bef','[\"*\"]',NULL,NULL,'2024-08-25 20:07:48','2024-08-25 20:07:48'),(29,'App\\Models\\User',33,'advert','04385c2fdfbff5e4aca36ea7a742ad2392fe9c1585581dbb857100d0b05b012d','[\"*\"]',NULL,NULL,'2024-08-25 20:09:48','2024-08-25 20:09:48'),(30,'App\\Models\\User',22,'advert','eac4398becf3643f54396467e2cf9961f5538dcd45903733e6dd74e6e1750d3a','[\"*\"]',NULL,NULL,'2024-10-01 22:08:16','2024-10-01 22:08:16'),(31,'App\\Models\\User',22,'advert','a136fe999faf1d075e3c0863b0756341cce36d921e3959f64217fec17845c914','[\"*\"]',NULL,NULL,'2024-10-01 22:33:01','2024-10-01 22:33:01'),(32,'App\\Models\\User',34,'advert','70461f46256674a4c2680405906979daed54e4f7be6dc786012b685561a457ab','[\"*\"]',NULL,NULL,'2024-10-04 18:07:33','2024-10-04 18:07:33'),(33,'App\\Models\\User',22,'advert','d8fff286afd4a1a47175230b552d0fbc55aaeccafe3036a235b7ad2860920c34','[\"*\"]',NULL,NULL,'2024-10-04 18:10:56','2024-10-04 18:10:56'),(34,'App\\Models\\User',22,'advert','cc732db70e784f6f5bcb780896b660ff7dd79dd577ce01b4c02f9fdd8bff7139','[\"*\"]',NULL,NULL,'2024-10-04 20:12:28','2024-10-04 20:12:28'),(35,'App\\Models\\User',22,'advert','e4bc18403fbbcdc8b6a3d3996d6392995f9f22072911568bbdbce1a39c4d25fe','[\"*\"]',NULL,NULL,'2024-10-04 21:10:33','2024-10-04 21:10:33'),(36,'App\\Models\\User',22,'advert','e8e1ab644e22d31791c875aaef1017e619e587ff526273bb095aef35492ac989','[\"*\"]',NULL,NULL,'2024-10-05 04:41:26','2024-10-05 04:41:26'),(37,'App\\Models\\User',35,'advert','ac48ac2476fe7692c096e36ad488e85066a73e5420f001edff1f6cd5defe321d','[\"*\"]',NULL,NULL,'2024-10-05 05:06:11','2024-10-05 05:06:11'),(38,'App\\Models\\User',42,'advert','c0906ce792be3e24ffdbc832562763554b19cf24dbf07ecae2b6a63d74aa2ba4','[\"*\"]',NULL,NULL,'2024-10-05 06:07:12','2024-10-05 06:07:12'),(39,'App\\Models\\User',42,'advert','333e848a01041a8ea71fcd6089a651fc4296f0bce684306aa3bb3e2c131f4fb8','[\"*\"]',NULL,NULL,'2024-10-05 06:10:41','2024-10-05 06:10:41'),(40,'App\\Models\\User',42,'advert','d7f30c021e11a05b869b4e46f7726d4632b4c4bfbbc85e2ecb74635f3e27c95e','[\"*\"]',NULL,NULL,'2024-10-05 06:12:11','2024-10-05 06:12:11'),(41,'App\\Models\\User',35,'advert','8d6a4e5f3f2f2c1f6f74d60a91ecc77997e1ebee4fded63d907c812935b91af6','[\"*\"]',NULL,NULL,'2024-10-05 06:22:30','2024-10-05 06:22:30'),(42,'App\\Models\\User',42,'advert','d52fe7ede5159f7780083720d0fde70a2be75c0ace8776c52f3bfde70c679f28','[\"*\"]',NULL,NULL,'2024-10-05 06:22:41','2024-10-05 06:22:41'),(43,'App\\Models\\User',22,'advert','73514dc056cb016142bab10b1c4d1d46869d07f1264f7b66f3068b6d1bf7a34f','[\"*\"]',NULL,NULL,'2024-10-05 06:23:43','2024-10-05 06:23:43'),(44,'App\\Models\\User',42,'advert','a0d99aa2e3849b2a924d4596d91cbd83cb75ad3b1fb216d2b76226ecb09cf5a9','[\"*\"]',NULL,NULL,'2024-10-05 06:30:45','2024-10-05 06:30:45'),(45,'App\\Models\\User',42,'advert','2915177c78148581617b2cb27586cb70ac63a46f5d7b282aaf9e138fc73544ab','[\"*\"]',NULL,NULL,'2024-10-05 06:32:35','2024-10-05 06:32:35'),(46,'App\\Models\\User',42,'advert','86842ddb411a53715e3dee1b4d627e025d663bc6b6f2b6f1474a7b379180863e','[\"*\"]',NULL,NULL,'2024-10-05 06:35:22','2024-10-05 06:35:22'),(47,'App\\Models\\User',42,'advert','4296af01e5536185ec59c058e5a3d000d423952e9d044a3c36dfd21d43ee8be7','[\"*\"]',NULL,NULL,'2024-10-05 06:36:10','2024-10-05 06:36:10'),(48,'App\\Models\\User',42,'advert','da1c564c3b88020a3b68af56139e3bc90b0a561c8bd323b154bba2ea8a114f2d','[\"*\"]',NULL,NULL,'2024-10-05 06:36:21','2024-10-05 06:36:21'),(49,'App\\Models\\User',42,'advert','abaf22ec4128f32c6b35816434a5386fbbe929c539e472c80f4d49d7555f6606','[\"*\"]',NULL,NULL,'2024-10-05 06:36:24','2024-10-05 06:36:24'),(50,'App\\Models\\User',42,'advert','4e35865f1040a518dcd246924838c99af58f7852195fb8710dbc5cfa962788e0','[\"*\"]',NULL,NULL,'2024-10-05 06:37:02','2024-10-05 06:37:02'),(51,'App\\Models\\User',42,'advert','6ee95628fe0dc9a019fc80ceb660f20fff485ad19bcc41b1e276e5275bdeaa07','[\"*\"]',NULL,NULL,'2024-10-05 06:39:30','2024-10-05 06:39:30'),(52,'App\\Models\\User',42,'advert','40913d0012364f5959b45add17038ff1a743ba8d3838580db98c8d7e7196ee0c','[\"*\"]',NULL,NULL,'2024-10-05 06:41:00','2024-10-05 06:41:00'),(53,'App\\Models\\User',42,'advert','7e9ac9ee2f9c4607baf58a2953aea20d24931bf3ac81a767e07a1b539e7168bd','[\"*\"]',NULL,NULL,'2024-10-05 06:44:53','2024-10-05 06:44:53'),(54,'App\\Models\\User',42,'advert','61976045907e4e51351a66fb98c9edecd73739b8f9bef6602b4ed46db1b4b27a','[\"*\"]',NULL,NULL,'2024-10-05 06:44:55','2024-10-05 06:44:55'),(55,'App\\Models\\User',42,'advert','44fd29f78f87ee1210dc3112af7ccb9a5a9bd1008b31a04771cf9e4e2a4ca343','[\"*\"]',NULL,NULL,'2024-10-05 06:44:55','2024-10-05 06:44:55'),(56,'App\\Models\\User',42,'advert','4c00f6072e68427efc12c283087c04a6fdbac518abdb827ad8285bb8e84bcc96','[\"*\"]',NULL,NULL,'2024-10-05 06:44:56','2024-10-05 06:44:56'),(57,'App\\Models\\User',42,'advert','1cfec82b1e53e31271c32791780ce1b800d2aea815d57145311836f9417ef9d8','[\"*\"]',NULL,NULL,'2024-10-05 06:44:56','2024-10-05 06:44:56'),(58,'App\\Models\\User',42,'advert','cfdaf24db29d35224c56e19fa191c9cd4d0fce92111fd9c23195cf08ec961cf6','[\"*\"]',NULL,NULL,'2024-10-05 06:44:56','2024-10-05 06:44:56'),(59,'App\\Models\\User',42,'advert','0d26541768926db9686d0e3aa4db97ed41465117f9650ac7e2e3bfcb7c9a8c12','[\"*\"]',NULL,NULL,'2024-10-05 06:44:57','2024-10-05 06:44:57'),(60,'App\\Models\\User',42,'advert','cd22f0c2bc244e62c5638cd077dbf68ddef17e8b164e40a477143a15379b8f88','[\"*\"]',NULL,NULL,'2024-10-05 06:44:57','2024-10-05 06:44:57'),(61,'App\\Models\\User',42,'advert','a461078cfc0de3085087e47361f4640d9e59618b5be434d68fb6bbdb1cd19ca9','[\"*\"]',NULL,NULL,'2024-10-05 06:44:57','2024-10-05 06:44:57'),(62,'App\\Models\\User',42,'advert','056e7b82936836d9450c6b8ad1fc27cf1710646d1b228adc623c3ca38a6cf641','[\"*\"]',NULL,NULL,'2024-10-05 06:44:58','2024-10-05 06:44:58'),(63,'App\\Models\\User',42,'advert','c0238fa5b6b3d0d214942acf43c1ddd100099e1e0cc800519fb71e8edcdc6fc5','[\"*\"]',NULL,NULL,'2024-10-05 06:44:58','2024-10-05 06:44:58'),(64,'App\\Models\\User',42,'advert','0003a94d88bec2b880f0419030258728d3790fa0b45372fa5bc4918bf29da31e','[\"*\"]',NULL,NULL,'2024-10-05 06:44:58','2024-10-05 06:44:58'),(65,'App\\Models\\User',42,'advert','377f77bdcf5df645c3937f2e5d31d00ab709099f3cd12795cfbcab6b8144842a','[\"*\"]',NULL,NULL,'2024-10-05 06:44:59','2024-10-05 06:44:59'),(66,'App\\Models\\User',42,'advert','570d4b9aa01ab4098498ae8e868a5b8cfd6fd9b6ccaa0d9ba9e9d3f4a4a437e4','[\"*\"]',NULL,NULL,'2024-10-05 06:49:59','2024-10-05 06:49:59'),(67,'App\\Models\\User',22,'advert','1f0f2012a10d6e667391698778759b690540b64462f85e9e87fbdbceb169df73','[\"*\"]',NULL,NULL,'2024-10-05 06:53:20','2024-10-05 06:53:20');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `snapchat_ads`
--

DROP TABLE IF EXISTS `snapchat_ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `snapchat_ads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `impressions` int NOT NULL,
  `clicks` int DEFAULT NULL,
  `cost` double(8,2) DEFAULT NULL,
  `revenue` double(8,2) DEFAULT NULL,
  `promo_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `snapchat_ads`
--

LOCK TABLES `snapchat_ads` WRITE;
/*!40000 ALTER TABLE `snapchat_ads` DISABLE KEYS */;
/*!40000 ALTER TABLE `snapchat_ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_confirmed` tinyint(1) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','john@example.com','1234567890','public/images/vZ9AnISlsnZnkog1UAx497SDQJhMQel6cfktSTE5.jpg','agency','all',1,'2024-08-10 00:35:21',1,'2024-08-10 00:35:21','Y5todCIVqfBKj0PJyo3wSDVeQWG2ofMWoCg1pmwI9XNHDJ85AxhKFaB65Zut','2024-08-09 23:35:21','$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.','ZgyyHL6hxo','2024-08-09 23:35:22','2024-08-19 22:43:06',NULL),(2,'admin2','admin2@example.com','1234567890','profile1.jpg','admin','all',0,'2024-08-10 00:35:22',1,'2024-08-10 00:35:22','H5znYfB97M9D9xyiwHcG5nD5PdSyTxB4EnNauXA58oSULVeWwe0QTjbGa078','2024-08-09 23:35:22','$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.','9fSoS0Wd7x','2024-08-09 23:35:22','2024-08-19 23:48:02',NULL),(3,'Editagency1','agency1@example.com','1234567890',NULL,'agent','all',1,'2024-08-10 00:35:22',1,'2024-08-10 00:35:22',NULL,'2024-08-09 23:35:22','$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.','9R37gcW3T4','2024-08-09 23:35:22','2024-08-19 17:30:12',NULL),(4,'agency2','agency2@example.com','yyyy111xxx',NULL,'agency','all',0,'2024-08-10 00:35:22',1,'2024-08-10 00:35:22',NULL,'2024-08-09 23:35:22','$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.','raOaM9Jrs2','2024-08-09 23:35:22','2024-08-19 17:45:35',NULL),(5,'agency3','agency3@example.com',NULL,NULL,'agency','all',1,'2024-08-10 00:35:22',1,'2024-08-10 00:35:22','A09jUnl6BF6Q77PxUvMz8ngtiNFYkOSnWIyNoFu4IkVwSUp63Y6LjtqupOzx','2024-08-09 23:35:22','$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.','FkzytzpJAU','2024-08-09 23:35:23','2024-08-19 18:12:42',NULL),(6,'agent','agent@example.com','1234567890','profile1.jpg','agency','all',1,'2024-08-10 00:35:23',1,'2024-08-10 00:35:23','CGtHXPHhWnBu5W254NVsKHGNZgbAzPGTbnXVz79qgE3Wya6cvQIBD1GqjmR2','2024-08-09 23:35:23','$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.','hSBNO3rZ9Z','2024-08-09 23:35:23','2024-08-19 17:02:10',NULL),(7,'Yetta Bauer','boze@mailinator.com',NULL,NULL,'agency',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-10 13:43:38','2024-08-19 17:01:00',NULL),(8,'amir','amir@gmail.com',NULL,NULL,'agency',NULL,0,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-19 17:52:13','2024-08-19 17:55:14',NULL),(9,'khalid','khalid@gmail.com',NULL,NULL,'agency',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-19 17:54:50','2024-08-19 17:54:50',NULL),(22,'admin0000','john2@example.com','123',NULL,'admin','all',1,'2024-08-20 00:13:06',1,'2024-08-20 00:13:06','THIqVQjxfYF8t42KPKiwUOb01BGAlMdGSdUn20q5QmjwYh3O2GQlI80ykTSG','2024-08-19 23:13:06','$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.','FvpMy2v1zd','2024-08-19 23:13:06','2024-08-19 23:58:16',NULL),(23,'ddd@nnn.con','ccc@nnn.con','123123123',NULL,'admin',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 00:05:18','2024-08-20 00:06:35',NULL),(24,'brahim@fff.coi','brahim@fff.coi','2121121221',NULL,'agency',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 11:36:15','2024-08-20 11:36:15',NULL),(25,'Mercedes Hewitt','buloryqeq@mailinator.com','+1 (366) 569-7339',NULL,'agency',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 11:38:51','2024-08-20 11:38:51',NULL),(26,'Alec Woods','rypowu@mailinator.com','+1 (606) 445-4187',NULL,'agency',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 11:40:20','2024-08-20 11:40:20',NULL),(27,'Mona Soto','sedym@mailinator.com','+1 (489) 635-1649',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 11:41:38','2024-08-20 11:41:38',NULL),(28,'bbbbbb','leqicib@mailinator.com','+1 (772) 679-2664',NULL,'agent',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 11:41:47','2024-08-20 11:50:17',NULL),(29,'Eleanor Chaney','virabagyfa@mailinator.com','+1 (485) 511-6601',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 23:45:57','2024-08-20 23:45:57',NULL),(30,'Amy Santos','xowe@mailinator.com','+1 (485) 112-7556',NULL,'agent',NULL,0,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 23:51:22','2024-08-21 00:09:39',NULL),(31,'Ingrid Bass14','rexawbih@mailinator.com','+1 (923) 378-5056',NULL,'agent',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-20 23:51:54','2024-08-21 00:10:05',NULL),(32,'Abra Mason','brahim@labdaa.com','+1 (778) 961-7197',NULL,'agent',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-21 00:14:26','2024-08-21 00:27:33',NULL),(33,'omari','omari@mailinator.com','+1 (108) 242-4326',NULL,'agent',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-08-21 00:30:12','2024-08-25 20:06:41',NULL),(34,'brahim labdaa','haladigitally@gmail.com',NULL,NULL,'agency',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$NAT08TSliqfupzJ4Uq/0XeL9qTsNx3cfiyY5yVYqO5/.hFpCDGmF.',NULL,'2024-10-04 18:07:33','2024-10-04 18:07:33',NULL),(35,'Kyla Meyers','test@mailinator.com','+1 (547) 114-3774','images/NbSr9unzNvoAt5TW3CGXxy26dUrzVEtt6Ue2ZKfu.jpg','agency',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$F60t1lTmpj.vJKCIqeF1teX90ZxZHZeynbY6yiYHmw61Onk2X56YC',NULL,'2024-10-05 05:03:07','2024-10-05 06:30:24',NULL),(36,'Karen Cooke','ranewavema@mailinator.com','+1 (579) 139-1384',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$QzbPqbx9HCyeYk4MKRghpeX41LU5w6lz0hT5xMxms9kgS1s9U5N7u',NULL,'2024-10-05 05:15:54','2024-10-05 05:15:54',NULL),(37,'Nerea Becker','qocup@mailinator.com','+1 (378) 978-4881',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$8Z4GE7pwubNoCHPcHuJ3xONgj.qVNJZesqadRKoEjWGZUWyAKQVgG',NULL,'2024-10-05 05:22:38','2024-10-05 05:22:38',NULL),(38,'Owen Villarreal','tocyty@mailinator.com','+1 (264) 781-3283',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$AVDTdur73GAEk/bR1rzbQe6uvNYfybPEIR3kR1QsUriBxbPW938WW',NULL,'2024-10-05 05:23:52','2024-10-05 05:23:52',NULL),(39,'Kane Buck','wiqe@mailinator.com','+1 (546) 737-1183',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$zyHq7az0zY2o.LYK9VzuWeQyrNdY/FcKLExq7Cceg.1jb07wVmjvq',NULL,'2024-10-05 05:28:46','2024-10-05 05:28:46',NULL),(40,'eeeee','wiqe222@mailinator.com','44353453',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$xRgdykgu10q6fHD3mi5OcOjI12tfisAOQPe0JaxdsqtmW0Xkze1u2',NULL,'2024-10-05 05:29:43','2024-10-05 05:29:43',NULL),(41,'www','erwqr@example.com','432334',NULL,'agent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$BKjTRCJEtGDhr.tyotsq0uDDUR0bqh6PxG6mgr2.3iNzV5y6VzDo.',NULL,'2024-10-05 05:55:48','2024-10-05 05:55:48',NULL),(42,'test','brahim@gmail.com','34314143',NULL,'agent',NULL,1,NULL,NULL,NULL,NULL,NULL,'$2y$12$Qj8hHPN2ZGa.mWtL..VgxebbvgQL6W7cu/kcxVi0yhjPWQ0xt0ntG',NULL,'2024-10-05 05:59:22','2024-10-05 06:36:18',NULL);
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

-- Dump completed on 2024-10-05  9:21:26
