/*
SQLyog Ultimate v8.55 
MySQL - 5.0.67-community-nt : Database - core
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`core` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `core`;

/*Data for the table `academic_session` */

/*Data for the table `batch` */

insert  into `batch`(`batch_id`,`department_id`,`programme_id`,`batch_start`,`batch_number`,`is_active`) values (1,'CSE','BTECH',2002,1,0),(2,'BT','BTECH',2002,1,0),(3,'ECE','BTECH',2002,1,0),(4,'MECH','BTECH',2002,1,0),(5,'CSE','BTECH',2003,2,0),(6,'BT','BTECH',2003,2,0),(7,'ECE','BTECH',2003,2,0),(8,'MECH','BTECH',2003,2,0),(9,'CSE','BTECH',2004,3,0),(10,'BT','BTECH',2004,3,0),(11,'ECE','BTECH',2004,3,0),(12,'MECH','BTECH',2004,3,0),(13,'CSE','BTECH',2005,4,0),(14,'BT','BTECH',2005,4,0),(15,'ECE','BTECH',2005,4,0),(16,'MECH','BTECH',2005,4,0),(17,'CSE','BTECH',2006,5,0),(18,'BT','BTECH',2006,5,0),(19,'ECE','BTECH',2006,5,0),(20,'MECH','BTECH',2006,5,0),(21,'CSE','BTECH',2007,6,0),(22,'BT','BTECH',2007,6,0),(23,'ECE','BTECH',2007,6,0),(24,'MECH','BTECH',2007,6,0),(25,'CSE','BTECH',2008,7,0),(26,'BT','BTECH',2008,7,0),(27,'ECE','BTECH',2008,7,0),(28,'MECH','BTECH',2008,7,0),(29,'CSE','BTECH',2009,8,1),(30,'BT','BTECH',2009,8,1),(31,'ECE','BTECH',2009,8,1),(32,'MECH','BTECH',2009,8,1),(33,'CSE','BTECH',2010,9,1),(34,'BT','BTECH',2010,9,1),(35,'ECE','BTECH',2010,9,1),(36,'MECH','BTECH',2010,9,1),(37,'CSE','BTECH',2011,10,1),(38,'BT','BTECH',2011,10,1),(39,'ECE','BTECH',2011,10,1),(40,'MECH','BTECH',2011,10,1),(41,'CSE','BTECH',2012,11,1),(42,'BT','BTECH',2012,11,1),(43,'ECE','BTECH',2012,11,1),(44,'MECH','BTECH',2012,11,1);

/*Data for the table `block` */

/*Data for the table `bus_stations` */

/*Data for the table `casts` */

insert  into `casts`(`cast_id`,`cast_name`) values (1,'GEN'),(2,'OBC'),(3,'SC'),(4,'ST'),(5,'BC');

/*Data for the table `class` */

