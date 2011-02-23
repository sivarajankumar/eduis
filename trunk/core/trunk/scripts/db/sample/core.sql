/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : core

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2011-02-19 12:41:20
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `academic_session`
-- ----------------------------
DROP TABLE IF EXISTS `academic_session`;
CREATE TABLE `academic_session` (
  `academic_year` year(4) NOT NULL,
  `semester_type` char(10) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`academic_year`,`semester_type`),
  KEY `fk_academic_session_semester_type1` (`semester_type`),
  CONSTRAINT `academic_session_ibfk_1` FOREIGN KEY (`semester_type`) REFERENCES `semester_type` (`semester_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_academic_session_semester_type1` FOREIGN KEY (`semester_type`) REFERENCES `semester_type` (`semester_type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of academic_session
-- ----------------------------
INSERT INTO `academic_session` VALUES ('2009', 'even', '2010-02-10', '2010-07-25');
INSERT INTO `academic_session` VALUES ('2009', 'odd', '2009-08-15', '2010-02-09');
INSERT INTO `academic_session` VALUES ('2010', 'even', '2011-01-20', '2011-04-20');
INSERT INTO `academic_session` VALUES ('2010', 'odd', '2010-07-26', '2010-11-30');

-- ----------------------------
-- Table structure for `batch`
-- ----------------------------
DROP TABLE IF EXISTS `batch`;
CREATE TABLE `batch` (
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `batch_start` year(4) NOT NULL,
  `batch_number` tinyint(4) unsigned DEFAULT NULL,
  `is_active` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`department_id`,`degree_id`,`batch_start`),
  KEY `fk_batch_degree_department1` (`department_id`,`degree_id`),
  CONSTRAINT `batch_ibfk_1` FOREIGN KEY (`department_id`, `degree_id`) REFERENCES `degree_department` (`department_id`, `degree_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_batch_degree_department1` FOREIGN KEY (`department_id`, `degree_id`) REFERENCES `degree_department` (`department_id`, `degree_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of batch
-- ----------------------------
INSERT INTO `batch` VALUES ('APPSC', 'BTECH', '2009', '1', '1');
INSERT INTO `batch` VALUES ('BT', 'BTECH', '2006', '5', '0');
INSERT INTO `batch` VALUES ('BT', 'BTECH', '2007', '6', '1');
INSERT INTO `batch` VALUES ('BT', 'BTECH', '2008', '7', '1');
INSERT INTO `batch` VALUES ('BT', 'BTECH', '2009', '8', '1');
INSERT INTO `batch` VALUES ('BT', 'BTECH', '2010', null, '1');
INSERT INTO `batch` VALUES ('BT', 'MTECH', '2009', '1', '1');
INSERT INTO `batch` VALUES ('BT', 'MTECH', '2010', '2', '1');
INSERT INTO `batch` VALUES ('CSE', 'BTECH', '2006', '5', '0');
INSERT INTO `batch` VALUES ('CSE', 'BTECH', '2007', '6', '1');
INSERT INTO `batch` VALUES ('CSE', 'BTECH', '2008', '7', '1');
INSERT INTO `batch` VALUES ('CSE', 'BTECH', '2009', '8', '1');
INSERT INTO `batch` VALUES ('CSE', 'BTECH', '2010', null, '1');
INSERT INTO `batch` VALUES ('CSE', 'MTECH', '2010', '1', '1');
INSERT INTO `batch` VALUES ('ECE', 'BTECH', '2006', '5', '0');
INSERT INTO `batch` VALUES ('ECE', 'BTECH', '2007', '6', '1');
INSERT INTO `batch` VALUES ('ECE', 'BTECH', '2008', '7', '1');
INSERT INTO `batch` VALUES ('ECE', 'BTECH', '2009', '8', '1');
INSERT INTO `batch` VALUES ('ECE', 'BTECH', '2010', null, '1');
INSERT INTO `batch` VALUES ('ECE', 'MTECH', '2009', '1', '1');
INSERT INTO `batch` VALUES ('ECE', 'MTECH', '2010', '2', '1');
INSERT INTO `batch` VALUES ('ME', 'BTECH', '2004', '1', '0');
INSERT INTO `batch` VALUES ('ME', 'BTECH', '2005', '2', '0');
INSERT INTO `batch` VALUES ('ME', 'BTECH', '2006', '3', '0');
INSERT INTO `batch` VALUES ('ME', 'BTECH', '2007', '4', '1');
INSERT INTO `batch` VALUES ('ME', 'BTECH', '2008', '5', '1');
INSERT INTO `batch` VALUES ('ME', 'BTECH', '2009', '6', '1');
INSERT INTO `batch` VALUES ('ME', 'BTECH', '2010', null, '1');
INSERT INTO `batch` VALUES ('ME', 'MTECH', '2010', '1', '1');

-- ----------------------------
-- Table structure for `batch_semester`
-- ----------------------------
DROP TABLE IF EXISTS `batch_semester`;
CREATE TABLE `batch_semester` (
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `batch_start` year(4) NOT NULL,
  `semester_id` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`department_id`,`degree_id`,`batch_start`,`semester_id`),
  KEY `fk_batch_semester_batch1` (`department_id`,`degree_id`,`batch_start`) USING BTREE,
  KEY `fk_batch_semester_semester_degree1` (`semester_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='batch enrolled in semester';

-- ----------------------------
-- Records of batch_semester
-- ----------------------------
INSERT INTO `batch_semester` VALUES ('BT', 'BTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('BT', 'MTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('CSE', 'BTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('CSE', 'MTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('ECE', 'BTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('ECE', 'MTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('ME', 'BTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('ME', 'MTECH', '2010', '2');
INSERT INTO `batch_semester` VALUES ('BT', 'BTECH', '2009', '4');
INSERT INTO `batch_semester` VALUES ('BT', 'MTECH', '2009', '4');
INSERT INTO `batch_semester` VALUES ('CSE', 'BTECH', '2009', '4');
INSERT INTO `batch_semester` VALUES ('ECE', 'BTECH', '2009', '4');
INSERT INTO `batch_semester` VALUES ('ECE', 'MTECH', '2009', '4');
INSERT INTO `batch_semester` VALUES ('ME', 'BTECH', '2009', '4');
INSERT INTO `batch_semester` VALUES ('BT', 'BTECH', '2008', '6');
INSERT INTO `batch_semester` VALUES ('CSE', 'BTECH', '2008', '6');
INSERT INTO `batch_semester` VALUES ('ECE', 'BTECH', '2008', '6');
INSERT INTO `batch_semester` VALUES ('ME', 'BTECH', '2008', '6');
INSERT INTO `batch_semester` VALUES ('BT', 'BTECH', '2007', '8');
INSERT INTO `batch_semester` VALUES ('CSE', 'BTECH', '2007', '8');
INSERT INTO `batch_semester` VALUES ('ECE', 'BTECH', '2007', '8');
INSERT INTO `batch_semester` VALUES ('ME', 'BTECH', '2007', '8');

-- ----------------------------
-- Table structure for `block`
-- ----------------------------
DROP TABLE IF EXISTS `block`;
CREATE TABLE `block` (
  `block_id` char(10) NOT NULL,
  `block_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Blocks or Buildings of College';

-- ----------------------------
-- Records of block
-- ----------------------------
INSERT INTO `block` VALUES ('ADM_B1', 'Admin Block 1');
INSERT INTO `block` VALUES ('ADM_B2', 'Admin Block 2');

-- ----------------------------
-- Table structure for `configs`
-- ----------------------------
DROP TABLE IF EXISTS `configs`;
CREATE TABLE `configs` (
  `parameter` varchar(30) NOT NULL,
  `value` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It should be internal purposes, by events or procedures etc';

-- ----------------------------
-- Records of configs
-- ----------------------------
INSERT INTO `configs` VALUES ('EVNT_PRD_ATT', 'TRUE');

-- ----------------------------
-- Table structure for `degree`
-- ----------------------------
DROP TABLE IF EXISTS `degree`;
CREATE TABLE `degree` (
  `degree_id` char(10) NOT NULL,
  `degree_name` varchar(30) DEFAULT NULL,
  `total_semesters` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`degree_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All degrees provided by college.';

-- ----------------------------
-- Records of degree
-- ----------------------------
INSERT INTO `degree` VALUES ('BTECH', 'Bechlor in Technology', '8');
INSERT INTO `degree` VALUES ('MTECH', 'Master in Technology', '4');

-- ----------------------------
-- Table structure for `degree_department`
-- ----------------------------
DROP TABLE IF EXISTS `degree_department`;
CREATE TABLE `degree_department` (
  `degree_id` char(10) NOT NULL,
  `department_id` char(10) NOT NULL,
  PRIMARY KEY (`department_id`,`degree_id`),
  KEY `fk_degree_department_department1` (`department_id`) USING BTREE,
  KEY `fk_degree_department_degree1` (`degree_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Degrees provided by departments.';

-- ----------------------------
-- Records of degree_department
-- ----------------------------
INSERT INTO `degree_department` VALUES ('BTECH', 'APPSC');
INSERT INTO `degree_department` VALUES ('BTECH', 'BT');
INSERT INTO `degree_department` VALUES ('MTECH', 'BT');
INSERT INTO `degree_department` VALUES ('BTECH', 'CSE');
INSERT INTO `degree_department` VALUES ('MTECH', 'CSE');
INSERT INTO `degree_department` VALUES ('BTECH', 'ECE');
INSERT INTO `degree_department` VALUES ('MTECH', 'ECE');
INSERT INTO `degree_department` VALUES ('BTECH', 'ME');
INSERT INTO `degree_department` VALUES ('MTECH', 'ME');

-- ----------------------------
-- Table structure for `department`
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `department_id` char(10) NOT NULL,
  `department_name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All educational departments of College';

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('APPSC', 'APPLIED SCIENCE');
INSERT INTO `department` VALUES ('BT', 'BIOTECH');
INSERT INTO `department` VALUES ('CSE', 'COMPUTER SCIENCE AND ENGINEERING');
INSERT INTO `department` VALUES ('ECE', 'ELECTRONICS AND COMMUNICATION');
INSERT INTO `department` VALUES ('LIB', 'LIBRARY');
INSERT INTO `department` VALUES ('ME', 'MECHANICAL ENGINEERING');
INSERT INTO `department` VALUES ('MGMT', 'MANAGEMENT');

-- ----------------------------
-- Table structure for `designation`
-- ----------------------------
DROP TABLE IF EXISTS `designation`;
CREATE TABLE `designation` (
  `designation_id` char(5) NOT NULL,
  `designation_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`designation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of designation
-- ----------------------------
INSERT INTO `designation` VALUES ('AP', 'Assitant Professor');
INSERT INTO `designation` VALUES ('FAC', 'Faculty');
INSERT INTO `designation` VALUES ('HOD', 'Head of Department');
INSERT INTO `designation` VALUES ('Prof', 'Professor');
INSERT INTO `designation` VALUES ('RA', 'Research Associate');
INSERT INTO `designation` VALUES ('REG', 'Registrar');

-- ----------------------------
-- Table structure for `gender`
-- ----------------------------
DROP TABLE IF EXISTS `gender`;
CREATE TABLE `gender` (
  `gender_id` char(1) NOT NULL,
  `gender_name` char(7) DEFAULT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Genders : Just Male and Female';

-- ----------------------------
-- Records of gender
-- ----------------------------
INSERT INTO `gender` VALUES ('F', 'Female');
INSERT INTO `gender` VALUES ('M', 'Male');

-- ----------------------------
-- Table structure for `groups`
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `group_id` char(5) NOT NULL,
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `fk_Groups_degree_department1` (`department_id`,`degree_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Groups in each Department''s Degree';

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('ALL', 'ALL', 'ALL');
INSERT INTO `groups` VALUES ('C1', 'BT', 'BTECH');
INSERT INTO `groups` VALUES ('C2', 'BT', 'BTECH');
INSERT INTO `groups` VALUES ('C3', 'BT', 'BTECH');
INSERT INTO `groups` VALUES ('F1', 'BT', 'MTECH');
INSERT INTO `groups` VALUES ('A1', 'CSE', 'BTECH');
INSERT INTO `groups` VALUES ('A2', 'CSE', 'BTECH');
INSERT INTO `groups` VALUES ('A3', 'CSE', 'BTECH');
INSERT INTO `groups` VALUES ('H1', 'CSE', 'MTECH');
INSERT INTO `groups` VALUES ('B1', 'ECE', 'BTECH');
INSERT INTO `groups` VALUES ('B2', 'ECE', 'BTECH');
INSERT INTO `groups` VALUES ('B3', 'ECE', 'BTECH');
INSERT INTO `groups` VALUES ('E1', 'ECE', 'MTECH');
INSERT INTO `groups` VALUES ('D1', 'ME', 'BTECH');
INSERT INTO `groups` VALUES ('D2', 'ME', 'BTECH');
INSERT INTO `groups` VALUES ('D3', 'ME', 'BTECH');
INSERT INTO `groups` VALUES ('G1', 'ME', 'MTECH');

-- ----------------------------
-- Table structure for `holiday`
-- ----------------------------
DROP TABLE IF EXISTS `holiday`;
CREATE TABLE `holiday` (
  `date_from` date NOT NULL,
  `date_upto` date DEFAULT NULL,
  `purpose` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`date_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='List of Holidays.';

-- ----------------------------
-- Records of holiday
-- ----------------------------
INSERT INTO `holiday` VALUES ('2010-01-26', '2010-01-26', 'Republic Day');
INSERT INTO `holiday` VALUES ('2010-02-12', '2010-02-12', 'Mahashivra');
INSERT INTO `holiday` VALUES ('2010-02-27', '2010-03-01', 'Holi');
INSERT INTO `holiday` VALUES ('2010-03-24', '2010-03-24', 'Ram Navami');
INSERT INTO `holiday` VALUES ('2010-09-02', '2010-09-02', 'Janmashtami ');
INSERT INTO `holiday` VALUES ('2010-09-15', '2010-09-15', 'Engineering Day');
INSERT INTO `holiday` VALUES ('2010-10-01', '2010-10-01', 'Holiday');
INSERT INTO `holiday` VALUES ('2010-10-02', '2010-10-02', 'Mahatma Gandhi Jynti');
INSERT INTO `holiday` VALUES ('2010-10-16', '2010-10-07', 'Dusshera');
INSERT INTO `holiday` VALUES ('2010-11-05', '2010-11-06', 'Diwali');

-- ----------------------------
-- Table structure for `module`
-- ----------------------------
DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `module_id` varchar(20) NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of module
-- ----------------------------
INSERT INTO `module` VALUES ('core');

-- ----------------------------
-- Table structure for `mod_action`
-- ----------------------------
DROP TABLE IF EXISTS `mod_action`;
CREATE TABLE `mod_action` (
  `module_id` varchar(20) NOT NULL,
  `controller_id` varchar(20) NOT NULL,
  `action_id` varchar(20) NOT NULL,
  PRIMARY KEY (`action_id`,`controller_id`,`module_id`),
  KEY `fk_mod_action_mod_controller1` (`controller_id`,`module_id`),
  CONSTRAINT `fk_mod_action_mod_controller1` FOREIGN KEY (`controller_id`, `module_id`) REFERENCES `mod_controller` (`controller_id`, `module_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_action
-- ----------------------------
INSERT INTO `mod_action` VALUES ('core', 'batch', 'index');
INSERT INTO `mod_action` VALUES ('core', 'batchsemester', 'index');
INSERT INTO `mod_action` VALUES ('core', 'block', 'index');
INSERT INTO `mod_action` VALUES ('core', 'degree', 'index');
INSERT INTO `mod_action` VALUES ('core', 'degreedepartment', 'index');
INSERT INTO `mod_action` VALUES ('core', 'dept', 'index');
INSERT INTO `mod_action` VALUES ('core', 'groups', 'index');
INSERT INTO `mod_action` VALUES ('core', 'holiday', 'index');
INSERT INTO `mod_action` VALUES ('core', 'index', 'index');
INSERT INTO `mod_action` VALUES ('core', 'room', 'index');
INSERT INTO `mod_action` VALUES ('core', 'roomtype', 'index');
INSERT INTO `mod_action` VALUES ('core', 'semeserdegree', 'index');
INSERT INTO `mod_action` VALUES ('core', 'semester', 'index');
INSERT INTO `mod_action` VALUES ('core', 'session', 'index');
INSERT INTO `mod_action` VALUES ('core', 'staff', 'index');
INSERT INTO `mod_action` VALUES ('core', 'staffpersonal', 'index');
INSERT INTO `mod_action` VALUES ('core', 'student', 'index');
INSERT INTO `mod_action` VALUES ('core', 'studentpersonal', 'index');
INSERT INTO `mod_action` VALUES ('core', 'weekday', 'index');

-- ----------------------------
-- Table structure for `mod_controller`
-- ----------------------------
DROP TABLE IF EXISTS `mod_controller`;
CREATE TABLE `mod_controller` (
  `module_id` varchar(20) NOT NULL,
  `controller_id` varchar(20) NOT NULL,
  PRIMARY KEY (`controller_id`,`module_id`),
  KEY `fk_mod_controller_module1` (`module_id`),
  CONSTRAINT `fk_mod_controller_module1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_controller
-- ----------------------------
INSERT INTO `mod_controller` VALUES ('core', 'batch');
INSERT INTO `mod_controller` VALUES ('core', 'batchsemester');
INSERT INTO `mod_controller` VALUES ('core', 'block');
INSERT INTO `mod_controller` VALUES ('core', 'degree');
INSERT INTO `mod_controller` VALUES ('core', 'degreedepartment');
INSERT INTO `mod_controller` VALUES ('core', 'dept');
INSERT INTO `mod_controller` VALUES ('core', 'groups');
INSERT INTO `mod_controller` VALUES ('core', 'holiday');
INSERT INTO `mod_controller` VALUES ('core', 'index');
INSERT INTO `mod_controller` VALUES ('core', 'room');
INSERT INTO `mod_controller` VALUES ('core', 'roomtype');
INSERT INTO `mod_controller` VALUES ('core', 'semeserdegree');
INSERT INTO `mod_controller` VALUES ('core', 'semester');
INSERT INTO `mod_controller` VALUES ('core', 'session');
INSERT INTO `mod_controller` VALUES ('core', 'staff');
INSERT INTO `mod_controller` VALUES ('core', 'staffpersonal');
INSERT INTO `mod_controller` VALUES ('core', 'student');
INSERT INTO `mod_controller` VALUES ('core', 'studentpersonal');
INSERT INTO `mod_controller` VALUES ('core', 'weekday');

-- ----------------------------
-- Table structure for `mod_role`
-- ----------------------------
DROP TABLE IF EXISTS `mod_role`;
CREATE TABLE `mod_role` (
  `role_id` varchar(20) NOT NULL,
  `role_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mod_role
-- ----------------------------

-- ----------------------------
-- Table structure for `qualification`
-- ----------------------------
DROP TABLE IF EXISTS `qualification`;
CREATE TABLE `qualification` (
  `qualification_id` char(5) NOT NULL,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`qualification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='All possible qualifications.';

-- ----------------------------
-- Records of qualification
-- ----------------------------

-- ----------------------------
-- Table structure for `role_resource`
-- ----------------------------
DROP TABLE IF EXISTS `role_resource`;
CREATE TABLE `role_resource` (
  `role_id` varchar(20) NOT NULL,
  `module_id` varchar(20) NOT NULL,
  `controller_id` varchar(20) NOT NULL,
  `action_id` varchar(20) NOT NULL,
  PRIMARY KEY (`action_id`,`controller_id`,`module_id`,`role_id`),
  KEY `fk_role_resource_mod_action1` (`action_id`,`controller_id`,`module_id`),
  KEY `fk_role_resource_mod_role1` (`role_id`),
  CONSTRAINT `fk_role_resource_mod_action1` FOREIGN KEY (`action_id`, `controller_id`, `module_id`) REFERENCES `mod_action` (`action_id`, `controller_id`, `module_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_role_resource_mod_role1` FOREIGN KEY (`role_id`) REFERENCES `mod_role` (`role_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_resource
-- ----------------------------

-- ----------------------------
-- Table structure for `room`
-- ----------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE `room` (
  `block_id` char(10) NOT NULL,
  `room_id` char(10) NOT NULL,
  `room_type_id` char(10) NOT NULL,
  `capacity` tinyint(4) DEFAULT NULL,
  `remark` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`room_id`,`block_id`),
  KEY `fk_room_room_type1` (`room_type_id`) USING BTREE,
  KEY `fk_room_block1` (`block_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Every room in College which are used for education purpose.';

-- ----------------------------
-- Records of room
-- ----------------------------
INSERT INTO `room` VALUES ('ADM_B1', '1', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '1', 'LAB', '22', '');
INSERT INTO `room` VALUES ('ADM_B2', '10', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '11', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '12', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '16', 'TR', '25', '');
INSERT INTO `room` VALUES ('ADM_B2', '17', 'TR', '25', '');
INSERT INTO `room` VALUES ('ADM_B2', '18', 'TR', '25', '');
INSERT INTO `room` VALUES ('ADM_B2', '19', 'TR', '25', '');
INSERT INTO `room` VALUES ('ADM_B1', '2', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '2', 'LAB', '22', '');
INSERT INTO `room` VALUES ('ADM_B1', '3', 'DH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '3', 'LAB', '22', '');
INSERT INTO `room` VALUES ('ADM_B2', '4', 'LAB', '22', '');
INSERT INTO `room` VALUES ('ADM_B2', '5', 'LAB', '22', '');
INSERT INTO `room` VALUES ('ADM_B1', '6', 'LAB', '25', '');
INSERT INTO `room` VALUES ('ADM_B2', '6', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '7', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '8', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', '9', 'LH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', 'AC', 'LAB', '25', '');
INSERT INTO `room` VALUES ('ADM_B2', 'FM', 'LAB', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', 'HT', 'LAB', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', 'IE', 'LAB', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', 'SH', 'SH', '70', '');
INSERT INTO `room` VALUES ('ADM_B2', 'TE', 'LAB', '70', '');

-- ----------------------------
-- Table structure for `room_type`
-- ----------------------------
DROP TABLE IF EXISTS `room_type`;
CREATE TABLE `room_type` (
  `room_type_id` char(10) NOT NULL,
  `room_type_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`room_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Types of room';

-- ----------------------------
-- Records of room_type
-- ----------------------------
INSERT INTO `room_type` VALUES ('DH', 'Drawing Hall');
INSERT INTO `room_type` VALUES ('DR', 'Dark Room');
INSERT INTO `room_type` VALUES ('LAB', 'Laboratory');
INSERT INTO `room_type` VALUES ('LH', 'Lecture Hall');
INSERT INTO `room_type` VALUES ('LIBH', 'Library Hall');
INSERT INTO `room_type` VALUES ('SH', 'Seminar Hall');
INSERT INTO `room_type` VALUES ('TR', 'Tutorial Room');

-- ----------------------------
-- Table structure for `semester`
-- ----------------------------
DROP TABLE IF EXISTS `semester`;
CREATE TABLE `semester` (
  `semester_id` tinyint(4) unsigned NOT NULL,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`semester_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='It is just a semester numbers table.';

-- ----------------------------
-- Records of semester
-- ----------------------------
INSERT INTO `semester` VALUES ('1', 'One');
INSERT INTO `semester` VALUES ('2', 'Two');
INSERT INTO `semester` VALUES ('3', 'Three');
INSERT INTO `semester` VALUES ('4', 'Four');
INSERT INTO `semester` VALUES ('5', 'Five');
INSERT INTO `semester` VALUES ('6', 'Six');
INSERT INTO `semester` VALUES ('7', 'Seven');
INSERT INTO `semester` VALUES ('8', 'Eight');

-- ----------------------------
-- Table structure for `semester_degree`
-- ----------------------------
DROP TABLE IF EXISTS `semester_degree`;
CREATE TABLE `semester_degree` (
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `semester_id` tinyint(4) unsigned NOT NULL,
  `semester_type_id` char(10) NOT NULL,
  `semester_duration` tinyint(4) unsigned DEFAULT NULL,
  `handled_by_dept` char(10) NOT NULL,
  PRIMARY KEY (`semester_id`,`department_id`,`degree_id`),
  KEY `fk_semester_degree_semester1` (`semester_id`) USING BTREE,
  KEY `fk_semester_degree_semester_type1` (`semester_type_id`) USING BTREE,
  KEY `fk_semester_degree_degree_department1` (`department_id`,`degree_id`) USING BTREE,
  KEY `fk_semester_degree_degree_department2` (`handled_by_dept`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='degree wise semesters';

-- ----------------------------
-- Records of semester_degree
-- ----------------------------
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '1', 'ODD', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('BT', 'MTECH', '1', 'ODD', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '1', 'ODD', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('CSE', 'MTECH', '1', 'ODD', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '1', 'ODD', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('ECE', 'MTECH', '1', 'ODD', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '1', 'ODD', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('ME', 'MTECH', '1', 'ODD', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '2', 'EVEN', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('BT', 'MTECH', '2', 'EVEN', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '2', 'EVEN', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('CSE', 'MTECH', '2', 'EVEN', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '2', 'EVEN', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('ECE', 'MTECH', '2', 'EVEN', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '2', 'EVEN', '6', 'APPSC');
INSERT INTO `semester_degree` VALUES ('ME', 'MTECH', '2', 'EVEN', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '3', 'ODD', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('BT', 'MTECH', '3', 'ODD', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '3', 'ODD', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('CSE', 'MTECH', '3', 'ODD', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '3', 'ODD', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ECE', 'MTECH', '3', 'ODD', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '3', 'ODD', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('ME', 'MTECH', '3', 'ODD', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '4', 'EVEN', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('BT', 'MTECH', '4', 'EVEN', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '4', 'EVEN', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('CSE', 'MTECH', '4', 'EVEN', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '4', 'EVEN', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ECE', 'MTECH', '4', 'EVEN', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '4', 'EVEN', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('ME', 'MTECH', '4', 'EVEN', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '5', 'ODD', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '5', 'ODD', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '5', 'ODD', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '5', 'ODD', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '6', 'EVEN', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '6', 'EVEN', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '6', 'EVEN', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '6', 'EVEN', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '7', 'ODD', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '7', 'ODD', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '7', 'ODD', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '7', 'ODD', '6', 'ME');
INSERT INTO `semester_degree` VALUES ('BT', 'BTECH', '8', 'EVEN', '6', 'BT');
INSERT INTO `semester_degree` VALUES ('CSE', 'BTECH', '8', 'EVEN', '6', 'CSE');
INSERT INTO `semester_degree` VALUES ('ECE', 'BTECH', '8', 'EVEN', '6', 'ECE');
INSERT INTO `semester_degree` VALUES ('ME', 'BTECH', '8', 'EVEN', '6', 'ME');

-- ----------------------------
-- Table structure for `semester_type`
-- ----------------------------
DROP TABLE IF EXISTS `semester_type`;
CREATE TABLE `semester_type` (
  `semester_type_id` char(10) NOT NULL,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`semester_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of semester_type
-- ----------------------------
INSERT INTO `semester_type` VALUES ('EVEN', 'Even Semester');
INSERT INTO `semester_type` VALUES ('ODD', 'Odd Semester');

-- ----------------------------
-- Table structure for `staff_designation`
-- ----------------------------
DROP TABLE IF EXISTS `staff_designation`;
CREATE TABLE `staff_designation` (
  `staff_id` char(10) NOT NULL,
  `designation_id` char(5) NOT NULL,
  PRIMARY KEY (`designation_id`,`staff_id`),
  KEY `fk_staff_designation_designation1` (`designation_id`) USING BTREE,
  KEY `fk_staff_designation_staff_personal1` (`staff_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Staff Designations';

-- ----------------------------
-- Records of staff_designation
-- ----------------------------

-- ----------------------------
-- Table structure for `staff_personal`
-- ----------------------------
DROP TABLE IF EXISTS `staff_personal`;
CREATE TABLE `staff_personal` (
  `staff_id` char(10) NOT NULL,
  `initial` char(5) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `department_id` char(10) NOT NULL,
  `gender_id` char(1) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `contact_cell` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`staff_id`),
  KEY `fk_Staff_personal_gender1` (`gender_id`) USING BTREE,
  KEY `fk_staff_personal_department1` (`department_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Personel information of faculty.';

-- ----------------------------
-- Records of staff_personal
-- ----------------------------
INSERT INTO `staff_personal` VALUES ('ACE_RAKU', 'Mr.', 'Ram', null, 'Kumar', 'MGMT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_ASPA', 'Mr.', 'Ashok', null, 'Pal', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_DHSI', 'Mr.', 'Dharambir', null, 'Singh', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_JUSI', 'Mr.', 'Jugmendra', null, 'Singh', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_JYGU', 'Ms.', 'Jyoti', null, 'Gulati', 'APPSC', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_KASO', 'Mr.', 'Kapil', null, 'Sood', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_NEKU', 'Ms.', 'Neesha', null, 'Kumari', 'APPSC', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_PAKU', 'Mr.', 'Parmender', 'Kumar', 'Saini', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_POGR', 'Ms.', 'Poonam', null, 'Gramini', 'APPSC', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_RUKA', 'Ms.', 'Rupinder', null, 'Kaur', 'APPSC', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_SAKU', 'Ms.', 'Sarita', null, 'Kumari', 'APPSC', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_SHSI', 'Mr.', 'Sham', null, 'Singh', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_SUBA', 'Mr.', 'Sumit', null, 'Bali', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_VAKA', 'Ms.', 'Vandna', null, 'Kathuria', 'APPSC', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_VISH', 'Mr.', 'Vinay', null, 'Sharma', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_YAAR', 'Ms.', 'Yavika', null, 'Arya', 'APPSC', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('APPSC_YPME', 'Mr.', 'Y.P.', null, 'Mehta', 'APPSC', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_AMTA', 'Mr.', 'Amit', null, 'Tak', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_BAKH', 'Ms.', 'Babita', null, 'Khosla', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_DISI', 'Ms.', 'Divya', null, 'Singhal', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_GAKO', 'Ms.', 'Gayatri', null, 'Kochar', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_GARA', 'Ms.', 'Gauri', null, 'Rana', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_LACH', 'Ms.', 'Lakshmi', null, 'Chaudhary', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_LAKU', 'Ms.', 'Lakshmi', null, 'Kumari', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_MACH', 'Mr.', 'Machiavelli', null, 'Machiavelli', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_MUKU', 'Mr.', 'Mukesh', null, 'Kumar', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_MUSA', 'Mr.', 'Mukesh', null, 'Saini', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_RAKU', 'Mr.', 'Ram', 'Kumar', 'Pundir', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_RASH', 'Ms.', 'Rashi', null, 'Shrivastava', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_RKJE', 'Mr.', 'R.K.', null, 'Jethi', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_RODE', 'Ms.', 'Roose', null, 'Dhamija', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('BT_SAKA', 'Mr.', 'Santosh', null, 'Karan', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_SARA', 'Mr.', 'Satish', null, 'Rana', 'BT', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('BT_SUKU', 'Ms.', 'Sushma', null, 'Kumari', 'BT', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_AJKU', 'Mr.', 'Ajay', null, 'Singh', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_AMSH', 'Mr.', 'Amit', null, 'Sharma', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_ARSE', 'Mr.', 'Arvind', null, 'Selwal', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_ASKA', 'Mr.', 'Ashok', null, 'Kajal', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_CHMO', 'Mr.', 'Chander', null, 'Mohan', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_MASI', 'Mr.', 'Manjit', null, 'Singh', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_NEGO', 'Ms.', 'Neha', null, 'Goel', 'CSE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_NEJA', 'Ms.', 'Neha', null, 'Jain', 'CSE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_NLOK', 'Mr.', 'N.S.', null, 'Lokesh', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_PACH', 'Mr.', 'Pardeep', null, 'Chauhan', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_PAKA', 'Ms.', 'Parneet', null, 'Kaur', 'CSE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_POSA', 'Ms.', 'Pooja', null, 'Saini', 'CSE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_PURA', 'Mr.', 'Puneet', null, 'Ratan', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_RAGO', 'Mr.', 'Rajeev', null, 'Goel', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_RASI', 'Mr.', 'Rajpreet', null, 'Singh', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_SERA', 'Ms.', 'Seema', null, 'Rani', 'CSE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('CSE_SOKU', 'Mr.', 'Sonu', null, 'Kumar', 'CSE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('DIR_JKSH', 'Mr.', 'JK', null, 'Sharma', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_ANKA', 'Ms.', 'Ankita', null, 'Kaundal', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_ASKU', 'Mr.', 'Ashok', null, 'Kumar', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_CHMO', 'Mr.', 'Chander', null, 'Mohan', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_GAGU', 'Mr.', 'Gaurav', null, 'Gupta', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_GAWA', 'Sir', 'Gaurav', null, '', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_JYKU', 'Ms.', 'Jyoti', null, 'Kumari', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_KIWA', 'Ms.', 'Kiran', null, 'Walia', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_KUKU', 'Mr.', 'Kusum', null, 'Kumar', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_MOSH', 'Ms.', 'Monika', null, 'Sharma', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_NEBA', 'Ms.', 'Neha', null, 'Batra', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_NEJA', 'Ms.', 'Neha', null, 'Jain', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_PRKA', 'Ms.', 'Preeti', null, 'Kaushik', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_PRKH', 'Ms.', 'Preeti', null, 'Khera', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_SARA', 'Ms.', 'Savita', null, 'Rani', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_SHSH', 'Ms.', 'Shikha', '', 'Shekhar', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_SOBU', 'Ms.', 'Sonia', null, 'Bukra', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_SUGA', 'Mr.', 'Sushil', null, 'Garg', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_SUSI', 'Mr.', 'Sukhwinder', null, 'Singh', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_VIAN', 'Mr.', 'Vijay', null, 'Anand', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_VIJA', 'Ms.', 'Vibhuti', null, 'Jaiswal', 'ECE', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('ECE_VIMI', 'Mr.', 'Vikas', null, 'Mittal', 'ECE', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('LIB_DAKA', 'Ms.', 'Daljeet', null, 'Kaur', 'LIB', 'F', null, null);
INSERT INTO `staff_personal` VALUES ('LIB_HASH', 'Mr.', 'Hari', null, 'Sharma', 'LIB', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('LIB_NAPA', 'Mr.', 'Naveen', null, 'Parsad', 'LIB', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('LIB_NASI', 'Mr.', 'Narpal', null, 'Singh', 'LIB', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('LIB_RASI', 'Mr.', 'Ram', null, 'Singh', 'LIB', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('LIB_SASI', 'Mr.', 'Satpal', null, 'Singh', 'LIB', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('LIB_SUKU', 'Mr.', 'Suresh', null, 'Kumar', 'LIB', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_AJSH', 'Mr.', 'Ajay', null, 'Sharma', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_AMBA', 'Mr.', 'Amit', null, 'Bansal', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_ARKU', 'Mr.', 'Arun', null, 'Kumar', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_CPKH', 'Mr.', 'C.P', null, 'Khattar', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_DEAG', 'Mr.', 'Deepak', null, 'Aggarwal', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_JABH', 'Mr.', 'Jai', null, 'Bhagwan', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_MACH', 'Mr.', 'Mayank', null, 'Chabra', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_PLBA', 'Mr.', 'P.L.', null, 'Bali', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_RAAN', 'Mr.', 'Rahul', null, 'Anand', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_RKHA', 'Mr.', 'R.K.', null, 'Handoo', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_ROMA', 'Mr.', 'Rohit', null, 'Mankatla', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_ROSI', 'Mr.', 'Rohit', null, 'Singla', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_SAJA', 'Mr.', 'Sanjeev', null, 'Jain', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_SASE', 'Mr.', 'Sagar', null, 'Sethia', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_SHKU', 'Mr.', 'Shyam', null, 'Kumar', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_VIGU', 'Mr.', 'Vikas', null, 'Gupta', 'ME', 'M', null, null);
INSERT INTO `staff_personal` VALUES ('ME_VSPR', 'Mr.', 'V.Sitaram', null, 'Prasad', 'ME', 'M', null, null);

-- ----------------------------
-- Table structure for `staff_professional`
-- ----------------------------
DROP TABLE IF EXISTS `staff_professional`;
CREATE TABLE `staff_professional` (
  `staff_id` char(10) NOT NULL,
  `experience_teaching` tinyint(4) DEFAULT NULL,
  `experience_industry` tinyint(4) DEFAULT NULL,
  `experience_research` tinyint(4) DEFAULT NULL,
  `date_of_join` date DEFAULT NULL,
  `date_of_relieve` date DEFAULT NULL,
  `gross_salary` int(11) DEFAULT NULL,
  PRIMARY KEY (`staff_id`),
  KEY `fk_staff_professional_staff_personal1` (`staff_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Professional Information of Faculty.';

-- ----------------------------
-- Records of staff_professional
-- ----------------------------

-- ----------------------------
-- Table structure for `staff_qualification`
-- ----------------------------
DROP TABLE IF EXISTS `staff_qualification`;
CREATE TABLE `staff_qualification` (
  `staff_id` char(10) NOT NULL,
  `qualification_id` char(5) NOT NULL,
  `remark` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`qualification_id`,`staff_id`),
  KEY `fk_staff_qualification_qualification1` (`qualification_id`) USING BTREE,
  KEY `fk_staff_qualification_staff_personal1` (`staff_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Qualification or Specialization of Staff';

-- ----------------------------
-- Records of staff_qualification
-- ----------------------------

-- ----------------------------
-- Table structure for `student_department`
-- ----------------------------
DROP TABLE IF EXISTS `student_department`;
CREATE TABLE `student_department` (
  `student_roll_no` char(20) NOT NULL,
  `group_id` char(5) NOT NULL,
  `department_id` char(10) NOT NULL,
  `degree_id` char(10) NOT NULL,
  `batch_start` year(4) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`student_roll_no`),
  KEY `fk_student_department_student_personal1` (`student_roll_no`) USING BTREE,
  KEY `fk_student_department_groups1` (`group_id`) USING BTREE,
  KEY `fk_student_department_batch1` (`department_id`,`degree_id`,`batch_start`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Basic info of student';

-- ----------------------------
-- Records of student_department
-- ----------------------------
INSERT INTO `student_department` VALUES ('2306001', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306002', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306003', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306004', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306005', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306006', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306007', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306008', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306009', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306010', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306011', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306012', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306013', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306014', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306015', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306016', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306017', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306018', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306019', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306020', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306021', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306022', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306023', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306024', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306025', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306026', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306027', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306028', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306029', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306030', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306031', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306032', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306033', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306034', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306035', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306036', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306037', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306038', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306039', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306040', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306041', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306042', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306043', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306044', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306045', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306046', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306047', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306048', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306049', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306050', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306051', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306052', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306053', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306054', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306055', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306056', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306057', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306058', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306059', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306060', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306061', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306201', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306202', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306204', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306205', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306206', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306207', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306208', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306209', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306210', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306211', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306212', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306213', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306214', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306215', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306216', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306217', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306218', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306219', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306220', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306221', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306222', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306223', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306225', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306226', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306227', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306228', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306229', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306230', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306231', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306232', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306233', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306234', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306235', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306236', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306237', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306238', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306239', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306240', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306241', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306242', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306243', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306244', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306245', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306246', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306247', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306248', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306249', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306250', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306251', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306252', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306253', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306254', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306257', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306258', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306259', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306260', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306261', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306401', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306402', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306403', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306404', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306405', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306406', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306407', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306409', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306410', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306411', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306412', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306413', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306414', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306415', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306416', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306417', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306418', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306419', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306420', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306421', 'C1', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306422', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306423', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306424', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306426', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306427', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306428', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306429', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306430', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306431', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306432', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306433', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306434', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306435', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306436', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306437', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306438', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306439', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306440', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306441', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306442', 'C2', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306443', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306444', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306445', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306446', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306447', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306448', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306449', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306450', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306451', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306452', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306453', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306454', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306455', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306456', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306457', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306458', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306459', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306460', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306461', 'C3', 'BT', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306601', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306602', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306603', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306604', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306605', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306606', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306609', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306610', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306611', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306612', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306615', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306616', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306617', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306618', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306619', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306620', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306621', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306622', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306623', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306624', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306625', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306626', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306627', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306628', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306629', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306630', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306631', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306632', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306633', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306634', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306635', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306636', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306637', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306638', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306639', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306640', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306641', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306642', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306643', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306644', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306645', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306646', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306648', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306649', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306650', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306651', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306652', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306653', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306654', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306655', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306656', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306657', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306658', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306659', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2306660', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307001', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307002', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307003', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307004', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307005', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307006', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307007', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307008', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307009', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307010', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307011', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307012', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307013', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307014', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307015', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307016', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307017', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307018', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307019', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307020', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307021', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307022', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307023', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307024', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307025', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307026', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307027', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307028', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307029', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307030', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307031', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307032', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307033', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307034', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307035', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307036', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307037', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307038', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307039', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307040', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307041', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307042', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307043', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307044', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307045', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307046', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307047', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307048', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307049', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307050', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307051', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307052', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307053', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307054', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307055', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307056', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307057', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307058', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307059', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307060', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307061', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307180', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307181', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307182', 'A1', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307183', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307184', 'A2', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307185', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307186', 'A3', 'CSE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307201', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307202', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307203', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307204', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307205', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307206', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307207', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307208', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307209', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307210', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307211', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307212', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307213', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307214', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307215', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307216', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307217', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307218', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307219', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307220', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307221', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307222', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307223', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307224', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307225', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307226', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307227', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307228', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307229', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307230', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307231', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307232', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307233', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307234', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307235', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307236', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307237', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307238', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307239', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307240', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307241', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307242', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307243', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307244', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307245', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307246', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307247', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307248', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307249', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307250', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307251', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307252', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307253', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307254', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307255', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307256', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307257', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307259', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307260', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307261', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307380', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307381', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307382', 'B1', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307383', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307384', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307385', 'B2', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307386', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307387', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307388', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307389', 'B3', 'ECE', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307401', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307402', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307403', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307404', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307405', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307406', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307407', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307408', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307409', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307410', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307411', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307413', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307414', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307415', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307416', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307417', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307418', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307419', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307420', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307421', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307422', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307423', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307424', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307425', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307426', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307427', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307428', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307429', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307430', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307431', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307432', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307433', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307434', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307435', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307436', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307437', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307438', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307439', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307440', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307441', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307442', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307443', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307444', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307445', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307446', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307447', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307448', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307449', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307450', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307451', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307452', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307453', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307454', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307455', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307456', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307457', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307458', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307459', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307460', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307461', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307601', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307602', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307603', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307604', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307605', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307606', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307607', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307608', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307609', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307610', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307612', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307613', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307614', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307615', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307616', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307617', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307618', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307619', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307620', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307621', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307622', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307623', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307624', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307625', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307626', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307627', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307628', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307629', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307630', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307631', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307632', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307633', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307635', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307636', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307637', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307641', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307642', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307643', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307644', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307645', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307646', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307647', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307648', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307649', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307650', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307651', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307652', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307653', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307654', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307655', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307656', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307657', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307658', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307660', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307661', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2307780', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307781', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307782', 'D1', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307783', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307784', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307785', 'D2', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307787', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307788', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307789', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2307790', 'D3', 'ME', 'BTECH', '2006', '0');
INSERT INTO `student_department` VALUES ('2308001', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308002', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308003', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308004', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308005', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308006', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308007', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308008', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308009', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308010', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308011', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308012', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308013', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308014', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308015', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308016', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308017', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308018', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308019', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308020', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308021', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308022', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308023', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308024', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308025', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308026', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308027', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308028', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308029', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308030', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308031', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308032', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308033', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308034', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308035', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308036', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308037', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308038', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308039', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308040', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308041', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308042', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308043', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308044', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308045', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308046', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308047', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308048', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308049', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308050', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308051', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308052', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308053', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308054', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308055', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308056', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308057', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308058', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308059', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308060', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308180', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308181', 'A1', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308182', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308183', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308184', 'A2', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308185', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308186', 'A3', 'CSE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308201', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308202', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308203', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308204', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308205', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308206', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308207', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308208', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308209', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308210', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308211', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308212', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308213', 'B1', 'ECE', 'BTECH', '2008', '0');
INSERT INTO `student_department` VALUES ('2308214', 'B1', 'ECE', 'BTECH', '2008', '0');
INSERT INTO `student_department` VALUES ('2308215', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308216', 'B1', 'ECE', 'BTECH', '2008', '0');
INSERT INTO `student_department` VALUES ('2308217', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308218', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308219', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308220', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308221', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308222', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308223', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308224', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308225', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308226', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308227', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308228', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308229', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308230', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308231', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308232', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308233', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308234', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308235', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308236', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308237', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308238', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308239', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308240', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308241', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308242', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308243', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308244', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308245', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308246', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308247', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308248', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308249', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308250', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308251', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308252', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308253', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308254', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308255', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308256', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308257', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308258', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308259', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308260', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308261', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308380', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308381', 'B1', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308382', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308383', 'B2', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308384', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308385', 'B3', 'ECE', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308401', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308402', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308404', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308405', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308406', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308407', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308408', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308409', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308410', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308411', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308412', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308413', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308414', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308415', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308416', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308417', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308419', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308420', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308421', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308423', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308424', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308425', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308426', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308427', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308428', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308429', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308430', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308432', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308433', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308434', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308435', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308436', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308437', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308438', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308439', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308440', 'C2', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308441', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308442', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308443', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308444', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308445', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308446', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308447', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308448', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308449', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308450', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308451', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308452', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308453', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308454', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308455', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308456', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308457', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308458', 'C3', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308580', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308581', 'C1', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308582', 'C2', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308583', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308584', 'C3', 'BT', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308601', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308602', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308603', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308604', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308605', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308606', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308607', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308608', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308609', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308610', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308611', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308612', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308613', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308614', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308616', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308617', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308618', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308619', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308620', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308621', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308622', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308623', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308624', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308625', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308627', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308628', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308629', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308630', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308631', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308632', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308633', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308635', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308636', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308637', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308638', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308639', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308640', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308641', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308642', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308643', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308644', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308645', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308646', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308647', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308648', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308650', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308651', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308652', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308653', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308654', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308655', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308656', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308657', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308658', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2308780', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308781', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308782', 'D1', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308783', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308784', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308785', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308786', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308787', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308788', 'D2', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308789', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308790', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2308791', 'D3', 'ME', 'BTECH', '2007', '1');
INSERT INTO `student_department` VALUES ('2309001', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309002', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309003', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309004', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309005', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309006', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309007', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309008', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309009', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309010', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309011', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309012', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309013', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309014', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309015', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309016', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309017', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309018', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309019', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309020', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309021', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309022', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309023', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309024', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309025', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309026', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309027', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309028', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309029', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309030', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309031', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309032', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309033', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309034', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309035', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309036', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309037', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309038', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309039', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309040', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309041', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309042', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309043', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309044', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309045', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309046', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309047', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309048', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309049', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309050', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309051', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309052', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309053', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309054', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309055', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309056', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309057', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309058', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309059', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309060', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309061', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309180', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309181', 'A1', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309182', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309183', 'A2', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309184', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309185', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309186', 'A3', 'CSE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309201', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309202', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309203', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309204', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309205', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309206', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309207', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309208', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309209', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309210', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309211', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309212', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309213', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309214', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309215', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309216', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309217', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309218', 'B1', 'ECE', 'BTECH', '2009', '0');
INSERT INTO `student_department` VALUES ('2309219', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309220', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309221', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309222', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309223', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309224', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309225', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309226', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309228', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309229', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309230', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309231', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309232', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309233', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309234', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309235', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309236', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309237', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309238', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309239', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309240', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309241', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309242', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309243', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309244', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309245', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309246', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309247', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309248', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309249', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309250', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309251', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309252', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309253', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309254', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309255', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309256', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309257', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309258', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309259', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309260', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309380', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309381', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309382', 'B1', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309383', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309384', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309385', 'B2', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309386', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309387', 'B3', 'ECE', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309401', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309402', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309404', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309405', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309406', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309407', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309408', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309409', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309410', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309411', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309412', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309414', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309415', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309416', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309417', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309418', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309419', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309420', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309421', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309422', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309423', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309424', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309425', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309426', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309427', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309428', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309429', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309430', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309431', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309432', 'C2', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309433', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309434', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309435', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309436', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309437', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309438', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309439', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309440', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309441', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309442', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309443', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309444', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309445', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309446', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309447', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309448', 'C3', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309580', 'C1', 'BT', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309601', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309602', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309604', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309605', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309606', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309607', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309608', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309609', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309610', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309611', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309612', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309613', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309614', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309615', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309616', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309617', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309618', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309619', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309620', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309621', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309622', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309623', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309624', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309625', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309626', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309627', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309628', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309629', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309630', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309631', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309632', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309633', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309634', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309635', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309636', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309637', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309638', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309639', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309640', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309641', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309642', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309643', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309644', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309645', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309646', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309647', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309648', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309649', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309650', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309651', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309652', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309653', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309654', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309655', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309656', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309657', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309658', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309659', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309660', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2309780', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309781', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309782', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309783', 'D1', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309784', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309785', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309786', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309787', 'D2', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309788', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309789', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309790', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309791', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2309792', 'D3', 'ME', 'BTECH', '2008', '1');
INSERT INTO `student_department` VALUES ('2310001', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310002', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310003', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310004', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310005', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310006', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310007', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310008', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310009', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310010', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310011', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310012', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310013', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310014', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310015', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310016', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310017', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310018', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310019', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310020', 'A1', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310021', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310022', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310023', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310024', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310025', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310026', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310027', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310028', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310029', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310030', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310031', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310032', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310033', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310034', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310035', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310036', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310037', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310038', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310039', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310040', 'A2', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310041', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310042', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310043', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310044', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310045', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310046', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310047', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310048', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310049', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310050', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310051', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310052', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310053', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310054', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310055', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310056', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310057', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310058', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310059', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310060', 'A3', 'CSE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310180', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310181', 'A1', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310182', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310183', 'A2', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310184', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310185', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310186', 'A3', 'CSE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310201', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310202', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310203', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310204', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310205', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310206', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310207', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310208', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310209', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310210', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310211', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310212', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310213', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310214', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310215', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310216', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310217', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310218', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310219', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310220', 'B1', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310221', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310222', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310223', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310224', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310225', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310226', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310227', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310228', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310229', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310230', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310231', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310232', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310233', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310234', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310235', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310236', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310237', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310238', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310239', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310240', 'B2', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310241', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310242', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310243', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310244', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310245', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310246', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310247', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310248', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310249', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310250', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310251', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310252', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310253', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310254', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310255', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310256', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310257', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310258', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310259', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310260', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310261', 'B3', 'ECE', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310380', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310381', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310382', 'B1', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310383', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310384', 'B2', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310385', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310386', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310387', 'B3', 'ECE', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310401', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310402', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310403', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310404', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310405', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310406', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310407', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310408', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310409', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310410', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310411', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310412', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310413', 'C1', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310414', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310415', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310416', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310417', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310418', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310419', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310420', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310421', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310422', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310423', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310424', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310425', 'C2', 'BT', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310580', 'C1', 'BT', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310601', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310602', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310603', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310604', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310605', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310606', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310607', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310608', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310609', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310610', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310611', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310612', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310613', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310614', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310615', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310616', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310617', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310618', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310619', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310620', 'D1', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310621', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310622', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310623', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310624', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310625', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310626', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310627', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310628', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310629', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310630', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310631', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310632', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310633', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310634', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310635', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310636', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310637', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310638', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310639', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310640', 'D2', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310641', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310642', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310643', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310644', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310645', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310646', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310647', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310648', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310649', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310650', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310651', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310652', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310653', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310654', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310655', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310656', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310657', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310658', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310659', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310660', 'D3', 'ME', 'BTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('2310780', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310781', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310782', 'D1', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310783', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310784', 'D2', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310785', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('2310786', 'D3', 'ME', 'BTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309201', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309202', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309203', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309204', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309205', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309206', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309207', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309208', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309209', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309210', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309211', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309212', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309213', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309214', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309215', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309216', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309217', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309218', 'E1', 'ECE', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309401', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309402', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309403', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309404', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309405', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309406', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309407', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309408', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309410', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309411', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309412', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309413', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309414', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309415', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309416', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309417', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2309418', 'F1', 'BT', 'MTECH', '2009', '1');
INSERT INTO `student_department` VALUES ('MT2310001', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310002', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310003', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310004', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310005', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310006', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310007', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310008', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310009', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310010', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310011', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310012', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310013', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310014', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310015', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310016', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310017', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310018', 'H1', 'CSE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310201', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310202', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310203', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310204', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310205', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310206', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310207', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310208', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310209', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310210', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310211', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310212', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310213', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310214', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310215', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310216', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310217', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310218', 'E1', 'ECE', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310401', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310402', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310403', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310404', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310405', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310406', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310407', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310408', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310409', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310410', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310411', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310412', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310413', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310414', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310415', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310416', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310417', 'F1', 'BT', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310601', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310602', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310603', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310604', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310605', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310606', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310607', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310608', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310609', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310610', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310611', 'G1', 'ME', 'MTECH', '2010', '1');
INSERT INTO `student_department` VALUES ('MT2310612', 'G1', 'ME', 'MTECH', '2010', '1');

-- ----------------------------
-- Table structure for `student_personal`
-- ----------------------------
DROP TABLE IF EXISTS `student_personal`;
CREATE TABLE `student_personal` (
  `student_roll_no` char(20) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `gender_id` char(1) NOT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `guardian_no` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`student_roll_no`),
  KEY `fk_student_personal_gender1` (`gender_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Personal information of Student';

-- ----------------------------
-- Records of student_personal
-- ----------------------------
INSERT INTO `student_personal` VALUES ('2306001', 'DEEPAK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306002', 'ANSHUL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306003', 'SHEETAL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306004', 'SANDEEP', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306005', 'GEETIKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306006', 'PRIYANKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306007', 'NITESH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306008', 'ANURAG', null, 'BAKSHI ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306009', 'ANUJ', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306010', 'GAURAV', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306011', 'NAVEEN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306012', 'HARMANPREET', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306013', 'SHIVANGI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306014', 'AMANDEEP', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306015', 'SAKSHI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306016', 'SAJAL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306017', 'LOHIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306018', 'NUPUR', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306019', 'ABHINAV', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306020', 'SRISHTI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306021', 'STUTI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306022', 'ROCHAK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306023', 'PRABHJOT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306024', 'DINESH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306025', 'HARKAMAL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306026', 'SUROJIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306027', 'ANKIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306028', 'PARUL', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306029', 'SANCHIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306030', 'SHINKY', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306031', 'HENNA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306032', 'RUPINDER', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306033', 'ALKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306034', 'SHIVASTUTI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306035', 'SUJATA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306036', 'RITIKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306037', 'SAURAV', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306038', 'NITIKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306039', 'CHETAN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306040', 'DISHA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306041', 'PRABHJEET', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306042', 'HARSHDEEP', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306043', 'VARUN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306044', 'RAHUL', null, 'TOMAR ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306045', 'POOJA', null, 'MANGLA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306046', 'ABHISHEK', null, 'CHAWLA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306047', 'MUKESH', null, 'MANN ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306048', 'SUGNDHA', null, 'RANA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306049', 'PRASHANT', null, 'SAROHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306050', 'ANKUSH', null, 'CHHABRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306051', 'GAURAV', null, 'CHAUHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306052', 'ASHISH', null, 'CHAWLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306053', 'PUNESSH', null, 'SACHDEVA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306054', 'KAWAL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306055', 'RADHIKA', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306056', 'SANCHIT', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306057', 'AVINASH', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306058', 'MUKUL', null, 'GOEL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306059', 'RAJPRRET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306060', 'MADHU', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306061', 'VISHALI', null, 'RAINA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306201', 'SHAVETA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306202', 'IQBAL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306204', 'MANISH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306205', 'DEEPAK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306206', 'AYUSH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306207', 'CHIRAG', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306208', 'SWATI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306209', 'NEERAJ', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306210', 'NEHA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306211', 'ASHISH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306212', 'ANUJ', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306213', 'J', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306214', 'SARVJIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306215', 'MANJOT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306216', 'ANURAG', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306217', 'UTKARSH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306218', 'NITIN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306219', 'ROHIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306220', 'NAVJOT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306221', 'SHUBHAM', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306222', 'RISHABH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306223', 'NAVEEN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306225', 'CHAKSHU', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306226', 'DIPANSH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306227', 'SUMIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306228', 'VIKRAM', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306229', 'AMIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306230', 'SHARAD', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306231', 'DEVAL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306232', 'SHAINA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306233', 'ANKIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306234', 'HARSIMRAN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306235', 'POOJA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306236', 'ABHISHEK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306237', 'SONAL', null, 'KHANNA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306238', 'KUSUM', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306239', 'RAVI', null, 'SHARMA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306240', 'SHIVANGI', null, 'GUPTA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306241', 'LAKSHIT', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306242', 'SHUBHAM', null, 'DAS ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306243', 'DEEPANKAR', null, 'SAJWAN ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306244', 'VARUNIKA', null, 'ARYA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306245', 'PARVEEN', null, 'KANWAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306246', 'BRIHAD', null, 'MITTAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306247', 'PIYUSH', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306248', 'SONAM', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306249', 'ROHIT', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306250', 'SOURAV', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306251', 'PARUL', null, 'PARUL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306252', 'SAHIL', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306253', 'NEHA', null, 'GARG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306254', 'VISHAL', null, 'BHANDARI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306257', 'GAGANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306258', 'JAGDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306259', 'MONIKA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306260', 'VASHU', null, 'BAJAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306261', 'ANISHA', null, 'RAINA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306401', 'SHALINI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306402', 'SUJATA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306403', 'HIMANSHU', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306404', 'SUGANDHA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306405', 'GURLEEN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306406', 'NANCY', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306407', 'NATYA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306409', 'SHALLU', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306410', 'PANKHURI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306411', 'DEEPAK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306412', 'DIVYA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306413', 'HINA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306414', 'AMAN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306415', 'BHUMIKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306416', 'SUPREET', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306417', 'AJAY', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306418', 'GURJIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306419', 'VIDHU', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306420', 'SAKSHI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306421', 'AMANDEEP', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306422', 'KRITIKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306423', 'PULKIT', null, 'PULKIT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306424', 'AASTHA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306426', 'MEETU', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306427', 'NITIN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306428', 'RESHMI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306429', 'ABHISHEK', null, 'ACHARYA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306430', 'SIDDHARTH', null, 'ANAND ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306431', 'PRATEEK', null, 'GULATI ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306432', 'RAJINDER', null, 'NAGPAL ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306433', 'ABHISHEK', null, 'SINHA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306434', 'KUSHALDEEP', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306435', 'RAVI', null, 'TIWARI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306436', 'PREETI', null, 'PREETI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306437', 'MEGHA', null, 'GANDHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306438', 'RIDHI', null, 'MEHTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306439', 'HIMANSHU', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306440', 'ASHWANI', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306441', 'MANISHA', null, 'MITTAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306442', 'RUPINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306443', 'PRIYANKA', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306444', 'SHIKHA', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306445', 'PRAGATI', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306446', 'NEHA', null, 'KASHYAP', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306447', 'NEHA', null, 'SINGLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306448', 'PAAVAN', null, 'PAAVAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306449', 'SHVETA', null, 'SHVETA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306450', 'SARU', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306451', 'RITIKA', null, 'GERA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306452', 'DEEPIKA', null, 'RANA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306453', 'SABNEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306454', 'GAURAV', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306455', 'KARAN', null, 'KAUSHIK ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306456', 'SAURABH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306457', 'HUMA', null, 'HUMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306458', 'SUMEET', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306459', 'SONAM', null, 'SONAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306460', 'SHIKHA', null, 'KOUL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306461', 'JASPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306601', 'HIMANSHU', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306602', 'GURJINDER', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306603', 'ROHIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306604', 'SWAPNIL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306605', 'KRISHAN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306606', 'MOHIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306609', 'AJAY', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306610', 'VAIDYA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306611', 'VIVEK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306612', 'VIKAS', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306615', 'ANKUR', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306616', 'PARDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306617', 'ANKIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306618', 'RISHABH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306619', 'SHOBHIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306620', 'ASHISH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306621', 'VINOD', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306622', 'SISHUTOSH', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306623', 'HARPREET', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306624', 'ABHINAV', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306625', 'RAHUL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306626', 'SAMRAT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306627', 'ISHU', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306628', 'NAVEEN', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306629', 'JITENDER', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306630', 'ROHIT', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306631', 'GAURAV', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306632', 'DEEPAK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306633', 'SUPREET', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306634', 'ANKUR', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306635', 'MANPREET', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306636', 'MANUJ', null, 'SHARMA ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306637', 'YOGESH', null, 'SAINI ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306638', 'KIRTI', null, 'AZAD ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306639', 'SANJEEV', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306640', 'VISHAL', null, 'TAYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306641', 'GAGANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306642', 'SANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306643', 'ROHIT', null, 'SINGLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306644', 'AMAN', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306645', 'ANKUR', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306646', 'MANPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306648', 'VINEET', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306649', 'VIKAS', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306650', 'RAGHAV', null, 'KAPOOR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306651', 'MAYANK', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306652', 'SANDEEP', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306653', 'JITENDER', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306654', 'ANUJ', null, 'GULATI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306655', 'JASPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306656', 'PARTH', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306657', 'SIDHANT', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306658', 'GAGANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306659', 'SUNIL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2306660', 'RAJESH', null, 'SANGWAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307001', 'SHIPRA', null, 'GROVER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307002', 'UDIT', null, 'NARAYAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307003', 'MEENU', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307004', 'BHAWNA', null, 'BHAWNA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307005', 'NIDHI', null, 'CHOUDHERY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307006', 'HIMANSHU', null, 'SONKAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307007', 'PRAJAYA', null, 'TALWAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307008', 'ANKITA', null, 'NARANG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307009', 'ANKITA', null, 'GULATI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307010', 'TARUNPREET', null, 'BHATIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307011', 'RASHMI', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307012', 'HEMANT', null, 'DABRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307013', 'NITIKA', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307014', 'VIBHUTI', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307015', 'RAMANPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307016', 'GARIMA', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307017', 'VIKRAM', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307018', 'PALWINDER', null, 'GREWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307019', 'GAURAV', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307020', 'ASHU', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307021', 'KARAN', null, 'SAMBHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307022', 'SHAGUN', null, 'SHAGUN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307023', 'SHAVETA', null, 'BAKSHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307024', 'TAMANNA', null, 'TAMANNA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307025', 'MEETALI', null, 'JOHAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307026', 'KIRTI', null, 'KIRTI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307027', 'SATYA', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307028', 'KUSUM', null, 'LATA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307029', 'NIPUN', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307030', 'RAVI', null, 'DALAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307031', 'AMARJEET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307032', 'HITESH', null, 'AHUJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307033', 'ATUL', null, 'GOYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307034', 'ISHANT', null, 'OBERAI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307035', 'RAJWINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307036', 'DISHANT', null, 'VINAYAK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307037', 'RAVI', null, 'DHAWAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307038', 'JASDEEP', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307039', 'HAPPY', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307040', 'SWATI', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307041', 'MANNU', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307042', 'YASHIKA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307043', 'MEGHA', null, 'MEHRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307044', 'ABHISHEK', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307045', 'BIJENDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307046', 'DINESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307047', 'RAM', null, 'NARESH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307048', 'PARAMANS', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307049', 'HARDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307050', 'PARMOD', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307051', 'SANYA', null, 'KATYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307052', 'NITISH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307053', 'RICHA', null, 'AHULWALIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307054', 'SIMARJEET', null, 'NAGRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307055', 'NIVESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307056', 'SONAM', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307057', 'ANKUR', null, 'BEHL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307058', 'SOHIT', null, 'KAPOOR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307059', 'ROMA', null, 'SONI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307060', 'SALONI', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307061', 'SUMEETA', null, '(KM)', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307180', 'CHAND', null, 'KAMYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307181', 'POONAM', null, 'POONAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307182', 'GURPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307183', 'SUMAN', null, 'SUMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307184', 'RAJESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307185', 'SHALINI', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307186', 'SWATI', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307201', 'TARUN', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307202', 'GURPAL', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307203', 'SHIVANI', null, 'MITTAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307204', 'AYUSHI', null, 'GARG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307205', 'VIKAS', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307206', 'SAURABH', null, 'KOHLI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307207', 'DEEPAK', null, 'BANSAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307208', 'ABHINAV', null, 'SYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307209', 'RACHIT', null, 'MANCHANDA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307210', 'BHARAT', null, 'GAUTAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307211', 'SUNITA', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307212', 'VIKAS', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307213', 'DRISHTI', null, 'DHAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307214', 'ANKUR', null, 'CHADHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307215', 'AKSHI', null, 'SETHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307216', 'CHIRAG', null, 'CHIRAG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307217', 'SAHIL', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307218', 'AMANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307219', 'RAHUL', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307220', 'ROHIT', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307221', 'ANKUSH', null, 'ANKUSH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307222', 'ABHISHEK', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307223', 'POOJA', null, 'POOJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307224', 'SHIVANI', null, 'BANSAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307225', 'CHARAN', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307226', 'JATIN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307227', 'ANKIT', null, 'NEGI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307228', 'ASHIM', null, 'BATRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307229', 'RAVI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307230', 'SUDEEP', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307231', 'RAKESH', null, 'RAKESH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307232', 'ROOMA', null, 'DEVI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307233', 'SAPNA', null, 'KUMARI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307234', 'PUNEET', null, 'CHUGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307235', 'HIMANI', null, 'GAUDWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307236', 'JATIN', null, 'KAUSHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307237', 'MANISH', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307238', 'NISHANT', null, 'SOLANKI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307239', 'GEETA', null, 'BHATIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307240', 'VIKAS', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307241', 'NEERU', null, 'NEERU', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307242', 'POONAM', null, 'SACHDEVA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307243', 'YOGESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307244', 'ROHIT', null, 'MOHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307245', 'VERINDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307246', 'DEEPAK', null, 'DEEPAK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307247', 'GURPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307248', 'MUDIT', null, 'KAPOOR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307249', 'SANJAY', null, 'JAWA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307250', 'SURAJ', null, 'SURAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307251', 'CHAVI', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307252', 'MANJIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307253', 'AMANDEEP', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307254', 'KANWARDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307255', 'POOJA', null, 'POOJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307256', 'MOHIT', null, 'CHOPRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307257', 'MEENAKSHI', null, 'CHAWHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307259', 'RAGHAV', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307260', 'JYOTIRMAYA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307261', 'SHIVETA', null, '(KM)', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307380', 'POOJA', null, 'POOJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307381', 'MANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307382', 'ANUPMA', null, 'ANUPMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307383', 'MOHIT', null, 'CHAHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307384', 'SUMIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307385', 'GAURAV', null, 'KAUSHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307386', 'EESHU', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307387', 'PUNEET', null, 'CHADHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307388', 'DEEPAK', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307389', 'ANJALI', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307401', 'RUCHI', null, 'HUDA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307402', 'RANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307403', 'DEEPIKA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307404', 'VINOD', null, 'VINOD', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307405', 'SEEMA', null, 'BENIWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307406', 'CHETAN', null, 'PARKASH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307407', 'GEETIKA', null, 'GEETIKA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307408', 'GURLEEN', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307409', 'NITIN', null, 'ARORA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307410', 'ALEESHA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307411', 'ASHIMA', null, 'GANOTRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307413', 'ABHILASHA', null, 'ABHILASHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307414', 'SHIVALIKA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307415', 'SHAVETA', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307416', 'MANISHA', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307417', 'RUPSI', null, 'GARG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307418', 'RAJESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307419', 'BASANT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307420', 'ESHITA', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307421', 'NEERAJ', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307422', 'RUPINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307423', 'PRAVEEN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307424', 'POOJA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307425', 'PREM', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307426', 'NAVNEET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307427', 'SAKSHI', null, 'BHARDWAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307428', 'GURPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307429', 'AVTAR', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307430', 'ADITI', null, 'OJHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307431', 'GUNEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307432', 'RENU', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307433', 'SUPRIYA', null, 'JAGGA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307434', 'SARITA', null, 'SARITA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307435', 'MOKSHA', null, 'SANDILYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307436', 'MANHAR', null, 'WALIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307437', 'SATISH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307438', 'PRATIMA', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307439', 'KANIKA', null, 'MALHOTRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307440', 'SHWETA', null, 'HALDUNIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307441', 'SAKSHI', null, 'SAKSHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307442', 'BANINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307443', 'SAPNA', null, 'CHAUHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307444', 'GAURAV', null, 'ADHAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307445', 'DIVYA', null, 'BANSAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307446', 'GURPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307447', 'HARWINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307448', 'SMRITI', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307449', 'DEEPANJALI', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307450', 'SAKSHI', null, 'CHADHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307451', 'GEETA', null, 'SANDHU', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307452', 'SANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307453', 'SANDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307454', 'RAHUL', null, 'SAKLANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307455', 'SWATI', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307456', 'DEEPIKA', null, 'DEEPIKA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307457', 'SALONIKA', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307458', 'MEGHA', null, 'BEDI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307459', 'HARDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307460', 'PARNEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307461', 'APURVA', null, '(KM)', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307601', 'DEEPAK', null, 'SUDAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307602', 'PALVINDER', null, 'SANDHU', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307603', 'SANJAY', null, 'SANJAY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307604', 'RAHUL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307605', 'NAVEEN', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307606', 'KARANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307607', 'MANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307608', 'PUNEET', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307609', 'WARJINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307610', 'DHERINDER', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307612', 'NARINDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307613', 'YUDHVEER', null, 'YUDHVEER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307614', 'ARPIT', null, 'BHASIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307615', 'SHIWA', null, 'ADHIKARI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307616', 'MANINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307617', 'DHEERAJ', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307618', 'GURMEET', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307619', 'ASHISH', null, 'SEHGAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307620', 'AMIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307621', 'VISHAL', null, 'VISHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307622', 'PRINCE', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307623', 'SUMIT', null, 'RUHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307624', 'LOVEJEET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307625', 'SUNIL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307626', 'PARDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307627', 'RAJESH', null, 'TANWAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307628', 'SUNIL', null, 'KANDPAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307629', 'SANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307630', 'HARDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307631', 'GURVINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307632', 'SANDEEP', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307633', 'RAMESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307635', 'ROHIT', null, 'NARANG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307636', 'VIRENDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307637', 'TEJENDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307641', 'RAHUL', null, 'MALHOTRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307642', 'RAJINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307643', 'RAMANDEEP', null, 'RAMANDEEP', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307644', 'HARENDER', null, 'HARENDER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307645', 'SAHIL', null, 'ARORA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307646', 'PANKIL', null, 'MALIK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307647', 'ABHIJIT', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307648', 'GURJINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307649', 'ANMOL', null, 'BALI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307650', 'SATISH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307651', 'AMIT', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307652', 'SHSHANK', null, 'BHATLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307653', 'DEEPAK', null, 'GARG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307654', 'RAHUL', null, 'GOYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307655', 'HARSHIT', null, 'RASTOGI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307656', 'ANKUSH', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307657', 'RAJEEV', null, 'PRAJAPATI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307658', 'VIPIN', null, 'MOHIL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307660', 'VIKAS', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307661', 'KARAN', null, '(KM)', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307780', 'AMAN', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307781', 'LALIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307782', 'RAMAN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307783', 'NAVNEET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307784', 'VINOD', null, 'SANDHU', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307785', 'SUMIT', null, 'WALIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307787', 'SHAMPUMAN', null, 'GOYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307788', 'KASHISH', null, 'KHATRI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307789', 'ADITYA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2307790', 'NAVEEN', null, 'CHUGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308001', 'RUPINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308002', 'GURSHEEN', null, 'MATTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308003', 'RUCHITA', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308004', 'ANIL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308005', 'SURJEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308006', 'GARIMA', null, 'GARIMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308007', 'JASPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308008', 'SWETA', null, 'SWETA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308009', 'HARSH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308010', 'AMRIT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308011', 'CHARANJIT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308012', 'SUMITI', null, 'BANSAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308013', 'ROOPALI', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308014', 'KOMAL', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308015', 'PRARTHANA', null, 'PRARTHANA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308016', 'BABITA', null, 'BABITA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308017', 'SUMIT', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308018', 'HARPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308019', 'SAGAR', null, 'SAGAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308020', 'SUMIT', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308021', 'TWINKLE', null, 'TWINKLE', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308022', 'MAMTA', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308023', 'ANJALI', null, 'CHAUHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308024', 'RAMIKA', null, 'RAMIKA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308025', 'NISHANK', null, 'ARORA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308026', 'SATVINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308027', 'MANPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308028', 'NEERAJ', null, 'NEERAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308029', 'PRABHJOT', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308030', 'DIPESH', null, 'WALIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308031', 'MANPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308032', 'JAGDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308033', 'ARUN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308034', 'VIVEK', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308035', 'AMAN', null, 'AMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308036', 'PARMINA', null, 'PARMINA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308037', 'SANDEEP', null, 'SANDEEP', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308038', 'AMANDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308039', 'SHIVANI', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308040', 'RAHUL', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308041', 'ARPAN', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308042', 'SUKHPAL', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308043', 'JASBIR', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308044', 'PAWANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308045', 'HEENA', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308046', 'NIDHI', null, 'SANGWAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308047', 'BHARTI', null, 'VAISH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308048', 'BHARAT', null, 'BYAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308049', 'TANISHA', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308050', 'AASTHA', null, 'KAPOOR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308051', 'MANPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308052', 'ADITI', null, 'PRIYADARSHANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308053', 'SIDHARTH', null, 'CHAUDHARY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308054', 'YUDHVEER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308055', 'ANURAG', null, 'DIXIT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308056', 'CHIRAG', null, 'GARG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308057', 'RAHUL', null, 'MITTAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308058', 'SURUCHI', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308059', 'RAVINDER', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308060', 'SONU', null, 'SAHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308180', 'LEENU', null, 'PANDITA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308181', 'KUSHAL', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308182', 'NITIN', null, 'SONI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308183', 'RAHUL', null, 'RAHUL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308184', 'AMANDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308185', 'DEEPIKA', null, 'DEEPIKA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308186', 'ANJU', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308201', 'MANDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308202', 'VARUN', null, 'GOEL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308203', 'VIVEK', null, 'BATRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308204', 'VIVEK', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308205', 'DHAIRYA', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308206', 'MANAN', null, 'GAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308207', 'GOURAV', null, 'GOURAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308208', 'AJAY', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308209', 'MANISH', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308210', 'SAPNA', null, 'SADYAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308211', 'MEENAKSHI', null, 'MEENAKSHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308212', 'DEEPTI', null, 'DEEPTI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308213', 'SHIVANGI', null, 'BILORA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308214', 'SANJIV', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308215', 'ADITYA', null, 'ADITYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308216', 'PARVEEN', null, 'PARVEEN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308217', 'MUKESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308218', 'RAMAN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308219', 'SUDHANSHU', null, 'MOHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308220', 'BHAWANA', null, 'BHAWANA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308221', 'NEHA', null, 'JASSI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308222', 'JITENDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308223', 'PRITISHTHA', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308224', 'APARNA', null, 'TOMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308225', 'RAVEENA', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308226', 'SANDEEP', null, 'SINGHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308227', 'GITESH', null, 'JHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308228', 'VINOD', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308229', 'JAGVINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308230', 'RAJAT', null, 'NARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308231', 'SUMEDHA', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308232', 'BHANU', null, 'PRIYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308233', 'SOHAN', null, 'LAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308234', 'ADITYA', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308235', 'RAMANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308236', 'KANIKA', null, 'KANIKA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308237', 'VIKAS', null, 'CHANDER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308238', 'VIKAS', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308239', 'SAHIL', null, 'PAHWA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308240', 'RAM', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308241', 'NEETU', null, 'THIND', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308242', 'KOMAL', null, 'KOMAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308243', 'TARUN', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308244', 'SAHIL', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308245', 'VASTSALA', null, 'NIRJHAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308246', 'NEHA', null, 'ARYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308247', 'SHIPRA', null, 'GERA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308248', 'HITESH', null, 'KAPIL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308249', 'SHRDHA', null, 'CHAWLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308250', 'DHEERAJ', null, 'DHINGRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308251', 'AKHIL', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308252', 'SIDDHANT', null, 'PAHWA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308253', 'AMIT', null, 'CHAUHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308254', 'ANIKAIT', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308255', 'K', null, 'JAGATHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308256', 'RAHUL', null, 'KHATTI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308257', 'ANAND', null, 'RAWAT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308258', 'ANUJ', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308259', 'ANKIT', null, 'AHUJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308260', 'HIMANSHU', null, 'BHUTANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308261', 'AKANKSHA', null, '(KM)', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308380', 'SAHIL', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308381', 'ANIL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308382', 'MANISH', null, 'PASSI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308383', 'DIMPLE', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308384', 'MANISH', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308385', 'PALLAVI', null, 'MEHTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308401', 'RUCHI', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308402', 'HIMANI', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308404', 'ROHIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308405', 'SUNIL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308406', 'NAVEEN', null, 'NAVEEN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308407', 'GURPREET', null, 'SIDHU', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308408', 'PRIKSHIT', null, 'PRIKSHIT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308409', 'SHAILENDER', null, 'PATEL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308410', 'KANUPRIYA', null, 'KANUPRIYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308411', 'TANU', null, 'BHATIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308412', 'SUNIL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308413', 'PRADEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308414', 'PURNIMA', null, 'KHURANA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308415', 'SAHIL', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308416', 'HIMANSHU', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308417', 'LOVEY', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308419', 'SIMMI', null, 'SIMMI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308420', 'RITIKA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308421', 'ABHIMANYU', null, 'ABHIMANYU', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308423', 'VAISHALI', null, 'VAISHALI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308424', 'KAPIL', null, 'KAPIL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308425', 'RADHESHAM', null, 'RADHESHAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308426', 'PAWAN', null, 'TOMER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308427', 'PRAVESH', null, 'MALIK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308428', 'KOMAL', null, 'KOMAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308429', 'PRAFUL', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308430', 'SURENDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308432', 'MANJARI', null, 'VYAS', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308433', 'NITISH', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308434', 'AMAN', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308435', 'POONAM', null, 'BANGIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308436', 'SUMIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308437', 'ARUSHI', null, 'BATRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308438', 'DEEPAM', null, 'BHARARA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308439', 'RISHU', null, 'RISHU', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308440', 'LALIT', null, 'KAPUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308441', 'MANISHA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308442', 'NAVNEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308443', 'SUMEGHA', null, 'KOHLI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308444', 'ANKUSH', null, 'GARG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308445', 'PARISH', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308446', 'NEERAJ', null, 'NEERAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308447', 'LAKSHDEEP', null, 'SODHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308448', 'POOJA', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308449', 'ANUPAM', null, 'MANGAT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308450', 'SUMANPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308451', 'ARUSHI', null, 'SABHARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308452', 'LALIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308453', 'ANKUR', null, 'SAWHNEY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308454', 'BALDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308455', 'DARPAN', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308456', 'NIYATI', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308457', 'KHUSHI', null, 'KHUSHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308458', 'AKANSHI', null, 'KAKROO(KM)', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308580', 'HEMANT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308581', 'PRINCE', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308582', 'AMIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308583', 'GAURAV', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308584', 'NIKESH', null, 'CHANDER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308601', 'SARITA', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308602', 'RAKESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308603', 'PANKAJ', null, 'BHATIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308604', 'SUNIL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308605', 'VIPIN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308606', 'SACHIN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308607', 'AIVIN', null, 'PAIK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308608', 'PARVEEN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308609', 'BHARAT', null, 'DHAMIJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308610', 'VINAY', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308611', 'GURJIT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308612', 'VINAY', null, 'GOSAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308613', 'AMAN', null, 'AMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308614', 'SIDHARTH', null, 'JASORIYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308616', 'KAMAL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308617', 'NEERAJ', null, 'MAHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308618', 'SUKHJINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308619', 'NIKHIL', null, 'SANGWAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308620', 'ASHISH', null, 'ASHISH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308621', 'SACHIN', null, 'KAMBOJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308622', 'ABHISHEK', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308623', 'MANU', null, 'CHAUDHARY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308624', 'VINEET', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308625', 'AASHISH', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308627', 'NEERAJ', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308628', 'DHIRENDER', null, 'YADAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308629', 'RAJNISH', null, 'RAJNISH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308630', 'SANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308631', 'VIKRAM', null, 'PAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308632', 'RAJU', null, 'SONI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308633', 'RAJINDER', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308634', 'MANVENDRA', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308635', 'JITENDER', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308636', 'MUNESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308637', 'ANMOL', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308638', 'NITISH', null, 'NITISH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308639', 'NARESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308640', 'VIKRAM', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308641', 'JASBIR', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308642', 'SUMIT', null, 'GAUTAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308643', 'GITESH', null, 'ARORA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308644', 'BALVINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308645', 'NIKHIL', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308646', 'GAURAV', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308647', 'BIDYA', null, 'MISHRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308648', 'ABHISHEK', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308650', 'UJJWAL', null, 'HARCHAND', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308651', 'NARENDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308652', 'NEERAJ', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308653', 'MANOJ', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308654', 'ANURAG', null, 'PANDEY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308655', 'GURPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308656', 'AJAY', null, 'CHAUHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308657', 'SANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308658', 'SUMEET', null, 'KOUL(KM)', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308780', 'VISHNU', null, 'PAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308781', 'MANISH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308782', 'SOHAN', null, 'LAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308783', 'HITESH', null, 'KALOTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308784', 'MANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308785', 'ATUL', null, 'MARKANDAY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308786', 'NAVJOT', null, 'INJRAH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308787', 'RAHUL', null, 'RAHUL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308788', 'SUMIT', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308789', 'GURJENT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308790', 'AMANDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2308791', 'PARDEEP', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309001', 'AMAN', null, 'SACHDEVA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309002', 'CHAITANYA', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309003', 'SHAHEEN', null, 'SIKRI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309004', 'RUCHIKA', null, 'BATRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309005', 'MANISH', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309006', 'PRATIBHA', null, 'ROHILLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309007', 'ROHIT', null, 'KALRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309008', 'AAKRITI', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309009', 'NAVISHA', null, 'GOYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309010', 'MEHAK', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309011', 'KANIKA', null, 'MALHOTRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309012', 'JASPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309013', 'GARIMA', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309014', 'AAKRITI', null, 'GOEL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309015', 'HIMANI', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309016', 'SHEENAM', null, 'BANSAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309017', 'DISHA', null, 'SINGLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309018', 'PALVIKA', null, 'NAGPAL', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309019', 'RAMANDEEP', null, 'SETHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309020', 'SHUBHAM', null, 'KHARBANDA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309021', 'CHEHAK', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309022', 'RICHA', null, 'GOEL', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309023', 'KANIKA', null, 'GARG', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309024', 'HARNEET', null, 'KAUR', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309025', 'SONAL', null, 'ARORA', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309026', 'SUKHJIT', null, 'KAUR', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309027', 'ANIL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309028', 'PALLVI', null, 'BHARTI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309029', 'SNEHA', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309030', 'PRASHANT', null, 'CHAWLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309031', 'AMIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309032', 'KARISHMA', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309033', 'SHIPRA', null, 'PASSI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309034', 'SONIA', null, 'RANI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309035', 'ROHIT', null, 'TOKY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309036', 'AMRIT', null, 'KAUR', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309037', 'AKANKSHA', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2309038', 'BANTI', null, 'BANTI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309039', 'AKANKSHA', null, 'PASSI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309040', 'MONICA', null, 'BHAT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309041', 'GOURAV', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309042', 'NAVDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309043', 'HUNNY', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309044', 'SALONI', null, 'SALONI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309045', 'RAJAT', null, 'KHANNA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309046', 'DEEPALI', null, 'GILL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309047', 'JAIPRIYA', null, 'JAIPRIYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309048', 'PRIYANKA', null, 'GULATI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309049', 'SHREYA', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309050', 'BINEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309051', 'SUMEDHA', null, 'CHAUDHRY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309052', 'NEETU', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309053', 'MEHAK', null, 'MANOCHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309054', 'ANJALI', null, 'VASHIST', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309055', 'PARUL', null, 'MUKHERJEE', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309056', 'NAVDEEP', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309057', 'RICHA', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309058', 'GAURAV', null, 'GAURAV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309059', 'ISHA', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309060', 'NIDHI', null, 'SAREEN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309061', 'MANMEET', null, 'SAHNI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309180', 'MITALI', null, 'SAGAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309181', 'REENA', null, 'REENA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309182', 'ASHISH', null, 'GOEL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309183', 'POOJA', null, 'MATTOO', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309184', 'RAJAN', null, 'SADANA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309185', 'DEEPAK', null, 'DEEPAK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309186', 'SHUBHAM', null, 'SHUBHAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309201', 'RISHU', null, 'SINGLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309202', 'MAHIPAL', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309203', 'TUSHAR', null, 'SETH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309204', 'AMIT', null, 'SETHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309205', 'NISHANT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309206', 'VISHAL', null, 'BHASIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309207', 'MANJEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309208', 'VIKAS', null, 'CHHABRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309209', 'ABHISHEK', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309210', 'ABHISHEK', null, 'ABHISHEK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309211', 'AJAY', null, 'KARTIK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309212', 'ANIRUDH', null, 'KAUSHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309213', 'RAHUL', null, 'DAHIYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309214', 'DEEPANSHU', null, 'MITTAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309215', 'AVNEET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309216', 'SAHIL', null, 'GULATI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309217', 'GAURAV', null, 'CHOUDHARY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309218', 'YATIN', null, 'MANOCHA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309219', 'SHUBHAM', null, 'GAUTAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309220', 'DEEPIKA', null, 'BHASIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309221', 'PRIYANKA', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309222', 'DIVYA', null, 'DIVYA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309223', 'ALKA', null, 'CHOPRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309224', 'PARDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309225', 'HARPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309226', 'VARUNA', null, 'VARUNA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309227', 'SUMESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309228', 'ROHIT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309229', 'ABHISHEK', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309230', 'BINDU', null, 'BALA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309231', 'PRINKAL', null, 'PRINKAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309232', 'MANPREET', null, 'MANPREET', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309233', 'PARAS', null, 'PAUL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309234', 'NITASHA', null, 'KASHYAP', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309235', 'RUPINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309236', 'PRIYA', null, 'BHARTI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309237', 'RAJEEV', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309238', 'MUKESH', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309239', 'SAHIL', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309240', 'MUNAWWAR', null, 'ALI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309241', 'POONAM', null, 'POONAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309242', 'MEGHA', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309243', 'MANAN', null, 'KAPOOR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309244', 'SUMIT', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309245', 'PARTEEK', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309246', 'GOURAV', null, 'KALRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309247', 'CHIRAG', null, 'SHEOKAND', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309248', 'ANKIT', null, 'GUGLANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309249', 'HARDEEP', null, 'DESWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309250', 'PREETINDER', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309251', 'MANAV', null, 'GOYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309252', 'PUNIT', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309253', 'ABHISHEK', null, 'BANSAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309254', 'SUKHJEET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309255', 'ASHISH', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309256', 'MOHIT', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309257', 'ANKITA', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309258', 'NIDHI', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309259', 'KARAN', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309260', 'KARTIKEYA', null, 'KHOSLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309261', 'NITIN', null, 'BHAT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309380', 'RAVINDER', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309381', 'SIMPI', null, 'SIMPI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309382', 'AAKRITI', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309383', 'MANISH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309384', 'LAKHVINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309385', 'TANU', null, 'SHREE', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309386', 'SHASHI', null, 'KANT', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309387', 'PARDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309401', 'PARUL', null, 'MALHOTRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309402', 'CHARANJIT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309403', 'VINAY', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309404', 'KHUSHBU', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309405', 'ANINDIT', null, 'CHHIBBER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309406', 'KOMALPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309407', 'SAKINA', null, 'SAKINA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309408', 'KANCHAN', null, 'KANCHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309409', 'PRIYAM', null, 'PIYUSH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309410', 'MAHAK', null, 'MAHAK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309411', 'JATIN', null, 'ARORA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309412', 'RAVINDER', null, 'MALIK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309413', 'ANKUSH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309414', 'POOJA', null, 'MEHTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309415', 'SAWAN', null, 'SAWAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309416', 'NANCY', null, 'NANCY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309417', 'AASTHA', null, 'AHUJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309418', 'SONAM', null, 'SONAM', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309419', 'VIKRAMJIT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309420', 'SNEHA', null, 'SAGAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309421', 'HAPPY', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309422', 'SURUCHI', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309423', 'MANDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309424', 'NITIN', null, 'GOYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309425', 'ANJALI', null, 'SACHDEVA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309426', 'KRITI', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309427', 'AYESHA', null, 'MALIK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309428', 'MUKESH', null, 'TOMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309429', 'JYOTI', null, 'JYOTI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309430', 'DIVYA', null, 'RANI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309431', 'GURPREET', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309432', 'SOURAV', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309433', 'SUNNY', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309434', 'RISHABH', null, 'NARULA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309435', 'PREETI', null, 'KHATKER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309436', 'AMAR', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309437', 'ABHINAM', null, 'DHIMAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309438', 'SHALINI', null, 'CHAUHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309439', 'SINDHU', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309440', 'TARUN', null, 'AGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309441', 'PRIYANKA', null, 'RANA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309442', 'PRATIBHA', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309443', 'KHUSHBOO', null, 'KHUSHBOO', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309444', 'PAWAN', null, 'AHUJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309445', 'SAHIL', null, 'SAHIL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309446', 'TRIPTA', null, 'TRIPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309447', 'BHAVIKA', null, 'CHHETTRI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309448', 'Parvesh', null, 'Kumar', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309580', 'PARVEEN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309601', 'KULDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309602', 'VIRENDER', null, 'VIRENDER', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309603', 'AKASH', null, 'GYAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309604', 'HARPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309605', 'RUPESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309606', 'DHEERAJ', null, 'BHARDWAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309607', 'HITESH', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309608', 'VIVEK', null, 'TIWARI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309609', 'SAHIL', null, 'AHUJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309610', 'AKASH', null, 'GOEL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309611', 'DIVESH', null, 'KUKREJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309612', 'BHAVYA', null, 'KAPOOR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309613', 'SAHIL', null, 'GOEL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309614', 'CHIRAG', null, 'MEHTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309615', 'MANOJ', null, 'RAVESH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309616', 'ANKIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309617', 'SUMIT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309618', 'PANKIT', null, 'SAGGAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309619', 'KETAN', null, 'AJAY', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309620', 'SUBHASH', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309621', 'SUNNY', null, 'CHOPRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309622', 'ASHISH', null, 'MALIK', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309623', 'RAHUL', null, 'RAHUL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309624', 'AKSHAT', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309625', 'SAURAV', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309626', 'MOHAN', null, 'MOHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309627', 'KULDEEP', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309628', 'RUPAM', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309629', 'PARVEEN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309630', 'RAHUL', null, 'RAHUL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309631', 'PANKAJ', null, 'PANKAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309632', 'GURJEET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309633', 'JAI', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309634', 'MOHIT', null, 'BHOLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309635', 'RAJESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309636', 'HEMENT', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309637', 'SANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309638', 'PARDEEP', null, 'RAI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309639', 'SHASHI', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309640', 'PANKAJ', null, 'PANWAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309641', 'SANDEEP', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309642', 'NISHANT', null, 'DHRUV', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309643', 'DEPTESH', null, 'NARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309644', 'RAJESH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309645', 'ROHIT', null, 'THAKUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309646', 'PRAVEEN', null, 'PRAKASH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309647', 'ADITYA', null, 'SANGA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309648', 'AGAM', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309649', 'AKASH', null, 'MITTAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309650', 'MANAN', null, 'KHANDUJA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309651', 'MOHIT', null, 'GAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309652', 'MUKUL', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309653', 'SAURABH', null, 'SHARMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309654', 'SAHIL', null, 'KESRI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309655', 'PANKAJ', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309656', 'ASHISH', null, 'KASHYAP', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309657', 'AKSHAY', null, 'SINGLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309658', 'CHINTU', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309659', 'EKANSH', null, 'GABA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309660', 'AKIN', null, 'SHARDA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309780', 'RAJ', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309781', 'PUNIT', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309782', 'ATTINDER', null, 'CHAHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309783', 'CHEENA', null, 'CHEENA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309784', 'ASHISH', null, 'JAIN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309785', 'MANMEET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309786', 'ARUN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309787', 'DEEPAK', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309788', 'JITENDER', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309789', 'KAMAL', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309790', 'UMESH', null, 'SAINI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309791', 'RAJNISH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2309792', 'ABHINAV', null, 'KALRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310001', 'Shivangi', null, 'Sharma', 'M', '9256477343', '0172-2550160', null);
INSERT INTO `student_personal` VALUES ('2310002', 'Ekta', null, 'Verma', 'M', '9255274508', '', null);
INSERT INTO `student_personal` VALUES ('2310003', 'Lovish', null, 'Sharma', 'M', '9416992728', '', null);
INSERT INTO `student_personal` VALUES ('2310004', 'Piyush', null, 'Baweja', 'M', '9466852185', '9416441847', null);
INSERT INTO `student_personal` VALUES ('2310005', 'Vidhika', null, 'Sharma', 'M', '9812183683', '0171-2650318', null);
INSERT INTO `student_personal` VALUES ('2310006', 'Shaina', null, '', 'M', '9466047155', '01744-241955', null);
INSERT INTO `student_personal` VALUES ('2310007', 'Deepak', null, 'Saroha', 'M', '9416780967', '0171-2651752', null);
INSERT INTO `student_personal` VALUES ('2310008', 'Abhinav', null, 'Jain', 'M', '9416114361', '0171-2641725', null);
INSERT INTO `student_personal` VALUES ('2310009', 'Ankurita', null, 'Hurrha', 'M', '9416317513', '', null);
INSERT INTO `student_personal` VALUES ('2310010', 'Deepa', null, 'Kalsi', 'M', '9416226503', '0171-2654324', null);
INSERT INTO `student_personal` VALUES ('2310011', 'Gurneet', null, 'Kaur', 'M', '9996042237', '', null);
INSERT INTO `student_personal` VALUES ('2310012', 'Hema', null, 'Yadav', 'M', '9729546332', '9416937331', null);
INSERT INTO `student_personal` VALUES ('2310013', 'Harpreet', null, 'Singh', 'M', '9416269033', '', null);
INSERT INTO `student_personal` VALUES ('2310014', 'Lalit', null, 'Kumar', 'M', '9416428910', '0171-2533091', null);
INSERT INTO `student_personal` VALUES ('2310015', 'Vishal', null, 'Verma', 'M', '9216400441', '0172-2734140', null);
INSERT INTO `student_personal` VALUES ('2310016', 'Shefali', null, 'Bhalla', 'M', '9896526627', '0171-2552118', null);
INSERT INTO `student_personal` VALUES ('2310017', 'Sonia', null, '', 'M', '9992781842', '9034179080', null);
INSERT INTO `student_personal` VALUES ('2310018', 'Bharat', null, 'Bhambhoria', 'M', '9896347090', '0171-2557090', null);
INSERT INTO `student_personal` VALUES ('2310019', 'Ritu', null, 'Dogra', 'M', '9896414566', '0171-2690893', null);
INSERT INTO `student_personal` VALUES ('2310020', 'Nancy', null, 'Umrao', 'M', '9416352794', '', null);
INSERT INTO `student_personal` VALUES ('2310021', 'Ashutosh', null, 'Pasi', 'M', '9541470286', '0171-2652797', null);
INSERT INTO `student_personal` VALUES ('2310022', 'Preety', null, 'Sohal', 'M', '9215179042', '', null);
INSERT INTO `student_personal` VALUES ('2310023', 'Anshul', null, 'Bhargava', 'M', '9355061889', '01732-226502', null);
INSERT INTO `student_personal` VALUES ('2310024', 'Payal', null, 'Verma', 'M', '9467910795', '0171-4020996', null);
INSERT INTO `student_personal` VALUES ('2310025', 'Manish', null, 'Gumbal', 'M', '9896674385', '0171-2661940', null);
INSERT INTO `student_personal` VALUES ('2310026', 'Probir', null, 'Chakrabarty', 'M', '9899850637', '011-25869565', null);
INSERT INTO `student_personal` VALUES ('2310027', 'Abha', null, 'Singh', 'M', '9466587054', '', null);
INSERT INTO `student_personal` VALUES ('2310028', 'Himanshu', null, 'Goel', 'M', '9466635040', '0171-4000623', null);
INSERT INTO `student_personal` VALUES ('2310029', 'Shivani', null, 'Aggarwal', 'M', '9996234971', '0171-2653523', null);
INSERT INTO `student_personal` VALUES ('2310030', 'Mehak', null, 'Guglani', 'M', '98201388828', '0172-2726930', null);
INSERT INTO `student_personal` VALUES ('2310031', 'Alok', null, 'Deep', 'M', '9457296900', '0171-2525063', null);
INSERT INTO `student_personal` VALUES ('2310032', 'Minakshi', null, 'Boruah', 'M', '9996165778', '', null);
INSERT INTO `student_personal` VALUES ('2310033', 'Gurmeet', null, 'Singh', 'M', '9253113779', '', null);
INSERT INTO `student_personal` VALUES ('2310034', 'Gagandeep', null, 'Singh', 'M', '9416471452', '0171-2699376', null);
INSERT INTO `student_personal` VALUES ('2310035', 'Simarpreet', null, 'Kaur', 'M', '9729059037', '0171-2557524', null);
INSERT INTO `student_personal` VALUES ('2310036', 'Jasmeet', null, 'Singh', 'M', '9896509143', '', null);
INSERT INTO `student_personal` VALUES ('2310037', 'Nidhi', null, 'Saini', 'M', '9466466295', '0171-2535500', null);
INSERT INTO `student_personal` VALUES ('2310038', 'Karan', null, 'Mehta', 'M', '9466714774', '0171-2662236', null);
INSERT INTO `student_personal` VALUES ('2310039', 'Sahil', null, 'Makkar', 'M', '9466387667', '', null);
INSERT INTO `student_personal` VALUES ('2310040', 'Sagar', null, 'Grover', 'M', '9034805225', '9416119800', null);
INSERT INTO `student_personal` VALUES ('2310041', 'Madhu', null, 'Sharma', 'M', '9996833386', '0171-2810018', null);
INSERT INTO `student_personal` VALUES ('2310042', 'Rajat', null, 'Kumar', 'M', '9355148017', '9896097403', null);
INSERT INTO `student_personal` VALUES ('2310043', 'Geetansh', null, 'Gulati', 'M', '9416280549', '0171-2640332', null);
INSERT INTO `student_personal` VALUES ('2310044', 'Kuldeep', null, 'Singh', 'M', '9034034864', '', null);
INSERT INTO `student_personal` VALUES ('2310045', 'Pratibha', null, 'Tripathi', 'M', '9389257892', '', null);
INSERT INTO `student_personal` VALUES ('2310046', 'Abha', null, 'Aggarwal', 'M', '9991227778', '01734-284288', null);
INSERT INTO `student_personal` VALUES ('2310047', 'Gaganjeet', null, 'Dhindsa', 'M', '9896196675', '0171-3233666', null);
INSERT INTO `student_personal` VALUES ('2310048', 'Annu', null, 'Kumari', 'M', '9017712278', '01276-244128', null);
INSERT INTO `student_personal` VALUES ('2310049', 'Neeraj', null, 'Khanna', 'M', '9896605347', '0171-4006734', null);
INSERT INTO `student_personal` VALUES ('2310050', 'Shubham', null, 'Chauhan', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310051', 'Sumeet', null, 'Singh', 'M', '9416937092', '0171-2871892', null);
INSERT INTO `student_personal` VALUES ('2310052', 'Neelotpal', null, 'Sharma', 'M', '9416377738', '', null);
INSERT INTO `student_personal` VALUES ('2310053', 'Sahil', null, 'Kumar', 'M', '9796222126', '', null);
INSERT INTO `student_personal` VALUES ('2310054', 'Jasmeet', null, 'Kaur', 'M', '9416876057', '', null);
INSERT INTO `student_personal` VALUES ('2310055', 'Sagar', null, 'Sood', 'M', '9896971305', '', null);
INSERT INTO `student_personal` VALUES ('2310056', 'Mohit', null, 'Bhargav', 'M', '9560124595', '', null);
INSERT INTO `student_personal` VALUES ('2310057', 'Manpreet', null, 'Singh', 'M', '9812359475', '0171-2855437', null);
INSERT INTO `student_personal` VALUES ('2310058', 'Lakshay', null, 'Madan', 'M', '9896051435', '0171-2532843', null);
INSERT INTO `student_personal` VALUES ('2310059', 'Heena', null, 'Aggarwal', 'M', '9416827327', '0171-2664064', null);
INSERT INTO `student_personal` VALUES ('2310060', 'Pulkit', null, 'Jain', 'M', '9812317661', '9466738475', null);
INSERT INTO `student_personal` VALUES ('2310180', 'MANDEEP', null, 'KAUR', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310181', 'HIMANSHU', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310182', 'NEHA', null, 'SHARMA', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310183', 'ARCHANA', null, 'SHARMA', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310184', 'DEEPAK', null, 'AGGARWAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310185', 'ARUN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310186', 'AYUSH', null, 'CHOPRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310201', 'Pranika', null, 'Kaur', 'M', '9416020030', '0171-2530030', null);
INSERT INTO `student_personal` VALUES ('2310202', 'Anuj', null, 'Dutt', 'M', '9416317218', '9416246340', null);
INSERT INTO `student_personal` VALUES ('2310203', 'Rahul', null, 'Kalra', 'M', '9812345411', '0171-2651412', null);
INSERT INTO `student_personal` VALUES ('2310204', 'Kashish', null, '', 'M', '9416293643', '0171-2650643', null);
INSERT INTO `student_personal` VALUES ('2310205', 'Deepak', null, 'Khurana', 'M', '9017531515', '0171-2531515', null);
INSERT INTO `student_personal` VALUES ('2310206', 'Vishal', null, 'Sangwan', 'M', '9416141107', '', null);
INSERT INTO `student_personal` VALUES ('2310207', 'Akansha', null, 'Singla', 'M', '9416494040', '0171-2531956', null);
INSERT INTO `student_personal` VALUES ('2310208', 'Sella', null, 'Nagpal', 'M', '9034589956', '', null);
INSERT INTO `student_personal` VALUES ('2310209', 'Jaspreet', null, 'Singh', 'M', '9416327028', '', null);
INSERT INTO `student_personal` VALUES ('2310210', 'Avneet', null, 'Singh', 'M', '9416187770', '0171-2444990', null);
INSERT INTO `student_personal` VALUES ('2310211', 'Sukhdeep', null, 'Kaur', 'M', '9416096653', '', null);
INSERT INTO `student_personal` VALUES ('2310212', 'Abhishek', null, 'Saini', 'M', '9416269903', '01734-263057', null);
INSERT INTO `student_personal` VALUES ('2310213', 'Bhoopendra', null, 'Singh', 'M', '9253097356', '', null);
INSERT INTO `student_personal` VALUES ('2310214', 'Amrita', null, 'Kaur', 'M', '9466834097', '0171-2671099', null);
INSERT INTO `student_personal` VALUES ('2310215', 'Jagriti', null, '', 'M', '9896301343', '0171-2669501', null);
INSERT INTO `student_personal` VALUES ('2310216', 'Manisha', null, '', 'M', '9813346636', '0171-2825186', null);
INSERT INTO `student_personal` VALUES ('2310217', 'Beeky', null, 'Singh', 'M', '9416280682', '', null);
INSERT INTO `student_personal` VALUES ('2310218', 'Pinky', null, 'Aledia', 'M', '9032653967', '', null);
INSERT INTO `student_personal` VALUES ('2310219', 'Kavita', null, '', 'M', '9468089099', '9466387964', null);
INSERT INTO `student_personal` VALUES ('2310220', 'Swinky', null, 'Rai', 'M', '9416458040', '0171-2664040', null);
INSERT INTO `student_personal` VALUES ('2310221', 'Neha', null, 'Dhiman', 'M', '9416156878', '', null);
INSERT INTO `student_personal` VALUES ('2310222', 'Navdeep', null, 'Singh', 'M', '9896843403', '', null);
INSERT INTO `student_personal` VALUES ('2310223', 'Denny', null, 'Saini', 'M', '9216177763', '', null);
INSERT INTO `student_personal` VALUES ('2310224', 'Manish', null, 'Saini', 'M', '9779548482', '', null);
INSERT INTO `student_personal` VALUES ('2310225', 'Tarun Kumar', null, 'Saini', 'M', '9416376252', '9466850989', null);
INSERT INTO `student_personal` VALUES ('2310226', 'Sandeep', null, 'Kumar', 'M', '9569887409', '', null);
INSERT INTO `student_personal` VALUES ('2310227', 'Amita', null, '', 'M', '9463353347', '', null);
INSERT INTO `student_personal` VALUES ('2310228', 'Maninder', null, 'Singh', 'M', '9896146142', '9896558665', null);
INSERT INTO `student_personal` VALUES ('2310229', 'Pankaj', null, 'Gera', 'M', '9896415964', '0171-3203697', null);
INSERT INTO `student_personal` VALUES ('2310230', 'Ankur', null, '', 'M', '9354561518', '0171-2610762', null);
INSERT INTO `student_personal` VALUES ('2310231', 'Arpan', null, 'Rathore', 'M', '8950583153', '0171-2690894', null);
INSERT INTO `student_personal` VALUES ('2310232', 'Vernika', null, 'Gupta', 'M', '9416006299', '0171-2511299', null);
INSERT INTO `student_personal` VALUES ('2310233', 'Mansi', null, '', 'M', '9416306783', '0171-2653113', null);
INSERT INTO `student_personal` VALUES ('2310234', 'Khushboo', null, 'Mittal', 'M', '9996464944', '0171-2551325', null);
INSERT INTO `student_personal` VALUES ('2310235', 'Daisy', null, 'Jhamba', 'M', '9416192090', '0171-2517724', null);
INSERT INTO `student_personal` VALUES ('2310236', 'Varun', null, 'Arora', 'M', '9466242000', '0184-2292468', null);
INSERT INTO `student_personal` VALUES ('2310237', 'Sunveer', null, 'Malhotra', 'M', '9034100293', '0171-4020293', null);
INSERT INTO `student_personal` VALUES ('2310238', 'Divya', null, 'Sharma', 'M', '9729541877', '01734-278055', null);
INSERT INTO `student_personal` VALUES ('2310239', 'Vasu', null, 'Ahuja', 'M', '9416462949', '0171-2650197', null);
INSERT INTO `student_personal` VALUES ('2310240', 'Vishali', null, 'Chadha', 'M', '9416247418', '9996338885', null);
INSERT INTO `student_personal` VALUES ('2310241', 'Ishu', null, 'Sharma', 'M', '9416803187', '0171-2822513', null);
INSERT INTO `student_personal` VALUES ('2310242', 'Aman', null, 'Gulati', 'M', '9315597701', '9416966248', null);
INSERT INTO `student_personal` VALUES ('2310243', 'Varinda', null, 'Aggarwal', 'M', '9467526313', '0171-2518897', null);
INSERT INTO `student_personal` VALUES ('2310244', 'Jasleen', null, 'Kaur', 'M', '9896018753', '', null);
INSERT INTO `student_personal` VALUES ('2310245', 'Baljinder', null, 'Singh', 'M', '9466260068', '', null);
INSERT INTO `student_personal` VALUES ('2310246', 'Aakanksha', null, 'Sharma(Km)', 'M', '9419140897', '0191-2505544', null);
INSERT INTO `student_personal` VALUES ('2310247', 'Rahul', null, 'Mahendru', 'M', '9416966217', '0171-2520937', null);
INSERT INTO `student_personal` VALUES ('2310248', 'Ajit', null, 'Singh', 'M', '9416252483', '8059180673', null);
INSERT INTO `student_personal` VALUES ('2310249', 'Aakruiti', null, 'Kuntal', 'M', '9729539533', '', null);
INSERT INTO `student_personal` VALUES ('2310250', 'Avneet', null, 'Kaur', 'M', '9255270628', '', null);
INSERT INTO `student_personal` VALUES ('2310251', 'Rupesh', null, 'Kumar', 'M', '8950232860', '', null);
INSERT INTO `student_personal` VALUES ('2310252', 'Rajan', null, 'Garg', 'M', '9729904154', '9466662383', null);
INSERT INTO `student_personal` VALUES ('2310253', 'Arvind', null, 'Tiwari', 'M', '9729092805', '9896814232', null);
INSERT INTO `student_personal` VALUES ('2310254', 'Ankit', null, 'Chhabra', 'M', '9996464664', '9896085223', null);
INSERT INTO `student_personal` VALUES ('2310255', 'Malkeet', null, 'Singh', 'M', '9991623797', '', null);
INSERT INTO `student_personal` VALUES ('2310256', 'Rishabh', null, '', 'M', '9896424149', '0171-2669007', null);
INSERT INTO `student_personal` VALUES ('2310257', 'Ankur', null, 'Rastogi', 'M', '9416352495', '0171-2619023', null);
INSERT INTO `student_personal` VALUES ('2310258', 'Ayushi', null, 'Maheshwari', 'M', '9416910285', '0171-2557164', null);
INSERT INTO `student_personal` VALUES ('2310259', 'Nishant', null, 'Moudgil', 'M', '9466289017', '0171-2640017', null);
INSERT INTO `student_personal` VALUES ('2310260', 'Aseem', null, 'Kapoor', 'M', '9416187454', '0171-2530244', null);
INSERT INTO `student_personal` VALUES ('2310261', 'Samir', null, 'Ali', 'M', '9416960960', '', null);
INSERT INTO `student_personal` VALUES ('2310380', 'POONAM', null, 'RANI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310381', 'SUMAN', null, 'LATA', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310382', 'VARUN', null, 'NARAD', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310383', 'KAWAL', null, 'JEET', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310384', 'ABHISHEK', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310385', 'NIKHIL', null, 'BHATIA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310386', 'NEELAM', null, 'RANI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310387', 'SANDEEP', null, 'GOYAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310401', 'Ajay', null, '', 'M', '9416957445', '9729219562', null);
INSERT INTO `student_personal` VALUES ('2310402', 'Vrinda', null, 'Gupta', 'M', '9416494711', '9812076842', null);
INSERT INTO `student_personal` VALUES ('2310403', 'Rohan', null, 'Dilaury', 'M', '9215325222', '9255388772', null);
INSERT INTO `student_personal` VALUES ('2310404', 'Himanshu', null, '', 'M', '9868822350', '9015414728', null);
INSERT INTO `student_personal` VALUES ('2310405', 'Mansi', null, 'Ganjoo', 'M', '9419186018', '0191-259140', null);
INSERT INTO `student_personal` VALUES ('2310406', 'Pawan', null, 'Kumar', 'M', '7876004295', '8950117134', null);
INSERT INTO `student_personal` VALUES ('2310407', 'Anurag', null, 'Kumar', 'M', '9416224874', '7206269868', null);
INSERT INTO `student_personal` VALUES ('2310408', 'Puneet', null, 'Kaur', 'M', '9896065453', '9255819287', null);
INSERT INTO `student_personal` VALUES ('2310409', 'Raman', null, 'Surya', 'M', '9034400537', '01681/326029', null);
INSERT INTO `student_personal` VALUES ('2310410', 'Archana', null, 'Saini', 'M', '9289510906', '9250937388', null);
INSERT INTO `student_personal` VALUES ('2310411', 'Visheshta', null, 'Sharad', 'M', '9582158589', '9818157379', null);
INSERT INTO `student_personal` VALUES ('2310412', 'Gourav', null, 'Koul', 'M', '9781405274', '0191-2593072', null);
INSERT INTO `student_personal` VALUES ('2310413', 'Gaurav Rahul', null, 'Saini', 'M', '9896324430', '0171-2664488', null);
INSERT INTO `student_personal` VALUES ('2310414', 'Anupam', null, 'Sibal', 'M', '9255424711', '0171-2610587', null);
INSERT INTO `student_personal` VALUES ('2310415', 'Deepika', null, 'Thakur', 'M', '9816246633', '', null);
INSERT INTO `student_personal` VALUES ('2310416', 'Apoorva', null, 'Sharma', 'M', '9319519004', '01332-276719', null);
INSERT INTO `student_personal` VALUES ('2310417', 'Shubham', null, 'Rana', 'M', '9813486515', '', null);
INSERT INTO `student_personal` VALUES ('2310418', 'Akanksha', null, 'Bhat', 'M', '9878888851', '9878888893', null);
INSERT INTO `student_personal` VALUES ('2310419', 'Aurvindo', null, '', 'M', '9815583763', '0181-4622763', null);
INSERT INTO `student_personal` VALUES ('2310420', 'Aakriti', null, 'Bhat', 'M', '9419210652', '0191-2552001', null);
INSERT INTO `student_personal` VALUES ('2310421', 'Aditya', null, 'Chauhan', 'M', '9215579544', '0171-2828004', null);
INSERT INTO `student_personal` VALUES ('2310422', 'Reetika', null, 'Kalra', 'M', '9466841688', '0171-2443774', null);
INSERT INTO `student_personal` VALUES ('2310423', 'Sweta', null, 'Kumari', 'M', '9576395539', '', null);
INSERT INTO `student_personal` VALUES ('2310424', 'Manish', null, 'Kumar', 'M', '8102678022', '', null);
INSERT INTO `student_personal` VALUES ('2310425', 'Neha', null, 'Singh', 'M', '9023259531', '9931456437', null);
INSERT INTO `student_personal` VALUES ('2310580', 'PARVESH', null, 'KALRA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310601', 'Jasbir', null, '', 'M', '9050345871', '', null);
INSERT INTO `student_personal` VALUES ('2310602', 'Navneet', null, 'Kumar', 'M', '9416224630', '0171-2897569', null);
INSERT INTO `student_personal` VALUES ('2310603', 'Mishel', null, 'Dhiman', 'M', '9812042152', '0171-2699027', null);
INSERT INTO `student_personal` VALUES ('2310604', 'Rahul', null, '', 'M', '9467080189', '', null);
INSERT INTO `student_personal` VALUES ('2310605', 'Manprabh', null, 'Gill', 'M', '9253741113', '9996327447', null);
INSERT INTO `student_personal` VALUES ('2310606', 'Sandeep', null, 'Kumar', 'M', '9255938276', '9034972781', null);
INSERT INTO `student_personal` VALUES ('2310607', 'Himanshu', null, '', 'M', '9896239354', '01732-291058', null);
INSERT INTO `student_personal` VALUES ('2310608', 'Ravi', null, 'Kumar', 'M', '8950503942', '', null);
INSERT INTO `student_personal` VALUES ('2310609', 'Hardeep', null, 'Singh', 'M', '9416431104', '9996871500', null);
INSERT INTO `student_personal` VALUES ('2310610', 'Nitish', null, 'Sharma', 'M', '9813291225', '01734-286175', null);
INSERT INTO `student_personal` VALUES ('2310611', 'Rishab', null, '', 'M', '9255358608', '9034105663', null);
INSERT INTO `student_personal` VALUES ('2310612', 'Tinku', null, '', 'M', '9253167676', '9996363133', null);
INSERT INTO `student_personal` VALUES ('2310613', 'Jaswinder', null, 'Jeet', 'M', '9468029008', '0171-2669150', null);
INSERT INTO `student_personal` VALUES ('2310614', 'Abhinav', null, 'Deep', 'M', '9416979311', '', null);
INSERT INTO `student_personal` VALUES ('2310615', 'Praveen', null, 'Grover', 'M', '9416443521', '', null);
INSERT INTO `student_personal` VALUES ('2310616', 'Sachin', null, '', 'M', '9211620304', '9728092705', null);
INSERT INTO `student_personal` VALUES ('2310617', 'Parth', null, 'Bahmani', 'M', '9416231826', '', null);
INSERT INTO `student_personal` VALUES ('2310618', 'Rajesh', null, 'Kumar', 'M', '', '9416966408', null);
INSERT INTO `student_personal` VALUES ('2310619', 'Nishant', null, 'Kaushik', 'M', '9541785571', '9416275498', null);
INSERT INTO `student_personal` VALUES ('2310620', 'Rahul', null, 'Saini', 'M', '9813030839', '01744-267038', null);
INSERT INTO `student_personal` VALUES ('2310621', 'Deepak', null, 'Parjapat', 'M', '9417957459', '01731-316908', null);
INSERT INTO `student_personal` VALUES ('2310622', 'Naiya', null, 'Mayur', 'M', '9813524460', '', null);
INSERT INTO `student_personal` VALUES ('2310623', 'Vaibhav', null, 'Chadha', 'M', '9416085668', '0171-2651671', null);
INSERT INTO `student_personal` VALUES ('2310624', 'Manpreet', null, 'Singh', 'M', '9416960371', '0171-2663500', null);
INSERT INTO `student_personal` VALUES ('2310625', 'Ashish', null, 'Sharma', 'M', '9355180845', '0171-2552845', null);
INSERT INTO `student_personal` VALUES ('2310626', 'Gurpal', null, 'Singh', 'M', '9416108118', '0171-2534121', null);
INSERT INTO `student_personal` VALUES ('2310627', 'Gulab', null, 'Singh', 'M', '9255293015', '9996234157', null);
INSERT INTO `student_personal` VALUES ('2310628', 'Sukesh', null, 'Tyagi', 'M', '97828120619', '9416162828', null);
INSERT INTO `student_personal` VALUES ('2310629', 'Himanshu', null, 'Bansal', 'M', '9017404523', '', null);
INSERT INTO `student_personal` VALUES ('2310630', 'Karan', null, 'Walia', 'M', '9996941168', '9416378230', null);
INSERT INTO `student_personal` VALUES ('2310631', 'Arvind', null, 'Singh', 'M', '9671224398', '9813524363', null);
INSERT INTO `student_personal` VALUES ('2310632', 'Ravi', null, 'Dev', 'M', '', '9416369535', null);
INSERT INTO `student_personal` VALUES ('2310633', 'Sagar', null, 'Dhindsa', 'M', '9467003711', '9416135661', null);
INSERT INTO `student_personal` VALUES ('2310634', 'Gagandeep', null, 'Singh', 'M', '9416366625', '01734-240633', null);
INSERT INTO `student_personal` VALUES ('2310635', 'Pushpender', null, 'Singh', 'M', '', '8950728185', null);
INSERT INTO `student_personal` VALUES ('2310636', 'Deepak', null, 'Narula', 'M', '', '9996091424', null);
INSERT INTO `student_personal` VALUES ('2310637', 'Nishank', null, 'Gupta', 'M', '9896618599', '0171-2644494', null);
INSERT INTO `student_personal` VALUES ('2310638', 'Ashwani', null, 'Sharma', 'M', '9254902712', '9034799937', null);
INSERT INTO `student_personal` VALUES ('2310639', 'Mayank', null, 'Arora', 'M', '9034727970', '01744-254229', null);
INSERT INTO `student_personal` VALUES ('2310640', 'Rahul', null, 'Saini', 'M', '9034272057', '', null);
INSERT INTO `student_personal` VALUES ('2310641', 'Vivek', null, 'Sharma', 'M', '9812971128', '', null);
INSERT INTO `student_personal` VALUES ('2310642', 'Abhishek', null, 'Kumar', 'M', '9431874703', '9430996238', null);
INSERT INTO `student_personal` VALUES ('2310643', 'Neeraj', null, '', 'M', '9416686637', '', null);
INSERT INTO `student_personal` VALUES ('2310644', 'Shubham', null, 'Sharma', 'M', '9416024056', '0171-2652056', null);
INSERT INTO `student_personal` VALUES ('2310645', 'Ajay', null, 'Kumar', 'M', '9466765248', '0171-2661581', null);
INSERT INTO `student_personal` VALUES ('2310646', 'Pankaj', null, 'Kumar', 'M', '9416285090', '', null);
INSERT INTO `student_personal` VALUES ('2310647', 'Vinod', null, 'Kumar', 'M', '8950115954', '', null);
INSERT INTO `student_personal` VALUES ('2310648', 'Varun', null, 'Bratt Arya', 'M', '941683446', '', null);
INSERT INTO `student_personal` VALUES ('2310649', 'Anuj', null, 'Joshi', 'M', '9899225589', '011-27351982', null);
INSERT INTO `student_personal` VALUES ('2310650', 'Gobind', null, '', 'M', '9992478777', '', null);
INSERT INTO `student_personal` VALUES ('2310651', 'Nishant', null, 'Kumar', 'M', '9813876544', '9813876509', null);
INSERT INTO `student_personal` VALUES ('2310652', 'Ashish', null, 'Sharma', 'M', '9540040346', '9467326632', null);
INSERT INTO `student_personal` VALUES ('2310653', 'Mohit', null, 'Gupta', 'M', '9813861074', '', null);
INSERT INTO `student_personal` VALUES ('2310654', 'Deepak', null, 'Jain', 'M', '9466567190', '01253-258436', null);
INSERT INTO `student_personal` VALUES ('2310655', 'Chetan', null, 'Batra', 'M', '989669780', '', null);
INSERT INTO `student_personal` VALUES ('2310656', 'Bhasker', null, 'Bhanot', 'M', '9729396017', '9255879545', null);
INSERT INTO `student_personal` VALUES ('2310657', 'Sourabh', null, 'Rana', 'M', '9729448278', '', null);
INSERT INTO `student_personal` VALUES ('2310658', 'Aman', null, '', 'M', '9896362431', '0171-2669721', null);
INSERT INTO `student_personal` VALUES ('2310659', 'Sarabjeet', null, 'Singh', 'M', '9466820935', '01734-276833', null);
INSERT INTO `student_personal` VALUES ('2310660', 'Abhishek', null, 'Sharma', 'M', '9466608968', '', null);
INSERT INTO `student_personal` VALUES ('2310780', 'GURCHRAN SINGH', null, 'TOMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310781', 'KAMAL', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310782', 'ANKIT', null, 'PASSI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310783', 'Ekta', null, '', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310784', 'KIRAN', null, 'DEVI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('2310785', 'AMANDEEP SINGH', null, 'BHALLA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('2310786', 'ASHISH', null, 'PATIAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309201', 'CHARANPREET', null, 'SETHI', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309202', 'NAVJOT', null, 'KAUR', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309203', 'AVESH', null, 'GARG', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309204', 'HITENDER', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309205', 'MANISH', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309206', 'JASWINDER', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309207', 'NEHA', null, 'AGGARWAL', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309208', 'PARUL', null, 'MINOCHA', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309209', 'ANURAG', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309210', 'DEEPAK', null, 'VERMA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309211', 'PUNEET', null, 'SAGAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309212', 'MANPREET', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309213', 'PARUL', null, 'MALHOTRA', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309214', 'VINAY', null, 'BHARDWAJ', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309215', 'RAVI', null, 'KAUSHAL', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309216', 'BACHANL', null, 'SINGH', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309217', 'MANDEEP', null, 'KAUR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309218', 'RAHUL', null, 'SAXENA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309401', 'DEEPIKA', null, 'GARG', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309402', 'DIVYA', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309403', 'SATISH', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309404', 'SACHIN', null, 'KUMAR', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309405', 'PRAGATI', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309406', 'HEMLATA', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309407', 'SAHIL', null, 'BHUSHAN', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309408', 'SHREYA', null, 'BISHNOI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309409', 'PRIYANKA', null, 'RANI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309410', 'ANJALI', null, 'SHARMA', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309411', 'GEETANJALI', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309412', 'SANJEEV', null, 'BALDA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309413', 'KANIKA', null, 'DUHAN', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309414', 'VISHAL', null, 'GUPTA', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309415', 'SHARUTI', null, null, 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309416', 'RANDEEP', null, null, 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309417', 'RANI', null, 'GOEL', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2309418', 'NIHARIKA', null, 'GULATI', 'F', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310001', 'Sakshi', null, 'Gupta', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310002', 'Kamal', null, 'Kumar', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310003', 'Brij', null, 'Pal', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310004', 'Saurabh', null, 'Sharma', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310005', 'Aastha', null, 'Garg', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310006', 'Ankita', null, 'Sharma', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310007', 'Namrata', null, 'Puri', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310008', 'Gunjan', null, 'Sethi', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310009', 'Zumita', null, 'Kaushal', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310010', 'Parul', null, 'Goel', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310011', 'Kanika', null, 'Gupta', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310012', 'Stuti', null, 'Mehla', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310013', 'Shruti', null, 'Katyal', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310014', 'Gurpreet', null, 'Kaur', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310015', 'Nikita', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310016', 'Siddharth', null, 'Arora', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310017', 'Bindu', null, 'Rani', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310018', 'Neha', null, 'Miglani', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310201', 'Isha', null, 'Jain', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310202', 'Shefali', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310203', 'Manisha', null, 'Dhindsa', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310204', 'Sumit', null, 'Jha', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310205', 'Shivangi', null, 'Gupta', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310206', 'Pooja', null, 'Lamba', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310207', 'Sonam', null, 'Aggarwal', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310208', 'Gagandeep', null, 'Singh', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310209', 'Nipun', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310210', 'Swati', null, 'Sharma', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310211', 'Harmanpreet', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310212', 'Neetu', null, 'Sharma', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310213', 'Vibha', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310214', 'Sakshi', null, 'Anand', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310215', 'Manpreet', null, 'Kaur', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310216', 'Ritu', null, 'Devi', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310217', 'Geetanjali', null, 'Jain', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310218', 'Tanu', null, 'Pahwa', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310401', 'Ridhi', null, 'Mehta', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310402', 'Neha', null, 'Kashyap', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310403', 'Saru', null, 'Saini', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310404', 'Sushri Suchismita', null, 'Nathsharma', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310405', 'Neha', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310406', 'Priya', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310407', 'Paavan', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310408', 'Anuradha', null, 'Saini', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310409', 'Amandeep', null, 'Kaur', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310410', 'Sujata', null, 'Sharma', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310411', 'Gourav', null, 'Choudhary', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310412', 'Mohit', null, '', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310413', 'Priyanka', null, 'Kalra', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310414', 'Hemant', null, 'Tyagi', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310415', 'Pardeep', null, 'Kumar', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310416', 'Shagun', null, 'Gujral', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310417', 'Jagdeep', null, 'Singh', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310601', 'Bhupinder', null, 'Singh', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310602', 'Yadvinder', null, 'Singh', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310603', 'Ashok', null, 'Malik', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310604', 'Rakesh', null, 'Sharma', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310605', 'Suraj', null, 'Choudhary', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310606', 'Parveen', null, 'Kumar', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310607', 'Dyal', null, 'Singh', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310608', 'Manish', null, 'Kumar', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310609', 'Punit', null, 'Sihag', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310610', 'Anuj', null, 'Chauhan', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310611', 'Viney', null, 'Jain', 'M', null, null, null);
INSERT INTO `student_personal` VALUES ('MT2310612', 'Vikas', null, 'Sahu', 'M', null, null, null);

-- ----------------------------
-- Table structure for `student_qualification`
-- ----------------------------
DROP TABLE IF EXISTS `student_qualification`;
CREATE TABLE `student_qualification` (
  `student_roll_no` char(20) NOT NULL,
  `qualification_id` char(5) NOT NULL,
  `remark` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`qualification_id`,`student_roll_no`),
  KEY `fk_student_qualification_qualification1` (`qualification_id`) USING BTREE,
  KEY `fk_student_qualification_student_personal1` (`student_roll_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student_qualification
-- ----------------------------
