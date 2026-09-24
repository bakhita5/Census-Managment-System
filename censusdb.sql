-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: censusdb
-- ------------------------------------------------------
-- Server version	8.0.44

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
-- Table structure for table `census_officer`
--

DROP TABLE IF EXISTS `census_officer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `census_officer` (
  `censusofficer_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `supervisor_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`censusofficer_id`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `national_id` (`national_id`),
  KEY `supervisor_id` (`supervisor_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `census_officer_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisor` (`supervisor_id`),
  CONSTRAINT `census_officer_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `census_officer`
--

LOCK TABLES `census_officer` WRITE;
/*!40000 ALTER TABLE `census_officer` DISABLE KEYS */;
INSERT INTO `census_officer` VALUES (1,'Maria','Wairimu','0711021011','mariawairimu@gmail.com','65748322',1,1),(21,'Aaron','Muli','0793325225','aaronm@gmail.com','14578231',1,32),(22,'Betty','Wanjiru','0784433228','bettyw@gmail.com','23459871',25,33),(23,'Caleb','Otieno','0718452396','calebo@gmail.com','35642198',25,34),(24,'Diana','Chebet','0702764531','dianac@gmail.com','41238976',26,35),(25,'Elvis','Kiptoo','0739981245','elvisk@gmail.com','19873456',26,36),(26,'Fiona','Achieng','0742218903','fionaa@gmail.com','26784531',27,37),(27,'George','Mwangi','0756634128','georgem@gmail.com','32417895',27,38),(28,'Hilda','Nyambura','0798842137','hildan@gmail.com','40125678',28,39),(29,'Isaac','Kamau','0725567814','isaack@gmail.com','17894523',28,40),(30,'Janet','Wekesa','0789123456','janetw@gmail.com','28973415',29,41),(31,'Kevin','Koskei','0708892345','kevink@gmail.com','34215678',29,42),(32,'Lucy','Moraa','0734456123','lucym@gmail.com','41257839',30,43),(33,'Mark','Owino','0749987123','marko@gmail.com','19845672',30,44),(34,'Nadia','Waithera','0753216789','nadiaw@gmail.com','25678934',31,45),(35,'Owen','Mutiso','0712349876','owenm@gmail.com','36789412',31,46),(36,'Paula','Njeri','0729983412','paulan@gmail.com','42315678',32,47),(37,'Quinn','Ndungu','0791123458','quinnn@gmail.com','13478952',32,48),(38,'Rose','Wambui','0732126784','rosew@gmail.com','24567831',33,49),(39,'Steve','Ouma','0786654321','steveo@gmail.com','38974512',33,50);
/*!40000 ALTER TABLE `census_officer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `censusdata`
--

DROP TABLE IF EXISTS `censusdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `censusdata` (
  `household_id` int NOT NULL AUTO_INCREMENT,
  `censusofficer_id` int DEFAULT NULL,
  `family_size` int NOT NULL,
  `access_to_electricity` varchar(20) NOT NULL,
  `access_to_water` varchar(20) NOT NULL,
  `assets` varchar(255) NOT NULL,
  `residential_status` varchar(50) NOT NULL,
  `age` int NOT NULL,
  `gender` varchar(20) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `education` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `employment_status` varchar(100) NOT NULL,
  `tribe` varchar(20) NOT NULL,
  PRIMARY KEY (`household_id`),
  KEY `censusofficer_id` (`censusofficer_id`),
  CONSTRAINT `censusdata_ibfk_1` FOREIGN KEY (`censusofficer_id`) REFERENCES `census_officer` (`censusofficer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `censusdata`
--