insert  into `class`(`class_id`,`batch_id`,`handled_by_dept`,`semester_id`,`semester_type`,`semester_duration`,`start_date`,`completion_date`,`is_active`) values (1,1,'CSE',1,'ODD',NULL,NULL,NULL,0),(2,1,'CSE',2,'EVEN',NULL,NULL,NULL,0),(3,1,'CSE',3,'ODD',NULL,NULL,NULL,0),(4,1,'CSE',4,'EVEN',NULL,NULL,NULL,0),(5,1,'CSE',5,'ODD',NULL,NULL,NULL,0),(6,1,'CSE',6,'EVEN',NULL,NULL,NULL,0),(7,1,'CSE',7,'ODD',NULL,NULL,NULL,0),(8,1,'CSE',8,'EVEN',NULL,NULL,NULL,0),(9,2,'BT',1,'ODD',NULL,NULL,NULL,0),(10,2,'BT',2,'EVEN',NULL,NULL,NULL,0),(11,2,'BT',3,'ODD',NULL,NULL,NULL,0),(12,2,'BT',4,'EVEN',NULL,NULL,NULL,0),(13,2,'BT',5,'ODD',NULL,NULL,NULL,0),(14,2,'BT',6,'EVEN',NULL,NULL,NULL,0),(15,2,'BT',7,'ODD',NULL,NULL,NULL,0),(16,2,'BT',8,'EVEN',NULL,NULL,NULL,0),(17,3,'ECE',1,'ODD',NULL,NULL,NULL,0),(18,3,'ECE',2,'EVEN',NULL,NULL,NULL,0),(19,3,'ECE',3,'ODD',NULL,NULL,NULL,0),(20,3,'ECE',4,'EVEN',NULL,NULL,NULL,0),(21,3,'ECE',5,'ODD',NULL,NULL,NULL,0),(22,3,'ECE',6,'EVEN',NULL,NULL,NULL,0),(23,3,'ECE',7,'ODD',NULL,NULL,NULL,0),(24,3,'ECE',8,'EVEN',NULL,NULL,NULL,0),(25,4,'MECH',1,'ODD',NULL,NULL,NULL,0),(26,4,'MECH',2,'EVEN',NULL,NULL,NULL,0),(27,4,'MECH',3,'ODD',NULL,NULL,NULL,0),(28,4,'MECH',4,'EVEN',NULL,NULL,NULL,0),(29,4,'MECH',5,'ODD',NULL,NULL,NULL,0),(30,4,'MECH',6,'EVEN',NULL,NULL,NULL,0),(31,4,'MECH',7,'ODD',NULL,NULL,NULL,0),(32,4,'MECH',8,'EVEN',NULL,NULL,NULL,0),(33,5,'CSE',1,'ODD',NULL,NULL,NULL,0),(34,5,'CSE',2,'EVEN',NULL,NULL,NULL,0),(35,5,'CSE',3,'ODD',NULL,NULL,NULL,0),(36,5,'CSE',4,'EVEN',NULL,NULL,NULL,0),(37,5,'CSE',5,'ODD',NULL,NULL,NULL,0),(38,5,'CSE',6,'EVEN',NULL,NULL,NULL,0),(39,5,'CSE',7,'ODD',NULL,NULL,NULL,0),(40,5,'CSE',8,'EVEN',NULL,NULL,NULL,0),(41,6,'BT',1,'ODD',NULL,NULL,NULL,0),(42,6,'BT',2,'EVEN',NULL,NULL,NULL,0),(43,6,'BT',3,'ODD',NULL,NULL,NULL,0),(44,6,'BT',4,'EVEN',NULL,NULL,NULL,0),(45,6,'BT',5,'ODD',NULL,NULL,NULL,0),(46,6,'BT',6,'EVEN',NULL,NULL,NULL,0),(47,6,'BT',7,'ODD',NULL,NULL,NULL,0),(48,6,'BT',8,'EVEN',NULL,NULL,NULL,0),(49,7,'ECE',1,'ODD',NULL,NULL,NULL,0),(50,7,'ECE',2,'EVEN',NULL,NULL,NULL,0),(51,7,'ECE',3,'ODD',NULL,NULL,NULL,0),(52,7,'ECE',4,'EVEN',NULL,NULL,NULL,0),(53,7,'ECE',5,'ODD',NULL,NULL,NULL,0),(54,7,'ECE',6,'EVEN',NULL,NULL,NULL,0),(55,7,'ECE',7,'ODD',NULL,NULL,NULL,0),(56,7,'ECE',8,'EVEN',NULL,NULL,NULL,0),(57,8,'MECH',1,'ODD',NULL,NULL,NULL,0),(58,8,'MECH',2,'EVEN',NULL,NULL,NULL,0),(59,8,'MECH',3,'ODD',NULL,NULL,NULL,0),(60,8,'MECH',4,'EVEN',NULL,NULL,NULL,0),(61,8,'MECH',5,'ODD',NULL,NULL,NULL,0),(62,8,'MECH',6,'EVEN',NULL,NULL,NULL,0),(63,8,'MECH',7,'ODD',NULL,NULL,NULL,0),(64,8,'MECH',8,'EVEN',NULL,NULL,NULL,0),(65,9,'CSE',1,'ODD',NULL,NULL,NULL,0),(66,9,'CSE',2,'EVEN',NULL,NULL,NULL,0),(67,9,'CSE',3,'ODD',NULL,NULL,NULL,0),(68,9,'CSE',4,'EVEN',NULL,NULL,NULL,0),(69,9,'CSE',5,'ODD',NULL,NULL,NULL,0),(70,9,'CSE',6,'EVEN',NULL,NULL,NULL,0),(71,9,'CSE',7,'ODD',NULL,NULL,NULL,0),(72,9,'CSE',8,'EVEN',NULL,NULL,NULL,0),(73,10,'BT',1,'ODD',NULL,NULL,NULL,0),(74,10,'BT',2,'EVEN',NULL,NULL,NULL,0),(75,10,'BT',3,'ODD',NULL,NULL,NULL,0),(76,10,'BT',4,'EVEN',NULL,NULL,NULL,0),(77,10,'BT',5,'ODD',NULL,NULL,NULL,0),(78,10,'BT',6,'EVEN',NULL,NULL,NULL,0),(79,10,'BT',7,'ODD',NULL,NULL,NULL,0),(80,10,'BT',8,'EVEN',NULL,NULL,NULL,0),(81,11,'ECE',1,'ODD',NULL,NULL,NULL,0),(82,11,'ECE',2,'EVEN',NULL,NULL,NULL,0),(83,11,'ECE',3,'ODD',NULL,NULL,NULL,0),(84,11,'ECE',4,'EVEN',NULL,NULL,NULL,0),(85,11,'ECE',5,'ODD',NULL,NULL,NULL,0),(86,11,'ECE',6,'EVEN',NULL,NULL,NULL,0),(87,11,'ECE',7,'ODD',NULL,NULL,NULL,0),(88,11,'ECE',8,'EVEN',NULL,NULL,NULL,0),(89,12,'MECH',1,'ODD',NULL,NULL,NULL,0),(90,12,'MECH',2,'EVEN',NULL,NULL,NULL,0),(91,12,'MECH',3,'ODD',NULL,NULL,NULL,0),(92,12,'MECH',4,'EVEN',NULL,NULL,NULL,0),(93,12,'MECH',5,'ODD',NULL,NULL,NULL,0),(94,12,'MECH',6,'EVEN',NULL,NULL,NULL,0),(95,12,'MECH',7,'ODD',NULL,NULL,NULL,0),(96,12,'MECH',8,'EVEN',NULL,NULL,NULL,0),(97,13,'CSE',1,'ODD',NULL,NULL,NULL,0),(98,13,'CSE',2,'EVEN',NULL,NULL,NULL,0),(99,13,'CSE',3,'ODD',NULL,NULL,NULL,0),(100,13,'CSE',4,'EVEN',NULL,NULL,NULL,0),(101,13,'CSE',5,'ODD',NULL,NULL,NULL,0),(102,13,'CSE',6,'EVEN',NULL,NULL,NULL,0),(103,13,'CSE',7,'ODD',NULL,NULL,NULL,0),(104,13,'CSE',8,'EVEN',NULL,NULL,NULL,0),(105,14,'BT',1,'ODD',NULL,NULL,NULL,0),(106,14,'BT',2,'EVEN',NULL,NULL,NULL,0),(107,14,'BT',3,'ODD',NULL,NULL,NULL,0),(108,14,'BT',4,'EVEN',NULL,NULL,NULL,0),(109,14,'BT',5,'ODD',NULL,NULL,NULL,0),(110,14,'BT',6,'EVEN',NULL,NULL,NULL,0),(111,14,'BT',7,'ODD',NULL,NULL,NULL,0),(112,14,'BT',8,'EVEN',NULL,NULL,NULL,0),(113,15,'ECE',1,'ODD',NULL,NULL,NULL,0),(114,15,'ECE',2,'EVEN',NULL,NULL,NULL,0),(115,15,'ECE',3,'ODD',NULL,NULL,NULL,0),(116,15,'ECE',4,'EVEN',NULL,NULL,NULL,0),(117,15,'ECE',5,'ODD',NULL,NULL,NULL,0),(118,15,'ECE',6,'EVEN',NULL,NULL,NULL,0),(119,15,'ECE',7,'ODD',NULL,NULL,NULL,0),(120,15,'ECE',8,'EVEN',NULL,NULL,NULL,0),(121,16,'MECH',1,'ODD',NULL,NULL,NULL,0),(122,16,'MECH',2,'EVEN',NULL,NULL,NULL,0),(123,16,'MECH',3,'ODD',NULL,NULL,NULL,0),(124,16,'MECH',4,'EVEN',NULL,NULL,NULL,0),(125,16,'MECH',5,'ODD',NULL,NULL,NULL,0),(126,16,'MECH',6,'EVEN',NULL,NULL,NULL,0),(127,16,'MECH',7,'ODD',NULL,NULL,NULL,0),(128,16,'MECH',8,'EVEN',NULL,NULL,NULL,0),(129,17,'CSE',1,'ODD',NULL,NULL,NULL,0),(130,17,'CSE',2,'EVEN',NULL,NULL,NULL,0),(131,17,'CSE',3,'ODD',NULL,NULL,NULL,0),(132,17,'CSE',4,'EVEN',NULL,NULL,NULL,0),(133,17,'CSE',5,'ODD',NULL,NULL,NULL,0),(134,17,'CSE',6,'EVEN',NULL,NULL,NULL,0),(135,17,'CSE',7,'ODD',NULL,NULL,NULL,0),(136,17,'CSE',8,'EVEN',NULL,NULL,NULL,0),(137,18,'BT',1,'ODD',NULL,NULL,NULL,0),(138,18,'BT',2,'EVEN',NULL,NULL,NULL,0),(139,18,'BT',3,'ODD',NULL,NULL,NULL,0),(140,18,'BT',4,'EVEN',NULL,NULL,NULL,0),(141,18,'BT',5,'ODD',NULL,NULL,NULL,0),(142,18,'BT',6,'EVEN',NULL,NULL,NULL,0),(143,18,'BT',7,'ODD',NULL,NULL,NULL,0),(144,18,'BT',8,'EVEN',NULL,NULL,NULL,0),(145,19,'ECE',1,'ODD',NULL,NULL,NULL,0),(146,19,'ECE',2,'EVEN',NULL,NULL,NULL,0),(147,19,'ECE',3,'ODD',NULL,NULL,NULL,0),(148,19,'ECE',4,'EVEN',NULL,NULL,NULL,0),(149,19,'ECE',5,'ODD',NULL,NULL,NULL,0),(150,19,'ECE',6,'EVEN',NULL,NULL,NULL,0),(151,19,'ECE',7,'ODD',NULL,NULL,NULL,0),(152,19,'ECE',8,'EVEN',NULL,NULL,NULL,0),(153,20,'MECH',1,'ODD',NULL,NULL,NULL,0),(154,20,'MECH',2,'EVEN',NULL,NULL,NULL,0),(155,20,'MECH',3,'ODD',NULL,NULL,NULL,0),(156,20,'MECH',4,'EVEN',NULL,NULL,NULL,0),(157,20,'MECH',5,'ODD',NULL,NULL,NULL,0),(158,20,'MECH',6,'EVEN',NULL,NULL,NULL,0),(159,20,'MECH',7,'ODD',NULL,NULL,NULL,0),(160,20,'MECH',8,'EVEN',NULL,NULL,NULL,0),(161,21,'CSE',1,'ODD',NULL,NULL,NULL,0),(162,21,'CSE',2,'EVEN',NULL,NULL,NULL,0),(163,21,'CSE',3,'ODD',NULL,NULL,NULL,0),(164,21,'CSE',4,'EVEN',NULL,NULL,NULL,0),(165,21,'CSE',5,'ODD',NULL,NULL,NULL,0),(166,21,'CSE',6,'EVEN',NULL,NULL,NULL,0),(167,21,'CSE',7,'ODD',NULL,NULL,NULL,0),(168,21,'CSE',8,'EVEN',NULL,NULL,NULL,0),(169,22,'BT',1,'ODD',NULL,NULL,NULL,0),(170,22,'BT',2,'EVEN',NULL,NULL,NULL,0),(171,22,'BT',3,'ODD',NULL,NULL,NULL,0),(172,22,'BT',4,'EVEN',NULL,NULL,NULL,0),(173,22,'BT',5,'ODD',NULL,NULL,NULL,0),(174,22,'BT',6,'EVEN',NULL,NULL,NULL,0),(175,22,'BT',7,'ODD',NULL,NULL,NULL,0),(176,22,'BT',8,'EVEN',NULL,NULL,NULL,0),(177,23,'ECE',1,'ODD',NULL,NULL,NULL,0),(178,23,'ECE',2,'EVEN',NULL,NULL,NULL,0),(179,23,'ECE',3,'ODD',NULL,NULL,NULL,0),(180,23,'ECE',4,'EVEN',NULL,NULL,NULL,0),(181,23,'ECE',5,'ODD',NULL,NULL,NULL,0),(182,23,'ECE',6,'EVEN',NULL,NULL,NULL,0),(183,23,'ECE',7,'ODD',NULL,NULL,NULL,0),(184,23,'ECE',8,'EVEN',NULL,NULL,NULL,0),(185,24,'MECH',1,'ODD',NULL,NULL,NULL,0),(186,24,'MECH',2,'EVEN',NULL,NULL,NULL,0),(187,24,'MECH',3,'ODD',NULL,NULL,NULL,0),(188,24,'MECH',4,'EVEN',NULL,NULL,NULL,0),(189,24,'MECH',5,'ODD',NULL,NULL,NULL,0),(190,24,'MECH',6,'EVEN',NULL,NULL,NULL,0),(191,24,'MECH',7,'ODD',NULL,NULL,NULL,0),(192,24,'MECH',8,'EVEN',NULL,NULL,NULL,0),(193,25,'CSE',1,'ODD',NULL,NULL,NULL,0),(194,25,'CSE',2,'EVEN',NULL,NULL,NULL,0),(195,25,'CSE',3,'ODD',NULL,NULL,NULL,0),(196,25,'CSE',4,'EVEN',NULL,NULL,NULL,0),(197,25,'CSE',5,'ODD',NULL,NULL,NULL,0),(198,25,'CSE',6,'EVEN',NULL,NULL,NULL,0),(199,25,'CSE',7,'ODD',NULL,NULL,NULL,0),(200,25,'CSE',8,'EVEN',NULL,NULL,NULL,0),(201,26,'BT',1,'ODD',NULL,NULL,NULL,0),(202,26,'BT',2,'EVEN',NULL,NULL,NULL,0),(203,26,'BT',3,'ODD',NULL,NULL,NULL,0),(204,26,'BT',4,'EVEN',NULL,NULL,NULL,0),(205,26,'BT',5,'ODD',NULL,NULL,NULL,0),(206,26,'BT',6,'EVEN',NULL,NULL,NULL,0),(207,26,'BT',7,'ODD',NULL,NULL,NULL,0),(208,26,'BT',8,'EVEN',NULL,NULL,NULL,0),(209,27,'ECE',1,'ODD',NULL,NULL,NULL,0),(210,27,'ECE',2,'EVEN',NULL,NULL,NULL,0),(211,27,'ECE',3,'ODD',NULL,NULL,NULL,0),(212,27,'ECE',4,'EVEN',NULL,NULL,NULL,0),(213,27,'ECE',5,'ODD',NULL,NULL,NULL,0),(214,27,'ECE',6,'EVEN',NULL,NULL,NULL,0),(215,27,'ECE',7,'ODD',NULL,NULL,NULL,0),(216,27,'ECE',8,'EVEN',NULL,NULL,NULL,0),(217,28,'MECH',1,'ODD',NULL,NULL,NULL,0),(218,28,'MECH',2,'EVEN',NULL,NULL,NULL,0),(219,28,'MECH',3,'ODD',NULL,NULL,NULL,0),(220,28,'MECH',4,'EVEN',NULL,NULL,NULL,0),(221,28,'MECH',5,'ODD',NULL,NULL,NULL,0),(222,28,'MECH',6,'EVEN',NULL,NULL,NULL,0),(223,28,'MECH',7,'ODD',NULL,NULL,NULL,0),(224,28,'MECH',8,'EVEN',NULL,NULL,NULL,0),(225,29,'CSE',1,'ODD',NULL,NULL,NULL,1),(226,29,'CSE',2,'EVEN',NULL,NULL,NULL,1),(227,29,'CSE',3,'ODD',NULL,NULL,NULL,1),(228,29,'CSE',4,'EVEN',NULL,NULL,NULL,1),(229,29,'CSE',5,'ODD',NULL,NULL,NULL,1),(230,29,'CSE',6,'EVEN',NULL,NULL,NULL,1),(231,29,'CSE',7,'ODD',NULL,NULL,NULL,1),(232,29,'CSE',8,'EVEN',NULL,NULL,NULL,1),(233,30,'BT',1,'ODD',NULL,NULL,NULL,1),(234,30,'BT',2,'EVEN',NULL,NULL,NULL,1),(235,30,'BT',3,'ODD',NULL,NULL,NULL,1),(236,30,'BT',4,'EVEN',NULL,NULL,NULL,1),(237,30,'BT',5,'ODD',NULL,NULL,NULL,1),(238,30,'BT',6,'EVEN',NULL,NULL,NULL,1),(239,30,'BT',7,'ODD',NULL,NULL,NULL,1),(240,30,'BT',8,'EVEN',NULL,NULL,NULL,1),(241,31,'ECE',1,'ODD',NULL,NULL,NULL,1),(242,31,'ECE',2,'EVEN',NULL,NULL,NULL,1),(243,31,'ECE',3,'ODD',NULL,NULL,NULL,1),(244,31,'ECE',4,'EVEN',NULL,NULL,NULL,1),(245,31,'ECE',5,'ODD',NULL,NULL,NULL,1),(246,31,'ECE',6,'EVEN',NULL,NULL,NULL,1),(247,31,'ECE',7,'ODD',NULL,NULL,NULL,1),(248,31,'ECE',8,'EVEN',NULL,NULL,NULL,1),(249,32,'MECH',1,'ODD',NULL,NULL,NULL,1),(250,32,'MECH',2,'EVEN',NULL,NULL,NULL,1),(251,32,'MECH',3,'ODD',NULL,NULL,NULL,1),(252,32,'MECH',4,'EVEN',NULL,NULL,NULL,1),(253,32,'MECH',5,'ODD',NULL,NULL,NULL,1),(254,32,'MECH',6,'EVEN',NULL,NULL,NULL,1),(255,32,'MECH',7,'ODD',NULL,NULL,NULL,1),(256,32,'MECH',8,'EVEN',NULL,NULL,NULL,1),(257,33,'CSE',1,'ODD',NULL,NULL,NULL,1),(258,33,'CSE',2,'EVEN',NULL,NULL,NULL,1),(259,33,'CSE',3,'ODD',NULL,NULL,NULL,1),(260,33,'CSE',4,'EVEN',NULL,NULL,NULL,1),(261,33,'CSE',5,'ODD',NULL,NULL,NULL,1),(262,33,'CSE',6,'EVEN',NULL,NULL,NULL,1),(263,33,'CSE',7,'ODD',NULL,NULL,NULL,1),(264,33,'CSE',8,'EVEN',NULL,NULL,NULL,1),(265,34,'BT',1,'ODD',NULL,NULL,NULL,1),(266,34,'BT',2,'EVEN',NULL,NULL,NULL,1),(267,34,'BT',3,'ODD',NULL,NULL,NULL,1),(268,34,'BT',4,'EVEN',NULL,NULL,NULL,1),(269,34,'BT',5,'ODD',NULL,NULL,NULL,1),(270,34,'BT',6,'EVEN',NULL,NULL,NULL,1),(271,34,'BT',7,'ODD',NULL,NULL,NULL,1),(272,34,'BT',8,'EVEN',NULL,NULL,NULL,1),(273,35,'ECE',1,'ODD',NULL,NULL,NULL,1),(274,35,'ECE',2,'EVEN',NULL,NULL,NULL,1),(275,35,'ECE',3,'ODD',NULL,NULL,NULL,1),(276,35,'ECE',4,'EVEN',NULL,NULL,NULL,1),(277,35,'ECE',5,'ODD',NULL,NULL,NULL,1),(278,35,'ECE',6,'EVEN',NULL,NULL,NULL,1),(279,35,'ECE',7,'ODD',NULL,NULL,NULL,1),(280,35,'ECE',8,'EVEN',NULL,NULL,NULL,1),(281,36,'MECH',1,'ODD',NULL,NULL,NULL,1),(282,36,'MECH',2,'EVEN',NULL,NULL,NULL,1),(283,36,'MECH',3,'ODD',NULL,NULL,NULL,1),(284,36,'MECH',4,'EVEN',NULL,NULL,NULL,1),(285,36,'MECH',5,'ODD',NULL,NULL,NULL,1),(286,36,'MECH',6,'EVEN',NULL,NULL,NULL,1),(287,36,'MECH',7,'ODD',NULL,NULL,NULL,1),(288,36,'MECH',8,'EVEN',NULL,NULL,NULL,1),(289,37,'CSE',1,'ODD',NULL,NULL,NULL,1),(290,37,'CSE',2,'EVEN',NULL,NULL,NULL,1),(291,37,'CSE',3,'ODD',NULL,NULL,NULL,1),(292,37,'CSE',4,'EVEN',NULL,NULL,NULL,1),(293,37,'CSE',5,'ODD',NULL,NULL,NULL,1),(294,37,'CSE',6,'EVEN',NULL,NULL,NULL,1),(295,37,'CSE',7,'ODD',NULL,NULL,NULL,1),(296,37,'CSE',8,'EVEN',NULL,NULL,NULL,1),(297,38,'BT',1,'ODD',NULL,NULL,NULL,1),(298,38,'BT',2,'EVEN',NULL,NULL,NULL,1),(299,38,'BT',3,'ODD',NULL,NULL,NULL,1),(300,38,'BT',4,'EVEN',NULL,NULL,NULL,1),(301,38,'BT',5,'ODD',NULL,NULL,NULL,1),(302,38,'BT',6,'EVEN',NULL,NULL,NULL,1),(303,38,'BT',7,'ODD',NULL,NULL,NULL,1),(304,38,'BT',8,'EVEN',NULL,NULL,NULL,1),(305,39,'ECE',1,'ODD',NULL,NULL,NULL,1),(306,39,'ECE',2,'EVEN',NULL,NULL,NULL,1),(307,39,'ECE',3,'ODD',NULL,NULL,NULL,1),(308,39,'ECE',4,'EVEN',NULL,NULL,NULL,1),(309,39,'ECE',5,'ODD',NULL,NULL,NULL,1),(310,39,'ECE',6,'EVEN',NULL,NULL,NULL,1),(311,39,'ECE',7,'ODD',NULL,NULL,NULL,1),(312,39,'ECE',8,'EVEN',NULL,NULL,NULL,1),(313,40,'MECH',1,'ODD',NULL,NULL,NULL,1),(314,40,'MECH',2,'EVEN',NULL,NULL,NULL,1),(315,40,'MECH',3,'ODD',NULL,NULL,NULL,1),(316,40,'MECH',4,'EVEN',NULL,NULL,NULL,1),(317,40,'MECH',5,'ODD',NULL,NULL,NULL,1),(318,40,'MECH',6,'EVEN',NULL,NULL,NULL,1),(319,40,'MECH',7,'ODD',NULL,NULL,NULL,1),(320,40,'MECH',8,'EVEN',NULL,NULL,NULL,1),(321,41,'CSE',1,'ODD',NULL,NULL,NULL,1),(322,41,'CSE',2,'EVEN',NULL,NULL,NULL,1),(323,41,'CSE',3,'ODD',NULL,NULL,NULL,1),(324,41,'CSE',4,'EVEN',NULL,NULL,NULL,1),(325,41,'CSE',5,'ODD',NULL,NULL,NULL,1),(326,41,'CSE',6,'EVEN',NULL,NULL,NULL,1),(327,41,'CSE',7,'ODD',NULL,NULL,NULL,1),(328,41,'CSE',8,'EVEN',NULL,NULL,NULL,1),(329,42,'BT',1,'ODD',NULL,NULL,NULL,1),(330,42,'BT',2,'EVEN',NULL,NULL,NULL,1),(331,42,'BT',3,'ODD',NULL,NULL,NULL,1),(332,42,'BT',4,'EVEN',NULL,NULL,NULL,1),(333,42,'BT',5,'ODD',NULL,NULL,NULL,1),(334,42,'BT',6,'EVEN',NULL,NULL,NULL,1),(335,42,'BT',7,'ODD',NULL,NULL,NULL,1),(336,42,'BT',8,'EVEN',NULL,NULL,NULL,1),(337,43,'ECE',1,'ODD',NULL,NULL,NULL,1),(338,43,'ECE',2,'EVEN',NULL,NULL,NULL,1),(339,43,'ECE',3,'ODD',NULL,NULL,NULL,1),(340,43,'ECE',4,'EVEN',NULL,NULL,NULL,1),(341,43,'ECE',5,'ODD',NULL,NULL,NULL,1),(342,43,'ECE',6,'EVEN',NULL,NULL,NULL,1),(343,43,'ECE',7,'ODD',NULL,NULL,NULL,1),(344,43,'ECE',8,'EVEN',NULL,NULL,NULL,1),(345,44,'MECH',1,'ODD',NULL,NULL,NULL,1),(346,44,'MECH',2,'EVEN',NULL,NULL,NULL,1),(347,44,'MECH',3,'ODD',NULL,NULL,NULL,1),(348,44,'MECH',4,'EVEN',NULL,NULL,NULL,1),(349,44,'MECH',5,'ODD',NULL,NULL,NULL,1),(350,44,'MECH',6,'EVEN',NULL,NULL,NULL,1),(351,44,'MECH',7,'ODD',NULL,NULL,NULL,1),(352,44,'MECH',8,'EVEN',NULL,NULL,NULL,1);

