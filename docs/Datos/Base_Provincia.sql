-- MySQL dump 10.15  Distrib 10.0.20-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: yacadev
-- ------------------------------------------------------
-- Server version	10.0.20-MariaDB-log

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
-- Table structure for table `Base_Provincia`
--

DROP TABLE IF EXISTS `Base_Provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Base_Provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoIfam` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `NombreOficial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Version` int(11) NOT NULL DEFAULT '1',
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `Pais_id` int(11) NOT NULL,
  `CodigoIso` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `GentiliciosMasculinos` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `GentiliciosFemeninos` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F2399E59B9EC5A` (`Pais_id`),
  CONSTRAINT `FK_2F2399E59B9EC5A` FOREIGN KEY (`Pais_id`) REFERENCES `Base_Pais` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Base_Provincia`
--

LOCK TABLES `Base_Provincia` WRITE;
/*!40000 ALTER TABLE `Base_Provincia` DISABLE KEYS */;
INSERT INTO `Base_Provincia` VALUES (1,'BUE','','http://www.gba.gov.ar','Buenos Aires',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-B','bonaerense','bonaerense'),(2,'CAT','','http://www.catamarca.gov.ar','Catamarca',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-K','catamarqueño, catamarcano','catamarqueña, catamarcana'),(3,'CHA','','http://www.chaco.gov.ar','Chaco',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-H','chaqueño','chaqueña'),(4,'CHU','','http://www.chubut.gov.ar','Chubut',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-U','chubutense','chubutense'),(5,'CBA','','http://www.cba.gov.ar','Córdoba',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-X','cordobés','cordobesa'),(6,'COR','','http://www.corrientes.gov.ar','Corrientes',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-W','correntino','correntina'),(7,'ERI','','http://www.entrerios.gov.ar','Entre Ríos',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-E','entrerriana','entrerriana'),(8,'FOR','','http://www.formosa.gov.ar','Formosa',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-P','formoseño','formoseña'),(9,'JUJ','','http://www.jujuy.gov.ar','Jujuy',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-Y','jujeño','jujeña'),(10,'LAP','','http://www.lapampa.gov.ar','La Pampa',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-L','pampeano','pampeana'),(11,'LRJ','','http://www.larioja.gov.ar','La Rioja',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-F','riojano','riojana'),(12,'MZA','','http://www.mendoza.gov.ar','Mendoza',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-M','mendocino','mendocina'),(13,'MIS','','http://www.misiones.gov.ar','Misiones',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-N','misionero','misionera'),(14,'NEU','','http://www.neuquen.gov.ar','Neuquén',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-Q','neuquino','neuquina'),(15,'RNO','','http://www.rionegro.gov.ar','Río Negro',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-R','rionegrino','rionegrina'),(16,'SAL','','http://www.salta.gov.ar','Salta',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-A','salteño','salteña'),(17,'SJU','','http://www.sanjuan.gov.ar','San Juan',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-J','sanjuanino','sanjuanina'),(18,'SLU','','http://www.sanluis.gov.ar','San Luis',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-D','puntano, sanluiseño','puntana, sanluiseña'),(19,'SCR','','http://www.santacruz.gov.ar','Santa Cruz',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-Z','santacruceño','santacruceña'),(20,'SFE','','http://www.santafe.gov.ar','Santa Fe',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-S','santafesino','santafesina'),(21,'SGO','','http://www.sde.gov.ar','Santiago del Estero',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-G','santiagueño','santiagueña'),(22,'TDF','Tierra del Fuego, Antártida e Islas del Atlántico Sur','http://www.tierradelfuego.gov.ar','Tierra del Fuego',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-V','fueguino','fueguina'),(23,'TUC','','http://www.tucuman.gov.ar','Tucumán',1,'2015-10-05 11:02:07','2015-10-05 11:02:07',9,'AR-T','tucumano','tucumana');
/*!40000 ALTER TABLE `Base_Provincia` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-05 12:44:16