LOCK TABLES `censusdata` WRITE;
/*!40000 ALTER TABLE `censusdata` DISABLE KEYS */;
INSERT INTO `censusdata` VALUES (1,1,3,'yes','yes','laptop,tv,musical instruments','Owner',32,'Male','single','undergraduate','christian','Music teacher','employed','Kikuyu');
/*!40000 ALTER TABLE `censusdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissioner`
--

DROP TABLE IF EXISTS `commissioner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commissioner` (
  `commissioner_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `county_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`commissioner_id`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `national_id` (`national_id`),
  KEY `county_id` (`county_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissioner`
--

LOCK TABLES `commissioner` WRITE;
/*!40000 ALTER TABLE `commissioner` DISABLE KEYS */;
INSERT INTO `commissioner` VALUES (1,'Mark','Jones','0711111111','markjones@gmail.com','72222212',1,1);
/*!40000 ALTER TABLE `commissioner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `county`
--

DROP TABLE IF EXISTS `county`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `county` (
  `county_id` int NOT NULL,
  `county_name` varchar(50) NOT NULL,
  PRIMARY KEY (`county_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `county`
--

LOCK TABLES `county` WRITE;
/*!40000 ALTER TABLE `county` DISABLE KEYS */;
INSERT INTO `county` VALUES (1,'Kiambu');
/*!40000 ALTER TABLE `county` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deputy_commissioner`
--

DROP TABLE IF EXISTS `deputy_commissioner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deputy_commissioner` (
  `deputy_commissioner_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `subcounty_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`deputy_commissioner_id`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `national_id` (`national_id`),
  KEY `subcounty_id` (`subcounty_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `deputy_commissioner_ibfk_1` FOREIGN KEY (`subcounty_id`) REFERENCES `subcounty` (`subcounty_id`),
  CONSTRAINT `deputy_commissioner_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deputy_commissioner`
--

LOCK TABLES `deputy_commissioner` WRITE;
/*!40000 ALTER TABLE `deputy_commissioner` DISABLE KEYS */;
INSERT INTO `deputy_commissioner` VALUES (1,'Maryann ','Wamuyu','0711111111','maryannw@gmail.com','45637363',1,3),(2,'Becky','Wanjiru','0798989898','beckywanjiru@gmail.com','54545454',2,8),(3,'Aidan','Kinuthia','0721321890','aidank@gmail.com','45365312',3,9),(4,'Millicent','Omabre','0765432675','milliombare@gmail.com','32112333',4,10),(5,'Mike ','Kinyanjui','0717784532','mikek@gmail.com','12345687',5,11),(6,'Malaika','Mugo','727653321','malaikam@gmail.com','34554321',6,12),(7,'Azel','Jude','789000787','azelj@gmail.com','53422312',7,13),(8,'Sarah','Kwamboka','737765321','sarahk@gmail.com','23412342',8,14),(9,'Melissa','Komathai','756566574','melissak@gmail.com','43564321',9,15),(14,'Dylan','Kosgei','743526127','dylank@gmail.com','12343212',10,16);
/*!40000 ALTER TABLE `deputy_commissioner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `household`
--

DROP TABLE IF EXISTS `household`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `household` (
  `household_id` int NOT NULL AUTO_INCREMENT,
  `censusofficer_id` int DEFAULT NULL,
  `family_size` int NOT NULL,
  `access_to_electricity` varchar(20) NOT NULL,
  `access_to_water` varchar(20) NOT NULL,
  `assets` varchar(255) NOT NULL,
  `residential_status` varchar(50) NOT NULL,
  PRIMARY KEY (`household_id`),
  KEY `censusofficer_id` (`censusofficer_id`),
  CONSTRAINT `household_ibfk_1` FOREIGN KEY (`censusofficer_id`) REFERENCES `census_officer` (`censusofficer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `household`
--

LOCK TABLES `household` WRITE;
/*!40000 ALTER TABLE `household` DISABLE KEYS */;
INSERT INTO `household` VALUES (1,1,4,'Yes','Yes','none','Owned'),(2,1,2,'Yes','Yes','Land,businesses,technology','Owned'),(3,1,3,'Yes','Yes','Land','Owned'),(7,21,3,'NO','NO','None','Tenant'),(8,21,3,'NO',' YES','Businesses','Tenant'),(9,22,4,'YES',' YES','Buildings','Owner'),(10,22,4,'YES',' YES','none','Owner'),(11,23,5,'YES',' YES','Land','Owner'),(12,23,5,'YES',' YES','car','Owner'),(13,24,5,'YES',' YES','None','Government Housing'),(14,24,7,'YES',' YES','Land,Businesses','Owner'),(15,25,13,'Yes','Yes','Land','Owned'),(16,26,6,'YES',' YES','None','Tenant'),(17,26,10,'YES',' YES','none','Owner'),(18,28,20,'YES',' YES','Land,businesss','Living with Family'),(19,29,10,'YES',' YES','Land,Business','Owner'),(20,30,4,'YES',' YES','Technology','Living with Family'),(24,30,4,'YES',' YES','none','Government Housing'),(25,30,7,'YES',' YES','Livestock','Employer Provided'),(26,30,6,'YES',' YES','Tractors','Living with Friends'),(27,31,3,'YES',' YES','Cars','Tenant'),(28,31,5,'YES',' YES','solar panels,generator','Owner'),(29,31,3,'YES',' YES','Refrigerator','Employer Provided'),(30,31,8,'YES',' YES','cars,washing machine,gas cooker','Owner'),(31,32,4,'YES',' YES','Livestock,land,farm','Owner'),(32,32,5,'YES',' YES','Cows','Owner'),(33,32,5,'YES',' YES','Coffee farm','Owner'),(34,33,7,'YES',' YES','A mini shop','Tenant'),(35,33,8,'YES',' YES','Motorbike','Temporary Shelter'),(36,33,9,'YES',' YES','Milling machine','Tenant'),(37,34,5,'YES',' YES','None','Living with Friends'),(38,34,6,'YES',' YES','Cows.goat,chicken','Living with Family'),(39,34,10,'YES',' YES','Farm,Buildings,Land,Livestock','Owner'),(40,35,5,'YES','YES','Sofa, TV, Refrigerator','Owner'),(41,35,7,'NO','NO','Bicycle, Radio, Mattresses','Tenant'),(42,35,9,'YES','NO','TV, Radio, Sofa set, Generator','Employer Provided Housing'),(43,35,4,'NO','NO','Radio, Mattresses, Pots','Living with Friends'),(44,36,6,'YES','NO','TV, Sofa, Radio, Stove','Living with Family'),(45,36,5,'NO','YES','Bicycle, Radio, Mattresses','Tenant'),(46,36,8,'YES','YES','Television, Refrigerator, Washing Machine, Solar Panels','Owner'),(47,37,6,'YES','YES','TV, Refrigerator, Car, Washing Machine','Owner'),(48,37,4,'NO','YES','Sofa, Radio, Stove','Tenant'),(49,37,9,'YES','NO','Solar Panels, TV, Radio, Generator','Employer Provided Housing'),(50,38,5,'NO','YES','Livestock, Radio, Mobile Phone','Owner'),(51,38,7,'YES','NO','TV, Sofa, Radio, Generator','Tenant'),(52,38,6,'YES','YES','Sofa Set, TV, Refrigerator, Radio','Owner'),(53,38,8,'NO','YES','Radio, Mattresses, Solar Panel, Bicycle','Government Housing'),(54,39,6,'YES','YES','TV, Refrigerator, Washing Machine, Car','Owner'),(55,39,8,'NO','YES','Bicycle, Radio, Mattresses, Solar Panel','Tenant'),(56,39,5,'YES','NO','TV, Radio, Stove, Generator','Government Housing'),(57,39,9,'NO','YES','Solar Panel, Radio, Beds, Cooking Pots','Living with Family'),(58,39,6,'NO','NO','Radio, Cooking Pots, Mattresses, Water Containers','Temporary Shelter'),(59,39,7,'NO','YES','Radio, Livestock, Cooking Pot, Solar Lamp','Living with Family'),(60,39,8,'NO','NO','Radio, Water Containers, Beds, Livestock','Temporary Shelter');
/*!40000 ALTER TABLE `household` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person` (
  `person_id` int NOT NULL AUTO_INCREMENT,
  `household_id` int NOT NULL,
  `age` int NOT NULL,
  `gender` varchar(20) NOT NULL,
  `marital_status` varchar(20) NOT NULL,
  `education` varchar(100) NOT NULL,
  `religion` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `employment_status` varchar(100) NOT NULL,
  `tribe` varchar(20) NOT NULL,
  PRIMARY KEY (`person_id`),
  KEY `household_id` (`household_id`),
  CONSTRAINT `person_ibfk_1` FOREIGN KEY (`household_id`) REFERENCES `household` (`household_id`)
) ENGINE=InnoDB AUTO_INCREMENT=353 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (2,1,7,'Female','Single','Secondary','christian','N/A','Student','Kikuyu'),(3,7,11,'Male','single','Primary','Muslim','N/A','Student','Somali'),(4,7,27,'Female','married','Diploma','Muslim','Teacher','employed','Somali'),(5,7,30,'Male','married','Diploma','Muslim','business man','Self employed','Somali'),(6,8,9,'Female','single','Primary','Muslim','N/A','Student','Somali'),(7,8,21,'Female','married','Secondary','Muslim','N/A','not employed','Somali'),(8,8,30,'Male','married','undergraduate','Muslim','N/A','Self employed','Somali'),(9,1,10,'Female','single','Primary','christian','N/A','Student','Kikuyu'),(10,1,34,'Female','Single','undergraduate','christian','Flight Attendant','employed','Kikuyu'),(11,1,63,'Female','widowed','Secondary','christian','Retired','Retired','Kikuyu'),(12,2,25,'Female','married','undergraduate','other','Lawyer','employed','luhya'),(13,2,30,'Male','Single','Postgraduate','Atheist','Software Engineer','self employed','Luo'),(14,3,21,'Female','single','undergraduate','Hindu','Student','Student','Kenyan Asian'),(15,3,58,'Female','married','Diploma','Hindu','Tailor','Self employed','Kenyan Asian'),(16,3,60,'Male','married','undergraduate','Hindu','business man','Self employed','Kenyan Asian'),(17,9,13,'Female','single','Primary','christian','N/A','Student','Luo'),(18,9,17,'Female','Single','High School','Christian','N/A','Student','Luo'),(19,9,42,'Female','married','PhD','christian','doctor','employed','Luo'),(20,9,50,'Male','married','PhD','christian','doctor','employed','Luo'),(21,10,6,'Male','single','Primary','Muslim','N/A','Student','Swahili'),(22,10,8,'Female','single','Primary','Muslim','N/A','not employed','Swahili'),(23,10,32,'Female','sepatared','undergraduate','Muslim','Chef','employed','Swahili'),(24,10,34,'Male','sepatared','undergraduate','Muslim','Banker','employed','Swahili'),(25,11,3,'Male','single','Not educated','christian','N/A','not employed','Kikuyu'),(26,11,3,'Male','single','Not educated','christian','N/A','not employed','Kikuyu'),(27,11,3,'Male','single','Not educated','christian','N/A','not employed','Kikuyu'),(28,11,30,'Female','married','Master','christian','Teacher','employed','Kikuyu'),(29,11,35,'Male','married','PhD','christian','Lecturer','employed','Kikuyu'),(30,12,5,'Male','Single','Primary','christian','N/A','not employed','luhya'),(31,12,8,'Female','single','Primary','christian','N/A','not employed','luhya'),(32,12,52,'Male','Married','Diploma','Christian','Teacher','Employed','Luhya'),(33,12,48,'Female','Married','Certificate','Christian','Housewife','Not employed','Luhya'),(34,12,14,'Female','Single','Primary','Christian','Student','Student','Luhya'),(35,13,55,'Male','Married','Diploma','Christian','Farmer','Self employed','Luhya'),(36,13,50,'Female','Married','Primary','Christian','Housewife','Not employed','Luhya'),(37,13,28,'Male','Single','Bachelor\'s Degree','Christian','Accountant','Employed','Luhya'),(38,13,24,'Female','Single','Diploma','Christian','Teacher','Employed','Luhya'),(39,13,20,'Male','Single','Secondary','Christian','Student','Student','Luhya'),(40,14,68,'Male','Married','Certificate','Christian','Retired Teacher','Retired','Luhya'),(41,14,65,'Female','Married','Diploma','Christian','Retired Nurse','Retired','Luhya'),(42,14,42,'Male','Divorced','Bachelor\'s Degree','Christian','Businessman','Self employed','Luhya'),(43,14,38,'Female','Separated','Diploma','Christian','Accountant','Employed','Luhya'),(44,14,20,'Male','Single','Secondary','Christian','Student','Student','Luhya'),(45,14,16,'Female','Single','Secondary','Christian','Student','Student','Luhya'),(46,14,10,'Female','Single','Primary','Christian','Student','Student','Luhya'),(47,15,75,'Male','Married','Certificate','Christian','Retired Teacher','Retired','Luhya'),(48,15,72,'Female','Married','Diploma','Christian','Retired Nurse','Retired','Luhya'),(49,15,50,'Male','Married','Bachelor\'s Degree','Christian','Accountant','Employed','Luhya'),(50,15,47,'Female','Married','Diploma','Christian','Housewife','Not employed','Luhya'),(51,15,45,'Male','Divorced','Master\'s Degree','Christian','Engineer','Employed','Luhya'),(52,15,40,'Female','Separated','Bachelor\'s Degree','Christian','Nurse','Employed','Luhya'),(53,15,35,'Male','Single','Bachelor\'s Degree','Christian','Businessman','Self employed','Luhya'),(54,15,24,'Female','Single','Bachelor\'s Degree','Christian','Intern','Employed','Luhya'),(55,15,22,'Male','Single','Diploma','Christian','Student','Student','Luhya'),(56,15,20,'Female','Single','Secondary','Christian','Student','Student','Luhya'),(57,15,17,'Male','Single','Secondary','Christian','Student','Student','Luhya'),(58,15,15,'Female','Single','Secondary','Christian','Student','Student','Luhya'),(59,15,8,'Male','Single','Primary','Christian','Student','Student','Luhya'),(60,16,48,'Male','Married','undergraduate','Christian','Civil Servant','Employed','Kikuyu'),(61,16,44,'Female','Married','Diploma','Christian','Teacher','Employed','Kikuyu'),(62,16,69,'Female','Widowed','Primary','Christian','Farmer','Retired','Kikuyu'),(63,16,19,'Male','single','Secondary','Christian','Student','Student','Kikuyu'),(64,16,16,'Female','single','Secondary','Christian','Student','Student','Kikuyu'),(65,16,9,'Male','single','Primary','Christian','Student','Student','Kikuyu'),(66,17,73,'Male','Married','Primary','Christian','Farmer','Retired','Kalenjin'),(67,17,68,'Female','Married','Primary','Christian','Housewife','Retired','Kalenjin'),(68,17,46,'Male','Married','Diploma','Christian','Electrician','Self employed','Kalenjin'),(69,17,42,'Female','Married','undergraduate','Christian','Teacher','Employed','Kalenjin'),(70,17,38,'Male','single','Certificate','Christian','Mechanic','Self employed','Kalenjin'),(71,17,35,'Female','Divorced','Diploma','Christian','Nurse','Employed','Kalenjin'),(72,17,18,'Female','single','Secondary','Christian','Student','Student','Kalenjin'),(73,17,15,'Male','single','Secondary','Christian','Student','Student','Kalenjin'),(74,17,11,'Female','single','Primary','Christian','Student','Student','Kalenjin'),(75,17,6,'Male','single','Primary','Christian','Student','Student','Kalenjin'),(76,18,82,'Male','Married','Primary','Christian','Farmer','Retired','Luo'),(77,18,78,'Female','Married','Primary','Christian','Housewife','Retired','Luo'),(78,18,56,'Male','Married','undergraduate','Christian','Teacher','Employed','Luo'),(79,18,52,'Female','Married','Diploma','Christian','Businesswoman','Self employed','Luo'),(80,18,50,'Male','Married','Certificate','Christian','Electrician','Self employed','Luo'),(81,18,46,'Female','Married','Diploma','Christian','Nurse','Employed','Luo'),(82,18,42,'Male','Divorced','undergraduate','Christian','Accountant','Employed','Luo'),(83,18,39,'Female','Widowed','Secondary','Christian','Tailor','Self employed','Luo'),(84,18,35,'Male','single','Master','Christian','Software Developer','Employed','Luo'),(85,18,33,'Female','single','undergraduate','Christian','Teacher','Employed','Luo'),(86,18,28,'Male','Married','Diploma','Christian','Driver','Employed','Luo'),(87,18,26,'Female','Married','Certificate','Christian','Hairdresser','Self employed','Luo'),(88,18,23,'Male','single','undergraduate','Christian','Intern','Employed','Luo'),(89,18,21,'Female','single','Diploma','Christian','Student','Student','Luo'),(90,18,18,'Male','single','Secondary','Christian','Student','Student','Luo'),(91,18,16,'Female','single','Secondary','Christian','Student','Student','Luo'),(92,18,14,'Male','single','Secondary','Christian','Student','Student','Luo'),(93,18,10,'Female','single','Primary','Christian','Student','Student','Luo'),(94,18,7,'Male','single','Primary','Christian','Student','Student','Luo'),(95,18,4,'Female','single','Not educated','Christian','Child','Not employed','Luo'),(96,19,71,'Male','Married','Primary','Christian','Farmer','Retired','Kamba'),(97,19,67,'Female','Married','Primary','Christian','Housewife','Retired','Kamba'),(98,19,45,'Male','Married','Diploma','Christian','Police Officer','Employed','Kamba'),(99,19,41,'Female','Married','undergraduate','Christian','Lecturer','Employed','Kamba'),(100,19,23,'Male','single','undergraduate','Christian','Graphic Designer','Self employed','Kamba'),(101,19,20,'Female','single','Diploma','Christian','Student','Student','Kamba'),(102,19,17,'Male','single','Secondary','Christian','Student','Student','Kamba'),(103,19,15,'Female','single','Secondary','Christian','Student','Student','Kamba'),(104,19,11,'Male','single','Primary','Christian','Student','Student','Kamba'),(105,19,5,'Female','single','Not educated','Christian','Child','Not employed','Kamba'),(106,20,45,'Male','Married','Diploma','Christian','Teacher','Employed','Kikuyu'),(107,20,40,'Female','Married','Certificate','Christian','Nurse','Employed','Kikuyu'),(108,20,10,'Male','Single','Primary','Christian','Student','Student','Kikuyu'),(109,20,8,'Female','Single','Primary','Christian','Student','Student','Kikuyu'),(110,20,6,'Male','Single','Primary','Christian','Student','Student','Kikuyu'),(111,24,68,'Female','Widowed','Primary','Christian','Retired','Retired','Kamba'),(112,24,45,'Male','Divorced','Diploma','Christian','Mechanic','Self employed','Kamba'),(113,24,18,'Female','Single','Secondary','Christian','Student','Student','Kamba'),(114,24,15,'Male','Single','Secondary','Christian','Student','Student','Kamba'),(115,25,38,'Male','Married','Bachelor','Muslim','Engineer','Employed','Somali'),(116,25,35,'Female','Married','Diploma','Muslim','Teacher','Employed','Somali'),(117,25,12,'Female','Single','Primary','Muslim','Student','Student','Somali'),(118,25,9,'Male','Single','Primary','Muslim','Student','Student','Somali'),(119,25,7,'Female','Single','Primary','Muslim','Student','Student','Somali'),(120,25,5,'Male','Single','Primary','Muslim','Student','Student','Somali'),(121,25,3,'Female','Single','Primary','Muslim','Student','Student','Somali'),(122,26,28,'Male','Single','Bachelor','Christian','Software Developer','Employed','Kikuyu'),(123,26,26,'Female','Single','Diploma','Muslim','Nurse','Employed','Swahili'),(124,26,30,'Male','Divorced','Secondary','Hindu','Electrician','Self employed','Gujarati'),(125,26,22,'Female','Single','Bachelor','Atheist','Student','Student','Luo'),(126,26,25,'Male','Single','Certificate','Christian','Driver','Employed','Kamba'),(127,26,24,'Female','Separated','Secondary','Muslim','Unemployed','Not employed','Somali'),(128,27,34,'Male','Married','Bachelor','Christian','Accountant','Employed','Luhya'),(129,27,32,'Female','Married','Diploma','Christian','Secretary','Employed','Luhya'),(130,27,6,'Male','Single','Primary','Christian','Student','Student','Luhya'),(131,28,40,'Male','Married','Bachelor','Christian','Civil Engineer','Employed','Kalenjin'),(132,28,38,'Female','Married','Diploma','Christian','Nurse','Employed','Kalenjin'),(133,28,15,'Male','Single','Secondary','Christian','Student','Student','Kalenjin'),(134,28,12,'Female','Single','Primary','Christian','Student','Student','Kalenjin'),(135,28,8,'Male','Single','Primary','Christian','Student','Student','Kalenjin'),(136,29,36,'Male','Married','Bachelor','Christian','Banker','Employed','Kisii'),(137,29,34,'Female','Married','Certificate','Christian','Sales Representative','Employed','Kisii'),(138,29,10,'Female','Single','Primary','Christian','Student','Student','Kisii'),(139,30,48,'Male','Married','Bachelor','Christian','Lecturer','Employed','Meru'),(140,30,45,'Female','Married','Diploma','Christian','Administrator','Employed','Meru'),(141,30,21,'Male','Single','Bachelor','Christian','Student','Student','Meru'),(142,30,18,'Female','Single','Certificate','Christian','Student','Student','Meru'),(143,30,15,'Male','Single','Secondary','Christian','Student','Student','Meru'),(144,30,12,'Female','Single','Primary','Christian','Student','Student','Meru'),(145,30,9,'Male','Single','Primary','Christian','Student','Student','Meru'),(146,30,4,'Female','Single','Not educated','Christian','Student','Student','Meru'),(147,31,42,'Male','Married','Diploma','Christian','Farmer','Employed','Kikuyu'),(148,31,40,'Female','Married','Certificate','Christian','Teacher','Employed','Kikuyu'),(149,31,14,'Male','Single','Secondary','Christian','Student','Student','Kikuyu'),(150,31,10,'Female','Single','Primary','Christian','Student','Student','Kikuyu'),(151,32,44,'Male','Married','Bachelor','Christian','Civil Servant','Employed','Luo'),(152,32,42,'Female','Married','Diploma','Christian','Social Worker','Employed','Luo'),(153,32,17,'Male','Single','Secondary','Christian','Student','Student','Luo'),(154,32,14,'Female','Single','Secondary','Christian','Student','Student','Luo'),(155,32,10,'Male','Single','Primary','Christian','Student','Student','Luo'),(156,32,44,'Male','Married','Bachelor','Christian','Civil Servant','Employed','Luo'),(157,32,42,'Female','Married','Diploma','Christian','Social Worker','Employed','Luo'),(158,32,17,'Male','Single','Secondary','Christian','Student','Student','Luo'),(159,32,14,'Female','Single','Secondary','Christian','Student','Student','Luo'),(160,32,10,'Male','Single','Primary','Christian','Student','Student','Luo'),(161,33,46,'Male','Married','Bachelor','Muslim','Pharmacist','Employed','Somali'),(162,33,43,'Female','Married','Diploma','Muslim','Teacher','Employed','Somali'),(163,33,19,'Male','Single','Certificate','Muslim','Student','Student','Somali'),(164,33,15,'Female','Single','Secondary','Muslim','Student','Student','Somali'),(165,33,11,'Male','Single','Primary','Muslim','Student','Student','Somali'),(166,34,50,'Male','Married','Bachelor','Christian','Manager','Employed','Kamba'),(167,34,47,'Female','Married','Diploma','Christian','Secretary','Employed','Kamba'),(168,34,22,'Male','Single','Bachelor','Christian','Student','Student','Kamba'),(169,34,19,'Female','Single','Certificate','Christian','Student','Student','Kamba'),(170,34,16,'Male','Single','Secondary','Christian','Student','Student','Kamba'),(171,34,12,'Female','Single','Primary','Christian','Student','Student','Kamba'),(172,34,8,'Male','Single','Primary','Christian','Student','Student','Kamba'),(173,35,52,'Male','Married','Bachelor','Muslim','Businessman','Employed','Swahili'),(174,35,49,'Female','Married','Diploma','Muslim','Teacher','Employed','Swahili'),(175,35,24,'Male','Single','Bachelor','Muslim','Student','Student','Swahili'),(176,35,21,'Female','Single','Certificate','Muslim','Student','Student','Swahili'),(177,35,17,'Male','Single','Secondary','Muslim','Student','Student','Swahili'),(178,35,14,'Female','Single','Secondary','Muslim','Student','Student','Swahili'),(179,35,10,'Male','Single','Primary','Muslim','Student','Student','Swahili'),(180,35,7,'Female','Single','Primary','Muslim','Student','Student','Swahili'),(181,36,72,'Male','Widowed','Primary','Christian','Retired Farmer','Retired','Kikuyu'),(182,36,68,'Female','Widowed','Not educated','Christian','Retired','Retired','Kikuyu'),(183,36,45,'Male','Married','Bachelor','Christian','Civil Servant','Employed','Kikuyu'),(184,36,43,'Female','Married','Diploma','Christian','Hair Stylist','Self employed','Kikuyu'),(185,36,19,'Male','Single','Certificate','Christian','Student','Student','Kikuyu'),(186,36,16,'Female','Single','Secondary','Christian','Student','Student','Kikuyu'),(187,36,13,'Male','Single','Secondary','Christian','Student','Student','Kikuyu'),(188,36,10,'Female','Single','Primary','Christian','Student','Student','Kikuyu'),(189,36,4,'Male','Single','Not educated','Christian','Child','Not employed','Kikuyu'),(195,37,46,'Male','Married','Diploma','Muslim','Driver','Employed','Borana'),(196,37,43,'Female','Married','Certificate','Muslim','Food Vendor','Self employed','Borana'),(197,37,18,'Male','Single','Certificate','Muslim','Student','Student','Borana'),(198,37,14,'Female','Single','Secondary','Muslim','Student','Student','Borana'),(199,37,10,'Male','Single','Primary','Muslim','Student','Student','Borana'),(200,38,44,'Male','Married','Secondary','Christian','Livestock Trader','Employed','Maasai'),(201,38,41,'Female','Married','Primary','Christian','Beadwork Seller','Self employed','Maasai'),(202,38,17,'Male','Single','Secondary','Christian','Student','Student','Maasai'),(203,38,13,'Female','Single','Secondary','Christian','Student','Student','Maasai'),(204,38,8,'Male','Single','Primary','Christian','Student','Student','Maasai'),(205,39,48,'Male','Married','Bachelor','Christian','Teacher','Employed','Taita'),(206,39,46,'Female','Married','Diploma','Christian','Caterer','Self employed','Taita'),(207,39,21,'Male','Single','Bachelor','Christian','Student','Student','Taita'),(208,39,19,'Female','Single','Certificate','Christian','Student','Student','Taita'),(209,39,16,'Male','Single','Secondary','Christian','Student','Student','Taita'),(210,39,14,'Female','Single','Secondary','Christian','Student','Student','Taita'),(211,39,11,'Male','Single','Primary','Christian','Student','Student','Taita'),(212,39,8,'Female','Single','Primary','Christian','Student','Student','Taita'),(213,39,5,'Male','Single','Primary','Christian','Student','Student','Taita'),(214,39,2,'Female','Single','Not educated','Christian','Child','Not employed','Taita'),(215,40,45,'Male','Married','Diploma','Christian','Teacher','Employed','Kikuyu'),(216,40,40,'Female','Married','Certificate','Christian','Nurse','Employed','Kikuyu'),(217,40,10,'Male','Single','Primary','Christian','Student','Student','Kikuyu'),(218,40,8,'Female','Single','Primary','Christian','Student','Student','Kikuyu'),(219,40,6,'Male','Single','Primary','Christian','Student','Student','Kikuyu'),(220,41,48,'Male','Married','Bachelor','Christian','Mechanic','Employed','Kamba'),(221,41,44,'Female','Married','Diploma','Christian','Teacher','Employed','Kamba'),(222,41,22,'Male','Single','Bachelor','Christian','Student','Student','Kamba'),(223,41,19,'Female','Single','Certificate','Christian','Student','Student','Kamba'),(224,41,16,'Male','Single','Secondary','Christian','Student','Student','Kamba'),(225,41,12,'Female','Single','Primary','Christian','Student','Student','Kamba'),(226,41,8,'Male','Single','Primary','Christian','Student','Student','Kamba'),(227,42,70,'Male','Widowed','Primary','Christian','Retired Farmer','Retired','Luo'),(228,42,68,'Female','Widowed','Not educated','Christian','Retired','Retired','Luo'),(229,42,46,'Male','Married','Bachelor','Christian','Civil Servant','Employed','Luo'),(230,42,44,'Female','Married','Diploma','Christian','Hair Stylist','Self employed','Luo'),(231,42,22,'Male','Single','Bachelor','Christian','Student','Student','Luo'),(232,42,19,'Female','Single','Certificate','Christian','Student','Student','Luo'),(233,42,16,'Male','Single','Secondary','Christian','Student','Student','Luo'),(234,42,12,'Female','Single','Primary','Christian','Student','Student','Luo'),(235,42,8,'Male','Single','Primary','Christian','Student','Student','Luo'),(236,43,38,'Male','Married','Certificate','Christian','Driver','Employed','Kisii'),(237,43,35,'Female','Married','Secondary','Christian','Housewife','Not employed','Kisii'),(238,43,12,'Male','Single','Primary','Christian','Student','Student','Kisii'),(239,43,8,'Female','Single','Primary','Christian','Student','Student','Kisii'),(240,44,42,'Male','Married','Diploma','Muslim','Businessman','Self employed','Somali'),(241,44,40,'Female','Married','Certificate','Muslim','Tailor','Self employed','Somali'),(242,44,20,'Male','Single','Bachelor','Muslim','Student','Student','Somali'),(243,44,17,'Female','Single','Certificate','Muslim','Student','Student','Somali'),(244,44,14,'Male','Single','Secondary','Muslim','Student','Student','Somali'),(245,44,10,'Female','Single','Primary','Muslim','Student','Student','Somali'),(246,45,44,'Male','Married','Secondary','Muslim','Driver','Employed','Swahili'),(247,45,41,'Female','Married','Certificate','Muslim','Shop Attendant','Employed','Swahili'),(248,45,17,'Male','Single','Secondary','Muslim','Student','Student','Swahili'),(249,45,13,'Female','Single','Primary','Muslim','Student','Student','Swahili'),(250,45,8,'Male','Single','Primary','Muslim','Student','Student','Swahili'),(251,46,75,'Male','Widowed','Primary','Christian','Retired Carpenter','Retired','Kamba'),(252,46,72,'Female','Widowed','Not educated','Christian','Retired','Retired','Kamba'),(253,46,48,'Male','Married','Bachelor','Christian','Bank Manager','Employed','Kamba'),(254,46,45,'Female','Married','Diploma','Christian','Caterer','Self employed','Kamba'),(255,46,23,'Male','Single','Bachelor','Christian','Student','Student','Kamba'),(256,46,20,'Female','Single','Certificate','Christian','Student','Student','Kamba'),(257,46,16,'Male','Single','Secondary','Christian','Student','Student','Kamba'),(258,46,11,'Female','Single','Primary','Christian','Student','Student','Kamba'),(259,47,50,'Male','Married','Bachelor','Hindu','Business Owner','Self employed','Gujarati'),(260,47,47,'Female','Married','Diploma','Hindu','Accountant','Employed','Gujarati'),(261,47,22,'Male','Single','Bachelor','Hindu','Student','Student','Gujarati'),(262,47,19,'Female','Single','Certificate','Hindu','Student','Student','Gujarati'),(263,47,16,'Male','Single','Secondary','Hindu','Student','Student','Gujarati'),(264,47,11,'Female','Single','Primary','Hindu','Student','Student','Gujarati'),(265,48,35,'Male','Married','Diploma','Hindu','Electrician','Self employed','Gujarati'),(266,48,33,'Female','Married','Certificate','Hindu','Housewife','Not employed','Gujarati'),(267,48,10,'Male','Single','Primary','Hindu','Student','Student','Gujarati'),(268,48,7,'Female','Single','Primary','Hindu','Student','Student','Gujarati'),(269,49,74,'Male','Widowed','Primary','Atheist','Retired Teacher','Retired','Luo'),(270,49,70,'Female','Widowed','Not educated','Atheist','Retired','Retired','Luo'),(271,49,48,'Male','Married','Bachelor','Atheist','Engineer','Employed','Luo'),(272,49,45,'Female','Married','Diploma','Atheist','Freelance Writer','Self employed','Luo'),(273,49,22,'Male','Single','Bachelor','Atheist','Student','Student','Luo'),(274,49,19,'Female','Single','Certificate','Atheist','Student','Student','Luo'),(275,49,16,'Male','Single','Secondary','Atheist','Student','Student','Luo'),(276,49,12,'Female','Single','Primary','Atheist','Student','Student','Luo'),(277,49,7,'Male','Single','Primary','Atheist','Student','Student','Luo'),(278,50,42,'Male','Married','Secondary','Other','Livestock Trader','Employed','Maasai'),(279,50,39,'Female','Married','Primary','Other','Beadwork Seller','Self employed','Maasai'),(280,50,16,'Male','Single','Secondary','Other','Student','Student','Maasai'),(281,50,13,'Female','Single','Secondary','Other','Student','Student','Maasai'),(282,50,9,'Male','Single','Primary','Other','Student','Student','Maasai'),(283,51,68,'Female','Widowed','Primary','Other','Retired','Retired','Kikuyu'),(284,51,44,'Male','Married','Diploma','Other','Mechanic','Employed','Kikuyu'),(285,51,41,'Female','Married','Certificate','Other','Tailor','Self employed','Kikuyu'),(286,51,20,'Male','Single','Bachelor','Other','Student','Student','Kikuyu'),(287,51,18,'Female','Single','Certificate','Other','Student','Student','Kikuyu'),(288,51,15,'Male','Single','Secondary','Other','Student','Student','Kikuyu'),(289,51,10,'Female','Single','Primary','Other','Student','Student','Kikuyu'),(290,52,46,'Male','Married','Diploma','Other','Teacher','Employed','Luhya'),(291,52,43,'Female','Married','Certificate','Other','Caterer','Self employed','Luhya'),(292,52,21,'Male','Single','Bachelor','Other','Student','Student','Luhya'),(293,52,18,'Female','Single','Certificate','Other','Student','Student','Luhya'),(294,52,15,'Male','Single','Secondary','Other','Student','Student','Luhya'),(295,52,10,'Female','Single','Primary','Other','Student','Student','Luhya'),(296,53,72,'Male','Widowed','Primary','Other','Retired Farmer','Retired','Kalenjin'),(297,53,69,'Female','Widowed','Not educated','Other','Retired','Retired','Kalenjin'),(298,53,44,'Male','Married','Certificate','Other','Carpenter','Self employed','Kalenjin'),(299,53,42,'Female','Married','Diploma','Other','Nurse','Employed','Kalenjin'),(300,53,22,'Male','Single','Bachelor','Other','Student','Student','Kalenjin'),(301,53,19,'Female','Single','Certificate','Other','Student','Student','Kalenjin'),(302,53,16,'Male','Single','Secondary','Other','Student','Student','Kalenjin'),(303,53,12,'Female','Single','Primary','Other','Student','Student','Kalenjin'),(304,54,48,'Male','Married','Bachelor','Muslim','Businessman','Employed','Somali'),(305,54,45,'Female','Married','Diploma','Muslim','Tailor','Self employed','Somali'),(306,54,22,'Male','Single','Bachelor','Muslim','Student','Student','Somali'),(307,54,19,'Female','Single','Certificate','Muslim','Student','Student','Somali'),(308,54,16,'Male','Single','Secondary','Muslim','Student','Student','Somali'),(309,54,11,'Female','Single','Primary','Muslim','Student','Student','Somali'),(310,55,70,'Female','Widowed','Not educated','Muslim','Retired','Retired','Swahili'),(311,55,46,'Male','Married','Certificate','Muslim','Fisherman','Self employed','Swahili'),(312,55,44,'Female','Married','Secondary','Muslim','Shop Attendant','Employed','Swahili'),(313,55,23,'Male','Single','Bachelor','Muslim','Student','Student','Swahili'),(314,55,20,'Female','Single','Certificate','Muslim','Student','Student','Swahili'),(315,55,17,'Male','Single','Secondary','Muslim','Student','Student','Swahili'),(316,55,13,'Female','Single','Primary','Muslim','Student','Student','Swahili'),(317,55,8,'Male','Single','Primary','Muslim','Student','Student','Swahili'),(318,56,40,'Male','Married','Diploma','Muslim','Driver','Employed','Borana'),(319,56,38,'Female','Married','Certificate','Muslim','Food Vendor','Self employed','Borana'),(320,56,20,'Male','Single','Bachelor','Muslim','Student','Student','Borana'),(321,56,16,'Female','Single','Secondary','Muslim','Student','Student','Borana'),(322,56,11,'Male','Single','Primary','Muslim','Student','Student','Borana'),(323,57,75,'Male','Widowed','Primary','Muslim','Retired Herder','Retired','Oromo'),(324,57,72,'Female','Widowed','Not educated','Muslim','Retired','Retired','Oromo'),(325,57,48,'Male','Married','Certificate','Muslim','Livestock Trader','Self employed','Oromo'),(326,57,45,'Female','Married','Secondary','Muslim','Housewife','Not employed','Oromo'),(327,57,24,'Male','Single','Bachelor','Muslim','Student','Student','Oromo'),(328,57,21,'Female','Single','Certificate','Muslim','Student','Student','Oromo'),(329,57,18,'Male','Single','Secondary','Muslim','Student','Student','Oromo'),(330,57,14,'Female','Single','Primary','Muslim','Student','Student','Oromo'),(331,57,9,'Male','Single','Primary','Muslim','Student','Student','Oromo'),(332,58,42,'Male','Married','Certificate','Muslim','Herder','Self employed','Rendille'),(333,58,39,'Female','Married','Primary','Muslim','Housewife','Not employed','Rendille'),(334,58,17,'Male','Single','Secondary','Muslim','Student','Student','Rendille'),(335,58,14,'Female','Single','Secondary','Muslim','Student','Student','Rendille'),(336,58,10,'Male','Single','Primary','Muslim','Student','Student','Rendille'),(337,58,7,'Female','Single','Primary','Muslim','Student','Student','Rendille'),(338,59,45,'Male','Married','Certificate','Muslim','Livestock Trader','Self employed','Turkana'),(339,59,42,'Female','Married','Secondary','Muslim','Shop Attendant','Employed','Turkana'),(340,59,21,'Male','Single','Bachelor','Muslim','Student','Student','Turkana'),(341,59,18,'Female','Single','Certificate','Muslim','Student','Student','Turkana'),(342,59,15,'Male','Single','Secondary','Muslim','Student','Student','Turkana'),(343,59,11,'Female','Single','Primary','Muslim','Student','Student','Turkana'),(344,59,7,'Male','Single','Primary','Muslim','Student','Student','Turkana'),(345,60,72,'Male','Widowed','Primary','Muslim','Retired Herder','Retired','Gabra'),(346,60,68,'Female','Widowed','Not educated','Muslim','Retired','Retired','Gabra'),(347,60,46,'Male','Married','Certificate','Muslim','Livestock Trader','Self employed','Gabra'),(348,60,43,'Female','Married','Primary','Muslim','Housewife','Not employed','Gabra'),(349,60,22,'Male','Single','Bachelor','Muslim','Student','Student','Gabra'),(350,60,19,'Female','Single','Certificate','Muslim','Student','Student','Gabra'),(351,60,16,'Male','Single','Secondary','Muslim','Student','Student','Gabra'),(352,60,11,'Female','Single','Primary','Muslim','Student','Student','Gabra');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcounty`
--

DROP TABLE IF EXISTS `subcounty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcounty` (
  `subcounty_id` int NOT NULL AUTO_INCREMENT,
  `subcounty_name` varchar(50) NOT NULL,
  `county_id` int DEFAULT NULL,
  PRIMARY KEY (`subcounty_id`),
  KEY `county_id` (`county_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcounty`
--

LOCK TABLES `subcounty` WRITE;
/*!40000 ALTER TABLE `subcounty` DISABLE KEYS */;
INSERT INTO `subcounty` VALUES (1,'Gatundu North',1),(2,'Gatundu South',1),(3,'Juja',1),(4,'Limuru',1),(5,'Kiambaa',1),(6,'Ruiru',1),(7,'Githunguri',1),(8,'Kabete',1),(9,'Kikuyu',1),(10,'Lari',1);
/*!40000 ALTER TABLE `subcounty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supervisor`
--

DROP TABLE IF EXISTS `supervisor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supervisor` (
  `supervisor_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `national_id` varchar(20) NOT NULL,
  `ward_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`supervisor_id`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `national_id` (`national_id`),
  KEY `ward_id` (`ward_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `supervisor_ibfk_1` FOREIGN KEY (`ward_id`) REFERENCES `ward` (`ward_id`),
  CONSTRAINT `supervisor_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supervisor`
--

LOCK TABLES `supervisor` WRITE;
/*!40000 ALTER TABLE `supervisor` DISABLE KEYS */;
INSERT INTO `supervisor` VALUES (1,'Luke','Kimathi','0798754763','lukekimathi@gmail.com','64534532',1,4),(25,'Gabby','Gathore','0712345678','gabby@gmail.com','10000001',2,20),(26,'Brian','Ochieng','0723456789','brianm@gmail.com','10000002',3,21),(27,'Clara','Muruhi','0734567890','claraw@gmail.com','10000003',4,22),(28,'Dennis','Abeso','0745678901','denniso@gmail.com','10000004',5,23),(29,'Esther','Muthoni','0756789012','esthern@gmail.com','10000005',6,24),(30,'Faith','Njeri','0767890123','faithnjeri@gmail.com','10000006',7,25),(31,'George','Mwangi','0778901234','georgemwangi@gmail.com','10000007',8,26),(32,'Hannah','Wanjiku','0789012345','hannahwanjiku@gmail.com','10000008',9,27),(33,'Ian','Kiptoo','0790123456','iankiptoo@gmail.com','10000009',10,28);
/*!40000 ALTER TABLE `supervisor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Maria Wairimu','MariaW','MariaW','mariawairimu@gmail.com','Census officer'),(2,'Mark Jones','MarkJ','jones123','markjones@gmail.com','Commissioner'),(3,'MaryAnn Wamuyu','maryann','maryannwamuyu','maryannW@gmail.com','Deputy commissioner'),(4,'Luke Kimathi','LukeK','123Luke','lukekimathi@gmail.com','Supervisor'),(8,'Becky Wanjiru','Becky','Becky123','beckywanjiru@gmail.com','Deputy commissioner'),(9,'Aidan Kinuthia','aidank','aidank','aidank@gmail.com','Deputy commissioner'),(10,'Millicient Ombare','MilliO','Millio','milliombare@gmail.com','Deputy commissioner'),(11,'Mike Kinyanjui','MikeK','Mikek','mikek@gmail.com','Deputy commissioner'),(12,'Malaika Mugo','malaika','malaika','malaikamugo@gmail.com','Deputy commissioner'),(13,'azel Jude','Azelj','azelj','azel Jude','Deputy commissioner'),(14,'sarah kwamboka','sarahk','sarahk','Sarahakwamboka@gmail.com','Deputy commissioner'),(15,'Melissa Komothai','melissa','melissa','melissakomothai@gmail.com','Deputy commissioner'),(16,'Dylan Kosgei','dylank','dylan','dylank@gmail.com','Deputy Commissioner'),(17,'Kirstyn Wakarima','kirstyn','kirstyn','KirstynK@gmail.com','Deputy Commissioner'),(18,'Jeremy Hinga','jeremy','jeremy','jeremyh@gmail.com','Deputy Commissioner'),(19,'Whitney Maria','whitney','whitney','whitneymaria@gmail.com','Deputy Commissioner'),(20,'Gabby Gathore','Gabby','Gabby','gabby@gmail.com','Supervisor'),(21,'Brian Ochieng','Brian','Brian','brianm@gmail.com','Supervisor'),(22,'Clara Muruhi','Clara','Clara','claraw@gmail.com','Supervisor'),(23,'Dennis Abeso','Dennis','Dennis','denniso@gmail.com','Supervisor'),(24,'Esther Muthoni','Esther','Esther','esthern@gmail.com','Supervisor'),(25,'Faith Njeri','Faith','Faith','faithnjeri@gmail.com','Supervisor'),(26,'George Mwangi','George','George','georgemwangi@gmail.com','Supervisor'),(27,'Hannah Wanjiku','Hannah','Hannah','hannahwanjiku@gmail.com','Supervisor'),(28,'Ian Kiptoo','Ian','Ian','iankiptoo@gmail.com','Supervisor'),(29,'Joyce Atieno','Joyce','Joyce','joyceatieno@gmail.com','Supervisor'),(30,'Kevin Mutua','Kevin','Kevin','kevinmutua@gmail.com','Supervisor'),(31,'Lydia Chebet','Lydia','Lydia','lydiachebet@gmail.com','Supervisor'),(32,'Aaron Muli','Aaron','Aaron','aaronm@gmail.com','Census Officer'),(33,'Betty Wanjiru','Betty','Betty','bettyw@gmail.com','Census Officer'),(34,'Caleb Otieno','Caleb','Caleb','calebo@gmail.com','Census Officer'),(35,'Diana Chebet','Diana','Diana','dianac@gmail.com','Census Officer'),(36,'Elvis Kiptoo','Elvis','Elvis','elvisk@gmail.com','Census Officer'),(37,'Fiona Achieng','Fiona','Fiona','fionaa@gmail.com','Census Officer'),(38,'George Mwangi','George','George','georgem@gmail.com','Census Officer'),(39,'Hilda Nyambura','Hilda','Hilda','hildan@gmail.com','Census Officer'),(40,'Isaac Kamau','Isaac','Isaac','isaack@gmail.com','Census Officer'),(41,'Janet Wekesa','Janet','Janet','janetw@gmail.com','Census Officer'),(42,'Kevin Koskei','Kelvin','kevin123','kevink@gmail.com','Census Officer'),(43,'Lucy Moraa','Lucy','Lucy','lucym@gmail.com','Census Officer'),(44,'Mark Owino','Mark','Mark','marko@gmail.com','Census Officer'),(45,'Nadia Waithera','Nadia','Nadia','nadiaw@gmail.com','Census Officer'),(46,'Owen Mutiso','Owen','Owen','owenm@gmail.com','Census Officer'),(47,'Paula Njeri','Paula','Paula','paulan@gmail.com','Census Officer'),(48,'Quinn Ndungu','Quinn','Quinn','quinnn@gmail.com','Census Officer'),(49,'Rose Wambui','Rose','Rose','rosew@gmail.com','Census Officer'),(50,'Steve Ouma','Steve','Steve','steveo@gmail.com','Census Officer');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ward`
--

DROP TABLE IF EXISTS `ward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ward` (
  `ward_id` int NOT NULL AUTO_INCREMENT,
  `ward_name` varchar(50) NOT NULL,
  `subcounty_id` int DEFAULT NULL,
  PRIMARY KEY (`ward_id`),
  KEY `subcounty_id` (`subcounty_id`),
  CONSTRAINT `ward_ibfk_1` FOREIGN KEY (`subcounty_id`) REFERENCES `subcounty` (`subcounty_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ward`
--

LOCK TABLES `ward` WRITE;
/*!40000 ALTER TABLE `ward` DISABLE KEYS */;
INSERT INTO `ward` VALUES (1,'Chania',1),(2,'Mangu',1),(3,'Kiamwangi',2),(4,'Ngenda',2),(5,'Weitiethie',3),(6,'Kalimoni',3),(7,'Tigoni',4),(8,'Ndeiya',4),(9,'Karuri',5),(10,'kikuyu',5);
/*!40000 ALTER TABLE `ward` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-01 19:13:38