/*Data for the table `configs` */

insert  into `configs`(`parameter`,`value`) values ('EVNT_PRD_ATT','TRUE');

/*Data for the table `contact_type` */

insert  into `contact_type`(`contact_type_id`,`contact_type_name`) values (1,'HOME LANDLINE'),(2,'OFFICE LANDLINE'),(3,'EMAIL'),(4,'RELATIVE'),(5,'PERSONAL MOBILE'),(6,'HOME MOBILE');

/*Data for the table `department` */

insert  into `department`(`department_id`,`department_name`) values ('BT','Biotech'),('CSE','Computer Science and Engineering'),('ECE','Electronics and Communication Engineering'),('MECH','Mechanical Engineering');

/*Data for the table `department_programme` */

insert  into `department_programme`(`department_id`,`programme_id`) values ('BT','BTECH'),('CSE','BTECH'),('ECE','BTECH'),('MECH','BTECH'),('BT','MTECH'),('CSE','MTECH'),('ECE','MTECH'),('MECH','MTECH');

/*Data for the table `groups` */

insert  into `groups`(`group_id`,`department_id`,`programme_id`) values ('ALL','ALL','ALL'),('C1','BT','BTECH'),('C2','BT','BTECH'),('C3','BT','BTECH'),('A1','CSE','BTECH'),('A2','CSE','BTECH'),('A3','CSE','BTECH'),('B1','ECE','BTECH'),('B2','ECE','BTECH'),('B3','ECE','BTECH'),('D1','MECH','BTECH'),('D2','MECH','BTECH'),('D3','MECH','BTECH');

