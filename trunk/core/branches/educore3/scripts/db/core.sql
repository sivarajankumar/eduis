SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `core` ;
CREATE SCHEMA IF NOT EXISTS `core` DEFAULT CHARACTER SET utf8 ;
USE `core` ;

-- -----------------------------------------------------
-- Table `core`.`programme`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`programme` ;

CREATE  TABLE IF NOT EXISTS `core`.`programme` (
  `programme_id` CHAR(10) NOT NULL ,
  `programme_name` VARCHAR(30) NULL DEFAULT NULL ,
  `total_semesters` TINYINT(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`programme_id`) )
ENGINE = InnoDB
COMMENT = 'All degrees provided by college.';


-- -----------------------------------------------------
-- Table `core`.`department`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`department` ;

CREATE  TABLE IF NOT EXISTS `core`.`department` (
  `department_id` CHAR(10) NOT NULL ,
  `department_name` VARCHAR(60) NULL DEFAULT NULL ,
  PRIMARY KEY (`department_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'All educational departments of College';


-- -----------------------------------------------------
-- Table `core`.`department_programme`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`department_programme` ;

CREATE  TABLE IF NOT EXISTS `core`.`department_programme` (
  `department_id` CHAR(10) NOT NULL ,
  `programme_id` CHAR(10) NOT NULL ,
  PRIMARY KEY (`programme_id`, `department_id`) ,
  CONSTRAINT `fk_department_programme_programme1`
    FOREIGN KEY (`programme_id` )
    REFERENCES `core`.`programme` (`programme_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_department_programme_department1`
    FOREIGN KEY (`department_id` )
    REFERENCES `core`.`department` (`department_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Degrees provided by departments.';

CREATE INDEX `fk_department_programme_programme1` ON `core`.`department_programme` (`programme_id` ASC) ;

CREATE INDEX `fk_department_programme_department1` ON `core`.`department_programme` (`department_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`batch`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`batch` ;

CREATE  TABLE IF NOT EXISTS `core`.`batch` (
  `batch_id` INT NOT NULL AUTO_INCREMENT ,
  `department_id` CHAR(10) NOT NULL ,
  `programme_id` CHAR(10) NOT NULL ,
  `batch_start` YEAR NOT NULL ,
  `batch_number` TINYINT(4) UNSIGNED NULL ,
  `is_active` TINYINT(1)  NULL DEFAULT 1 ,
  PRIMARY KEY (`batch_id`) ,
  CONSTRAINT `fk_batch_department_programme1`
    FOREIGN KEY (`programme_id` , `department_id` )
    REFERENCES `core`.`department_programme` (`programme_id` , `department_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_batch_department_programme1` ON `core`.`batch` (`programme_id` ASC, `department_id` ASC) ;

CREATE UNIQUE INDEX `department_id_UNIQUE` ON `core`.`batch` (`department_id` ASC, `programme_id` ASC, `batch_start` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`block`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`block` ;

CREATE  TABLE IF NOT EXISTS `core`.`block` (
  `block_id` CHAR(10) NOT NULL ,
  `block_name` VARCHAR(30) NULL DEFAULT NULL ,
  PRIMARY KEY (`block_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Blocks or Buildings of College';


-- -----------------------------------------------------
-- Table `core`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`groups` ;

CREATE  TABLE IF NOT EXISTS `core`.`groups` (
  `group_id` CHAR(5) NOT NULL ,
  `department_id` CHAR(10) NOT NULL ,
  `programme_id` CHAR(10) NOT NULL ,
  PRIMARY KEY (`group_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Groups in each Department\'s Degree';

CREATE INDEX `fk_Groups_degree_department1` ON `core`.`groups` (`department_id` ASC, `programme_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`holiday`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`holiday` ;

CREATE  TABLE IF NOT EXISTS `core`.`holiday` (
  `date_from` DATE NOT NULL ,
  `date_upto` DATE NULL ,
  `purpose` VARCHAR(120) NULL ,
  PRIMARY KEY (`date_from`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'List of Holidays.';


-- -----------------------------------------------------
-- Table `core`.`room_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`room_type` ;

CREATE  TABLE IF NOT EXISTS `core`.`room_type` (
  `room_type_id` CHAR(10) NOT NULL ,
  `room_type_name` VARCHAR(30) NULL ,
  PRIMARY KEY (`room_type_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Types of room';


-- -----------------------------------------------------
-- Table `core`.`room`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`room` ;

CREATE  TABLE IF NOT EXISTS `core`.`room` (
  `block_id` CHAR(10) NOT NULL ,
  `room_id` CHAR(10) NOT NULL ,
  `room_type_id` CHAR(10) NOT NULL ,
  `capacity` TINYINT(4) NULL DEFAULT NULL ,
  `remark` VARCHAR(30) NULL DEFAULT NULL ,
  PRIMARY KEY (`room_id`, `block_id`) ,
  CONSTRAINT `fk_room_room_type1`
    FOREIGN KEY (`room_type_id` )
    REFERENCES `core`.`room_type` (`room_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_room_block1`
    FOREIGN KEY (`block_id` )
    REFERENCES `core`.`block` (`block_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Every room in College which are used for education purpose.';

CREATE INDEX `fk_room_room_type1` ON `core`.`room` (`room_type_id` ASC) ;

CREATE INDEX `fk_room_block1` ON `core`.`room` (`block_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`class` ;

CREATE  TABLE IF NOT EXISTS `core`.`class` (
  `class_id` INT NOT NULL AUTO_INCREMENT ,
  `batch_id` INT NOT NULL ,
  `handled_by_dept` CHAR(10) NOT NULL ,
  `semester_id` TINYINT(4) NOT NULL ,
  `semester_type` ENUM('ODD','EVEN') NULL ,
  `semester_duration` TINYINT(4) UNSIGNED NULL DEFAULT NULL ,
  `start_date` DATE NULL ,
  `completion_date` DATE NULL ,
  `is_active` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`class_id`) ,
  CONSTRAINT `fk_class_batch1`
    FOREIGN KEY (`batch_id` )
    REFERENCES `core`.`batch` (`batch_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_class_department1`
    FOREIGN KEY (`handled_by_dept` )
    REFERENCES `core`.`department` (`department_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `department_id_UNIQUE` ON `core`.`class` (`batch_id` ASC, `semester_id` ASC) ;

CREATE INDEX `fk_class_batch1` ON `core`.`class` (`batch_id` ASC) ;

CREATE INDEX `fk_class_department1` ON `core`.`class` (`handled_by_dept` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`member_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`member_type` ;

CREATE  TABLE IF NOT EXISTS `core`.`member_type` (
  `member_type_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `member_type_name` VARCHAR(20) NULL ,
  PRIMARY KEY (`member_type_id`) );


-- -----------------------------------------------------
-- Table `core`.`casts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`casts` ;

CREATE  TABLE IF NOT EXISTS `core`.`casts` (
  `cast_id` TINYINT(4) NOT NULL ,
  `cast_name` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`cast_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `core`.`religions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`religions` ;

CREATE  TABLE IF NOT EXISTS `core`.`religions` (
  `religion_id` TINYINT(4) NOT NULL ,
  `religion_name` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`religion_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `core`.`nationalities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`nationalities` ;

CREATE  TABLE IF NOT EXISTS `core`.`nationalities` (
  `nationality_id` TINYINT(3) UNSIGNED NOT NULL ,
  `nationality_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`nationality_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `nationality_id_UNIQUE` ON `core`.`nationalities` (`nationality_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`members` ;

CREATE  TABLE IF NOT EXISTS `core`.`members` (
  `member_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `member_type_id` INT UNSIGNED NOT NULL ,
  `cast_id` TINYINT(4) NOT NULL ,
  `religion_id` TINYINT(4) NOT NULL ,
  `nationality_id` TINYINT(3) UNSIGNED NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NULL ,
  `middle_name` VARCHAR(45) NULL ,
  `dob` DATE NOT NULL ,
  `blood_group` ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-') NULL DEFAULT 'A+' ,
  `gender` ENUM('MALE','FEMALE') NOT NULL DEFAULT 'MALE' ,
  `join_date` DATE NULL ,
  `relieve_date` DATE NULL ,
  `is_active` TINYINT(1)  NULL ,
  `image_no` VARCHAR(45) NULL ,
  PRIMARY KEY (`member_id`) ,
  CONSTRAINT `fk_members_member_type1`
    FOREIGN KEY (`member_type_id` )
    REFERENCES `core`.`member_type` (`member_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_members_casts1`
    FOREIGN KEY (`cast_id` )
    REFERENCES `core`.`casts` (`cast_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_members_religions1`
    FOREIGN KEY (`religion_id` )
    REFERENCES `core`.`religions` (`religion_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_members_nationalities1`
    FOREIGN KEY (`nationality_id` )
    REFERENCES `core`.`nationalities` (`nationality_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_members_member_type1` ON `core`.`members` (`member_type_id` ASC) ;

CREATE INDEX `fk_members_casts1` ON `core`.`members` (`cast_id` ASC) ;

CREATE INDEX `fk_members_religions1` ON `core`.`members` (`religion_id` ASC) ;

CREATE INDEX `fk_members_nationalities1` ON `core`.`members` (`nationality_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`staff_personal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`staff_personal` ;

CREATE  TABLE IF NOT EXISTS `core`.`staff_personal` (
  `member_id` INT UNSIGNED NOT NULL ,
  `staff_id` CHAR(10) NOT NULL ,
  `department_id` CHAR(10) NOT NULL ,
  `initial` CHAR(5) NULL ,
  PRIMARY KEY (`staff_id`) ,
  CONSTRAINT `fk_staff_personal_department1`
    FOREIGN KEY (`department_id` )
    REFERENCES `core`.`department` (`department_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_staff_personal_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Personel information of faculty.';

CREATE INDEX `fk_staff_personal_department1` ON `core`.`staff_personal` (`department_id` ASC) ;

CREATE INDEX `fk_staff_personal_members1` ON `core`.`staff_personal` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`staff_professional`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`staff_professional` ;

CREATE  TABLE IF NOT EXISTS `core`.`staff_professional` (
  `staff_id` CHAR(10) NOT NULL ,
  `experience_teaching` TINYINT(4) NULL DEFAULT NULL ,
  `experience_industry` TINYINT(4) NULL DEFAULT NULL ,
  `experience_research` TINYINT(4) NULL DEFAULT NULL ,
  `date_of_join` DATE NULL DEFAULT NULL ,
  `date_of_relieve` DATE NULL DEFAULT NULL ,
  `gross_salary` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`staff_id`) ,
  CONSTRAINT `fk_staff_professional_staff_personal1`
    FOREIGN KEY (`staff_id` )
    REFERENCES `core`.`staff_personal` (`staff_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'Professional Information of Faculty.';

CREATE INDEX `fk_staff_professional_staff_personal1` ON `core`.`staff_professional` (`staff_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`configs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`configs` ;

CREATE  TABLE IF NOT EXISTS `core`.`configs` (
  `parameter` VARCHAR(30) NOT NULL ,
  `value` VARCHAR(10) NULL ,
  PRIMARY KEY (`parameter`) );


-- -----------------------------------------------------
-- Table `core`.`academic_session`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`academic_session` ;

CREATE  TABLE IF NOT EXISTS `core`.`academic_session` (
  `academic_year` YEAR NOT NULL ,
  `start_date` DATE NULL ,
  `end_date` DATE NULL ,
  `semester_type` ENUM('ODD','EVEN') NULL ,
  PRIMARY KEY (`academic_year`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `core`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`module` ;

CREATE  TABLE IF NOT EXISTS `core`.`module` (
  `module_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`module_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `core`.`mod_controller`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`mod_controller` ;

CREATE  TABLE IF NOT EXISTS `core`.`mod_controller` (
  `module_id` VARCHAR(20) NOT NULL ,
  `controller_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`controller_id`, `module_id`) ,
  CONSTRAINT `fk_mod_controller_module1`
    FOREIGN KEY (`module_id` )
    REFERENCES `core`.`module` (`module_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_mod_controller_module1` ON `core`.`mod_controller` (`module_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`mod_action`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`mod_action` ;

CREATE  TABLE IF NOT EXISTS `core`.`mod_action` (
  `module_id` VARCHAR(20) NOT NULL ,
  `controller_id` VARCHAR(20) NOT NULL ,
  `action_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`action_id`, `controller_id`, `module_id`) ,
  CONSTRAINT `fk_mod_action_mod_controller1`
    FOREIGN KEY (`controller_id` , `module_id` )
    REFERENCES `core`.`mod_controller` (`controller_id` , `module_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_mod_action_mod_controller1` ON `core`.`mod_action` (`controller_id` ASC, `module_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`mod_role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`mod_role` ;

CREATE  TABLE IF NOT EXISTS `core`.`mod_role` (
  `role_id` VARCHAR(20) NOT NULL ,
  `role_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`role_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `core`.`role_resource`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`role_resource` ;

CREATE  TABLE IF NOT EXISTS `core`.`role_resource` (
  `role_id` VARCHAR(20) NOT NULL ,
  `module_id` VARCHAR(20) NOT NULL ,
  `controller_id` VARCHAR(20) NOT NULL ,
  `action_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`action_id`, `controller_id`, `module_id`, `role_id`) ,
  CONSTRAINT `fk_role_resource_mod_action1`
    FOREIGN KEY (`action_id` , `controller_id` , `module_id` )
    REFERENCES `core`.`mod_action` (`action_id` , `controller_id` , `module_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_role_resource_mod_role1`
    FOREIGN KEY (`role_id` )
    REFERENCES `core`.`mod_role` (`role_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_role_resource_mod_action1` ON `core`.`role_resource` (`action_id` ASC, `controller_id` ASC, `module_id` ASC) ;

CREATE INDEX `fk_role_resource_mod_role1` ON `core`.`role_resource` (`role_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`member_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`member_address` ;

CREATE  TABLE IF NOT EXISTS `core`.`member_address` (
  `member_id` INT UNSIGNED NOT NULL ,
  `postal_code` INT(11) NULL ,
  `city` VARCHAR(120) NULL ,
  `district` VARCHAR(120) NULL ,
  `state` VARCHAR(120) NULL ,
  `address` VARCHAR(45) NULL ,
  `adress_type` ENUM('BUSINESS','MAILING/POSTAL/CORRESPONDENCE','RESIDENTIAL','TEMPORARY RESIDENTIAL') NULL DEFAULT 'RESIDENTIAL' ,
  CONSTRAINT `fk_member_address_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_member_address_members1` ON `core`.`member_address` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`student_admission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`student_admission` ;

CREATE  TABLE IF NOT EXISTS `core`.`student_admission` (
  `member_id` INT UNSIGNED NOT NULL ,
  `marital_status` ENUM('SINGLE','MARRIED') NULL DEFAULT 'SINGLE' ,
  `councelling_no` TINYINT(4) NULL ,
  `admission_date` DATE NULL COMMENT '		' ,
  `alloted_category` VARCHAR(45) NULL ,
  `alloted_branch` VARCHAR(10) NOT NULL ,
  `state_of_domicile` VARCHAR(45) NULL ,
  `urban` TINYINT(1)  NULL ,
  `avails_hostel` TINYINT(1)  NULL ,
  `avails_bus` TINYINT(1)  NULL ,
  PRIMARY KEY (`member_id`) ,
  CONSTRAINT `fk_student_admission_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_student_admission_members1` ON `core`.`student_admission` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`bus_stations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`bus_stations` ;

CREATE  TABLE IF NOT EXISTS `core`.`bus_stations` (
  `boarding_station` CHAR(5) NOT NULL ,
  `station_name` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`boarding_station`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `core`.`member_bus_stop`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`member_bus_stop` ;

CREATE  TABLE IF NOT EXISTS `core`.`member_bus_stop` (
  `member_id` INT UNSIGNED NOT NULL ,
  `boarding_station` CHAR(5) NOT NULL ,
  PRIMARY KEY (`member_id`) ,
  CONSTRAINT `fk_bus_bus_station1`
    FOREIGN KEY (`boarding_station` )
    REFERENCES `core`.`bus_stations` (`boarding_station` )
    ON UPDATE CASCADE,
  CONSTRAINT `fk_member_bus_stop_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `fk_bus_bus_station1` ON `core`.`member_bus_stop` (`boarding_station` ASC) ;

CREATE INDEX `fk_member_bus_stop_members1` ON `core`.`member_bus_stop` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`relations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`relations` ;

CREATE  TABLE IF NOT EXISTS `core`.`relations` (
  `relation_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `relation_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`relation_id`) );


-- -----------------------------------------------------
-- Table `core`.`member_relatives`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`member_relatives` ;

CREATE  TABLE IF NOT EXISTS `core`.`member_relatives` (
  `member_id` INT UNSIGNED NOT NULL ,
  `relation_id` TINYINT UNSIGNED NOT NULL ,
  `name` VARCHAR(120) NULL ,
  `occupation` VARCHAR(120) NULL ,
  `designation` VARCHAR(120) NULL ,
  `office_add` VARCHAR(240) NULL ,
  `contact` VARCHAR(13) NULL ,
  `annual_income` INT(11) NULL ,
  `landline_no` VARCHAR(14) NULL ,
  `email` VARCHAR(50) NULL ,
  CONSTRAINT `fk_relatives_relations1`
    FOREIGN KEY (`relation_id` )
    REFERENCES `core`.`relations` (`relation_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_relatives_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_relatives_relations1` ON `core`.`member_relatives` (`relation_id` ASC) ;

CREATE INDEX `fk_relatives_members1` ON `core`.`member_relatives` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`student_class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`student_class` ;

CREATE  TABLE IF NOT EXISTS `core`.`student_class` (
  `member_id` INT UNSIGNED NOT NULL ,
  `class_id` INT NOT NULL ,
  `group_id` CHAR(5) NOT NULL ,
  `roll_no` VARCHAR(20) NOT NULL ,
  `start_date` DATE NULL ,
  `completion_date` DATE NULL ,
  `is_initial_batch_identifier` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`class_id`, `member_id`) ,
  CONSTRAINT `fk_student_class_groups1`
    FOREIGN KEY (`group_id` )
    REFERENCES `core`.`groups` (`group_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_class_class1`
    FOREIGN KEY (`class_id` )
    REFERENCES `core`.`class` (`class_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_class_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;

CREATE INDEX `fk_student_class_groups1` ON `core`.`student_class` (`group_id` ASC) ;

CREATE INDEX `fk_student_class_class1` ON `core`.`student_class` (`class_id` ASC) ;

CREATE UNIQUE INDEX `class_id_UNIQUE` ON `core`.`student_class` (`class_id` ASC, `roll_no` ASC) ;

CREATE INDEX `fk_student_class_members1` ON `core`.`student_class` (`member_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`contact_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`contact_type` ;

CREATE  TABLE IF NOT EXISTS `core`.`contact_type` (
  `contact_type_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `contact_type_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`contact_type_id`) );


-- -----------------------------------------------------
-- Table `core`.`member_contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`member_contacts` ;

CREATE  TABLE IF NOT EXISTS `core`.`member_contacts` (
  `member_id` INT UNSIGNED NOT NULL ,
  `contact_type_id` INT UNSIGNED NOT NULL ,
  `contact_details` VARCHAR(50) NULL ,
  CONSTRAINT `fk_member_contacts_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`members` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_member_contacts_contact_type1`
    FOREIGN KEY (`contact_type_id` )
    REFERENCES `core`.`contact_type` (`contact_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_member_contacts_members1` ON `core`.`member_contacts` (`member_id` ASC) ;

CREATE INDEX `fk_member_contacts_contact_type1` ON `core`.`member_contacts` (`contact_type_id` ASC) ;


-- -----------------------------------------------------
-- Table `core`.`student_registration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `core`.`student_registration` ;

CREATE  TABLE IF NOT EXISTS `core`.`student_registration` (
  `member_id` INT UNSIGNED NOT NULL ,
  `registration_id` VARCHAR(45) NULL ,
  PRIMARY KEY (`member_id`) ,
  CONSTRAINT `fk_student_registration_student_admission1`
    FOREIGN KEY (`member_id` )
    REFERENCES `core`.`student_admission` (`member_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE INDEX `fk_student_registration_student_admission1` ON `core`.`student_registration` (`member_id` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
