SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `tnp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `tnp` ;

-- -----------------------------------------------------
-- Table `tnp`.`skills`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`skills` (
  `skill_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `skill_name` VARCHAR(30) NOT NULL ,
  `skill_field` VARCHAR(20) NULL ,
  PRIMARY KEY (`skill_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`members`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`members` (
  `member_id` INT UNSIGNED NOT NULL ,
  `member_type_id` INT NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NULL DEFAULT NULL ,
  `middle_name` VARCHAR(45) NULL DEFAULT NULL ,
  `dob` DATE NOT NULL ,
  `blood_group` CHAR(6) NULL DEFAULT NULL ,
  `gender` CHAR(10) NOT NULL ,
  `religion_id` TINYINT(4) NOT NULL ,
  `cast_id` TINYINT(4) NOT NULL ,
  `nationality_id` TINYINT(3) NOT NULL ,
  `join_date` DATE NULL DEFAULT NULL ,
  `relieve_date` DATE NULL DEFAULT NULL ,
  `is_active` TINYINT(1) NULL DEFAULT NULL ,
  `image_no` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`member_id`) );


-- -----------------------------------------------------
-- Table `tnp`.`student_skills`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`student_skills` (
  `member_id` INT UNSIGNED NOT NULL ,
  `skill_id` INT UNSIGNED NOT NULL ,
  `proficiency` ENUM('BASIC','INTERMEDIATE','EXPERT') NOT NULL ,
  PRIMARY KEY (`member_id`, `skill_id`) ,
  INDEX `fk_student_skills_skills` (`skill_id` ASC) ,
  INDEX `fk_student_skills_members1` (`member_id` ASC) ,
  CONSTRAINT `fk_student_skills_skills`
    FOREIGN KEY (`skill_id` )
    REFERENCES `tnp`.`skills` (`skill_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_skills_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`languages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`languages` (
  `language_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `language_name` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`language_id`) ,
  UNIQUE INDEX `language_name_UNIQUE` (`language_name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`student_language`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`student_language` (
  `language_id` INT UNSIGNED NOT NULL ,
  `proficiency` SET('SPEAK','READ','WRITE') NULL ,
  `member_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`language_id`, `member_id`) ,
  INDEX `fk_student_language_languages1` (`language_id` ASC) ,
  INDEX `fk_student_language_members1` (`member_id` ASC) ,
  CONSTRAINT `fk_student_language_languages1`
    FOREIGN KEY (`language_id` )
    REFERENCES `tnp`.`languages` (`language_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_language_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`technical_fields`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`technical_fields` (
  `technical_field_id` INT NOT NULL AUTO_INCREMENT ,
  `technical_field_name` VARCHAR(45) NOT NULL ,
  `technical_sector` VARCHAR(45) NULL ,
  PRIMARY KEY (`technical_field_id`) ,
  UNIQUE INDEX `technical_field_name_UNIQUE` (`technical_field_name` ASC, `technical_sector` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`certification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`certification` (
  `certification_id` INT NOT NULL AUTO_INCREMENT ,
  `certification_name` VARCHAR(100) NOT NULL ,
  `technical_field_id` INT NOT NULL ,
  PRIMARY KEY (`certification_id`) ,
  INDEX `fk_certification_technical_fields1` (`technical_field_id` ASC) ,
  CONSTRAINT `fk_certification_technical_fields1`
    FOREIGN KEY (`technical_field_id` )
    REFERENCES `tnp`.`technical_fields` (`technical_field_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`student_certification`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`student_certification` (
  `member_id` INT UNSIGNED NOT NULL ,
  `certification_id` INT NOT NULL ,
  `start_date` DATE NOT NULL ,
  `complete_date` DATE NOT NULL ,
  PRIMARY KEY (`member_id`, `certification_id`) ,
  INDEX `fk_student_has_certification_certification1` (`certification_id` ASC) ,
  INDEX `fk_student_certification_members1` (`member_id` ASC) ,
  CONSTRAINT `fk_student_has_certification_certification1`
    FOREIGN KEY (`certification_id` )
    REFERENCES `tnp`.`certification` (`certification_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_certification_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`training`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`training` (
  `training_id` INT NOT NULL AUTO_INCREMENT ,
  `technical_field_id` INT NOT NULL ,
  `training_technology` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`training_id`) ,
  INDEX `fk_training_technical_fields1` (`technical_field_id` ASC) ,
  CONSTRAINT `fk_training_technical_fields1`
    FOREIGN KEY (`technical_field_id` )
    REFERENCES `tnp`.`technical_fields` (`technical_field_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`student_training`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`student_training` (
  `member_id` INT UNSIGNED NOT NULL ,
  `training_id` INT NOT NULL ,
  `training_institute` VARCHAR(100) NOT NULL ,
  `start_date` DATE NOT NULL ,
  `completion_date` DATE NULL ,
  `training_semester` TINYINT UNSIGNED NOT NULL ,
  PRIMARY KEY (`member_id`, `training_id`) ,
  INDEX `fk_student_training_training1` (`training_id` ASC) ,
  INDEX `fk_student_training_members1` (`member_id` ASC) ,
  CONSTRAINT `fk_student_training_training1`
    FOREIGN KEY (`training_id` )
    REFERENCES `tnp`.`training` (`training_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_training_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`employability_test`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`employability_test` (
  `employability_test_id` INT NOT NULL AUTO_INCREMENT ,
  `test_name` VARCHAR(20) NOT NULL ,
  `date_of_conduct` DATE NOT NULL ,
  PRIMARY KEY (`employability_test_id`) ,
  UNIQUE INDEX `test_name_UNIQUE` (`test_name` ASC, `date_of_conduct` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`employability_test_section`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`employability_test_section` (
  `test_section_id` INT NOT NULL AUTO_INCREMENT ,
  `employability_test_id` INT NOT NULL ,
  `test_section_name` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`test_section_id`) ,
  INDEX `fk_employability_test_section_employability_test1` (`employability_test_id` ASC) ,
  CONSTRAINT `fk_employability_test_section_employability_test1`
    FOREIGN KEY (`employability_test_id` )
    REFERENCES `tnp`.`employability_test` (`employability_test_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`employability_test_section_score`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`employability_test_section_score` (
  `section_score_id` INT NOT NULL AUTO_INCREMENT ,
  `test_section_id` INT NOT NULL ,
  `employability_test_id` INT NOT NULL ,
  `section_marks` TINYINT UNSIGNED NOT NULL ,
  `section_percentile` TINYINT UNSIGNED NULL ,
  `member_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`section_score_id`) ,
  INDEX `fk_employability_test_section_score_employability_test_section1` (`test_section_id` ASC) ,
  INDEX `fk_employability_test_section_score_employability_test1` (`employability_test_id` ASC) ,
  INDEX `fk_employability_test_section_score_members1` (`member_id` ASC) ,
  CONSTRAINT `fk_employability_test_section_score_employability_test_section1`
    FOREIGN KEY (`test_section_id` )
    REFERENCES `tnp`.`employability_test_section` (`test_section_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_employability_test_section_score_employability_test1`
    FOREIGN KEY (`employability_test_id` )
    REFERENCES `tnp`.`employability_test` (`employability_test_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_employability_test_section_score_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`employability_test_record`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`employability_test_record` (
  `test_record_id` INT NOT NULL AUTO_INCREMENT ,
  `employability_test_id` INT NOT NULL ,
  `test_regn_no` VARCHAR(20) NOT NULL ,
  `test_total_score` TINYINT NOT NULL ,
  `test_percentile` TINYINT NOT NULL ,
  `member_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`test_record_id`) ,
  INDEX `fk_employability_test_record_employability_test1` (`employability_test_id` ASC) ,
  INDEX `fk_employability_test_record_members1` (`member_id` ASC) ,
  CONSTRAINT `fk_employability_test_record_employability_test1`
    FOREIGN KEY (`employability_test_id` )
    REFERENCES `tnp`.`employability_test` (`employability_test_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_employability_test_record_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`co_curricular`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`co_curricular` (
  `member_id` INT UNSIGNED NOT NULL ,
  `achievements` VARCHAR(2000) NULL ,
  `activities` VARCHAR(2000) NULL ,
  `hobbies` VARCHAR(200) NULL ,
  PRIMARY KEY (`member_id`) ,
  CONSTRAINT `fk_co_curicullar_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`job_preferred`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`job_preferred` (
  `member_id` INT UNSIGNED NOT NULL ,
  `job_area` ENUM('IT','DEFENCE','CORE','GOVERNMENT') NOT NULL ,
  PRIMARY KEY (`member_id`, `job_area`) ,
  CONSTRAINT `fk_job_preferred_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`profile_status`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`profile_status` (
  `member_id` INT UNSIGNED NOT NULL ,
  `exists` TINYINT(1) NOT NULL DEFAULT '0' ,
  `is_locked` TINYINT(1) NOT NULL DEFAULT '0' ,
  `last_updated_on` DATE NOT NULL ,
  PRIMARY KEY (`member_id`) ,
  CONSTRAINT `fk_profile_status_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`company`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`company` (
  `company_id` INT NOT NULL AUTO_INCREMENT ,
  `company_name` VARCHAR(20) NOT NULL ,
  `field` VARCHAR(10) NOT NULL ,
  `description` VARCHAR(2000) NULL ,
  `verified` TINYINT(1) NULL ,
  PRIMARY KEY (`company_id`) );


-- -----------------------------------------------------
-- Table `tnp`.`personnel_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`personnel_type` (
  `personnel_id` INT NOT NULL AUTO_INCREMENT ,
  `personnel_post` CHAR(3) NOT NULL ,
  `company_id` INT NOT NULL ,
  PRIMARY KEY (`personnel_id`) ,
  INDEX `fk_personnel_type_company1` (`company_id` ASC) ,
  CONSTRAINT `fk_personnel_type_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `tnp`.`company` (`company_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`contacts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`contacts` (
  `contacts_id` INT NOT NULL AUTO_INCREMENT ,
  `email_id` VARCHAR(45) NOT NULL ,
  `mobile_no` INT NULL ,
  `landline_no` INT NULL ,
  `fax_no` INT NULL ,
  `personnel_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`contacts_id`) ,
  INDEX `fk_contacts_personnel_type1` (`personnel_id` ASC) ,
  CONSTRAINT `fk_contacts_personnel_type1`
    FOREIGN KEY (`personnel_id` )
    REFERENCES `tnp`.`personnel_type` (`personnel_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`company_job`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`company_job` (
  `company_job_id` INT NOT NULL AUTO_INCREMENT ,
  `company_id` INT NOT NULL ,
  `job` VARCHAR(45) NOT NULL ,
  `eligibility_criteria` VARCHAR(1024) NOT NULL ,
  `description` VARCHAR(1024) NULL ,
  `date_of_announcement` DATE NULL ,
  `external` TINYINT(1) NULL ,
  PRIMARY KEY (`company_job_id`) ,
  INDEX `fk_company_job_company1` (`company_id` ASC) ,
  UNIQUE INDEX `company_id_UNIQUE` (`company_id` ASC, `job` ASC, `date_of_announcement` ASC) ,
  CONSTRAINT `fk_company_job_company1`
    FOREIGN KEY (`company_id` )
    REFERENCES `tnp`.`company` (`company_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `tnp`.`job_record`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`job_record` (
  `company_job_id` INT NOT NULL ,
  `appeared` TINYINT(1) NOT NULL ,
  `selected` TINYINT(1) NOT NULL ,
  `package` INT NOT NULL ,
  `date_of_selection` DATE NOT NULL ,
  `campus_name` VARCHAR(100) NULL ,
  `registered` TINYINT(1) NULL ,
  `member_id` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`company_job_id`, `member_id`) ,
  INDEX `fk_placement_record_company_job1` (`company_job_id` ASC) ,
  CONSTRAINT `fk_placement_record_company_job1`
    FOREIGN KEY (`company_job_id` )
    REFERENCES `tnp`.`company_job` (`company_job_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`industries`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`industries` (
  `industry_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `industry_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`industry_id`) ,
  UNIQUE INDEX `industry_name_UNIQUE` (`industry_name` ASC) );


-- -----------------------------------------------------
-- Table `tnp`.`functional_area`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`functional_area` (
  `functional_area_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `functional_area_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`functional_area_id`) ,
  UNIQUE INDEX `functional_area_name_UNIQUE` (`functional_area_name` ASC) );


-- -----------------------------------------------------
-- Table `tnp`.`roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`roles` (
  `role_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `role_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`role_id`) ,
  UNIQUE INDEX `role_name_UNIQUE` (`role_name` ASC) );


-- -----------------------------------------------------
-- Table `tnp`.`student_experience`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`student_experience` (
  `student_experience_id` INT NOT NULL AUTO_INCREMENT ,
  `member_id` INT UNSIGNED NOT NULL ,
  `industry_id` TINYINT UNSIGNED NOT NULL ,
  `functional_area_id` TINYINT UNSIGNED NOT NULL ,
  `role_id` INT UNSIGNED NOT NULL ,
  `experience_months` TINYINT(11) UNSIGNED NULL ,
  `experience_years` TINYINT NULL ,
  `organisation` VARCHAR(100) NULL ,
  `start_date` DATE NULL ,
  `end_date` DATE NULL ,
  `is_parttime` TINYINT(1) NULL ,
  `description` VARCHAR(1024) NULL ,
  PRIMARY KEY (`student_experience_id`) ,
  INDEX `fk_student_experience_industries1` (`industry_id` ASC) ,
  INDEX `fk_student_experience_functional_area1` (`functional_area_id` ASC) ,
  INDEX `fk_student_experience_roles1` (`role_id` ASC) ,
  INDEX `fk_student_experience_members1` (`member_id` ASC) ,
  CONSTRAINT `fk_student_experience_industries1`
    FOREIGN KEY (`industry_id` )
    REFERENCES `tnp`.`industries` (`industry_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_experience_functional_area1`
    FOREIGN KEY (`functional_area_id` )
    REFERENCES `tnp`.`functional_area` (`functional_area_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_experience_roles1`
    FOREIGN KEY (`role_id` )
    REFERENCES `tnp`.`roles` (`role_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_student_experience_members1`
    FOREIGN KEY (`member_id` )
    REFERENCES `tnp`.`members` (`member_id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE);


-- -----------------------------------------------------
-- Table `tnp`.`batch`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`batch` (
  `batch_id` INT NOT NULL ,
  `department_id` CHAR(10) NULL DEFAULT NULL ,
  `programme_id` CHAR(10) NULL DEFAULT NULL ,
  `batch_start` YEAR NULL DEFAULT NULL ,
  `batch_number` TINYINT(4) NULL DEFAULT NULL ,
  `is_active` TINYINT(1) NULL DEFAULT NULL ,
  UNIQUE INDEX `department_id_UNIQUE` (`department_id` ASC, `programme_id` ASC, `batch_start` ASC) ,
  PRIMARY KEY (`batch_id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `tnp`.`student_class`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`student_class` (
  `member_id` INT UNSIGNED NOT NULL ,
  `class_id` INT UNSIGNED NOT NULL ,
  `roll_no` VARCHAR(20) NULL DEFAULT NULL ,
  `group_id` CHAR(5) NULL DEFAULT NULL ,
  `start_date` DATE NULL DEFAULT NULL ,
  `completion_date` DATE NULL DEFAULT NULL ,
  `is_initial_batch_identifier` TINYINT(1) NULL DEFAULT NULL ,
  PRIMARY KEY (`member_id`, `class_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tnp`.`class`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tnp`.`class` (
  `class_id` INT NOT NULL ,
  `batch_id` INT NULL DEFAULT NULL ,
  `semester_id` TINYINT(4) NOT NULL ,
  `semester_type` ENUM('ODD','EVEN') NULL DEFAULT NULL ,
  `semester_duration` TINYINT(4) UNSIGNED NULL DEFAULT NULL ,
  `handled_by_dept` CHAR(10) NOT NULL ,
  `start_date` DATE NULL DEFAULT NULL ,
  `completion_date` DATE NULL DEFAULT NULL ,
  `is_active` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`class_id`) ,
  UNIQUE INDEX `batch_id_UNIQUE` (`semester_id` ASC) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