/*Data for the table `holiday` */

/*Data for the table `member_address` */

/*Data for the table `member_bus_stop` */

/*Data for the table `member_contacts` */

/*Data for the table `member_relatives` */

/*Data for the table `member_type` */

insert  into `member_type`(`member_type_id`,`member_type_name`) values (1,'STUDENT'),(2,'STAFF'),(3,'MANAGEMENT'),(4,'OUTSIDER');

/*Data for the table `members` */

/*Data for the table `mod_action` */

insert  into `mod_action`(`action_id`,`controller_id`,`module_id`) values ('aclconfig','batch','main'),('addbatch','batch','main'),('getbatchids','batch','main'),('getbatchinfo','batch','main'),('index','batch','main'),('savebatch','batch','main'),('viewbatchinfo','batch','main'),('aclconfig','class','main'),('addclass','class','main'),('fetchdepartments','class','main'),('fetchprogrammes','class','main'),('getclassids','class','main'),('getclassinfo','class','main'),('index','class','main'),('saveclass','class','main'),('viewclassinfo','class','main'),('index','index','main'),('fetchmemberid','search','main'),('fetchrollnumbers','search','main'),('index','search','main'),('search','search','main'),('aclconfig','student','main'),('collectexportabledata','student','main'),('createprofile','student','main'),('editaddressinfo','student','main'),('editclassinfo','student','main'),('editcontactinfo','student','main'),('editpersonalinfo','student','main'),('editrelativesinfo','student','main'),('editunvregistrationinfo','student','main'),('exportexcel','student','main'),('fetchaddressinfo','student','main'),('fetchclassinfo','student','main'),('fetchcontactinfo','student','main'),('fetchemailids','student','main'),('fetchpersonalinfo','student','main'),('fetchrelativesinfo','student','main'),('fetchunvregistrationinfo','student','main'),('getimagename','student','main'),('index','student','main'),('memberidcheck','student','main'),('saveaddressinfo','student','main'),('saveclassinfo','student','main'),('savecontactinfo','student','main'),('saveexcelonclient','student','main'),('savepersonalinfo','student','main'),('savephoto','student','main'),('saverelativesinfo','student','main'),('saveunvregistrationinfo','student','main'),('sendemail','student','main'),('testex','student','main'),('uploadphoto','student','main'),('viewaddressinfo','student','main'),('viewclassinfo','student','main'),('viewcontactinfo','student','main'),('viewimage','student','main'),('viewpersonalinfo','student','main'),('viewrelativesinfo','student','main'),('viewunvregistrationinfo','student','main');

