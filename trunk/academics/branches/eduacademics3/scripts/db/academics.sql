SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `academics` ;
CREATE SCHEMA IF NOT EXISTS `academics` DEFAULT CHARACTER SET utf8 ;
USE `academics` ;

-- -----------------------------------------------------
-- Table `academics`.`semester_degree`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`semester_degree` ;

CREATE  TABLE IF NOT EXISTS `academics`.`semester_degree` (
  `department_id` CHAR(10) NOT NULL ,
  `degree_id` CHAR(10) NOT NULL ,
  `semester_id` TINYINT NOT NULL ,
  PRIMARY KEY (`department_id`, `degree_id`, `semester_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`academic_session`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`academic_session` ;

CREATE  TABLE IF NOT EXISTS `academics`.`academic_session` (
  `academic_year` YEAR NOT NULL ,
  `semester_type` CHAR(10) NOT NULL ,
  `start_date` DATE NULL DEFAULT NULL ,
  `end_date` DATE NULL DEFAULT NULL ,
  `department_id` CHAR(10) NOT NULL ,
  `degree_id` CHAR(10) NOT NULL ,
  `semester_id` TINYINT NOT NULL ,
  PRIMARY KEY (`academic_year`, `semester_type`) ,
  CONSTRAINT `fk_academic_session_semester_degree1`
    FOREIGN KEY (`department_id` , `degree_id` , `semester_id` )
    REFERENCES `academics`.`semester_degree` (`department_id` , `degree_id` , `semester_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Sessions information of a particular calender year.';

CREATE INDEX `fk_academic_session_semester_degree1` ON `academics`.`academic_session` (`department_id` ASC, `degree_id` ASC, `semester_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`period_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`period_info` ;

CREATE  TABLE IF NOT EXISTS `academics`.`period_info` (
  `period_number` TINYINT UNSIGNED NOT NULL ,
  `duration` TINYINT NULL DEFAULT NULL COMMENT 'Duration in minutes' ,
  `start_time` TIME NULL DEFAULT NULL ,
  PRIMARY KEY (`period_number`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Total number of periods in college';


-- -----------------------------------------------------
-- Table `academics`.`period_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`period_type` ;

CREATE  TABLE IF NOT EXISTS `academics`.`period_type` (
  `period_type_id` CHAR(5) NOT NULL ,
  `description` VARCHAR(30) NULL ,
  PRIMARY KEY (`period_type_id`) )
ENGINE = InnoDB
COMMENT = 'Break or anything else';


-- -----------------------------------------------------
-- Table `academics`.`weekday`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`weekday` ;

CREATE  TABLE IF NOT EXISTS `academics`.`weekday` (
  `weekday_number` TINYINT UNSIGNED NOT NULL ,
  `weekday_name` VARCHAR(20) NULL ,
  PRIMARY KEY (`weekday_number`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`period`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`period` ;

CREATE  TABLE IF NOT EXISTS `academics`.`period` (
  `period_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `department_id` CHAR(10) NOT NULL ,
  `degree_id` CHAR(10) NOT NULL ,
  `semester_id` TINYINT NOT NULL ,
  `weekday_number` TINYINT UNSIGNED NOT NULL ,
  `period_number` TINYINT UNSIGNED NOT NULL ,
  `period_type_id` CHAR(5) NOT NULL ,
  PRIMARY KEY (`period_id`) ,
  CONSTRAINT `fk_period_period_info1`
    FOREIGN KEY (`period_number` )
    REFERENCES `academics`.`period_info` (`period_number` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_period_period_type1`
    FOREIGN KEY (`period_type_id` )
    REFERENCES `academics`.`period_type` (`period_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_period_semester_degree1`
    FOREIGN KEY (`department_id` , `degree_id` , `semester_id` )
    REFERENCES `academics`.`semester_degree` (`department_id` , `degree_id` , `semester_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_period_weekday1`
    FOREIGN KEY (`weekday_number` )
    REFERENCES `academics`.`weekday` (`weekday_number` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_period_period_info1` ON `academics`.`period` (`period_number` ASC) ;

CREATE INDEX `fk_period_period_type1` ON `academics`.`period` (`period_type_id` ASC) ;

CREATE INDEX `fk_period_semester_degree1` ON `academics`.`period` (`department_id` ASC, `degree_id` ASC, `semester_id` ASC) ;

CREATE INDEX `fk_period_weekday1` ON `academics`.`period` (`weekday_number` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`subject_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`subject_type` ;

CREATE  TABLE IF NOT EXISTS `academics`.`subject_type` (
  `subject_type_id` CHAR(5) NOT NULL ,
  `description` VARCHAR(30) NULL DEFAULT NULL ,
  PRIMARY KEY (`subject_type_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Type of Subject, theory or practical etc';


-- -----------------------------------------------------
-- Table `academics`.`subject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`subject` ;

CREATE  TABLE IF NOT EXISTS `academics`.`subject` (
  `subject_id` INT NOT NULL AUTO_INCREMENT ,
  `subject_code` CHAR(10) NOT NULL ,
  `abbr` VARCHAR(15) NULL ,
  `subject_name` VARCHAR(60) NULL DEFAULT NULL ,
  `subject_type_id` CHAR(5) NOT NULL ,
  `is_optional` TINYINT(1)  NULL DEFAULT FALSE ,
  `lecture_per_week` TINYINT(4) UNSIGNED NULL DEFAULT 0 ,
  `tutorial_per_week` TINYINT(4) UNSIGNED NULL DEFAULT 0 ,
  `practical_per_week` TINYINT(4) UNSIGNED NULL DEFAULT 0 ,
  `suggested_duration` TINYINT UNSIGNED NULL DEFAULT 1 ,
  `subjectcol` VARCHAR(45) NULL ,
  PRIMARY KEY (`subject_id`) ,
  CONSTRAINT `fk_subject_subject_type1`
    FOREIGN KEY (`subject_type_id` )
    REFERENCES `academics`.`subject_type` (`subject_type_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'All available subjects';

CREATE INDEX `fk_subject_subject_type1` ON `academics`.`subject` (`subject_type_id` ASC) ;

CREATE UNIQUE INDEX `subject_code_UNIQUE` ON `academics`.`subject` (`subject_code` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`subject_mode`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`subject_mode` ;

CREATE  TABLE IF NOT EXISTS `academics`.`subject_mode` (
  `subject_mode_id` CHAR(5) NOT NULL ,
  `subject_mode_name` VARCHAR(30) NULL DEFAULT NULL ,
  `subject_type_id` CHAR(5) NOT NULL ,
  `group_together` TINYINT(1)  NULL DEFAULT FALSE ,
  PRIMARY KEY (`subject_mode_id`) ,
  CONSTRAINT `fk_subject_mode_subject_type1`
    FOREIGN KEY (`subject_type_id` )
    REFERENCES `academics`.`subject_type` (`subject_type_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_subject_mode_subject_type1` ON `academics`.`subject_mode` (`subject_type_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`subject_faculty`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`subject_faculty` ;

CREATE  TABLE IF NOT EXISTS `academics`.`subject_faculty` (
  `department_id` CHAR(10) NOT NULL ,
  `subject_code` CHAR(10) NOT NULL ,
  `subject_mode_id` CHAR(5) NOT NULL ,
  `staff_id` CHAR(10) NOT NULL ,
  PRIMARY KEY (`subject_code`, `subject_mode_id`, `staff_id`, `department_id`) ,
  CONSTRAINT `fk_table1_subject1`
    FOREIGN KEY (`subject_code` )
    REFERENCES `academics`.`subject` (`subject_code` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_subject_mode1`
    FOREIGN KEY (`subject_mode_id` )
    REFERENCES `academics`.`subject_mode` (`subject_mode_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_subject_faculty_semester_degree1`
    FOREIGN KEY (`department_id` )
    REFERENCES `academics`.`semester_degree` (`department_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX `fk_table1_subject1` ON `academics`.`subject_faculty` (`subject_code` ASC) ;

CREATE INDEX `fk_table1_subject_mode1` ON `academics`.`subject_faculty` (`subject_mode_id` ASC) ;

CREATE INDEX `fk_subject_faculty_semester_degree1` ON `academics`.`subject_faculty` (`department_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`timetable`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`timetable` ;

CREATE  TABLE IF NOT EXISTS `academics`.`timetable` (
  `timetable_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `period_id` SMALLINT UNSIGNED NOT NULL ,
  `subject_code` CHAR(10) NOT NULL ,
  `subject_mode_id` CHAR(5) NOT NULL ,
  `staff_id` CHAR(10) NOT NULL ,
  `department_id` CHAR(10) NOT NULL ,
  `group_id` CHAR(5) NOT NULL ,
  `period_duration` TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'count of periods covered e.g. 3' ,
  `periods_covered` SET('1','2','3','4','5','6','7','8') NOT NULL COMMENT 'Period_numbers including itself e.g. 5,6,7 if period is 5 and period_duration is 3' ,
  `block_id` CHAR(10) NOT NULL ,
  `room_id` CHAR(10) NOT NULL ,
  `valid_from` DATE NULL ,
  `valid_upto` DATE NULL ,
  PRIMARY KEY (`timetable_id`) ,
  CONSTRAINT `fk_timetable_period1`
    FOREIGN KEY (`period_id` )
    REFERENCES `academics`.`period` (`period_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_timetable_subject_faculty1`
    FOREIGN KEY (`subject_code` , `subject_mode_id` , `staff_id` , `department_id` )
    REFERENCES `academics`.`subject_faculty` (`subject_code` , `subject_mode_id` , `staff_id` , `department_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Timetable schedule for attendance.';

CREATE INDEX `fk_timetable_period1` ON `academics`.`timetable` (`period_id` ASC) ;

CREATE INDEX `fk_timetable_subject_faculty1` ON `academics`.`timetable` (`subject_code` ASC, `subject_mode_id` ASC, `staff_id` ASC, `department_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`period_attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`period_attendance` ;

CREATE  TABLE IF NOT EXISTS `academics`.`period_attendance` (
  `period_date` DATE NOT NULL ,
  `timetable_id` INT UNSIGNED NOT NULL ,
  `staff_id` CHAR(10) NOT NULL ,
  `marked_date` DATE NULL ,
  PRIMARY KEY (`period_date`, `timetable_id`) ,
  CONSTRAINT `fk_period_attendance_timetable1`
    FOREIGN KEY (`timetable_id` )
    REFERENCES `academics`.`timetable` (`timetable_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'Attendance of Period';

CREATE INDEX `fk_period_attendance_timetable1` ON `academics`.`period_attendance` (`timetable_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`student_attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`student_attendance` ;

CREATE  TABLE IF NOT EXISTS `academics`.`student_attendance` (
  `period_date` DATE NOT NULL ,
  `timetable_id` INT UNSIGNED NOT NULL ,
  `student_roll_no` CHAR(20) NOT NULL ,
  PRIMARY KEY (`student_roll_no`, `period_date`, `timetable_id`) ,
  CONSTRAINT `fk_student_attendance_period_attendance1`
    FOREIGN KEY (`period_date` , `timetable_id` )
    REFERENCES `academics`.`period_attendance` (`period_date` , `timetable_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Attendance of Student';

CREATE INDEX `fk_student_attendance_period_attendance1` ON `academics`.`student_attendance` (`period_date` ASC, `timetable_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`student_academic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`student_academic` ;

CREATE  TABLE IF NOT EXISTS `academics`.`student_academic` (
  `student_roll_no` CHAR(20) NOT NULL ,
  PRIMARY KEY (`student_roll_no`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`adjustment_faculty`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`adjustment_faculty` ;

CREATE  TABLE IF NOT EXISTS `academics`.`adjustment_faculty` (
  `start_date` DATE NOT NULL ,
  `source_timetable_id` INT UNSIGNED NOT NULL ,
  `source_staff_id` CHAR(10) NOT NULL ,
  `target_timetable_id` INT UNSIGNED NOT NULL ,
  `target_staff_id` CHAR(10) NOT NULL ,
  `end_date` DATE NULL ,
  `purpose` VARCHAR(120) NULL ,
  PRIMARY KEY (`start_date`, `source_timetable_id`) ,
  CONSTRAINT `fk_adjustment_faculty_timetable1`
    FOREIGN KEY (`source_timetable_id` )
    REFERENCES `academics`.`timetable` (`timetable_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `fk_adjustment_faculty_timetable2`
    FOREIGN KEY (`target_timetable_id` )
    REFERENCES `academics`.`timetable` (`timetable_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE INDEX `fk_adjustment_faculty_timetable1` ON `academics`.`adjustment_faculty` (`source_timetable_id` ASC) ;

CREATE INDEX `fk_adjustment_faculty_timetable2` ON `academics`.`adjustment_faculty` (`target_timetable_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`adjustment_day`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`adjustment_day` ;

CREATE  TABLE IF NOT EXISTS `academics`.`adjustment_day` (
  `target_date` DATE NOT NULL ,
  `weekday_number` TINYINT UNSIGNED NOT NULL ,
  `comment` VARCHAR(30) NULL ,
  PRIMARY KEY (`target_date`, `weekday_number`) ,
  CONSTRAINT `fk_adjustment_day_weekday1`
    FOREIGN KEY (`weekday_number` )
    REFERENCES `academics`.`weekday` (`weekday_number` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_adjustment_day_weekday1` ON `academics`.`adjustment_day` (`weekday_number` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`no_attendance_purpose`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`no_attendance_purpose` ;

CREATE  TABLE IF NOT EXISTS `academics`.`no_attendance_purpose` (
  `purpose_id` CHAR(10) NOT NULL ,
  `purpose` VARCHAR(30) NULL ,
  PRIMARY KEY (`purpose_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`no_attendanceday`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`no_attendanceday` ;

CREATE  TABLE IF NOT EXISTS `academics`.`no_attendanceday` (
  `id` TINYINT NOT NULL AUTO_INCREMENT ,
  `department_id` CHAR(10) NOT NULL ,
  `degree_id` CHAR(10) NOT NULL ,
  `semester_id` TINYINT NOT NULL ,
  `purpose_id` CHAR(10) NOT NULL ,
  `date_from` DATE NULL ,
  `date_upto` DATE NULL ,
  `remarks` VARCHAR(30) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_no_attendanceday_no_attendance_purpose1`
    FOREIGN KEY (`purpose_id` )
    REFERENCES `academics`.`no_attendance_purpose` (`purpose_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_no_attendanceday_semester_degree1`
    FOREIGN KEY (`department_id` , `degree_id` , `semester_id` )
    REFERENCES `academics`.`semester_degree` (`department_id` , `degree_id` , `semester_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_no_attendanceday_no_attendance_purpose1` ON `academics`.`no_attendanceday` (`purpose_id` ASC) ;

CREATE INDEX `fk_no_attendanceday_semester_degree1` ON `academics`.`no_attendanceday` (`department_id` ASC, `degree_id` ASC, `semester_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`configs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`configs` ;

CREATE  TABLE IF NOT EXISTS `academics`.`configs` (
  `parameter` VARCHAR(30) NOT NULL ,
  `value` VARCHAR(10) NULL ,
  PRIMARY KEY (`parameter`) );


-- -----------------------------------------------------
-- Table `academics`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`module` ;

CREATE  TABLE IF NOT EXISTS `academics`.`module` (
  `module_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`module_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`mod_controller`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`mod_controller` ;

CREATE  TABLE IF NOT EXISTS `academics`.`mod_controller` (
  `module_id` VARCHAR(20) NOT NULL ,
  `controller_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`controller_id`, `module_id`) ,
  CONSTRAINT `fk_mod_controller_module1`
    FOREIGN KEY (`module_id` )
    REFERENCES `academics`.`module` (`module_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_mod_controller_module1` ON `academics`.`mod_controller` (`module_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`mod_action`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`mod_action` ;

CREATE  TABLE IF NOT EXISTS `academics`.`mod_action` (
  `module_id` VARCHAR(20) NOT NULL ,
  `controller_id` VARCHAR(20) NOT NULL ,
  `action_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`action_id`, `controller_id`, `module_id`) ,
  CONSTRAINT `fk_mod_action_mod_controller1`
    FOREIGN KEY (`controller_id` , `module_id` )
    REFERENCES `academics`.`mod_controller` (`controller_id` , `module_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_mod_action_mod_controller1` ON `academics`.`mod_action` (`controller_id` ASC, `module_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`mod_role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`mod_role` ;

CREATE  TABLE IF NOT EXISTS `academics`.`mod_role` (
  `role_id` VARCHAR(10) NOT NULL ,
  `role_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`mod_role_resource`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`mod_role_resource` ;

CREATE  TABLE IF NOT EXISTS `academics`.`mod_role_resource` (
  `role_id` VARCHAR(10) NOT NULL ,
  `module_id` VARCHAR(20) NOT NULL ,
  `controller_id` VARCHAR(20) NOT NULL ,
  `action_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`role_id`, `action_id`, `controller_id`, `module_id`) ,
  CONSTRAINT `fk_mod_role_resource_mod_role1`
    FOREIGN KEY (`role_id` )
    REFERENCES `academics`.`mod_role` (`role_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_mod_role_resource_mod_action1`
    FOREIGN KEY (`action_id` , `controller_id` , `module_id` )
    REFERENCES `academics`.`mod_action` (`action_id` , `controller_id` , `module_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_mod_role_resource_mod_role1` ON `academics`.`mod_role_resource` (`role_id` ASC) ;

CREATE INDEX `fk_mod_role_resource_mod_action1` ON `academics`.`mod_role_resource` (`action_id` ASC, `controller_id` ASC, `module_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`test_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`test_type` ;

CREATE  TABLE IF NOT EXISTS `academics`.`test_type` (
  `test_type_id` CHAR(10) NOT NULL ,
  `test_type_name` VARCHAR(45) NULL ,
  `default_max_marks` TINYINT NULL ,
  `default_pass_marks` TINYINT NULL ,
  PRIMARY KEY (`test_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`test`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`test` ;

CREATE  TABLE IF NOT EXISTS `academics`.`test` (
  `test_id` TINYINT NOT NULL ,
  `test_type_id` CHAR(10) NOT NULL ,
  `test_name` VARCHAR(45) NULL ,
  `is_optional` TINYINT(1)  NULL DEFAULT 0 ,
  PRIMARY KEY (`test_id`, `test_type_id`) ,
  CONSTRAINT `fk_test_test_type1`
    FOREIGN KEY (`test_type_id` )
    REFERENCES `academics`.`test_type` (`test_type_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_test_test_type1` ON `academics`.`test` (`test_type_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`class` ;

CREATE  TABLE IF NOT EXISTS `academics`.`class` (
  `class_id` INT NOT NULL AUTO_INCREMENT ,
  `semester_id` TINYINT(4) NOT NULL ,
  `semester_type` ENUM('ODD','EVEN') NULL ,
  `semester_duration` TINYINT(4) UNSIGNED NULL ,
  `handled_by_dept` CHAR(10) NOT NULL ,
  `start_date` DATE NULL ,
  `completion_date` DATE NULL ,
  `is_active` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`class_id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `batch_id_UNIQUE` ON `academics`.`class` (`semester_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`test_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`test_info` ;

CREATE  TABLE IF NOT EXISTS `academics`.`test_info` (
  `test_info_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `test_type_id` CHAR(10) NOT NULL ,
  `test_id` TINYINT NOT NULL ,
  `class_id` INT NOT NULL ,
  `subject_id` INT NOT NULL ,
  `is_locked` TINYINT(1)  NULL DEFAULT 0 ,
  `is_optional` TINYINT(1)  NULL ,
  `time` TIME NULL ,
  `date_of_announcement` DATE NULL ,
  `date_of_conduct` DATE NULL ,
  `max_marks` TINYINT NULL ,
  `pass_marks` TINYINT NULL ,
  `remarks` VARCHAR(45) NULL ,
  `subject_code` CHAR(10) NOT NULL ,
  `department_id` CHAR(10) NOT NULL ,
  `programme_id` CHAR(10) NOT NULL ,
  `semester_id` TINYINT NOT NULL ,
  PRIMARY KEY (`test_info_id`) ,
  CONSTRAINT `fk_test_info_test1`
    FOREIGN KEY (`test_id` , `test_type_id` )
    REFERENCES `academics`.`test` (`test_id` , `test_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_test_info_class1`
    FOREIGN KEY (`class_id` )
    REFERENCES `academics`.`class` (`class_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_test_info_subject1`
    FOREIGN KEY (`subject_id` )
    REFERENCES `academics`.`subject` (`subject_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `test_info_id_UNIQUE` ON `academics`.`test_info` (`test_info_id` ASC) ;

CREATE INDEX `fk_test_info_test1` ON `academics`.`test_info` (`test_id` ASC, `test_type_id` ASC) ;

CREATE INDEX `fk_test_info_class1` ON `academics`.`test_info` (`class_id` ASC) ;

CREATE INDEX `fk_test_info_subject1` ON `academics`.`test_info` (`subject_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`test_marks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`test_marks` ;

CREATE  TABLE IF NOT EXISTS `academics`.`test_marks` (
  `member_id` INT NOT NULL ,
  `test_info_id` INT UNSIGNED NOT NULL ,
  `marks_scored` TINYINT UNSIGNED NULL ,
  `status` CHAR(1) NULL DEFAULT 'P' ,
  PRIMARY KEY (`test_info_id`, `member_id`) ,
  CONSTRAINT `fk_test_marks_test_info1`
    FOREIGN KEY (`test_info_id` )
    REFERENCES `academics`.`test_info` (`test_info_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_test_marks_test_info1` ON `academics`.`test_marks` (`test_info_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`internal_marks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`internal_marks` ;

CREATE  TABLE IF NOT EXISTS `academics`.`internal_marks` (
  `member_id` INT NOT NULL ,
  `subject_code` CHAR(10) NOT NULL ,
  `department_id` CHAR(10) NOT NULL ,
  `programme_id` CHAR(10) NOT NULL ,
  `semester_id` TINYINT NOT NULL ,
  `marks_scored` TINYINT ZEROFILL NOT NULL ,
  `marks_suggested` TINYINT NULL ,
  PRIMARY KEY (`member_id`, `subject_code`, `department_id`, `programme_id`, `semester_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`period_attendance2`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`period_attendance2` ;

CREATE  TABLE IF NOT EXISTS `academics`.`period_attendance2` (
  `attendance_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `period_date` DATE NULL ,
  `department_id` CHAR(5) NULL ,
  `programme_id` CHAR(10) NULL ,
  `semester_id` TINYINT NULL ,
  `group_id` CHAR(5) NULL ,
  `subject_code` CHAR(10) NULL ,
  `subject_mode_id` CHAR(5) NULL ,
  `duration` TINYINT NULL ,
  `weekday_number` TINYINT NULL ,
  `period_number` TINYINT NULL ,
  `period_type` ENUM('REGULAR','ADJUSTMENT','EXTRA CLASS') NULL ,
  `faculty_id` VARCHAR(15) NULL ,
  `marked_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `remarks` VARCHAR(120) NULL ,
  PRIMARY KEY (`attendance_id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `department_id_UNIQUE` ON `academics`.`period_attendance2` (`department_id` ASC, `programme_id` ASC, `semester_id` ASC, `group_id` ASC, `subject_code` ASC, `subject_mode_id` ASC, `period_date` ASC, `period_number` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`student_attendance2`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`student_attendance2` ;

CREATE  TABLE IF NOT EXISTS `academics`.`student_attendance2` (
  `attendance_id` INT UNSIGNED NOT NULL ,
  `student_roll_no` INT NOT NULL ,
  `status` ENUM('ABSENT','SICK','LEAVE','SPORTS','PLACEMENT','FUNCTION','ONDUTY') NULL DEFAULT 'ABSENT' ,
  `remarks` VARCHAR(120) NULL ,
  PRIMARY KEY (`attendance_id`, `student_roll_no`) ,
  CONSTRAINT `fk_student_attendance2_period_attendance21`
    FOREIGN KEY (`attendance_id` )
    REFERENCES `academics`.`period_attendance2` (`attendance_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = MyISAM;

CREATE INDEX `fk_student_attendance2_period_attendance21` ON `academics`.`student_attendance2` (`attendance_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`dmc`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`dmc` ;

CREATE  TABLE IF NOT EXISTS `academics`.`dmc` (
  `dmc_id` CHAR(10) NOT NULL ,
  `test_info_id` INT(10) UNSIGNED NOT NULL ,
  `marks_scored` TINYINT(4) NULL DEFAULT NULL ,
  `is_external` TINYINT(1) NOT NULL DEFAULT '1' ,
  `status` CHAR(1) NULL DEFAULT 'P' ,
  CONSTRAINT `fk_dmc_test_info1`
    FOREIGN KEY (`test_info_id` )
    REFERENCES `academics`.`test_info` (`test_info_id` )
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_dmc_dmc_info1` ON `academics`.`dmc` (`dmc_id` ASC) ;

CREATE INDEX `fk_dmc_test_info1` ON `academics`.`dmc` (`test_info_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`discipline`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`discipline` ;

CREATE  TABLE IF NOT EXISTS `academics`.`discipline` (
  `discipline_id` CHAR(10) NOT NULL ,
  `discipline_name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`discipline_id`) );

CREATE UNIQUE INDEX `discipline_id_UNIQUE` ON `academics`.`discipline` (`discipline_id` ASC, `discipline_name` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`qualification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`qualification` ;

CREATE  TABLE IF NOT EXISTS `academics`.`qualification` (
  `qualification_id` INT UNSIGNED NOT NULL ,
  `qualification_name` VARCHAR(45) NOT NULL COMMENT 'member\'s qualification is stored in the table corresponding to qualification name\n' ,
  PRIMARY KEY (`qualification_id`) )
ENGINE = InnoDB;

CREATE UNIQUE INDEX `name_UNIQUE` ON `academics`.`qualification` (`qualification_name` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`members` ;

CREATE  TABLE IF NOT EXISTS `academics`.`members` (
  `member_id` INT NOT NULL ,
  `member_type_id` INT NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NULL ,
  `middle_name` VARCHAR(45) NULL ,
  `dob` DATE NOT NULL ,
  `blood_group` CHAR(6) NULL ,
  `gender` CHAR(10) NOT NULL ,
  `religion_id` TINYINT(4) NOT NULL ,
  `cast_id` TINYINT(4) NOT NULL ,
  `nationality_id` TINYINT(3) NOT NULL ,
  `join_date` DATE NULL ,
  `relieve_date` DATE NULL ,
  `is_active` TINYINT(1)  NULL ,
  `image_no` VARCHAR(45) NULL ,
  PRIMARY KEY (`member_id`) );

CREATE UNIQUE INDEX `student_roll_no_UNIQUE` ON `academics`.`members` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`member_qualification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`member_qualification` ;

CREATE  TABLE IF NOT EXISTS `academics`.`member_qualification` (
  `qualification_id` INT UNSIGNED NOT NULL ,
  `member_id` INT NOT NULL ,
  PRIMARY KEY (`qualification_id`, `member_id`) ,
  CONSTRAINT `fk_member_qualification_qualification1`
    FOREIGN KEY (`qualification_id` )
    REFERENCES `academics`.`qualification` (`qualification_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_member_qualification_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `academics`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_member_qualification_qualification1` ON `academics`.`member_qualification` (`qualification_id` ASC) ;

CREATE INDEX `fk_member_qualification_members1` ON `academics`.`member_qualification` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`diploma`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`diploma` ;

CREATE  TABLE IF NOT EXISTS `academics`.`diploma` (
  `member_id` INT NOT NULL ,
  `qualification_id` INT UNSIGNED NOT NULL ,
  `discipline_id` CHAR(10) NOT NULL ,
  `board_roll_no` VARCHAR(45) NOT NULL ,
  `discipline_name` VARCHAR(45) NOT NULL ,
  `marks_obtained` INT(11) NOT NULL ,
  `total_marks` INT(11) NOT NULL ,
  `percentage` TINYINT(4) NOT NULL ,
  `passing_year` YEAR NOT NULL ,
  `remarks` INT(11) NULL DEFAULT NULL ,
  `university` VARCHAR(45) NOT NULL ,
  `institution` VARCHAR(120) NOT NULL ,
  `migration_date` DATE NULL DEFAULT NULL ,
  `city_name` VARCHAR(45) NOT NULL ,
  `state_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`qualification_id`, `member_id`) ,
  CONSTRAINT `fk_diploma_discipline1`
    FOREIGN KEY (`discipline_id` )
    REFERENCES `academics`.`discipline` (`discipline_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_diploma_member_qualification1`
    FOREIGN KEY (`qualification_id` , `member_id` )
    REFERENCES `academics`.`member_qualification` (`qualification_id` , `member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_diploma_discipline1` ON `academics`.`diploma` (`discipline_id` ASC) ;

CREATE INDEX `fk_diploma_member_qualification1` ON `academics`.`diploma` (`qualification_id` ASC, `member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`matric`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`matric` ;

CREATE  TABLE IF NOT EXISTS `academics`.`matric` (
  `member_id` INT NOT NULL ,
  `qualification_id` INT UNSIGNED NOT NULL ,
  `board` VARCHAR(120) NOT NULL ,
  `board_roll_no` VARCHAR(20) NOT NULL ,
  `marks_obtained` INT(11) NOT NULL ,
  `total_marks` INT(11) NOT NULL ,
  `percentage` TINYINT(4) NOT NULL ,
  `passing_year` YEAR NOT NULL ,
  `school_rank` TINYINT(4) NOT NULL COMMENT 'if any' ,
  `remarks` VARCHAR(120) NULL ,
  `institution` VARCHAR(120) NOT NULL ,
  `city_name` VARCHAR(45) NOT NULL ,
  `state_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`qualification_id`, `member_id`) ,
  CONSTRAINT `fk_matric_member_qualification1`
    FOREIGN KEY (`qualification_id` , `member_id` )
    REFERENCES `academics`.`member_qualification` (`qualification_id` , `member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_matric_member_qualification1` ON `academics`.`matric` (`qualification_id` ASC, `member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`twelfth`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`twelfth` ;

CREATE  TABLE IF NOT EXISTS `academics`.`twelfth` (
  `member_id` INT NOT NULL ,
  `qualification_id` INT UNSIGNED NOT NULL ,
  `discipline_id` CHAR(10) NOT NULL ,
  `board` VARCHAR(10) NOT NULL ,
  `board_roll_no` VARCHAR(12) NOT NULL ,
  `marks_obtained` INT(11) NOT NULL ,
  `total_marks` INT(11) NOT NULL ,
  `percentage` INT(11) NOT NULL ,
  `pcm_percent` INT(11) NOT NULL ,
  `passing_year` YEAR NOT NULL ,
  `school_rank` TINYINT(4) NOT NULL ,
  `remarks` VARCHAR(120) NULL ,
  `institution` VARCHAR(120) NOT NULL ,
  `migration_date` DATE NULL DEFAULT NULL ,
  `city_name` VARCHAR(45) NOT NULL ,
  `state_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`qualification_id`, `member_id`) ,
  CONSTRAINT `fk_twelfth_discipline1`
    FOREIGN KEY (`discipline_id` )
    REFERENCES `academics`.`discipline` (`discipline_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_twelfth_member_qualification1`
    FOREIGN KEY (`qualification_id` , `member_id` )
    REFERENCES `academics`.`member_qualification` (`qualification_id` , `member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_twelfth_discipline1` ON `academics`.`twelfth` (`discipline_id` ASC) ;

CREATE INDEX `fk_twelfth_member_qualification1` ON `academics`.`twelfth` (`qualification_id` ASC, `member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`competitive_exam`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`competitive_exam` ;

CREATE  TABLE IF NOT EXISTS `academics`.`competitive_exam` (
  `exam_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `abbr` VARCHAR(10) NULL ,
  PRIMARY KEY (`exam_id`) );

CREATE UNIQUE INDEX `competitive_exam_name_UNIQUE` ON `academics`.`competitive_exam` (`name` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`student_competitive_exam`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`student_competitive_exam` ;

CREATE  TABLE IF NOT EXISTS `academics`.`student_competitive_exam` (
  `member_id` INT NOT NULL ,
  `exam_id` INT UNSIGNED NOT NULL ,
  `roll_no` VARCHAR(45) NULL ,
  `date` DATE NULL ,
  `total_score` INT NULL ,
  `all_india_rank` INT NULL ,
  PRIMARY KEY (`exam_id`) ,
  CONSTRAINT `fk_student_competitive_exam_competitive_exam1`
    FOREIGN KEY (`exam_id` )
    REFERENCES `academics`.`competitive_exam` (`exam_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_competitive_exam_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `academics`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_student_competitive_exam_competitive_exam1` ON `academics`.`student_competitive_exam` (`exam_id` ASC) ;

CREATE INDEX `fk_student_competitive_exam_members1` ON `academics`.`student_competitive_exam` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`btech`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`btech` ;

CREATE  TABLE IF NOT EXISTS `academics`.`btech` (
  `member_id` INT NOT NULL ,
  `qualification_id` INT UNSIGNED NOT NULL ,
  `discipline_id` CHAR(10) NOT NULL ,
  `marks_obtained` INT NOT NULL ,
  `total_marks` INT NOT NULL ,
  `percentage` DECIMAL(2) NOT NULL ,
  `passing_year` YEAR NOT NULL ,
  `istitution` VARCHAR(120) NOT NULL ,
  `university` VARCHAR(45) NOT NULL ,
  `city_name` VARCHAR(45) NOT NULL ,
  `state_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`qualification_id`, `member_id`) ,
  CONSTRAINT `fk_btech_discipline1`
    FOREIGN KEY (`discipline_id` )
    REFERENCES `academics`.`discipline` (`discipline_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_btech_member_qualification1`
    FOREIGN KEY (`qualification_id` , `member_id` )
    REFERENCES `academics`.`member_qualification` (`qualification_id` , `member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_btech_discipline1` ON `academics`.`btech` (`discipline_id` ASC) ;

CREATE INDEX `fk_btech_member_qualification1` ON `academics`.`btech` (`qualification_id` ASC, `member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`mtech`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`mtech` ;

CREATE  TABLE IF NOT EXISTS `academics`.`mtech` (
  `member_id` INT NOT NULL ,
  `qualification_id` INT UNSIGNED NOT NULL ,
  `discipline_id` CHAR(10) NOT NULL ,
  `marks_obtained` INT NOT NULL ,
  `total_marks` INT NOT NULL ,
  `percentage` DECIMAL(2) NOT NULL ,
  `passing_year` YEAR NOT NULL ,
  `institution` VARCHAR(45) NOT NULL ,
  `university` VARCHAR(255) NOT NULL ,
  `city_name` VARCHAR(45) NOT NULL ,
  `state_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`qualification_id`, `member_id`) ,
  CONSTRAINT `fk_mtech_discipline1`
    FOREIGN KEY (`discipline_id` )
    REFERENCES `academics`.`discipline` (`discipline_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_mtech_member_qualification1`
    FOREIGN KEY (`qualification_id` , `member_id` )
    REFERENCES `academics`.`member_qualification` (`qualification_id` , `member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_mtech_discipline1` ON `academics`.`mtech` (`discipline_id` ASC) ;

CREATE INDEX `fk_mtech_member_qualification1` ON `academics`.`mtech` (`qualification_id` ASC, `member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`country`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`country` ;

CREATE  TABLE IF NOT EXISTS `academics`.`country` (
  `country_id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`country_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`state` ;

CREATE  TABLE IF NOT EXISTS `academics`.`state` (
  `country_id` INT NOT NULL ,
  `state_id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`state_id`, `country_id`) ,
  CONSTRAINT `fk_state_country1`
    FOREIGN KEY (`country_id` )
    REFERENCES `academics`.`country` (`country_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_state_country1` ON `academics`.`state` (`country_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`city`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`city` ;

CREATE  TABLE IF NOT EXISTS `academics`.`city` (
  `city_id` INT NOT NULL ,
  `state_id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`city_id`, `state_id`) ,
  CONSTRAINT `fk_city_states1`
    FOREIGN KEY (`state_id` )
    REFERENCES `academics`.`state` (`state_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_city_states1` ON `academics`.`city` (`state_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`dmc_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`dmc_info` ;

CREATE  TABLE IF NOT EXISTS `academics`.`dmc_info` (
  `dmc_info_id` INT NOT NULL ,
  `dmc_id` VARCHAR(20) NOT NULL ,
  `roll_no` VARCHAR(45) NOT NULL ,
  `semester_id` INT NOT NULL ,
  `examination` VARCHAR(45) NOT NULL ,
  `custody_date` DATE NULL ,
  `is_granted` TINYINT(1)  NULL ,
  `grant_date` DATE NULL ,
  `recieveing_date` DATE NULL ,
  `is_copied` TINYINT(1)  NULL ,
  `dispatch_date` DATE NULL ,
  `marks_obtained` INT NULL ,
  `total_marks` INT NULL ,
  `scaled_marks` INT NULL ,
  `percentage` INT NULL ,
  PRIMARY KEY (`dmc_info_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`student_class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`student_class` ;

CREATE  TABLE IF NOT EXISTS `academics`.`student_class` (
  `member_id` INT NOT NULL ,
  `class_id` INT NOT NULL ,
  `roll_no` VARCHAR(20) NULL ,
  `group_id` CHAR(5) NULL ,
  `start_date` DATE NULL ,
  `completion_date` DATE NULL ,
  `is_initial_batch_identifier` TINYINT(1)  NULL ,
  PRIMARY KEY (`member_id`, `class_id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `academics`.`student_subject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`student_subject` ;

CREATE  TABLE IF NOT EXISTS `academics`.`student_subject` (
  `student_subject_id` INT NOT NULL ,
  `member_id` INT NOT NULL ,
  `subject_id` INT NOT NULL ,
  PRIMARY KEY (`student_subject_id`) ,
  CONSTRAINT `fk_student_subject_subject1`
    FOREIGN KEY (`subject_id` )
    REFERENCES `academics`.`subject` (`subject_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_subject_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `academics`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_student_subject_subject1` ON `academics`.`student_subject` (`subject_id` ASC) ;

CREATE INDEX `fk_student_subject_members1` ON `academics`.`student_subject` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`result_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`result_type` ;

CREATE  TABLE IF NOT EXISTS `academics`.`result_type` (
  `result_type_id` INT NOT NULL ,
  `result_type_name` ENUM('regular_pass','regular_fail','re_evaluation_pass','re_evaluation_fail','re_appear_pass','re_appear_fail') NULL DEFAULT 'regular_pass' ,
  PRIMARY KEY (`result_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academics`.`dmc_marks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`dmc_marks` ;

CREATE  TABLE IF NOT EXISTS `academics`.`dmc_marks` (
  `dmc_marks_id` INT NOT NULL ,
  `result_type_id` INT NOT NULL ,
  `student_subject_id` INT NOT NULL ,
  `dmc_info_id` INT NOT NULL ,
  `internal` INT NOT NULL ,
  `external` INT NOT NULL ,
  `percentage` INT NOT NULL ,
  `is_pass` TINYINT(1)  NOT NULL ,
  `is_considered` TINYINT(1)  NOT NULL ,
  `is_verified` TINYINT(1)  NOT NULL ,
  `date` DATE NULL ,
  PRIMARY KEY (`dmc_marks_id`) ,
  CONSTRAINT `fk_dmc_marks_result_type1`
    FOREIGN KEY (`result_type_id` )
    REFERENCES `academics`.`result_type` (`result_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_dmc_marks_student_subject1`
    FOREIGN KEY (`student_subject_id` )
    REFERENCES `academics`.`student_subject` (`student_subject_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_dmc_marks_dmc_info1`
    FOREIGN KEY (`dmc_info_id` )
    REFERENCES `academics`.`dmc_info` (`dmc_info_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_dmc_marks_result_type1` ON `academics`.`dmc_marks` (`result_type_id` ASC) ;

CREATE INDEX `fk_dmc_marks_student_subject1` ON `academics`.`dmc_marks` (`student_subject_id` ASC) ;

CREATE INDEX `fk_dmc_marks_dmc_info1` ON `academics`.`dmc_marks` (`dmc_info_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`class_subject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`class_subject` ;

CREATE  TABLE IF NOT EXISTS `academics`.`class_subject` (
  `class_subject_id` INT NOT NULL AUTO_INCREMENT ,
  `class_id` INT NOT NULL ,
  `subject_id` INT NOT NULL ,
  PRIMARY KEY (`class_subject_id`) ,
  CONSTRAINT `fk_class_subject_class1`
    FOREIGN KEY (`class_id` )
    REFERENCES `academics`.`class` (`class_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_class_subject_subject1`
    FOREIGN KEY (`subject_id` )
    REFERENCES `academics`.`subject` (`subject_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_class_subject_class1` ON `academics`.`class_subject` (`class_id` ASC) ;

CREATE INDEX `fk_class_subject_subject1` ON `academics`.`class_subject` (`subject_id` ASC) ;

CREATE UNIQUE INDEX `class_id_UNIQUE` ON `academics`.`class_subject` (`class_id` ASC, `subject_id` ASC) ;


-- -----------------------------------------------------
-- Table `academics`.`batch`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academics`.`batch` ;

CREATE  TABLE IF NOT EXISTS `academics`.`batch` (
  `batch_id` INT NOT NULL ,
  `department_id` CHAR(10) NULL ,
  `programme_id` CHAR(10) NULL ,
  `batch_start` YEAR NULL ,
  `batch_number` TINYINT(4) NULL ,
  `is_active` TINYINT(1)  NULL ,
  PRIMARY KEY (`batch_id`) )
ENGINE = MyISAM;

CREATE UNIQUE INDEX `department_id_UNIQUE` ON `academics`.`batch` (`department_id` ASC, `programme_id` ASC, `batch_start` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
