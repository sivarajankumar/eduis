/*
SQLyog Ultimate - MySQL GUI v8.22 
MySQL - 5.0.67-community-nt : Database - academics
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`academics` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `academics`;

/*Table structure for table `academic_session` */

DROP TABLE IF EXISTS `academic_session`;

CREATE TABLE `academic_session` (
  `academic_year` year(4) NOT NULL,
  `semester_type` char(10) NOT NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `semester_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`academic_year`,`semester_type`),
  KEY `fk_academic_session_semester_degree1` (`department_id`,`degree_id`,`semester_id`),
  CONSTRAINT `fk_academic_session_semester_degree1` FOREIGN KEY (`department_id`, `degree_id`, `semester_id`) REFERENCES `semester_degree` (`department_id`, `degree_id`, `semester_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Sessions information of a particular calender year.';

/*Data for the table `academic_session` */

/*Table structure for table `adjustment_day` */

DROP TABLE IF EXISTS `adjustment_day`;

CREATE TABLE `adjustment_day` (
  `target_date` date NOT NULL,
  `weekday_number` tinyint(3) unsigned NOT NULL,
  `comment` varchar(30) default NULL,
  PRIMARY KEY  (`target_date`,`weekday_number`),
  KEY `fk_adjustment_day_weekday1` (`weekday_number`),
  CONSTRAINT `fk_adjustment_day_weekday1` FOREIGN KEY (`weekday_number`) REFERENCES `weekday` (`weekday_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `adjustment_day` */

/*Table structure for table `adjustment_faculty` */

DROP TABLE IF EXISTS `adjustment_faculty`;

CREATE TABLE `adjustment_faculty` (
  `start_date` date NOT NULL,
  `source_timetable_id` int(10) unsigned NOT NULL,
  `source_staff_id` char(10) NOT NULL,
  `target_timetable_id` int(10) unsigned NOT NULL,
  `target_staff_id` char(10) NOT NULL,
  `end_date` date default NULL,
  `purpose` varchar(120) default NULL,
  PRIMARY KEY  (`start_date`,`source_timetable_id`),
  KEY `fk_adjustment_faculty_timetable1` (`source_timetable_id`),
  KEY `fk_adjustment_faculty_timetable2` (`target_timetable_id`),
  CONSTRAINT `fk_adjustment_faculty_timetable1` FOREIGN KEY (`source_timetable_id`) REFERENCES `timetable` (`timetable_id`),
  CONSTRAINT `fk_adjustment_faculty_timetable2` FOREIGN KEY (`target_timetable_id`) REFERENCES `timetable` (`timetable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `adjustment_faculty` */

/*Table structure for table `batch` */

DROP TABLE IF EXISTS `batch`;

CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL,
  `department_id` char(10) default NULL,
  `programme_id` char(10) default NULL,
  `batch_start` year(4) default NULL,
  `batch_number` tinyint(4) default NULL,
  `is_active` tinyint(1) default NULL,
  PRIMARY KEY  (`batch_id`),
  UNIQUE KEY `department_id_UNIQUE` (`department_id`,`programme_id`,`batch_start`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `batch` */

insert  into `batch`(`batch_id`,`department_id`,`programme_id`,`batch_start`,`batch_number`,`is_active`) values (1,'cse','btech',2008,8,1);

/*Table structure for table `btech` */

DROP TABLE IF EXISTS `btech`;

CREATE TABLE `btech` (
  `member_id` int(10) unsigned NOT NULL,
  `qualification_id` int(10) unsigned NOT NULL,
  `discipline_id` char(10) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `percentage` decimal(2,0) NOT NULL,
  `passing_year` year(4) NOT NULL,
  `istitution` varchar(120) NOT NULL,
  `university` varchar(45) NOT NULL,
  `city_name` varchar(45) NOT NULL,
  `state_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`member_id`,`qualification_id`),
  KEY `fk_btech_discipline1` (`discipline_id`),
  CONSTRAINT `fk_btech_discipline1` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`discipline_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_btech_member_qualification1` FOREIGN KEY (`member_id`, `qualification_id`) REFERENCES `member_qualification` (`member_id`, `qualification_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `btech` */

insert  into `btech`(`member_id`,`qualification_id`,`discipline_id`,`marks_obtained`,`total_marks`,`percentage`,`passing_year`,`istitution`,`university`,`city_name`,`state_name`) values (1,3,'1',678,1000,'68',2008,'ace','kuk','amb','hr');

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`city_id`,`state_id`),
  KEY `fk_city_states1` (`state_id`),
  CONSTRAINT `fk_city_states1` FOREIGN KEY (`state_id`) REFERENCES `state` (`state_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `city` */

/*Table structure for table `class` */

DROP TABLE IF EXISTS `class`;

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL auto_increment,
  `batch_id` int(11) default NULL,
  `semester_id` tinyint(4) NOT NULL,
  `semester_type` enum('ODD','EVEN') default NULL,
  `semester_duration` tinyint(4) unsigned default NULL,
  `handled_by_dept` char(10) NOT NULL,
  `start_date` date default NULL,
  `completion_date` date default NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY  (`class_id`),
  UNIQUE KEY `batch_id_UNIQUE` (`semester_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `class` */

insert  into `class`(`class_id`,`batch_id`,`semester_id`,`semester_type`,`semester_duration`,`handled_by_dept`,`start_date`,`completion_date`,`is_active`) values (1,1,8,'EVEN',4,'cse','2011-11-11',NULL,1);

/*Table structure for table `class_subject` */

DROP TABLE IF EXISTS `class_subject`;

CREATE TABLE `class_subject` (
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY  (`class_id`,`subject_id`),
  KEY `fk_class_subject_class1` (`class_id`),
  KEY `fk_class_subject_subject1` (`subject_id`),
  CONSTRAINT `fk_class_subject_class1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_class_subject_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `class_subject` */

insert  into `class_subject`(`class_id`,`subject_id`) values (1,1);

/*Table structure for table `competitive_exam` */

DROP TABLE IF EXISTS `competitive_exam`;

CREATE TABLE `competitive_exam` (
  `exam_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `abbr` varchar(10) default NULL,
  PRIMARY KEY  (`exam_id`),
  UNIQUE KEY `competitive_exam_name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `competitive_exam` */

insert  into `competitive_exam`(`exam_id`,`name`,`abbr`) values (1,'AIEEE','AIEEE'),(2,'LEET','LEET'),(3,'GATE','GATE');

/*Table structure for table `configs` */

DROP TABLE IF EXISTS `configs`;

CREATE TABLE `configs` (
  `parameter` varchar(30) NOT NULL,
  `value` varchar(10) default NULL,
  PRIMARY KEY  (`parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `configs` */

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `country` */

insert  into `country`(`country_id`,`name`) values (1,'INDIA');

/*Table structure for table `diploma` */

DROP TABLE IF EXISTS `diploma`;

CREATE TABLE `diploma` (
  `member_id` int(10) unsigned NOT NULL,
  `qualification_id` int(10) unsigned NOT NULL,
  `discipline_id` char(10) NOT NULL,
  `board_roll_no` varchar(45) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `percentage` tinyint(4) NOT NULL,
  `passing_year` year(4) NOT NULL,
  `remarks` int(11) default NULL,
  `university` varchar(45) NOT NULL,
  `institution` varchar(120) NOT NULL,
  `migration_date` date default NULL,
  `city_name` varchar(45) NOT NULL,
  `state_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`member_id`,`qualification_id`),
  KEY `fk_diploma_discipline1` (`discipline_id`),
  CONSTRAINT `fk_diploma_discipline1` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`discipline_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_diploma_member_qualification1` FOREIGN KEY (`member_id`, `qualification_id`) REFERENCES `member_qualification` (`member_id`, `qualification_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `diploma` */

insert  into `diploma`(`member_id`,`qualification_id`,`discipline_id`,`board_roll_no`,`marks_obtained`,`total_marks`,`percentage`,`passing_year`,`remarks`,`university`,`institution`,`migration_date`,`city_name`,`state_name`) values (1,3,'1','234567',300,1000,30,2009,NULL,'KURUKSHTERA','GOVT.POLYTECHNIC','0000-00-00','AMBALA','HARYANA');

/*Table structure for table `discipline` */

DROP TABLE IF EXISTS `discipline`;

CREATE TABLE `discipline` (
  `discipline_id` char(10) NOT NULL,
  `discipline_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`discipline_id`),
  UNIQUE KEY `discipline_id_UNIQUE` (`discipline_id`,`discipline_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `discipline` */

insert  into `discipline`(`discipline_id`,`discipline_name`) values ('1','CSE');

/*Table structure for table `dmc` */

DROP TABLE IF EXISTS `dmc`;

CREATE TABLE `dmc` (
  `dmc_id` char(10) NOT NULL,
  `test_info_id` int(10) unsigned NOT NULL,
  `marks_scored` tinyint(4) default NULL,
  `is_external` tinyint(1) NOT NULL default '1',
  `status` char(1) default 'P',
  KEY `fk_dmc_dmc_info1` (`dmc_id`),
  KEY `fk_dmc_test_info1` (`test_info_id`),
  CONSTRAINT `fk_dmc_test_info1` FOREIGN KEY (`test_info_id`) REFERENCES `test_info` (`test_info_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `dmc` */

/*Table structure for table `dmc_info` */

DROP TABLE IF EXISTS `dmc_info`;

CREATE TABLE `dmc_info` (
  `dmc_info_id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `result_type_id` int(11) NOT NULL,
  `dmc_id` varchar(20) NOT NULL,
  `is_considered` tinyint(1) default NULL,
  `roll_no` varchar(45) NOT NULL,
  `examination` varchar(45) NOT NULL,
  `custody_date` date default NULL,
  `is_granted` tinyint(1) default NULL,
  `grant_date` date default NULL,
  `recieveing_date` date default NULL,
  `is_copied` tinyint(1) default NULL,
  `dispatch_date` date default NULL,
  `marks_obtained` int(11) default NULL,
  `total_marks` int(11) default NULL,
  `scaled_marks` int(11) default NULL,
  `percentage` int(11) default NULL,
  PRIMARY KEY  (`dmc_info_id`),
  UNIQUE KEY `dmc_id_UNIQUE` (`dmc_id`),
  KEY `fk_dmc_info_result_type1` (`result_type_id`),
  KEY `fk_dmc_info_student_class1` (`member_id`,`class_id`),
  CONSTRAINT `fk_dmc_info_result_type1` FOREIGN KEY (`result_type_id`) REFERENCES `result_type` (`result_type_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dmc_info_student_class1` FOREIGN KEY (`member_id`, `class_id`) REFERENCES `student_class` (`member_id`, `class_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `dmc_info` */

insert  into `dmc_info`(`dmc_info_id`,`member_id`,`class_id`,`result_type_id`,`dmc_id`,`is_considered`,`roll_no`,`examination`,`custody_date`,`is_granted`,`grant_date`,`recieveing_date`,`is_copied`,`dispatch_date`,`marks_obtained`,`total_marks`,`scaled_marks`,`percentage`) values (1,1,1,1,'123',1,'2308009','BTECH',NULL,NULL,NULL,NULL,NULL,'2011-11-11',678,1000,68,68);

/*Table structure for table `dmc_marks` */

DROP TABLE IF EXISTS `dmc_marks`;

CREATE TABLE `dmc_marks` (
  `dmc_marks_id` int(10) unsigned NOT NULL auto_increment,
  `dmc_info_id` int(10) unsigned NOT NULL,
  `student_subject_id` int(11) NOT NULL,
  `internal` int(11) NOT NULL,
  `external` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `is_pass` tinyint(1) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `date` date default NULL,
  PRIMARY KEY  (`dmc_marks_id`),
  KEY `fk_dmc_marks_student_subject1` (`student_subject_id`),
  KEY `fk_dmc_marks_dmc_info1` (`dmc_info_id`),
  CONSTRAINT `fk_dmc_marks_student_subject1` FOREIGN KEY (`student_subject_id`) REFERENCES `student_subject` (`student_subject_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_dmc_marks_dmc_info1` FOREIGN KEY (`dmc_info_id`) REFERENCES `dmc_info` (`dmc_info_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `dmc_marks` */

/*Table structure for table `internal_marks` */

DROP TABLE IF EXISTS `internal_marks`;

CREATE TABLE `internal_marks` (
  `member_id` int(11) NOT NULL,
  `subject_code` char(10) NOT NULL,
  `department_id` char(10) NOT NULL,
  `programme_id` char(10) NOT NULL,
  `semester_id` tinyint(4) NOT NULL,
  `marks_scored` tinyint(3) unsigned zerofill NOT NULL,
  `marks_suggested` tinyint(4) default NULL,
  PRIMARY KEY  (`member_id`,`subject_code`,`department_id`,`programme_id`,`semester_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `internal_marks` */

/*Table structure for table `matric` */

DROP TABLE IF EXISTS `matric`;

CREATE TABLE `matric` (
  `member_id` int(10) unsigned NOT NULL,
  `qualification_id` int(10) unsigned NOT NULL,
  `board` varchar(120) NOT NULL,
  `board_roll_no` varchar(20) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `percentage` tinyint(4) NOT NULL,
  `passing_year` year(4) NOT NULL,
  `school_rank` tinyint(4) NOT NULL COMMENT 'if any',
  `remarks` varchar(120) default NULL,
  `institution` varchar(120) NOT NULL,
  `city_name` varchar(45) NOT NULL,
  `state_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`member_id`,`qualification_id`),
  CONSTRAINT `fk_matric_member_qualification1` FOREIGN KEY (`member_id`, `qualification_id`) REFERENCES `member_qualification` (`member_id`, `qualification_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `matric` */

insert  into `matric`(`member_id`,`qualification_id`,`board`,`board_roll_no`,`marks_obtained`,`total_marks`,`percentage`,`passing_year`,`school_rank`,`remarks`,`institution`,`city_name`,`state_name`) values (1,1,'CBSE','0980980',700,1000,70,2006,1,NULL,'PTA NAI','KALKA','HARYANA'),(1,2,'CBSE','2134789',890,1000,89,2005,1,NULL,'AIR FORCE SCHOOL','AMBALA','HARYANA'),(1,3,'CBSE','2345678',500,1000,50,2006,1,NULL,'KV CHANDIMANDIR','PINJORE','HARYANA');

/*Table structure for table `member_qualification` */

DROP TABLE IF EXISTS `member_qualification`;

CREATE TABLE `member_qualification` (
  `member_id` int(10) unsigned NOT NULL,
  `qualification_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`member_id`,`qualification_id`),
  KEY `fk_member_qualification_qualification1` (`qualification_id`),
  CONSTRAINT `fk_member_qualification_members1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_member_qualification_qualification1` FOREIGN KEY (`qualification_id`) REFERENCES `qualification` (`qualification_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `member_qualification` */

insert  into `member_qualification`(`member_id`,`qualification_id`) values (1,1),(1,2),(1,3),(1,4);

/*Table structure for table `members` */

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `member_id` int(10) unsigned NOT NULL,
  `member_type_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) default NULL,
  `middle_name` varchar(45) default NULL,
  `dob` date NOT NULL,
  `blood_group` char(6) default NULL,
  `gender` char(10) NOT NULL,
  `religion_id` tinyint(4) NOT NULL,
  `cast_id` tinyint(4) NOT NULL,
  `nationality_id` tinyint(3) NOT NULL,
  `join_date` date default NULL,
  `relieve_date` date default NULL,
  `is_active` tinyint(1) default NULL,
  `image_no` varchar(45) default NULL,
  PRIMARY KEY  (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `members` */

insert  into `members`(`member_id`,`member_type_id`,`first_name`,`last_name`,`middle_name`,`dob`,`blood_group`,`gender`,`religion_id`,`cast_id`,`nationality_id`,`join_date`,`relieve_date`,`is_active`,`image_no`) values (1,1,'harsh','yadav','kumar','0000-00-00',NULL,'male',1,1,1,NULL,NULL,NULL,NULL),(2,1,'prarthana','wahi',NULL,'1989-11-06','o+','female',1,1,1,NULL,NULL,NULL,NULL),(3,1,'AMRIT','SINGH',NULL,'1990-05-09',NULL,'MALE',1,1,1,NULL,NULL,NULL,NULL);

/*Table structure for table `mod_action` */

DROP TABLE IF EXISTS `mod_action`;

CREATE TABLE `mod_action` (
  `module_id` varchar(20) NOT NULL,
  `controller_id` varchar(20) NOT NULL,
  `action_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`action_id`,`controller_id`,`module_id`),
  KEY `fk_mod_action_mod_controller1` (`controller_id`,`module_id`),
  CONSTRAINT `fk_mod_action_mod_controller1` FOREIGN KEY (`controller_id`, `module_id`) REFERENCES `mod_controller` (`controller_id`, `module_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mod_action` */

/*Table structure for table `mod_controller` */

DROP TABLE IF EXISTS `mod_controller`;

CREATE TABLE `mod_controller` (
  `module_id` varchar(20) NOT NULL,
  `controller_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`controller_id`,`module_id`),
  KEY `fk_mod_controller_module1` (`module_id`),
  CONSTRAINT `fk_mod_controller_module1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mod_controller` */

/*Table structure for table `mod_role` */

DROP TABLE IF EXISTS `mod_role`;

CREATE TABLE `mod_role` (
  `role_id` varchar(10) NOT NULL,
  `role_name` varchar(45) default NULL,
  PRIMARY KEY  (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mod_role` */

/*Table structure for table `mod_role_resource` */

DROP TABLE IF EXISTS `mod_role_resource`;

CREATE TABLE `mod_role_resource` (
  `role_id` varchar(10) NOT NULL,
  `module_id` varchar(20) NOT NULL,
  `controller_id` varchar(20) NOT NULL,
  `action_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`role_id`,`action_id`,`controller_id`,`module_id`),
  KEY `fk_mod_role_resource_mod_role1` (`role_id`),
  KEY `fk_mod_role_resource_mod_action1` (`action_id`,`controller_id`,`module_id`),
  CONSTRAINT `fk_mod_role_resource_mod_role1` FOREIGN KEY (`role_id`) REFERENCES `mod_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mod_role_resource_mod_action1` FOREIGN KEY (`action_id`, `controller_id`, `module_id`) REFERENCES `mod_action` (`action_id`, `controller_id`, `module_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mod_role_resource` */

/*Table structure for table `module` */

DROP TABLE IF EXISTS `module`;

CREATE TABLE `module` (
  `module_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `module` */

/*Table structure for table `mtech` */

DROP TABLE IF EXISTS `mtech`;

CREATE TABLE `mtech` (
  `member_id` int(10) unsigned NOT NULL,
  `qualification_id` int(10) unsigned NOT NULL,
  `discipline_id` char(10) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `percentage` decimal(2,0) NOT NULL,
  `passing_year` year(4) NOT NULL,
  `institution` varchar(45) NOT NULL,
  `university` varchar(255) NOT NULL,
  `city_name` varchar(45) NOT NULL,
  `state_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`member_id`,`qualification_id`),
  KEY `fk_mtech_discipline1` (`discipline_id`),
  CONSTRAINT `fk_mtech_discipline1` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`discipline_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mtech_member_qualification1` FOREIGN KEY (`member_id`, `qualification_id`) REFERENCES `member_qualification` (`member_id`, `qualification_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mtech` */

/*Table structure for table `no_attendance_purpose` */

DROP TABLE IF EXISTS `no_attendance_purpose`;

CREATE TABLE `no_attendance_purpose` (
  `purpose_id` char(10) NOT NULL,
  `purpose` varchar(30) default NULL,
  PRIMARY KEY  (`purpose_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `no_attendance_purpose` */

/*Table structure for table `no_attendanceday` */

DROP TABLE IF EXISTS `no_attendanceday`;

CREATE TABLE `no_attendanceday` (
  `id` tinyint(4) NOT NULL auto_increment,
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `semester_id` tinyint(4) NOT NULL,
  `purpose_id` char(10) NOT NULL,
  `date_from` date default NULL,
  `date_upto` date default NULL,
  `remarks` varchar(30) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_no_attendanceday_no_attendance_purpose1` (`purpose_id`),
  KEY `fk_no_attendanceday_semester_degree1` (`department_id`,`degree_id`,`semester_id`),
  CONSTRAINT `fk_no_attendanceday_no_attendance_purpose1` FOREIGN KEY (`purpose_id`) REFERENCES `no_attendance_purpose` (`purpose_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_no_attendanceday_semester_degree1` FOREIGN KEY (`department_id`, `degree_id`, `semester_id`) REFERENCES `semester_degree` (`department_id`, `degree_id`, `semester_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `no_attendanceday` */

/*Table structure for table `period` */

DROP TABLE IF EXISTS `period`;

CREATE TABLE `period` (
  `period_id` smallint(5) unsigned NOT NULL auto_increment,
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `semester_id` tinyint(4) NOT NULL,
  `weekday_number` tinyint(3) unsigned NOT NULL,
  `period_number` tinyint(3) unsigned NOT NULL,
  `period_type_id` char(5) NOT NULL,
  PRIMARY KEY  (`period_id`),
  KEY `fk_period_period_info1` (`period_number`),
  KEY `fk_period_period_type1` (`period_type_id`),
  KEY `fk_period_semester_degree1` (`department_id`,`degree_id`,`semester_id`),
  KEY `fk_period_weekday1` (`weekday_number`),
  CONSTRAINT `fk_period_period_info1` FOREIGN KEY (`period_number`) REFERENCES `period_info` (`period_number`) ON UPDATE CASCADE,
  CONSTRAINT `fk_period_period_type1` FOREIGN KEY (`period_type_id`) REFERENCES `period_type` (`period_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_period_semester_degree1` FOREIGN KEY (`department_id`, `degree_id`, `semester_id`) REFERENCES `semester_degree` (`department_id`, `degree_id`, `semester_id`),
  CONSTRAINT `fk_period_weekday1` FOREIGN KEY (`weekday_number`) REFERENCES `weekday` (`weekday_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `period` */

/*Table structure for table `period_attendance` */

DROP TABLE IF EXISTS `period_attendance`;

CREATE TABLE `period_attendance` (
  `period_date` date NOT NULL,
  `timetable_id` int(10) unsigned NOT NULL,
  `staff_id` char(10) NOT NULL,
  `marked_date` date default NULL,
  PRIMARY KEY  (`period_date`,`timetable_id`),
  KEY `fk_period_attendance_timetable1` (`timetable_id`),
  CONSTRAINT `fk_period_attendance_timetable1` FOREIGN KEY (`timetable_id`) REFERENCES `timetable` (`timetable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attendance of Period';

/*Data for the table `period_attendance` */

/*Table structure for table `period_attendance2` */

DROP TABLE IF EXISTS `period_attendance2`;

CREATE TABLE `period_attendance2` (
  `attendance_id` int(10) unsigned NOT NULL auto_increment,
  `period_date` date default NULL,
  `department_id` char(5) default NULL,
  `programme_id` char(10) default NULL,
  `semester_id` tinyint(4) default NULL,
  `group_id` char(5) default NULL,
  `subject_code` char(10) default NULL,
  `subject_mode_id` char(5) default NULL,
  `duration` tinyint(4) default NULL,
  `weekday_number` tinyint(4) default NULL,
  `period_number` tinyint(4) default NULL,
  `period_type` enum('REGULAR','ADJUSTMENT','EXTRA CLASS') default NULL,
  `faculty_id` varchar(15) default NULL,
  `marked_date` timestamp NULL default CURRENT_TIMESTAMP,
  `remarks` varchar(120) default NULL,
  PRIMARY KEY  (`attendance_id`),
  UNIQUE KEY `department_id_UNIQUE` (`department_id`,`programme_id`,`semester_id`,`group_id`,`subject_code`,`subject_mode_id`,`period_date`,`period_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `period_attendance2` */

/*Table structure for table `period_info` */

DROP TABLE IF EXISTS `period_info`;

CREATE TABLE `period_info` (
  `period_number` tinyint(3) unsigned NOT NULL,
  `duration` tinyint(4) default NULL COMMENT 'Duration in minutes',
  `start_time` time default NULL,
  PRIMARY KEY  (`period_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Total number of periods in college';

/*Data for the table `period_info` */

/*Table structure for table `period_type` */

DROP TABLE IF EXISTS `period_type`;

CREATE TABLE `period_type` (
  `period_type_id` char(5) NOT NULL,
  `description` varchar(30) default NULL,
  PRIMARY KEY  (`period_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Break or anything else';

/*Data for the table `period_type` */

/*Table structure for table `qualification` */

DROP TABLE IF EXISTS `qualification`;

CREATE TABLE `qualification` (
  `qualification_id` int(10) unsigned NOT NULL,
  `qualification_name` varchar(45) NOT NULL COMMENT 'member''s qualification is stored in the table corresponding to qualification name\n',
  PRIMARY KEY  (`qualification_id`),
  UNIQUE KEY `name_UNIQUE` (`qualification_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `qualification` */

insert  into `qualification`(`qualification_id`,`qualification_name`) values (3,'BTECH'),(4,'DIPLOMA'),(1,'MATRIC'),(2,'TWELFTH');

/*Table structure for table `result_type` */

DROP TABLE IF EXISTS `result_type`;

CREATE TABLE `result_type` (
  `result_type_id` int(11) NOT NULL,
  `result_type_name` enum('regular_pass','regular_fail','re_evaluation_pass','re_evaluation_fail','re_appear_pass','re_appear_fail') default 'regular_pass',
  PRIMARY KEY  (`result_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `result_type` */

insert  into `result_type`(`result_type_id`,`result_type_name`) values (1,'regular_pass');

/*Table structure for table `semester_degree` */

DROP TABLE IF EXISTS `semester_degree`;

CREATE TABLE `semester_degree` (
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `semester_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`department_id`,`degree_id`,`semester_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `semester_degree` */

/*Table structure for table `state` */

DROP TABLE IF EXISTS `state`;

CREATE TABLE `state` (
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY  (`state_id`,`country_id`),
  KEY `fk_state_country1` (`country_id`),
  CONSTRAINT `fk_state_country1` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `state` */

/*Table structure for table `student_academic` */

DROP TABLE IF EXISTS `student_academic`;

CREATE TABLE `student_academic` (
  `student_roll_no` char(20) NOT NULL,
  PRIMARY KEY  (`student_roll_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `student_academic` */

insert  into `student_academic`(`student_roll_no`) values ('2308009'),('2308010'),('2308015');

/*Table structure for table `student_attendance` */

DROP TABLE IF EXISTS `student_attendance`;

CREATE TABLE `student_attendance` (
  `period_date` date NOT NULL,
  `timetable_id` int(10) unsigned NOT NULL,
  `student_roll_no` char(20) NOT NULL,
  PRIMARY KEY  (`student_roll_no`,`period_date`,`timetable_id`),
  KEY `fk_student_attendance_period_attendance1` (`period_date`,`timetable_id`),
  CONSTRAINT `fk_student_attendance_period_attendance1` FOREIGN KEY (`period_date`, `timetable_id`) REFERENCES `period_attendance` (`period_date`, `timetable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Attendance of Student';

/*Data for the table `student_attendance` */

/*Table structure for table `student_attendance2` */

DROP TABLE IF EXISTS `student_attendance2`;

CREATE TABLE `student_attendance2` (
  `attendance_id` int(10) unsigned NOT NULL,
  `student_roll_no` int(11) NOT NULL,
  `status` enum('ABSENT','SICK','LEAVE','SPORTS','PLACEMENT','FUNCTION','ONDUTY') default 'ABSENT',
  `remarks` varchar(120) default NULL,
  PRIMARY KEY  (`attendance_id`,`student_roll_no`),
  KEY `fk_student_attendance2_period_attendance21` (`attendance_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `student_attendance2` */

/*Table structure for table `student_class` */

DROP TABLE IF EXISTS `student_class`;

CREATE TABLE `student_class` (
  `member_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `roll_no` varchar(20) default NULL,
  `group_id` char(5) default NULL,
  `start_date` date default NULL,
  `completion_date` date default NULL,
  `is_initial_batch_identifier` tinyint(1) default NULL,
  PRIMARY KEY  (`member_id`,`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `student_class` */

insert  into `student_class`(`member_id`,`class_id`,`roll_no`,`group_id`,`start_date`,`completion_date`,`is_initial_batch_identifier`) values (1,1,'2308009','A1','2011-11-11',NULL,0);

/*Table structure for table `student_competitive_exam` */

DROP TABLE IF EXISTS `student_competitive_exam`;

CREATE TABLE `student_competitive_exam` (
  `member_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned NOT NULL,
  `roll_no` varchar(45) default NULL,
  `date` date default NULL,
  `total_score` int(11) default NULL,
  `all_india_rank` int(11) default NULL,
  PRIMARY KEY  (`member_id`,`exam_id`),
  KEY `fk_student_competitive_exam_competitive_exam1` (`exam_id`),
  KEY `fk_student_competitive_exam_members1` (`member_id`),
  CONSTRAINT `fk_student_competitive_exam_competitive_exam1` FOREIGN KEY (`exam_id`) REFERENCES `competitive_exam` (`exam_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_student_competitive_exam_members1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `student_competitive_exam` */

insert  into `student_competitive_exam`(`member_id`,`exam_id`,`roll_no`,`date`,`total_score`,`all_india_rank`) values (1,1,'84239','2008-04-08',1999,1),(1,2,'32141','2008-04-01',1000,1),(1,3,'32434','2010-02-03',1111,1);

/*Table structure for table `student_subject` */

DROP TABLE IF EXISTS `student_subject`;

CREATE TABLE `student_subject` (
  `student_subject_id` int(11) NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY  (`student_subject_id`),
  KEY `fk_student_subject_members1` (`member_id`),
  KEY `fk_student_subject_class_subject1` (`class_id`,`subject_id`),
  CONSTRAINT `fk_student_subject_members1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_student_subject_class_subject1` FOREIGN KEY (`class_id`, `subject_id`) REFERENCES `class_subject` (`class_id`, `subject_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `student_subject` */

insert  into `student_subject`(`student_subject_id`,`member_id`,`class_id`,`subject_id`) values (1,1,1,1);

/*Table structure for table `subject` */

DROP TABLE IF EXISTS `subject`;

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL auto_increment,
  `subject_code` char(10) NOT NULL,
  `abbr` varchar(15) default NULL,
  `subject_name` varchar(60) default NULL,
  `subject_type_id` char(5) NOT NULL,
  `is_optional` tinyint(1) default '0',
  `lecture_per_week` tinyint(4) unsigned default '0',
  `tutorial_per_week` tinyint(4) unsigned default '0',
  `practical_per_week` tinyint(4) unsigned default '0',
  `suggested_duration` tinyint(3) unsigned default '1',
  `subjectcol` varchar(45) default NULL,
  PRIMARY KEY  (`subject_id`),
  UNIQUE KEY `subject_code_UNIQUE` (`subject_code`),
  KEY `fk_subject_subject_type1` (`subject_type_id`),
  CONSTRAINT `fk_subject_subject_type1` FOREIGN KEY (`subject_type_id`) REFERENCES `subject_type` (`subject_type_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='All available subjects';

/*Data for the table `subject` */

insert  into `subject`(`subject_id`,`subject_code`,`abbr`,`subject_name`,`subject_type_id`,`is_optional`,`lecture_per_week`,`tutorial_per_week`,`practical_per_week`,`suggested_duration`,`subjectcol`) values (1,'CSE-303','NMS','NETWORK','1',0,0,0,0,1,NULL);

/*Table structure for table `subject_faculty` */

DROP TABLE IF EXISTS `subject_faculty`;

CREATE TABLE `subject_faculty` (
  `department_id` char(10) NOT NULL,
  `subject_code` char(10) NOT NULL,
  `subject_mode_id` char(5) NOT NULL,
  `staff_id` char(10) NOT NULL,
  PRIMARY KEY  (`subject_code`,`subject_mode_id`,`staff_id`,`department_id`),
  KEY `fk_table1_subject1` (`subject_code`),
  KEY `fk_table1_subject_mode1` (`subject_mode_id`),
  KEY `fk_subject_faculty_semester_degree1` (`department_id`),
  CONSTRAINT `fk_table1_subject1` FOREIGN KEY (`subject_code`) REFERENCES `subject` (`subject_code`) ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_subject_mode1` FOREIGN KEY (`subject_mode_id`) REFERENCES `subject_mode` (`subject_mode_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_subject_faculty_semester_degree1` FOREIGN KEY (`department_id`) REFERENCES `semester_degree` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `subject_faculty` */

/*Table structure for table `subject_mode` */

DROP TABLE IF EXISTS `subject_mode`;

CREATE TABLE `subject_mode` (
  `subject_mode_id` char(5) NOT NULL,
  `subject_mode_name` varchar(30) default NULL,
  `subject_type_id` char(5) NOT NULL,
  `group_together` tinyint(1) default '0',
  PRIMARY KEY  (`subject_mode_id`),
  KEY `fk_subject_mode_subject_type1` (`subject_type_id`),
  CONSTRAINT `fk_subject_mode_subject_type1` FOREIGN KEY (`subject_type_id`) REFERENCES `subject_type` (`subject_type_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `subject_mode` */

/*Table structure for table `subject_type` */

DROP TABLE IF EXISTS `subject_type`;

CREATE TABLE `subject_type` (
  `subject_type_id` char(5) NOT NULL,
  `description` varchar(30) default NULL,
  PRIMARY KEY  (`subject_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Type of Subject, theory or practical etc';

/*Data for the table `subject_type` */

insert  into `subject_type`(`subject_type_id`,`description`) values ('1','TH');

/*Table structure for table `test` */

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `test_id` tinyint(4) NOT NULL,
  `test_type_id` char(10) NOT NULL,
  `test_name` varchar(45) default NULL,
  `is_optional` tinyint(1) default '0',
  PRIMARY KEY  (`test_id`,`test_type_id`),
  KEY `fk_test_test_type1` (`test_type_id`),
  CONSTRAINT `fk_test_test_type1` FOREIGN KEY (`test_type_id`) REFERENCES `test_type` (`test_type_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `test` */

insert  into `test`(`test_id`,`test_type_id`,`test_name`,`is_optional`) values (1,'1','EXT',0);

/*Table structure for table `test_info` */

DROP TABLE IF EXISTS `test_info`;

CREATE TABLE `test_info` (
  `test_info_id` int(10) unsigned NOT NULL auto_increment,
  `test_type_id` char(10) NOT NULL,
  `test_id` tinyint(4) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `is_locked` tinyint(1) default '0',
  `is_optional` tinyint(1) default NULL,
  `time` time default NULL,
  `date_of_announcement` date default NULL,
  `date_of_conduct` date default NULL,
  `max_marks` tinyint(4) default NULL,
  `pass_marks` tinyint(4) default NULL,
  `remarks` varchar(45) default NULL,
  `subject_code` char(10) NOT NULL,
  `department_id` char(10) NOT NULL,
  `programme_id` char(10) NOT NULL,
  `semester_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`test_info_id`),
  UNIQUE KEY `test_info_id_UNIQUE` (`test_info_id`),
  KEY `fk_test_info_test1` (`test_id`,`test_type_id`),
  KEY `fk_test_info_class1` (`class_id`),
  KEY `fk_test_info_subject1` (`subject_id`),
  CONSTRAINT `fk_test_info_test1` FOREIGN KEY (`test_id`, `test_type_id`) REFERENCES `test` (`test_id`, `test_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_test_info_class1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_test_info_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `test_info` */

insert  into `test_info`(`test_info_id`,`test_type_id`,`test_id`,`class_id`,`subject_id`,`is_locked`,`is_optional`,`time`,`date_of_announcement`,`date_of_conduct`,`max_marks`,`pass_marks`,`remarks`,`subject_code`,`department_id`,`programme_id`,`semester_id`) values (1,'1',1,1,1,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CSE-303','CSE','BTECH',8);

/*Table structure for table `test_marks` */

DROP TABLE IF EXISTS `test_marks`;

CREATE TABLE `test_marks` (
  `member_id` int(11) NOT NULL,
  `test_info_id` int(10) unsigned NOT NULL,
  `marks_scored` tinyint(3) unsigned default NULL,
  `status` char(1) default 'P',
  PRIMARY KEY  (`test_info_id`,`member_id`),
  KEY `fk_test_marks_test_info1` (`test_info_id`),
  CONSTRAINT `fk_test_marks_test_info1` FOREIGN KEY (`test_info_id`) REFERENCES `test_info` (`test_info_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `test_marks` */

/*Table structure for table `test_type` */

DROP TABLE IF EXISTS `test_type`;

CREATE TABLE `test_type` (
  `test_type_id` char(10) NOT NULL,
  `test_type_name` varchar(45) default NULL,
  `default_max_marks` tinyint(4) default NULL,
  `default_pass_marks` tinyint(4) default NULL,
  PRIMARY KEY  (`test_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `test_type` */

insert  into `test_type`(`test_type_id`,`test_type_name`,`default_max_marks`,`default_pass_marks`) values ('1','EXT',100,40);

/*Table structure for table `timetable` */

DROP TABLE IF EXISTS `timetable`;

CREATE TABLE `timetable` (
  `timetable_id` int(10) unsigned NOT NULL auto_increment,
  `period_id` smallint(5) unsigned NOT NULL,
  `subject_code` char(10) NOT NULL,
  `subject_mode_id` char(5) NOT NULL,
  `staff_id` char(10) NOT NULL,
  `department_id` char(10) NOT NULL,
  `group_id` char(5) NOT NULL,
  `period_duration` tinyint(3) unsigned NOT NULL default '1' COMMENT 'count of periods covered e.g. 3',
  `periods_covered` set('1','2','3','4','5','6','7','8') NOT NULL COMMENT 'Period_numbers including itself e.g. 5,6,7 if period is 5 and period_duration is 3',
  `block_id` char(10) NOT NULL,
  `room_id` char(10) NOT NULL,
  `valid_from` date default NULL,
  `valid_upto` date default NULL,
  PRIMARY KEY  (`timetable_id`),
  KEY `fk_timetable_period1` (`period_id`),
  KEY `fk_timetable_subject_faculty1` (`subject_code`,`subject_mode_id`,`staff_id`,`department_id`),
  CONSTRAINT `fk_timetable_period1` FOREIGN KEY (`period_id`) REFERENCES `period` (`period_id`),
  CONSTRAINT `fk_timetable_subject_faculty1` FOREIGN KEY (`subject_code`, `subject_mode_id`, `staff_id`, `department_id`) REFERENCES `subject_faculty` (`subject_code`, `subject_mode_id`, `staff_id`, `department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Timetable schedule for attendance.';

/*Data for the table `timetable` */

/*Table structure for table `twelfth` */

DROP TABLE IF EXISTS `twelfth`;

CREATE TABLE `twelfth` (
  `member_id` int(10) unsigned NOT NULL,
  `qualification_id` int(10) unsigned NOT NULL,
  `discipline_id` char(10) NOT NULL,
  `board` varchar(10) NOT NULL,
  `board_roll_no` varchar(12) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `total_marks` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `pcm_percent` int(11) NOT NULL,
  `passing_year` year(4) NOT NULL,
  `school_rank` tinyint(4) NOT NULL,
  `remarks` varchar(120) default NULL,
  `institution` varchar(120) NOT NULL,
  `migration_date` date default NULL,
  `city_name` varchar(45) NOT NULL,
  `state_name` varchar(45) NOT NULL,
  PRIMARY KEY  (`member_id`,`qualification_id`),
  KEY `fk_twelfth_discipline1` (`discipline_id`),
  CONSTRAINT `fk_twelfth_discipline1` FOREIGN KEY (`discipline_id`) REFERENCES `discipline` (`discipline_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_twelfth_member_qualification1` FOREIGN KEY (`member_id`, `qualification_id`) REFERENCES `member_qualification` (`member_id`, `qualification_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `twelfth` */

insert  into `twelfth`(`member_id`,`qualification_id`,`discipline_id`,`board`,`board_roll_no`,`marks_obtained`,`total_marks`,`percentage`,`pcm_percent`,`passing_year`,`school_rank`,`remarks`,`institution`,`migration_date`,`city_name`,`state_name`) values (1,1,'1','cse','219',199,200,99,89,2008,1,NULL,'pta nai',NULL,'kalka','haryana'),(1,2,'1','cbse','1234',1000,1000,100,90,2007,1,NULL,'air force scholl',NULL,'ambala','haryana');

/*Table structure for table `weekday` */

DROP TABLE IF EXISTS `weekday`;

CREATE TABLE `weekday` (
  `weekday_number` tinyint(3) unsigned NOT NULL,
  `weekday_name` varchar(20) default NULL,
  PRIMARY KEY  (`weekday_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `weekday` */

/* Procedure structure for procedure `GetEnumChoiceList` */

/*!50003 DROP PROCEDURE IF EXISTS  `GetEnumChoiceList` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `GetEnumChoiceList`(IN dbName VARCHAR(80), IN tableName VARCHAR(80), IN columnName VARCHAR(80))
BEGIN
DECLARE subQuery TEXT;
DECLARE firstPos INT(11);
SET subQuery = (SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE (TABLE_SCHEMA = dbName AND TABLE_NAME = tableName AND COLUMN_NAME = columnName));
SET subQuery = SUBSTRING_INDEX(subQuery, "enum(", -1);
SET subQuery = SUBSTRING_INDEX(subQuery, ")", 1);
SET subQuery = REPLACE(subQuery,","," UNION SELECT ");
SET subQuery = INSERT(subQuery,1,0,"SELECT ");
SET firstPos = INSTR(subQuery, 'UNION');
SET subQuery = INSERT(subQuery, firstPos, 0, "AS `Options` ");
SET @enumProcQuery = (subQuery);
PREPARE STMT FROM @enumProcQuery;
EXECUTE STMT;
DEALLOCATE PREPARE STMT;
END */$$
DELIMITER ;

/* Procedure structure for procedure `markPeriodAttendance` */

/*!50003 DROP PROCEDURE IF EXISTS  `markPeriodAttendance` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `markPeriodAttendance`(IN in_period_date DATE,OUT out_status VARCHAR(30))
BEGIN
DECLARE tmp_weekday_number TINYINT;
	DECLARE CONTINUE HANDLER FOR 1062 SET out_status='Duplicate Entry';
	SET out_status='OK';
	
	SELECT  DAYOFWEEK(in_period_date)-1 INTO tmp_weekday_number;
	INSERT INTO period_attendance(period_date,timetable_id,staff_id,marked_date)    
	(SELECT in_period_date,timetable.timetable_id,timetable.staff_id,NULL
FROM timetable
  INNER JOIN period
    ON timetable.period_id = period.period_id
WHERE period.weekday_number =  tmp_weekday_number AND (CURDATE() BETWEEN timetable.valid_from AND timetable.valid_upto) AND timetable.period_id NOT IN(SELECT
  period_id
FROM period
  INNER JOIN no_attendanceday
    ON period.department_id = no_attendanceday.department_id
      AND period.degree_id = no_attendanceday.degree_id
      AND period.semester_id = no_attendanceday.semester_id
WHERE in_period_date BETWEEN no_attendanceday.date_from
    AND no_attendanceday.date_upto AND period.weekday_number = tmp_weekday_number));
END */$$
DELIMITER ;

/* Procedure structure for procedure `prd_att_deptt_wise` */

/*!50003 DROP PROCEDURE IF EXISTS  `prd_att_deptt_wise` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `prd_att_deptt_wise`(IN `prd_date` DATE)
    READS SQL DATA
BEGIN
SELECT
  exptd.*,
  IFNULL(mrkd.marked,0) AS marked,
  IFNULL(mrkd.last_marked_on,' ') AS last_marked
FROM (SELECT
        `timetable`.`department_id`,
        COUNT(1)                    AS total
      FROM `academics`.`period_attendance`
        INNER JOIN `academics`.`timetable`
          ON (`period_attendance`.`timetable_id` = `timetable`.`timetable_id`)
      WHERE `period_attendance`.period_date = prd_date
      GROUP BY `timetable`.`department_id`) AS exptd
  LEFT JOIN (SELECT
               IFNULL(`timetable`.`department_id`,' ') AS department_id ,
               COUNT(1)                          AS marked,
               `period_attendance`.`marked_date` AS last_marked_on
             FROM `academics`.`period_attendance`
               INNER JOIN `academics`.`timetable`
                 ON (`period_attendance`.`timetable_id` = `timetable`.`timetable_id`)
             WHERE `period_attendance`.period_date = prd_date
                 AND `period_attendance`.marked_date IS NOT NULL
      GROUP BY `timetable`.`department_id`) AS mrkd
    ON (exptd.department_id = mrkd.department_id);
END */$$
DELIMITER ;

/*Table structure for table `absent` */

DROP TABLE IF EXISTS `absent`;

/*!50001 DROP VIEW IF EXISTS `absent` */;
/*!50001 DROP TABLE IF EXISTS `absent` */;

/*!50001 CREATE TABLE  `absent`(
 `subject_code` char(10) ,
 `subject_mode_id` char(5) ,
 `department_id` char(10) ,
 `group_id` char(5) ,
 `student_roll_no` char(20) ,
 `period_date` date 
)*/;

/*Table structure for table `attendance` */

DROP TABLE IF EXISTS `attendance`;

/*!50001 DROP VIEW IF EXISTS `attendance` */;
/*!50001 DROP TABLE IF EXISTS `attendance` */;

/*!50001 CREATE TABLE  `attendance`(
 `subject_code` char(10) ,
 `subject_mode_id` char(5) ,
 `department_id` char(10) ,
 `group_id` char(5) ,
 `student_roll_no` char(20) ,
 `period_date` date 
)*/;

/*Table structure for table `delivered` */

DROP TABLE IF EXISTS `delivered`;

/*!50001 DROP VIEW IF EXISTS `delivered` */;
/*!50001 DROP TABLE IF EXISTS `delivered` */;

/*!50001 CREATE TABLE  `delivered`(
 `subject_code` char(10) ,
 `subject_mode_id` char(5) ,
 `department_id` char(10) ,
 `group_id` char(5) ,
 `period_date` date 
)*/;

/*Table structure for table `periodinfo` */

DROP TABLE IF EXISTS `periodinfo`;

/*!50001 DROP VIEW IF EXISTS `periodinfo` */;
/*!50001 DROP TABLE IF EXISTS `periodinfo` */;

/*!50001 CREATE TABLE  `periodinfo`(
 `period_date` varchar(40) ,
 `marked_date` varchar(40) ,
 `timetable_id` int(10) unsigned ,
 `staff_id` char(10) ,
 `subject_code` char(10) ,
 `subject_name` varchar(60) ,
 `subject_mode_name` varchar(30) ,
 `subject_mode_id` char(5) ,
 `weekday_number` tinyint(3) unsigned ,
 `period_number` tinyint(3) unsigned ,
 `department_id` char(10) ,
 `degree_id` char(10) ,
 `semester_id` tinyint(4) 
)*/;

/*Table structure for table `unmarkedattendance` */

DROP TABLE IF EXISTS `unmarkedattendance`;

/*!50001 DROP VIEW IF EXISTS `unmarkedattendance` */;
/*!50001 DROP TABLE IF EXISTS `unmarkedattendance` */;

/*!50001 CREATE TABLE  `unmarkedattendance`(
 `period_date` varchar(40) ,
 `timetable_id` int(10) unsigned ,
 `staff_id` char(10) ,
 `subject_code` char(10) ,
 `subject_name` varchar(60) ,
 `subject_mode_name` varchar(30) ,
 `subject_mode_id` char(5) ,
 `weekday_number` tinyint(3) unsigned ,
 `period_number` tinyint(3) unsigned ,
 `department_id` char(10) ,
 `degree_id` char(10) ,
 `semester_id` tinyint(4) 
)*/;

/*View structure for view absent */

/*!50001 DROP TABLE IF EXISTS `absent` */;
/*!50001 DROP VIEW IF EXISTS `absent` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `absent` AS (select `timetable`.`subject_code` AS `subject_code`,`timetable`.`subject_mode_id` AS `subject_mode_id`,`timetable`.`department_id` AS `department_id`,`timetable`.`group_id` AS `group_id`,`student_attendance`.`student_roll_no` AS `student_roll_no`,`student_attendance`.`period_date` AS `period_date` from (`student_attendance` join `timetable` on((`student_attendance`.`timetable_id` = `timetable`.`timetable_id`)))) */;

/*View structure for view attendance */

/*!50001 DROP TABLE IF EXISTS `attendance` */;
/*!50001 DROP VIEW IF EXISTS `attendance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `attendance` AS (select `delivered`.`subject_code` AS `subject_code`,`delivered`.`subject_mode_id` AS `subject_mode_id`,`delivered`.`department_id` AS `department_id`,`delivered`.`group_id` AS `group_id`,`absent`.`student_roll_no` AS `student_roll_no`,`delivered`.`period_date` AS `period_date` from (`delivered` left join `absent` on(((`absent`.`subject_code` = convert(`delivered`.`subject_code` using utf8)) and (`absent`.`subject_mode_id` = convert(`delivered`.`subject_mode_id` using utf8)) and (`absent`.`department_id` = convert(`delivered`.`department_id` using utf8)) and (`absent`.`group_id` = convert(`delivered`.`group_id` using utf8)) and (`absent`.`period_date` = `delivered`.`period_date`))))) */;

/*View structure for view delivered */

/*!50001 DROP TABLE IF EXISTS `delivered` */;
/*!50001 DROP VIEW IF EXISTS `delivered` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `delivered` AS (select `timetable`.`subject_code` AS `subject_code`,`timetable`.`subject_mode_id` AS `subject_mode_id`,`timetable`.`department_id` AS `department_id`,`timetable`.`group_id` AS `group_id`,`period_attendance`.`period_date` AS `period_date` from (`period_attendance` join `timetable` on(((`period_attendance`.`timetable_id` = `timetable`.`timetable_id`) and (`period_attendance`.`marked_date` is not null)))) group by `timetable`.`subject_code`,`timetable`.`subject_mode_id`,`timetable`.`department_id`,`timetable`.`group_id`) */;

/*View structure for view periodinfo */

/*!50001 DROP TABLE IF EXISTS `periodinfo` */;
/*!50001 DROP VIEW IF EXISTS `periodinfo` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `periodinfo` AS select date_format(`period_attendance`.`period_date`,_utf8'%d/%b/%Y') AS `period_date`,date_format(`period_attendance`.`marked_date`,_utf8'%d/%b/%Y') AS `marked_date`,`timetable`.`timetable_id` AS `timetable_id`,`period_attendance`.`staff_id` AS `staff_id`,`timetable`.`subject_code` AS `subject_code`,`subject`.`subject_name` AS `subject_name`,`subject_mode`.`subject_mode_name` AS `subject_mode_name`,`timetable`.`subject_mode_id` AS `subject_mode_id`,`period`.`weekday_number` AS `weekday_number`,`period`.`period_number` AS `period_number`,`period`.`department_id` AS `department_id`,`period`.`degree_id` AS `degree_id`,`period`.`semester_id` AS `semester_id` from ((((`period_attendance` join `timetable` on((`period_attendance`.`timetable_id` = `timetable`.`timetable_id`))) join `period` on((`timetable`.`period_id` = `period`.`period_id`))) join `subject` on((`subject`.`subject_code` = `timetable`.`subject_code`))) join `subject_mode` on((`subject_mode`.`subject_mode_id` = `timetable`.`subject_mode_id`))) order by `period_attendance`.`period_date` */;

/*View structure for view unmarkedattendance */

/*!50001 DROP TABLE IF EXISTS `unmarkedattendance` */;
/*!50001 DROP VIEW IF EXISTS `unmarkedattendance` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unmarkedattendance` AS select date_format(`period_attendance`.`period_date`,_utf8'%d/%b/%Y') AS `period_date`,`timetable`.`timetable_id` AS `timetable_id`,`period_attendance`.`staff_id` AS `staff_id`,`timetable`.`subject_code` AS `subject_code`,`subject`.`subject_name` AS `subject_name`,`subject_mode`.`subject_mode_name` AS `subject_mode_name`,`timetable`.`subject_mode_id` AS `subject_mode_id`,`period`.`weekday_number` AS `weekday_number`,`period`.`period_number` AS `period_number`,`period`.`department_id` AS `department_id`,`period`.`degree_id` AS `degree_id`,`period`.`semester_id` AS `semester_id` from ((((`period_attendance` join `timetable` on((`period_attendance`.`timetable_id` = `timetable`.`timetable_id`))) join `period` on((`timetable`.`period_id` = `period`.`period_id`))) join `subject` on((`subject`.`subject_code` = `timetable`.`subject_code`))) join `subject_mode` on((`subject_mode`.`subject_mode_id` = `timetable`.`subject_mode_id`))) where isnull(`period_attendance`.`marked_date`) order by `period_attendance`.`period_date` */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