/*Data for the table `mod_controller` */

insert  into `mod_controller`(`controller_id`,`module_id`) values ('batch','main'),('class','main'),('index','main'),('search','main'),('student','main');

/*Data for the table `mod_role` */

insert  into `mod_role`(`role_id`,`role_name`) values ('guest','guest'),('student','student');

/*Data for the table `mod_role_resource` */

insert  into `mod_role_resource`(`role_id`,`action_id`,`controller_id`,`module_id`) values ('student','aclconfig','batch','main'),('student','aclconfig','class','main'),('student','aclconfig','student','main'),('student','addbatch','batch','main'),('student','addclass','class','main'),('student','collectexportabledata','student','main'),('student','createprofile','student','main'),('student','editaddressinfo','student','main'),('student','editclassinfo','student','main'),('student','editcontactinfo','student','main'),('student','editpersonalinfo','student','main'),('student','editrelativesinfo','student','main'),('student','editunvregistrationinfo','student','main'),('student','exportexcel','student','main'),('student','fetchaddressinfo','student','main'),('student','fetchclassinfo','student','main'),('student','fetchcontactinfo','student','main'),('student','fetchdepartments','class','main'),('student','fetchemailids','student','main'),('student','fetchmemberid','search','main'),('student','fetchpersonalinfo','student','main'),('student','fetchprogrammes','class','main'),('student','fetchrelativesinfo','student','main'),('student','fetchrollnumbers','search','main'),('student','fetchunvregistrationinfo','student','main'),('student','getbatchids','batch','main'),('student','getbatchinfo','batch','main'),('student','getclassids','class','main'),('student','getclassinfo','class','main'),('student','getimagename','student','main'),('student','index','batch','main'),('student','index','class','main'),('student','index','index','main'),('student','index','search','main'),('student','index','student','main'),('student','memberidcheck','student','main'),('student','saveaddressinfo','student','main'),('student','savebatch','batch','main'),('student','saveclass','class','main'),('student','saveclassinfo','student','main'),('student','savecontactinfo','student','main'),('student','saveexcelonclient','student','main'),('student','savepersonalinfo','student','main'),('student','savephoto','student','main'),('student','saverelativesinfo','student','main'),('student','saveunvregistrationinfo','student','main'),('student','search','search','main'),('student','sendemail','student','main'),('student','testex','student','main'),('student','uploadphoto','student','main'),('student','viewaddressinfo','student','main'),('student','viewbatchinfo','batch','main'),('student','viewclassinfo','class','main'),('student','viewclassinfo','student','main'),('student','viewcontactinfo','student','main'),('student','viewimage','student','main'),('student','viewpersonalinfo','student','main'),('student','viewrelativesinfo','student','main'),('student','viewunvregistrationinfo','student','main');

