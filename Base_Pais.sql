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
-- Table structure for table `Base_Pais`
--

DROP TABLE IF EXISTS `Base_Pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Base_Pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `IsoAlfa2` varchar(2) NOT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL,
  `Version` int(11) NOT NULL DEFAULT '1',
  `Cctld` varchar(3) NOT NULL,
  `GentiliciosMasculinos` varchar(255) NOT NULL,
  `GentiliciosFemeninos` varchar(255) NOT NULL,
  `MonedaIso` varchar(3) NOT NULL,
  `NombreOficial` varchar(255) DEFAULT NULL,
  `NombreIngles` varchar(255) NOT NULL,
  `NombreOficialIngles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=512 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Base_Pais`
--

LOCK TABLES `Base_Pais` WRITE;
/*!40000 ALTER TABLE `Base_Pais` DISABLE KEYS */;
INSERT INTO `Base_Pais` VALUES (1,'Afganistán','AF',NULL,NULL,1,'.af','afgano','afnana','AFN','República Islámica de Afganistán','Afghanistan','Islamic Republic of Afghanistan'),(2,'Albania','AL',NULL,NULL,1,'.al','albanés, albano','albanesa, albana','ALL','República de Albania','Albania','Republic of Albania'),(3,'Alemania','DE',NULL,NULL,1,'.de','alemán','alemana','EUR','República Federal de Alemania','Germany','Federal Republic of Germany'),(4,'Andorra','AD',NULL,NULL,1,'.ad','andorrano','andorrana','EUR','Principado de Andorra','Andorra','Principality of Andorra'),(5,'Angola','AO',NULL,NULL,1,'.ao','angoleño','angoleña','AOA','República de Angola','Angola','Republic of Angola'),(6,'Antigua y Barbuda','AG',NULL,NULL,1,'.ag','antiguano','antiguana','XCD','','Antigua and Barbuda',''),(7,'Arabia Saudita','SA',NULL,NULL,1,'.sa','saudita, saudí','saudita, saudí','SAR','Reino de Arabia Saudita','Saudi Arabia','Kingdom of Saudi Arabia'),(8,'Argelia','DZ',NULL,NULL,1,'.dz','argelino','argelina','DZD','República Argelina Democrática y Popular','Algeria','People\'s Democratic Republic of Algeria'),(9,'Argentina','AR',NULL,NULL,1,'.ar','argentino','argentina','ARS','República Argentina','Argentina','Argentine Republic'),(10,'Armenia','AM',NULL,NULL,1,'.am','armenio','armenia','AMD','República de Armenia','Armenia','Republic of Armenia'),(11,'Australia','AU',NULL,NULL,1,'.au','australiano','australiana','AUD','Mancomunidad de Australia','Australia','Commonwealth of Australia'),(12,'Austria','AT',NULL,NULL,1,'.at','austriaco, austríaco','austriaca, austríaca','EUR','República de Austria','Austria','Republic of Austria'),(13,'Azerbaiyán','AZ',NULL,NULL,1,'.az','azerbaiyano, azerí','azerbaiyana, azerí','AZM','República de Azerbaiyán','Azerbaijan','Republic of Azerbaijan'),(14,'Bahamas','BS',NULL,NULL,1,'.bs','bahameño','bahameña','BSD','Mancomunidad de las Bahamas','Bahamas, The','Commonwealth of the Bahamas'),(15,'Bangladés','BD',NULL,NULL,1,'.bd','bangladesí','bangladesí','BDT','República Popular de Bangladés','Bangladesh','People\'s Republic of Bangladesh'),(16,'Barbados','BB',NULL,NULL,1,'.bb','barbadense','barbadense','BBD','','Barbados',''),(17,'Baréin','BH',NULL,NULL,1,'.bh','bareiní','bareiní','BHD','Reino de Baréin','Bahrain','Kingdom of Bahrain'),(18,'Bélgica','BE',NULL,NULL,1,'.be','belga','belga','EUR','Reino de Bélgica','Belgium','Kingdom of Belgium'),(19,'Belice','BZ',NULL,NULL,1,'.bz','beliceño','beliceña','BZD','','Belize',''),(20,'Benín','BJ',NULL,NULL,1,'.bj','beninés','beninesa','XOF','República de Benín','Benin','Republic of Benin'),(21,'Bielorrusia','BY',NULL,NULL,1,'.by','bielorruso, belorruso, belaruso','bielorrusa, belorrusa, belarusa','BYR','República de Belarús','Belarus','Republic of Belarus'),(22,'Birmania','MM',NULL,NULL,1,'.mm','birmano','birmana','MMK','República de la Unión de Myanmar','Myanmar','Republic of the Union of Myanmar'),(23,'Bolivia','BO',NULL,NULL,1,'.bo','boliviano','boliviana','BOB','Estado Plurinacional de Bolivia','Bolivia','Plurinational State of Bolivia'),(24,'Bosnia y Herzegovina','BA',NULL,NULL,1,'.ba','bosnio','bosnia','BAM','','Bosnia and Herzegovina',''),(25,'Botsuana','BW',NULL,NULL,1,'.bw','botsuano, botsuanés','botsuana, botsuanesa','BWP','República de Botsuana','Botswana','Republic of Botswana'),(26,'Brasil','BR',NULL,NULL,1,'.br','brasileño, brasilero','brasileña, brasilera','BRL','República Federativa del Brasil','Brazil','Federative Republic of Brazil'),(27,'Brunéi','BN',NULL,NULL,1,'.bn','bruneano','bruneana','BND','Estado de Brunéi Darussalam','Brunei','Nation of Brunei, Abode of Peace'),(28,'Bulgaria','BG',NULL,NULL,1,'.bg','búlgaro','búlgara','BGN','República de Bulgaria','Bulgaria','Republic of Bulgaria'),(29,'Burkina Faso','BF',NULL,NULL,1,'.bf','burkinés','burkinés','XOF','','Burkina Faso',''),(30,'Burundi','BI',NULL,NULL,1,'.bi','burundés','burundesa','BIF','República de Burundi','Burundi','Republic of Burundi'),(31,'Bután','BT',NULL,NULL,1,'.bt','butanés','butanesa','BTN','Reino de Bután','Bhutan','Kingdom of Bhutan'),(32,'Cabo Verde','CV',NULL,NULL,1,'.cv','caboverdiano','caboverdiana','CVE','República de Cabo Verde','Cape Verde','Republic of Cabo Verde'),(33,'Camboya','KH',NULL,NULL,1,'.kh','camboyano','camboyana','KHR','Reino de Camboya','Cambodia','Kingdom of Cambodia'),(34,'Camerún','CM',NULL,NULL,1,'.cm','camerunés','camerunesa','XAF','República del Camerún','Cameroon','Republic of Cameroon'),(35,'Canadá','CA',NULL,NULL,1,'.ca','canadiense','canadiense','CAD','','Canada',''),(36,'Catar','QA',NULL,NULL,1,'.qa','catarí','catarí','QAR','Estado de Catar','Qatar','State of Qatar'),(37,'Chad','TD',NULL,NULL,1,'.td','chadiano','chadiana','XAF','República de Chad','Chad','Republic of Chad'),(38,'Chile','CL',NULL,NULL,1,'.cl','chileno','chilena','CLP','República de Chile','Chile','Republic of Chile'),(39,'China','CN',NULL,NULL,1,'.cn','chino','china','CNY','República Popular China','China','People\'s Republic of China'),(40,'Chipre','CY',NULL,NULL,1,'.cy','chipriota','chipriota','EUR','República de Chipre','Cyprus','Republic of Cyprus'),(41,'Ciudad del Vaticano','VA',NULL,NULL,1,'.va','vaticano','vaticana','EUR','Estado de la Ciudad del Vaticano','Vatican City','Vatican City State'),(42,'Colombia','CO',NULL,NULL,1,'.co','colombiano','colombiana','COP','República de Colombia','Colombia','Republic of Colombia'),(43,'Comoras','KM',NULL,NULL,1,'.km','comorense','comorense','KMF','Unión de las Comoras','Comoros','Union of the Comoros'),(44,'Corea del Norte','KP',NULL,NULL,1,'.kp','coreano, norcoreano','coreana, norcoreana','KPW','República Popular Democrática de Corea','Korea, North','Democratic People\'s Republic of Korea'),(45,'Corea del Sur','KR',NULL,NULL,1,'.kr','coreano, surcoreano','coreana, surcoreana','KRW','República de Corea','Korea, South','Republic of Korea'),(46,'Costa de Marfil','CI',NULL,NULL,1,'.ci','marfileño','marfileña','XOF','República de Costa de Marfil','Ivory Coast','Republic of Côte d\'Ivoire'),(47,'Costa Rica','CR',NULL,NULL,1,'.cr','costarricense','costarricense','CRC','República de Costa Rica','Costa Rica','Republic of Costa Rica'),(48,'Croacia','HR',NULL,NULL,1,'.hr','croata','croata','HRK','República de Croacia','Croatia','Republic of Croatia'),(49,'Cuba','CU',NULL,NULL,1,'.cu','cubano','cubana','CUP','República de Cuba','Cuba','Republic of Cuba'),(50,'Dinamarca','DK',NULL,NULL,1,'.dk','danés, dinamarqués','danesa, dinamarquesa','DKK','Reino de Dinamarca','Denmark','Kingdom of Denmark'),(51,'Dominica','DM',NULL,NULL,1,'.dm','dominiqués','dominiquesa','XCF','Mancomunidad de Dominica','Dominica','Commonwealth of Dominica'),(52,'Ecuador','EC',NULL,NULL,1,'.ec','ecuatoriano','ecuatoriana','USD','República de Ecuador','Ecuador','Republic of Ecuador'),(53,'Egipto','EG',NULL,NULL,1,'.eg','egipcio','egipcia','EGP','República Árabe de Egipto','Egypt','Arab Republic of Egypt'),(54,'El Salvador','SV',NULL,NULL,1,'.sv','salvadoreño','salvadoreña','USD','República de El Salvador','El Salvador','Republic of El Salvador'),(55,'Emiratos Árabes Unidos','AE',NULL,NULL,1,'.ae','emiratí','emiratí','AED','','United Arab Emirates',''),(56,'Eritrea','ER',NULL,NULL,1,'.er','eritreo','eritrea','ERN','Estado de Eritrea','Eritrea','State of Eritrea'),(57,'Eslovaquia','SK',NULL,NULL,1,'.sk','eslovaco','eslovaca','EUR','República Eslovaca','Slovakia','Slovak Republic'),(58,'Eslovenia','SI',NULL,NULL,1,'.si','esloveno','eslovena','EUR','República de Eslovenia','Slovenia','Republic of Slovenia'),(59,'España','ES',NULL,NULL,1,'.es','español','española','EUR','Reino de España','Spain','Kingdom of Spain'),(60,'Estados Unidos','US',NULL,NULL,1,'.us','estadounidense, estadunidense','estadounidense, estadunidense','USD','Estados Unidos de América','United States','United States of America'),(61,'Estonia','EE',NULL,NULL,1,'.ee','estonio','estonia','EUR','República de Estonia','Estonia','Republic of Estonia'),(62,'Etiopía','ET',NULL,NULL,1,'.et','etíope, abisinio','etíope, abisinia','ETB','República Democrática Federal de Etiopía','Ethiopia','Federal Democratic Republic of Ethiopia'),(63,'Filipinas','PH',NULL,NULL,1,'.ph','filipino','filipina','PHP','República de Filipinas','Philippines','Republic of the Philippines'),(64,'Finlandia','FI',NULL,NULL,1,'.fi','finlandés, finés','finlandesa, finesa','EUR','República de Finlandia','Finland','Republic of Finland'),(65,'Fiyi','FJ',NULL,NULL,1,'.fj','fiyiano','fiyiana','FJD','República de Fiyi','Fiji','Republic of Fiji'),(66,'Francia','FR',NULL,NULL,1,'.fr','francés','francesa','EUR','República Francesa','France','French Republic'),(67,'Gabón','GA',NULL,NULL,1,'.ga','gabonés','gabonesa','XAF','República Gabonesa','Gabon','Gabonese Republic'),(68,'Gambia','GM',NULL,NULL,1,'.gm','gambiano','gambiana','GMD','República del Gambia','Gambia, The','Republic of the Gambia'),(69,'Georgia','GE',NULL,NULL,1,'.ge','georgiano','georgiana','GEL','','Georgia',''),(70,'Ghana','GH',NULL,NULL,1,'.gh','ghanés','ghanesa','GHC','República de Ghana','Ghana','Republic of Ghana'),(71,'Granada','GD',NULL,NULL,1,'.gd','granadino','granadina','XCD','','Grenada',''),(72,'Grecia','GR',NULL,NULL,1,'.gr','griego, heleno','griega, helena','EUR','República Helénica','Greece','Hellenic Republic'),(73,'Guatemala','GT',NULL,NULL,1,'.gt','guatemalteco','guatemalteca','GTQ','República de Guatemala','Guatemala','Republic of Guatemala'),(74,'Guinea','GN',NULL,NULL,1,'.gn','guineano','guineana','GNF','República de Guinea','Guinea','Republic of Guinea'),(75,'Guinea Ecuatorial','GQ',NULL,NULL,1,'.gq','ecuatoguineano','ecuatoguineana','XAF','República de Guinea Ecuatorial','Equatorial Guinea','Republic of Equatorial Guinea'),(76,'Guinea-Bisáu','GW',NULL,NULL,1,'.gw','bisauguineano','bisauguineana','XOF','','Guinea-Bissau','Republic of Guinea-Bissau'),(77,'Guyana','GY',NULL,NULL,1,'.gy','guyanés','guyanesa','GYD','República Cooperativa de Guyana','Guyana','Co-operative Republic of Guyana'),(78,'Haití','HT',NULL,NULL,1,'.ht','haitiano','haitiana','HTG','República de Haití','Haiti','Republic of Haiti'),(79,'Honduras','HN',NULL,NULL,1,'.hn','hondureño','hondureña','HNL','República de Honduras','Honduras','Republic of Honduras'),(80,'Hungría','HU',NULL,NULL,1,'.hu','húngaro','húngara','HUF','','Hungary',''),(81,'India','IN',NULL,NULL,1,'.in','indio, hindú','india, hindú','INR','República de la India','India','Republic of India'),(82,'Indonesia','ID',NULL,NULL,1,'.id','indonesio','indonesia','IDR','República de Indonesia','Indonesia','Republic of Indonesia'),(83,'Irak','IQ',NULL,NULL,1,'.iq','irakí, iraquí','irakí, iraquí','IQD','República de Irak','Iraq','Republic of Iraq'),(84,'Irán','IR',NULL,NULL,1,'.ir','iraní','iraní','IRR','República Islámica de Irán','Iran','Islamic Republic of Iran'),(85,'Irlanda','IE',NULL,NULL,1,'.ie','irlandés','irlandesa','EUR','República de Irlanda','Ireland',''),(86,'Islandia','IS',NULL,NULL,1,'.is','islandés','islandesa','ISK','República de Islandia','Iceland','Republic of Iceland'),(87,'Islas Marshall','MH',NULL,NULL,1,'.mh','marshalés','marshalesa','USD','República de las Islas Marshall','Marshall Islands','Republic of the Marshall Islands'),(88,'Islas Salomón','SB',NULL,NULL,1,'.sb','salomonense','salomonense','SBD','','Solomon Islands',''),(89,'Israel','IL',NULL,NULL,1,'.il','israelí','israelí','ILS','Estado de Israel','Israel','State of Israel'),(90,'Italia','IT',NULL,NULL,1,'.it','italiano','italiana','EUR','República Italiana','Italy','Italian Republic'),(91,'Jamaica','JM',NULL,NULL,1,'.jm','jamaicano, jamaiquino','jamaicana, jamaiquina','JMD','','Jamaica',''),(92,'Japón','JP',NULL,NULL,1,'.jp','japonés','japonesa','JPY','Estado de Japón','Japan',''),(93,'Jordania','JO',NULL,NULL,1,'.jo','jordano','jordana','JOD','Reino Hachemita de Jordania','Jordan','Hashemite Kingdom of Jordan'),(94,'Kazajistán','KZ',NULL,NULL,1,'.kz','kazajo, kazako','kazaja, kazaka','KZT','República de Kazajistán','Kazakhstan','Republic of Kazakhstan'),(95,'Kenia','KE',NULL,NULL,1,'.ke','keniano, keniata','keniana, keniata','KES','República de Kenia','Kenya','Republic of Kenya'),(96,'Kirguistán','KG',NULL,NULL,1,'.kg','kirguís, kirguiso','kirguisa','KGS','República de Kirguistán','Kyrgyzstan','Kyrgyz Republic'),(97,'Kiribati','KI',NULL,NULL,1,'.ki','kiribatiano','kiribatiana','AUD','República de Kiribati','Kiribati','Republic of Kiribati'),(98,'Kuwait','KW',NULL,NULL,1,'.kw','kuwaití','kuwaití','KWD','Estado de Kuwait','Kuwait','State of Kuwait'),(99,'Laos','LA',NULL,NULL,1,'.la','laosiano','laosiana','LAK','República Democrática Popular Lao','Laos','Lao People\'s Democratic Republic'),(100,'Lesoto','LS',NULL,NULL,1,'.ls','lesotense','lesotense','LSL','Reino de Lesoto','Lesotho','Kingdom of Lesotho'),(101,'Letonia','LV',NULL,NULL,1,'.lv','letón','letona','EUR','República de Letonia','Latvia','Republic of Latvia'),(102,'Líbano','LB',NULL,NULL,1,'.lb','libanés','libanesa','LBP','República Libanesa','Lebanon','Lebanese Republic'),(103,'Liberia','LR',NULL,NULL,1,'.lr','liberiano','liberiana','LRD','República de Liberia','Liberia','Republic of Liberia'),(104,'Libia','LY',NULL,NULL,1,'.ly','libio','libia','LYD','Estado de Libia','Libya','State of Libya'),(105,'Liechtenstein','LI',NULL,NULL,1,'.li','liechtensteiniano','liechtensteiniana','CHF','Principado de Liechtenstein','Liechtenstein','Principality of Liechtenstein'),(106,'Lituania','LT',NULL,NULL,1,'.lt','lituano','lituana','EUR','República de Lituania','Lithuania','Republic of Lithuania'),(107,'Luxemburgo','LU',NULL,NULL,1,'.lu','luxemburgués','luxemburguesa','EUR','Gran Ducado de Luxemburgo','Luxembourg','Grand Duchy of Luxembourg'),(108,'Macedonia','MK',NULL,NULL,1,'.mk','macedonio','macedonia','MKD','República de Macedonia','Macedonia','Republic of Macedonia'),(109,'Madagascar','MG',NULL,NULL,1,'.mg','malgache','malgache','MGA','República de Madagascar','Madagascar','Republic of Madagascar'),(110,'Malasia','MY',NULL,NULL,1,'.my','malayo','malaya','MYR','','Malaysia',''),(111,'Malaui','MW',NULL,NULL,1,'.mw','malauí','malauí','MWK','República de Malaui','Malawi','Republic of Malawi'),(112,'Maldivas','MV',NULL,NULL,1,'.mv','maldivo','maldiva','MVR','República de Maldivas','Maldives','Republic of Maldives'),(113,'Malí','ML',NULL,NULL,1,'.ml','maliense, malí','maliense, malí','XOF','República de Malí','Mali','Republic of Mali'),(114,'Malta','MT',NULL,NULL,1,'.mt','maltés','maltesa','EUR','República de Malta','Malta','Republic of Malta'),(115,'Marruecos','MA',NULL,NULL,1,'.ma','marroquí','marroquí','MAD','Reino de Marruecos','Morocco','Kingdom of Morocco'),(116,'Mauricio','MU',NULL,NULL,1,'.mu','mauriciano','mauriciana','MUR','República de Mauricio','Mauritius','Republic of Mauritius'),(117,'Mauritania','MR',NULL,NULL,1,'.mr','mauritano','mauritana','MRO','República Islámica de Mauritania','Mauritania','Islamic Republic of Mauritania'),(118,'México','MX',NULL,NULL,1,'.mx','mexicano','mexicana','MXN','Estados Unidos Mexicanos','Mexico','United Mexican States'),(119,'Micronesia','FM',NULL,NULL,1,'.fm','micronesio','micronesia','USD','Estados Federados de Micronesia','Micronesia','Federated States of Micronesia'),(120,'Moldavia','MD',NULL,NULL,1,'.md','moldavo','moldava','MDL','República de Moldavia','Moldova','Republic of Moldova'),(121,'Mónaco','MC',NULL,NULL,1,'.mc','monegasco','monegasca','EUR','Principado de Mónaco','Monaco','Principality of Monaco'),(122,'Mongolia','MN',NULL,NULL,1,'.mn','mongol','mongola','MNT','','Mongolia',''),(123,'Montenegro','ME',NULL,NULL,1,'.me','montenegrino','montenegrina','EUR','','Montenegro',''),(124,'Mozambique','MZ',NULL,NULL,1,'.mz','mozambiqueño','mozambiqueña','MZM','República de Mozambique','Mozambique','Republic of Mozambique'),(125,'Namibia','NA',NULL,NULL,1,'.na','namibio','namibia','NAD','República de Namibia','Namibia','Republic of Namibia'),(126,'Nauru','NR',NULL,NULL,1,'.nr','nauruano','nauruana','AUD','República de Nauru','Nauru','Republic of Nauru'),(127,'Nepal','NP',NULL,NULL,1,'.np','nepalí, nepalés','nepalí, nepalesa','NPR','República Federal Democrática de Nepal','Nepal','Federal Democratic Republic of Nepal'),(128,'Nicaragua','NI',NULL,NULL,1,'.ni','nicaragüense','nicaragüense','NIO','República de Nicaragua','Nicaragua','Republic of Nicaragua'),(129,'Níger','NE',NULL,NULL,1,'.ne','nigerino','nigerina','XOF','República del Níger','Niger','Republic of Niger'),(130,'Nigeria','NG',NULL,NULL,1,'.ng','nigeriano','nigeriana','NGN','República Federal de Nigeria','Nigeria','Federal Republic of Nigeria'),(131,'Noruega','NO',NULL,NULL,1,'.no','noruego','noruega','NOK','Reino de Noruega','Norway','Kingdom of Norway'),(132,'Nueva Zelanda','NZ',NULL,NULL,1,'.nz','neozelandés','neozelandesa','NZD','','New Zealand',''),(133,'Omán','OM',NULL,NULL,1,'.om','omaní, omanés','omaní, omanesa','OMR','Sultanato de Omán','Oman','Sultanate of Oman'),(134,'Países Bajos','NL',NULL,NULL,1,'.nl','neerlandés','neerlandesa','EUR','Reino de los Países Bajos','Netherlands','Kingdom of the Netherlands'),(135,'Pakistán','PK',NULL,NULL,1,'.pk','pakistaní','pakistaní','PKR','República Islámica de Pakistán','Pakistan','Islamic Republic of Pakistan'),(136,'Palaos','PW',NULL,NULL,1,'.pw','palauano','palauana','USD','República de Palaos','Palau','Republic of Palau'),(137,'Palestina','PS',NULL,NULL,1,'.ps','palestino','palestina','JOD','Estado de Palestina','Palestine','State of Palestine'),(138,'Panamá','PA',NULL,NULL,1,'.pa','panameño','panameña','PAB','República de Panamá','Panama','Republic of Panama'),(139,'Papúa Nueva Guinea','PG',NULL,NULL,1,'.pg','papú, papú neoguineano, papuano','papú, papú neoguineana, papuana','PGK','Estado Independiente de Papúa Nueva Guinea','Papua New Guinea','Independent State of Papua New Guinea'),(140,'Paraguay','PY',NULL,NULL,1,'.py','paraguayo','paraguaya','PYG','República del Paraguay','Paraguay','Republic of Paraguay'),(141,'Perú','PE',NULL,NULL,1,'.pe','peruano','peruana','PEN','República del Perú','Peru','Republic of Peru'),(142,'Polonia','PL',NULL,NULL,1,'.pl','polaco, polonés, polandés','polaca, polonesa, polandesa','PLN','República de Polonia','Poland','Republic of Poland'),(143,'Portugal','PT',NULL,NULL,1,'.pt','portugués, luso','portuguesa, lusa','EUR','República Portuguesa','Portugal','Portuguese Republic'),(144,'Reino Unido','GB',NULL,NULL,1,'.uk','británico','británica','GBP','Reino Unido de Gran Bretaña e Irlanda del Norte','United Kingdom','United Kingdom of Great Britain and Northern Ireland'),(145,'República Centroafricana','CF',NULL,NULL,1,'.cf','centroafricano','centroafricana','XAF','','Central African Republic',''),(146,'República Checa','CZ',NULL,NULL,1,'.cz','checo','checa','CZK','','Czech Republic',''),(147,'República del Congo','CG',NULL,NULL,1,'.cg','congolés, congoleño','congolesa, congoleña','XAF','','Congo, Republic of the',''),(148,'República Democrática del Congo','CD',NULL,NULL,1,'.cd','congolés, congoleño','congolesa, congoleña','CDF','','Congo, Democratic Republic of the',''),(149,'República Dominicana','DO',NULL,NULL,1,'.do','dominicano','dominicana','DOP','','Dominican Republic',''),(150,'Ruanda','RW',NULL,NULL,1,'.rw','ruandés','ruandesa','RWF','República de Ruanda','Rwanda','Republic of Rwanda'),(151,'Rumania','RO',NULL,NULL,1,'.ro','rumano','rumana','RON','','Romania',''),(152,'Rusia','RU',NULL,NULL,1,'.ru','ruso','rusa','RUB','Federación Rusa','Russia','Russian Federation'),(153,'Samoa','WS',NULL,NULL,1,'.ws','samoano','samoana','WST','Estado Independiente de Samoa','Samoa','Independent State of Samoa'),(154,'San Cristóbal y Nieves','KN',NULL,NULL,1,'.kn','sancristobaleño','sancristobaleña','XCD','Federación de San Cristóbal y Nieves','Saint Kitts and Nevis','Federation of Saint Christopher and Nevis'),(155,'San Marino','SM',NULL,NULL,1,'.sm','sanmarinense','sanmarinense','EUR','Serenísima República de San Marino','San Marino','Republic of San Marino'),(156,'San Vicente y las Granadinas','VC',NULL,NULL,1,'.vc','sanvicentino','sanvicentina','XCD','','Saint Vincent and the Grenadines',''),(157,'Santa Lucía','LC',NULL,NULL,1,'.lc','santaluciano','santaluciano','XCD','','Saint Lucia',''),(158,'Santo Tomé y Príncipe','ST',NULL,NULL,1,'.st','santotomense','santotomense','STD','República Democrática de Santo Tomé y Príncipe','São Tomé and Príncipe','Democratic Republic of São Tomé and Príncipe'),(159,'Senegal','SN',NULL,NULL,1,'.sn','senegalés','senegalesa','XOF','República de Senegal','Senegal','Republic of Senegal'),(160,'Serbia','RS',NULL,NULL,1,'.rs','serbio','serbia','RSD','República de Serbia','Serbia','Republic of Serbia'),(161,'Seychelles','SC',NULL,NULL,1,'.sc','seychelense','seychelense','SCR','República de las Seychelles','Seychelles','Republic of Seychelles'),(162,'Sierra Leona','SL',NULL,NULL,1,'.sl','sierraleonés','sierraleonesa','SLL','República de Sierra Leona','Sierra Leone','Republic of Sierra Leone'),(163,'Singapur','SG',NULL,NULL,1,'.sg','singapurense','singapurense','SGD','República de Singapur','Singapore','Republic of Singapore'),(164,'Siria','SY',NULL,NULL,1,'.sy','sirio','siria','SYP','República Árabe Siria','Syria','Syrian Arab Republic'),(165,'Somalia','SO',NULL,NULL,1,'.so','somalí','somalí','SOS','República Federal de Somalia','Somalia','Federal Republic of Somalia'),(166,'Sri Lanka','LK',NULL,NULL,1,'.lk','srilanqués, esrilanqués, ceilanés, ceilandés','srilanquesa, esrilanquesa, ceilanesa, ceilandesa','LKR','República Democrática Socialista de Sri Lanka','Sri Lanka','Democratic Socialist Republic of Sri Lanka'),(167,'Suazilandia','SZ',NULL,NULL,1,'.sz','suazi','suazi','SZL','Reino de Suazilandia','Swaziland','Kingdom of Swaziland'),(168,'Sudáfrica','ZA',NULL,NULL,1,'.za','sudafricano','sudafricana','ZAR','República de Sudáfrica','South Africa','Republic of South Africa'),(169,'Sudán','SD',NULL,NULL,1,'.sd','sudanés','sudanesa','SDG','República del Sudán','Sudan','Republic of the Sudan'),(170,'Sudán del Sur','SS',NULL,NULL,1,'.ss','sursudanés, sudsudanés','sursudanesa, sudsudanesa','SSP','República de Sudán del Sur','South Sudan','Republic of South Sudan'),(171,'Suecia','SE',NULL,NULL,1,'.se','sueco','sueca','SEK','Reino de Suecia','Sweden','Kingdom of Sweden'),(172,'Suiza','CH',NULL,NULL,1,'.ch','suizo','suiza','CHF','Confederación Suiza','Switzerland','Swiss Confederation'),(173,'Surinam','SR',NULL,NULL,1,'.sr','surinamés','surinamesa','SRD','República de Surinam','Suriname','Republic of Suriname'),(174,'Tailandia','TH',NULL,NULL,1,'.th','tailandés','tailandesa','THB','Reino de Tailandia','Thailand','Kingdom of Thailand'),(175,'Tanzania','TZ',NULL,NULL,1,'.tz','tanzano','tanzana','TZS','República Unida de Tanzania','Tanzania','United Republic of Tanzania'),(176,'Tayikistán','TJ',NULL,NULL,1,'.tj','tayiko','tayika','TSO','República de Tayikistán','Tajikistan','Republic of Tajikistan'),(177,'Timor Oriental','TL',NULL,NULL,1,'.tl','timorense','timorense','USD','República Democrática de Timor Oriental','East Timor','Democratic Republic of Timor-Leste'),(178,'Togo','TG',NULL,NULL,1,'.tg','togolés','togolesa','XOF','República Togolesa','Togo','Togolese Republic'),(179,'Tonga','TO',NULL,NULL,1,'.to','tongano','tongana','TOP','Reino de Tonga','Tonga','Kingdom of Tonga'),(180,'Trinidad y Tobago','TT',NULL,NULL,1,'.tt','trinitense','trinitense','TTD','República de Trinidad y Tobago','Trinidad and Tobago','Republic of Trinidad and Tobago'),(181,'Túnez','TN',NULL,NULL,1,'.tn','tunecino','tunecina','TND','República Tunecina','Tunisia','Republic of Tunisia'),(182,'Turkmenistán','TM',NULL,NULL,1,'.tm','turkmeno, turcomano','turkmena, turcomana','TMM','','Turkmenistan',''),(183,'Turquía','TR',NULL,NULL,1,'.tr','turco','turca','TRY','República de Turquía','Turkey','Republic of Turkey'),(184,'Tuvalu','TV',NULL,NULL,1,'.tv','tuvaluano','tuvaluana','AUD','','Tuvalu',''),(185,'Ucrania','UA',NULL,NULL,1,'.ua','ucraniano','ucraniana','UAH','','Ukraine',''),(186,'Uganda','UG',NULL,NULL,1,'.ug','ugandés','ugandesa','UGX','República de Uganda','Uganda','Republic of Uganda'),(187,'Uruguay','UY',NULL,NULL,1,'.uy','uruguayo','uruguaya','UYU','República Oriental del Uruguay','Uruguay','Oriental Republic of Uruguay'),(188,'Uzbekistán','UZ',NULL,NULL,1,'.uz','uzbeko, uzbeco','uzbeka, uzbeca','UZS','República de Uzbekistán','Uzbekistan','Republic of Uzbekistan'),(189,'Vanuatu','VU',NULL,NULL,1,'.vu','vanuatuense','vanuatuense','VUV','República de Vanuatu','Vanuatu','Republic of Vanuatu'),(190,'Venezuela','VE',NULL,NULL,1,'.ve','venezolano','venezolana','VEF','República Bolivariana de Venezuela','Venezuela','Bolivarian Republic of Venezuela'),(191,'Vietnam','VN',NULL,NULL,1,'.vn','vietnamita','vietnamita','VND','República Socialista de Vietnam','Vietnam','Socialist Republic of Vietnam'),(192,'Yemen','YE',NULL,NULL,1,'.ye','yemení, yemenita','yemení, yemenita','YER','República de Yemen','Yemen','Republic of Yemen'),(193,'Yibuti','DJ',NULL,NULL,1,'.dj','yibutiano, yibutí, yibutense','yibutiana, yibutí, yibutense','DJF','República de Yibuti','Djibouti','Republic of Djibouti'),(194,'Zambia','ZM',NULL,NULL,1,'.zm','zambiano, zambio, zambés, zambero','zambiana, zambia, zambesa, zambera','ZMK','República de Zambia','Zambia','Republic of Zambia'),(195,'Zimbabue','KK',NULL,NULL,1,'.zw','zimbabuense','zimbabuense','USD','República de Zimbabue','Zimbabwe','Republic of Zimbabwe');
/*!40000 ALTER TABLE `Base_Pais` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-02 15:08:27
