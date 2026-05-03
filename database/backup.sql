-- MySQL dump 10.13  Distrib 9.6.0, for macos15.7 (arm64)
--
-- Host: turntable.proxy.rlwy.net    Database: railway
-- ------------------------------------------------------
-- Server version	9.4.0

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita_servicio`
--

DROP TABLE IF EXISTS `cita_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cita_servicio` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cita_id` bigint unsigned NOT NULL,
  `servicio_id` bigint unsigned NOT NULL,
  `precio_aplicado` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `servicio_id` (`cita_id`),
  KEY `cita_servicio_servicio_id_foreign` (`servicio_id`),
  CONSTRAINT `cita_servicio_cita_id_foreign` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cita_servicio_servicio_id_foreign` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita_servicio`
--

LOCK TABLES `cita_servicio` WRITE;
/*!40000 ALTER TABLE `cita_servicio` DISABLE KEYS */;
INSERT INTO `cita_servicio` VALUES (1,1,1,270.00,'2026-05-02 15:25:17','2026-05-02 15:25:17'),(2,2,3,280.00,'2026-05-02 16:13:03','2026-05-02 16:13:03'),(3,3,1,270.00,'2026-05-02 16:14:19','2026-05-02 16:14:19'),(4,4,2,250.00,'2026-05-02 16:15:26','2026-05-02 16:15:26'),(5,5,5,100.00,'2026-05-02 16:17:05','2026-05-02 16:17:05'),(6,6,1,270.00,'2026-05-02 16:19:48','2026-05-02 16:19:48');
/*!40000 ALTER TABLE `cita_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `horario_id` bigint unsigned NOT NULL,
  `fecha_cita` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` enum('pendiente','confirmada','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `mensaje_cliente` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citas_horario_id_foreign` (`horario_id`),
  KEY `citas_fecha_cita_estado_index` (`fecha_cita`,`estado`),
  KEY `citas_user_id_fecha_cita_index` (`user_id`,`fecha_cita`),
  CONSTRAINT `citas_horario_id_foreign` FOREIGN KEY (`horario_id`) REFERENCES `horarios` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `citas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES (1,3,1,'2026-05-04','10:00:00','13:00:00','confirmada',NULL,'2026-05-02 15:25:17','2026-05-02 15:26:21'),(2,4,2,'2026-05-04','16:30:00','19:30:00','confirmada',NULL,'2026-05-02 16:13:03','2026-05-02 16:13:24'),(3,5,3,'2026-05-05','10:30:00','13:30:00','confirmada',NULL,'2026-05-02 16:14:19','2026-05-02 16:14:31'),(4,6,4,'2026-05-05','17:00:00','20:00:00','confirmada',NULL,'2026-05-02 16:15:26','2026-05-02 16:15:38'),(5,7,11,'2026-05-08','17:30:00','19:00:00','confirmada','Maquillaje para una graduación','2026-05-02 16:17:05','2026-05-02 16:17:13'),(6,8,8,'2026-05-07','11:00:00','14:00:00','confirmada',NULL,'2026-05-02 16:19:48','2026-05-02 16:19:54');
/*!40000 ALTER TABLE `citas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facturas`
--

DROP TABLE IF EXISTS `facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facturas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cita_id` bigint unsigned NOT NULL,
  `numero_factura` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_emision` date NOT NULL,
  `estado_factura` enum('emitida','anulada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'emitida',
  `base_imponible` decimal(10,2) NOT NULL,
  `iva_porcentaje` decimal(5,2) NOT NULL DEFAULT '21.00',
  `iva_importe` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facturas_cita_id_unique` (`cita_id`),
  UNIQUE KEY `facturas_numero_factura_unique` (`numero_factura`),
  KEY `facturas_fecha_emision_estado_factura_index` (`fecha_emision`,`estado_factura`),
  CONSTRAINT `facturas_cita_id_foreign` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facturas`
--

LOCK TABLES `facturas` WRITE;
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
INSERT INTO `facturas` VALUES (1,1,'FAC-20260502-152517-1','2026-05-04','emitida',270.00,21.00,56.70,326.70,'2026-05-02 15:25:17','2026-05-02 15:25:17'),(2,2,'FAC-20260502-161303-2','2026-05-04','emitida',280.00,21.00,58.80,338.80,'2026-05-02 16:13:03','2026-05-02 16:13:03'),(3,3,'FAC-20260502-161419-3','2026-05-05','emitida',270.00,21.00,56.70,326.70,'2026-05-02 16:14:19','2026-05-02 16:14:19'),(4,4,'FAC-20260502-161526-4','2026-05-05','emitida',250.00,21.00,52.50,302.50,'2026-05-02 16:15:26','2026-05-02 16:15:26'),(5,5,'FAC-20260502-161705-5','2026-05-08','emitida',100.00,21.00,21.00,121.00,'2026-05-02 16:17:05','2026-05-02 16:17:05'),(6,6,'FAC-20260502-161948-6','2026-05-07','emitida',270.00,21.00,56.70,326.70,'2026-05-02 16:19:48','2026-05-02 16:19:48');
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;
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
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `dia_semana` tinyint unsigned NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `horarios_dia_semana_activo_index` (`dia_semana`,`activo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horarios`
--

LOCK TABLES `horarios` WRITE;
/*!40000 ALTER TABLE `horarios` DISABLE KEYS */;
INSERT INTO `horarios` VALUES (1,1,'10:00:00','14:00:00',1,'2026-05-02 14:48:25','2026-05-02 14:48:25'),(2,1,'16:00:00','20:00:00',1,'2026-05-02 14:48:48','2026-05-02 14:48:48'),(3,2,'10:00:00','14:00:00',1,'2026-05-02 14:49:01','2026-05-02 14:49:01'),(4,2,'16:00:00','20:00:00',1,'2026-05-02 14:49:22','2026-05-02 14:49:22'),(6,3,'10:00:00','14:00:00',1,'2026-05-02 14:49:59','2026-05-02 14:49:59'),(7,3,'16:00:00','20:00:00',1,'2026-05-02 14:50:11','2026-05-02 14:50:11'),(8,4,'10:00:00','14:00:00',1,'2026-05-02 14:50:26','2026-05-02 14:50:26'),(9,4,'16:00:00','20:00:00',1,'2026-05-02 14:50:39','2026-05-02 14:50:39'),(10,5,'10:00:00','14:00:00',1,'2026-05-02 14:50:51','2026-05-02 14:50:51'),(11,5,'16:00:00','20:00:00',1,'2026-05-02 14:51:11','2026-05-02 14:51:11');
/*!40000 ALTER TABLE `horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_24_161425_add_role_and_phones_to_users_table',1),(5,'2026_02_24_164258_create_servicios_table',1),(6,'2026_02_24_164311_create_horarios_table',1),(7,'2026_02_24_175755_add_bussines_fields_to_users_table',1),(8,'2026_02_24_182810_create_citas_table',1),(9,'2026_02_24_183649_create_cita_servicio_table',1),(10,'2026_02_24_184929_create_facturas_table',1),(11,'2026_02_24_185717_create_pagos_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagos`
--

DROP TABLE IF EXISTS `pagos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pagos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `factura_id` bigint unsigned NOT NULL,
  `metodo` enum('efectivo','tarjeta','bizum','transferencia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','pagado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `fecha_pago` datetime DEFAULT NULL,
  `referencia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pagos_estado_metodo_index` (`estado`,`metodo`),
  KEY `pagos_factura_id_estado_index` (`factura_id`,`estado`),
  CONSTRAINT `pagos_factura_id_foreign` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagos`
--

LOCK TABLES `pagos` WRITE;
/*!40000 ALTER TABLE `pagos` DISABLE KEYS */;
INSERT INTO `pagos` VALUES (1,1,'tarjeta',54.00,'pagado','2026-05-02 15:26:21','SIM-20260502152621-1','2026-05-02 15:26:21','2026-05-02 15:26:21'),(2,2,'transferencia',56.00,'pagado','2026-05-02 16:13:24','SIM-20260502161324-2','2026-05-02 16:13:24','2026-05-02 16:13:24'),(3,3,'tarjeta',54.00,'pagado','2026-05-02 16:14:31','SIM-20260502161431-3','2026-05-02 16:14:31','2026-05-02 16:14:31'),(4,4,'tarjeta',50.00,'pagado','2026-05-02 16:15:38','SIM-20260502161538-4','2026-05-02 16:15:38','2026-05-02 16:15:38'),(5,5,'tarjeta',20.00,'pagado','2026-05-02 16:17:13','SIM-20260502161713-5','2026-05-02 16:17:13','2026-05-02 16:17:13'),(6,6,'transferencia',54.00,'pagado','2026-05-02 16:19:54','SIM-20260502161954-6','2026-05-02 16:19:54','2026-05-02 16:19:54');
/*!40000 ALTER TABLE `pagos` ENABLE KEYS */;
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
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `tipo_servicio` enum('micropigmentacion','maquillaje') COLLATE utf8mb4_unicode_ci NOT NULL,
  `duracion_min` smallint unsigned NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `servicios_tipo_servicio_activo_index` (`tipo_servicio`,`activo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (1,'Micropigmentación de cejas','Diseño y definición de cejas adaptado a tu rostro para conseguir un resultado natural, simétrico y duradero. Ideal para mejorar la forma, densidad y expresión de la mirada.','micropigmentacion',180,270.00,1,'2026-05-02 14:53:03','2026-05-02 15:24:29'),(2,'Micropigmentación de ojos','Técnica profesional que realza la mirada mediante la aplicación de pigmento en la línea del ojo, aportando intensidad y definición con un acabado elegante y duradero','micropigmentacion',180,250.00,1,'2026-05-02 14:53:34','2026-05-02 15:24:45'),(3,'Micropigmentación de labios','Tratamiento estético que mejora el color, la forma y la definición de los labios, proporcionando un aspecto más uniforme, voluminoso y natural.','micropigmentacion',180,280.00,1,'2026-05-02 14:54:16','2026-05-02 15:24:38'),(4,'Micropigmentación de areolas','Procedimiento especializado orientado a la reconstrucción estética de la areola mamaria, logrando un resultado natural y armonioso tras intervenciones o cambios físicos.','micropigmentacion',180,290.00,1,'2026-05-02 14:54:48','2026-05-02 15:24:22'),(5,'Maquillaje profesional','Servicio de maquillaje personalizado para eventos, celebraciones o sesiones especiales, adaptado a tu estilo y resaltando tu belleza de forma profesional.','maquillaje',90,100.00,1,'2026-05-02 14:55:26','2026-05-02 14:55:26');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('EtNT1ZmrxFItClBw92zTIDDkJBPY1F3KtpTuQeMV',NULL,'100.64.0.2','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkJPNVdqMEZOM0VhZGVXS3lqZkdsOWc5ZXF3UG1uSERjOTlKNHpGZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly90YW1hcmFob3lhc2JlYXV0eXN0dWRpby1wcm9kdWN0aW9uLnVwLnJhaWx3YXkuYXBwIjtzOjU6InJvdXRlIjtzOjI3OiJnZW5lcmF0ZWQ6OnhTYVd0ZWdGU25LN285d08iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1777659025),('qyDi9w36MzOAiL3Et3AUJ9dAaGLzqQIfHiHQ2aSO',NULL,'100.64.0.13','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVhwS2R5RlliTEUyZFM4MlBORnJObFlOU2F3azdPOVFtT0x3RDRaUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjI6Imh0dHA6Ly90YW1hcmFob3lhc2JlYXV0eXN0dWRpby1wcm9kdWN0aW9uLnVwLnJhaWx3YXkuYXBwL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1777724824);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidos` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cliente',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `phone_1` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Admin',NULL,'Admin','admin@admin.com',NULL,'$2y$12$VBMwFD8CIjNQYqeOa.jAl.nmw6g7Co3ziVx3d7.ThTZm64BXMdatK',NULL,NULL,'2026-05-02 14:46:51','admin',1,NULL,NULL),(3,NULL,NULL,'María Dolores Fuertes','mdfuertes@gmail.com',NULL,'$2y$12$9JUhLrT0QIjE6uc.s2FOp.qrXjj4RmBB2SQAIhmmCtB0GCkkkI41.',NULL,'2026-05-02 15:22:48','2026-05-02 15:22:48','cliente',1,NULL,NULL),(4,NULL,NULL,'Carmen Ruiz Garcia','mrgarcia@gmail.com',NULL,'$2y$12$Jhhik.aQiM9EyRj/ACPrO.AbIW14Ft.aa3XV/3V62k/zyuWq/etpG',NULL,'2026-05-02 15:50:00','2026-05-02 15:50:00','cliente',1,NULL,NULL),(5,NULL,NULL,'Guadalupe Sierra Marcos','gsmarcos@gmail.com',NULL,'$2y$12$8XIaQ9M4255nuiWzxD5XNOMfbeQYov4Jqq.Q1VKDXpr.fqMoeUuZu',NULL,'2026-05-02 16:14:00','2026-05-02 16:14:00','cliente',1,NULL,NULL),(6,NULL,NULL,'Cristina Medina Sierra','cmsierra@gmail.com',NULL,'$2y$12$coAE6YROUHSFi7o8W8PLOOYTLHUn1al7Ish4DBkzl.bZDIkwQh/Gy',NULL,'2026-05-02 16:15:10','2026-05-02 16:15:10','cliente',1,NULL,NULL),(7,NULL,NULL,'Beatriz Fernandez Marquez','bfmarquez@gmail.com',NULL,'$2y$12$SCayGVKS121GOpqYaVsJwOH.IxTdhvF8kZO1viD009GXyLPeYT1tu',NULL,'2026-05-02 16:16:23','2026-05-02 16:16:23','cliente',1,NULL,NULL),(8,NULL,NULL,'Lidia Perez Moya','lperezmoya@gmail.com',NULL,'$2y$12$cDm1V0uB38h6toWI6Yn7T.Fx.e82PGNrHxqMuOAGRDyQ6hgIqw.yC',NULL,'2026-05-02 16:19:32','2026-05-02 16:19:32','cliente',1,NULL,NULL);
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

-- Dump completed on 2026-05-03 12:00:30