/*Data for the table `module` */

insert  into `module`(`module_id`) values ('main');

/*Data for the table `nationalities` */

insert  into `nationalities`(`nationality_id`,`nationality_name`) values (1,'INDIAN'),(2,'AMERICAN'),(3,'BRITISH'),(4,'AUSTRILIAN');

/*Data for the table `programme` */

insert  into `programme`(`programme_id`,`programme_name`,`total_semesters`,`duration`) values ('BTECH','Bachelor in Technology',8,NULL),('DIPLOMA','Diploma',6,NULL),('MTECH','Master in Technology',4,NULL);

/*Data for the table `relations` */

insert  into `relations`(`relation_id`,`relation_name`) values (1,'FATHER'),(2,'MOTHER'),(3,'GRAND FATHER'),(4,'GRAND MOTHER'),(5,'UNCLE');

/*Data for the table `religions` */

insert  into `religions`(`religion_id`,`religion_name`) values (1,'HINDU'),(2,'MUSLIM'),(3,'SIKH'),(4,'CHRISTIAN');

/*Data for the table `room` */

/*Data for the table `room_type` */

insert  into `room_type`(`room_type_id`,`room_type_name`) values ('LAB','Laboratory'),('LH','Lecture Hall'),('TR','Tutorial Room');

/*Data for the table `staff_personal` */

/*Data for the table `staff_professional` */

/*Data for the table `student_admission` */

/*Data for the table `student_class` */

/*Data for the table `student_registration` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
