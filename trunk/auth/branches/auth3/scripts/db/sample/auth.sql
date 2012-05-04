/*
SQLyog Ultimate v8.55 
MySQL - 5.5.19 : Database - auth
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `auth`;

/*Data for the table `action` */

insert  into `action`(`module_id`,`controller_id`,`action_id`) values ('login','authenticate','check'),('login','authenticate','gettest'),('login','authenticate','index'),('login','authenticate','logout'),('academic','index','index'),('core','index','index'),('library','index','index'),('login','index','index'),('main','index','index'),('login','test','gogo'),('login','test','popo');

/*Data for the table `auth_user` */

insert  into `auth_user`(`member_id`,`login_id`,`sec_passwd`,`user_salt`,`user_type_id`,`department_id`,`valid_from`,`valid_upto`,`is_active`,`remarks`) values (1,'hemant','pass',NULL,'STAFF','CSE','2012-05-03 23:28:28',NULL,1,NULL);

/*Data for the table `controller` */

insert  into `controller`(`module_id`,`controller_id`) values ('academic','index'),('core','index'),('library','index'),('login','authenticate'),('login','index');

/*Data for the table `department` */

insert  into `department`(`department_id`,`department_name`) values ('APPSC','APPSC'),('BT','BT'),('CSE','CSE'),('ECE','ECE'),('LIB','LIB'),('ME','ME'),('MGMT','MGMT');

/*Data for the table `member_registration` */

/*Data for the table `module` */

insert  into `module`(`module_id`) values ('academic'),('core'),('library'),('login');

/*Data for the table `project_server` */

/*Data for the table `role` */

insert  into `role`(`role_id`,`role_name`) values ('acad_clrk','Academic Clerk'),('acad_ti','Timetable Incharge'),('faculty','Faculty'),('guest','Guest'),('hod','HOD'),('lib_admin','Library Admin'),('lib_rstr','Library Restorer'),('rgstr','Registrar'),('student','Student'),('tpo','Training & Placement Officer');

/*Data for the table `role_resource` */

insert  into `role_resource`(`role_id`,`module_id`,`controller_id`,`action_id`) values ('acad_ti','academic','index','index'),('faculty','login','test','gogo'),('faculty','academic','index','index'),('guest','login','authenticate','check'),('guest','login','authenticate','gettest'),('guest','academic','index','index'),('guest','core','index','index'),('guest','library','index','index'),('guest','login','index','index'),('guest','main','index','index'),('guest','login','authenticate','logout'),('HOD','academic','index','index'),('HOD','login','test','popo'),('lib_admin','library','index','index'),('lib_rstr','library','index','index'),('RGSTR','academic','index','index'),('student','academic','index','index');

/*Data for the table `user_role` */

insert  into `user_role`(`member_id`,`role_id`) values (1,'faculty');

/*Data for the table `user_session` */

/*Data for the table `user_type` */

insert  into `user_type`(`user_type_id`,`user_type_name`) values ('STAFF','STAFF'),('STU','Student');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
