/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.1.47-MariaDB-0ubuntu0.18.04.1 : Database - laravel-template
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`laravel-template` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `laravel-template`;

/*Table structure for table `admin_navigations` */

DROP TABLE IF EXISTS `admin_navigations`;

CREATE TABLE `admin_navigations` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` bigint(20) unsigned DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `show_in_menu` tinyint(1) DEFAULT '0',
  `show_in_permission` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `admin_navigations_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `admin_navigations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_navigations` */

insert  into `admin_navigations`(`id`,`parent_id`,`name`,`en_name`,`display_order`,`icon`,`action_path`,`status`,`show_in_menu`,`show_in_permission`,`created_at`,`updated_at`) values 
(1,NULL,'Dashboard','Dashboard',0,'fa fa-tachometer','admin/dashboard',1,1,1,'2018-01-14 10:20:41','2019-06-25 09:38:57'),
(2,34,'Sub Admins','Sub Admins',1,'fa fa-universal-access','admin/sub_admins',1,1,1,'2018-01-14 10:22:16','2019-07-12 06:36:23'),
(3,34,'Roles','Roles',2,'fa fa-cogs','admin/role',1,1,1,'2018-01-14 10:34:16','2019-07-12 06:36:25'),
(4,34,'Navigations','Navigations',3,'fa fa-cogs','admin/navigation',1,1,1,'2018-01-14 10:34:50','2019-07-12 06:36:29'),
(5,NULL,'Manage Users','Manage Users',5,'fa fa-users','admin/users',1,1,1,'2018-07-03 09:33:34','2019-03-14 09:51:43'),
(6,NULL,'App Settings','App Settings',50,'fa fa-cogs','admin/settings',1,1,1,'2018-07-20 14:52:58','2018-07-20 14:52:58'),
(7,NULL,'Manage App CMS','Manage App CMS',49,'fa fa-globe','#',1,1,1,'2019-01-12 15:38:02','2019-01-13 18:48:37'),
(9,10,'Countries','Countries',1,NULL,'admin/countries',1,1,1,'2019-02-02 18:00:37','2020-06-04 12:00:25'),
(10,NULL,'Manage Locations','Manage Locations',4,'fa fa-globe','#',1,1,1,'2019-02-09 10:35:28','2019-02-09 10:35:28'),
(11,NULL,'Manage Coupons','Manage Coupons',6,'fa fa-ticket','admin/coupons',1,1,1,'2019-03-08 12:53:57','2019-03-11 17:51:27'),
(12,7,'FAQ','FAQ',1,NULL,'admin/faq',1,1,1,'2019-03-12 16:11:56','2019-03-12 16:11:56'),
(14,11,'Create Coupon','Create Coupon',1,NULL,'create_coupon',1,0,1,'2020-06-04 11:49:56','2020-06-04 11:49:56'),
(15,11,'Update Coupon','Update Coupon',2,NULL,'update_coupon',1,0,1,'2020-06-04 11:49:56','2020-06-04 11:49:56'),
(16,11,'Delete Coupon','Delete Coupon',3,NULL,'delete_coupon',1,0,1,'2020-06-04 11:49:56','2020-06-04 11:49:56'),
(17,2,'Create Admin','Create Admin',1,NULL,'create_sub_admin',1,0,1,'2020-06-04 11:52:13','2020-06-04 11:52:13'),
(18,2,'Update Admin','Update Admin',2,NULL,'update_sub_admin',1,0,1,'2020-06-04 11:52:13','2020-06-04 11:52:13'),
(19,2,'Delete Admin','Delete Admin',3,NULL,'delete_sub_admin',1,0,1,'2020-06-04 11:52:13','2020-06-04 11:52:13'),
(20,2,'Update Permissions','Update Permissions',4,NULL,'update_permission_sub_admin',1,0,1,'2020-06-04 11:52:13','2020-06-04 11:52:13'),
(21,2,'Change Password','Change Password',5,NULL,'change_password_sub_admin',1,0,1,'2020-06-04 11:52:13','2020-06-04 11:52:13'),
(22,3,'Create Role','Create Role',1,NULL,'create_role',1,0,1,'2020-06-04 11:55:34','2020-06-04 11:55:34'),
(23,3,'Update Role','Update Role',2,NULL,'update_role',1,0,1,'2020-06-04 11:55:34','2020-06-04 11:55:34'),
(24,3,'Delete Role','Delete Role',3,NULL,'delete_role',0,0,1,'2020-06-04 11:55:34','2020-06-04 11:55:34'),
(25,3,'Change Permissions','Change Permissions',4,NULL,'update_permission_role',1,0,1,'2020-06-04 11:55:34','2020-06-04 11:55:34'),
(26,9,'Create Country','Create Country',1,NULL,'create_country',0,0,1,'2020-06-04 11:58:54','2020-06-04 11:58:54'),
(27,12,'Create FAQ','Create FAQ',1,NULL,'create_faq',1,0,1,'2020-06-04 12:04:17','2020-06-04 12:04:17'),
(28,12,'Update FAQ','Update FAQ',2,NULL,'update_faq',1,0,1,'2020-06-04 12:04:17','2020-06-04 12:04:17'),
(29,12,'Delete FAQ','Delete FAQ',3,NULL,'delete_faq',1,0,1,'2020-06-04 12:04:17','2020-06-04 12:04:17'),
(30,5,'Create User','Create User',1,NULL,'create_user',1,0,1,'2020-06-04 12:08:11','2020-06-04 12:08:11'),
(31,5,'Update User','Update User',2,NULL,'update_user',1,0,1,'2020-06-04 12:08:11','2020-06-04 12:08:11'),
(32,5,'Delete User','Delete User',3,NULL,'delete_user',1,0,1,'2020-06-04 12:08:11','2020-06-04 12:08:11'),
(33,5,'Change Password','Change Password',4,NULL,'change_password_user',1,0,1,'2020-06-04 12:08:11','2020-06-04 12:08:11'),
(34,NULL,'Manage Admins','Manage Admins',1,'fa fa-universal-access','#',1,1,1,'2018-01-14 10:22:16','2019-07-12 06:36:23'),
(35,4,'Create Navigation','Create Navigation',1,NULL,'create_navigation',1,0,1,'2020-07-04 08:24:11','2020-07-04 08:24:11'),
(36,4,'Update Navigation','Update Navigation',2,NULL,'update_navigation',1,0,1,'2020-07-04 08:24:11','2020-07-04 08:24:11'),
(37,9,'Update Country','Update Country',2,NULL,'update_country',1,0,1,'2020-06-04 11:58:54','2020-06-04 11:58:54'),
(38,9,'Delete Country','Delete Country',3,NULL,'delete_country',0,0,1,'2020-06-04 11:58:54','2020-06-04 11:58:54');

/*Table structure for table `admin_permissions` */

DROP TABLE IF EXISTS `admin_permissions`;

CREATE TABLE `admin_permissions` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(80) unsigned DEFAULT NULL,
  `admin_navigation_id` bigint(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_permissions_user_id` (`admin_id`),
  KEY `users_permissions_navigation_id` (`admin_navigation_id`),
  CONSTRAINT `admin_permissions_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_permissions_ibfk_2` FOREIGN KEY (`admin_navigation_id`) REFERENCES `admin_navigations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_permissions` */

/*Table structure for table `admin_role_permissions` */

DROP TABLE IF EXISTS `admin_role_permissions`;

CREATE TABLE `admin_role_permissions` (
  `id` bigint(100) unsigned NOT NULL AUTO_INCREMENT,
  `admin_role_id` bigint(10) unsigned DEFAULT NULL,
  `admin_navigation_id` bigint(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_permissions_role_id` (`admin_role_id`),
  KEY `roles_permissions_navigation_id` (`admin_navigation_id`),
  CONSTRAINT `admin_role_permissions_ibfk_1` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_role_permissions_ibfk_2` FOREIGN KEY (`admin_navigation_id`) REFERENCES `admin_navigations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_role_permissions` */

insert  into `admin_role_permissions`(`id`,`admin_role_id`,`admin_navigation_id`,`created_at`,`updated_at`) values 
(8,2,1,'2019-07-12 07:10:17','2019-07-12 07:10:17');

/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_roles` */

insert  into `admin_roles`(`id`,`name`,`status`,`created_at`,`updated_at`) values 
(1,'Super Admin',1,'2018-01-14 10:17:56','2018-01-14 10:17:56'),
(2,'Admin',1,'2018-01-14 10:18:19','2018-01-14 10:18:19');

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` bigint(80) unsigned NOT NULL AUTO_INCREMENT,
  `admin_role_id` bigint(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'default-user.png',
  `dial_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admins_role_id` (`admin_role_id`),
  CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`admin_role_id`,`name`,`profile_image`,`dial_code`,`mobile`,`email`,`password`,`remember_token`,`hash_token`,`status`,`created_at`,`updated_at`) values 
(1,1,'Admin','20180622153757LRM6xCxZVW.jpg','91','1234567890','admin@demo.com','$2y$10$S.NJVoe6WxO7ZiuxtbSmze7qp0tIkDnuQ7dS/js2Ky44FwZCzMAfy','xUP6M79reB5ZnzIT9j5nOnIjm1aK7mxZEjRqSToGpuYgXe0LWCZCTh4oDTJT',NULL,1,'2018-04-23 14:38:00','2019-06-27 10:34:23'),
(2,2,'Other User','default-user.png','91','1111111111','other@gmail.com','$2y$10$J0Re7KCPAec6pKA3G5XJVuX9HND1luxmDagjDM24tpjs9QrcdTcWm',NULL,NULL,1,'2020-06-04 12:27:46','2020-07-04 08:19:35');

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alpha_2` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alpha_3` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` decimal(5,2) DEFAULT '18.00',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `countries` */

insert  into `countries`(`id`,`name`,`en_name`,`dial_code`,`alpha_2`,`alpha_3`,`currency`,`flag`,`tax`,`status`,`created_at`,`updated_at`) values 
(1,'Afghanistan','Afghanistan','93','AF','AFG','AFN','AFG_s.png',18.00,0,'2019-03-05 14:13:05','2019-03-05 14:13:05'),
(2,'Albania','Albania','355','AL','ALB','ALL','ALB_s.png',18.00,0,'2019-03-05 14:13:05','2019-03-05 14:13:05'),
(3,'Algeria','Algeria','213','DZ','DZA','DZD','DZA_s.png',18.00,0,'2019-03-05 14:13:05','2019-03-05 14:13:05'),
(4,'American Samoa','American Samoa','1','AS','ASM','USD','ASM_s.png',18.00,0,'2019-03-05 14:13:05','2019-03-05 14:13:05'),
(5,'Andorra','Andorra','376','AD','AND','EUR','AND_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(6,'Angola','Angola','244','AO','AGO','AOA','AGO_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(7,'Anguilla','Anguilla','1','AI','AIA','XCD','AIA_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(8,'Antarctica','Antarctica','672','AQ','ATA','AUD','ATA_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(9,'Argentina','Argentina','54','AR','ARG','ARS','ARG_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(10,'Armenia','Armenia','374','AM','ARM','AMD','ARM_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(11,'Aruba','Aruba','297','AW','ABW','AWG','ABW_s.png',10.00,0,'2019-03-05 14:13:06','2019-03-28 05:20:08'),
(12,'Australia','Australia','61','AU','AUS','AUD','AUS_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(13,'Austria','Austria','43','AT','AUT','EUR','AUT_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(14,'Azerbaijan','Azerbaijan','994','AZ','AZE','AZN','AZE_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(15,'Bahamas','Bahamas','1','BS','BHS','BSD','BHS_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(16,'Bahrain','Bahrain','973','BH','BHR','BHD','BHR_s.png',18.00,0,'2019-03-05 14:13:06','2019-03-05 14:13:06'),
(17,'Bangladesh','Bangladesh','880','BD','BGD','BDT','BGD_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(18,'Barbados','Barbados','1','BB','BRB','BBD','BRB_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(19,'Belarus','Belarus','375','BY','BLR','BYR','BLR_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(20,'Belgium','Belgium','32','BE','BEL','EUR','BEL_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(21,'Belize','Belize','501','BZ','BLZ','BZD','BLZ_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(22,'Benin','Benin','229','BJ','BEN','XOF','BEN_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(23,'Bermuda','Bermuda','1','BM','BMU','BMD','BMU_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(24,'Bhutan','Bhutan','975','BT','BTN','BTN','BTN_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(25,'Bolivia','Bolivia','591','BO','BOL','BOB','BOL_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(26,'Bosnia and Herzegovina','Bosnia and Herzegovina','387','BA','BIH','BAM','BIH_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(27,'Botswana','Botswana','267','BW','BWA','BWP','BWA_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(28,'Brazil','Brazil','55','BR','BRA','BRL','BRA_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(29,'British Virgin Islands','British Virgin Islands','1','VG','VGB','USD','VGB_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(30,'Brunei','Brunei','673','BN','BRN','BND','BRN_s.png',18.00,0,'2019-03-05 14:13:07','2019-03-05 14:13:07'),
(31,'Bulgaria','Bulgaria','359','BG','BGR','BGN','BGR_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(32,'Burkina Faso','Burkina Faso','226','BF','BFA','XOF','BFA_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(33,'Burundi','Burundi','257','BI','BDI','BIF','BDI_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(34,'Cambodia','Cambodia','855','KH','KHM','KHR','KHM_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(35,'Cameroon','Cameroon','237','CM','CMR','XAF','CMR_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(36,'Canada','Canada','1','CA','CAN','CAD','CAN_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(37,'Cape Verde','Cape Verde','238','CV','CPV','CVE','CPV_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(38,'Cayman Islands','Cayman Islands','1-345','KY','CYM','KYD','CYM_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(39,'Central African Republic','Central African Republic','236','CF','CAF','XAF','CAF_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(40,'Chile','Chile','56','CL','CHL','CLP','CHL_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(41,'China','China','86','CN','CHN','CNY','CHN_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(42,'Colombia','Colombia','57','CO','COL','COP','COL_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(43,'Comoros','Comoros','269','KM','COM','KMF','COM_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(44,'Cook Islands','Cook Islands','682','CK','COK','NZD','COK_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(45,'Costa Rica','Costa Rica','506','CR','CRI','CRC','CRI_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(46,'Croatia','Croatia','385','HR','HRV','HRK','HRV_s.png',18.00,0,'2019-03-05 14:13:08','2019-03-05 14:13:08'),
(47,'Cuba','Cuba','53','CU','CUB','CUP','CUB_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(48,'Curacao','Curacao','599','CW','CUW','ANG','CUW_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(49,'Cyprus','Cyprus','357','CY','CYP','EUR','CYP_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(50,'Czech Republic','Czech Republic','420','CZ','CZE','CZK','CZE_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(51,'Democratic Republic of Congo','Democratic Republic of Congo','243','CD','COD','CDF','COD_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(52,'Denmark','Denmark','45','DK','DNK','DKK','DNK_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(53,'Djibouti','Djibouti','253','DJ','DJI','DJF','DJI_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(54,'Dominica','Dominica','1','DM','DMA','XCD','DMA_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(55,'Dominican Republic','Dominican Republic','1','DO','DOM','DOP','DOM_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(56,'East Timor','East Timor','670','TL','TLS','IDR','TLS_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(57,'Ecuador','Ecuador','593','EC','ECU','USD','ECU_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(58,'Egypt','Egypt','20','EG','EGY','EGP','EGY_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(59,'El Salvador','El Salvador','503','SV','SLV','SVC','SLV_s.png',18.00,0,'2019-03-05 14:13:09','2019-03-05 14:13:09'),
(60,'Equatorial Guinea','Equatorial Guinea','240','GQ','GNQ','XAF','GNQ_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(61,'Eritrea','Eritrea','291','ER','ERI','ETB','ERI_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(62,'Estonia','Estonia','372','EE','EST','EUR','EST_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(63,'Ethiopia','Ethiopia','251','ET','ETH','ETB','ETH_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(64,'Falkland Islands','Falkland Islands','500','FK','FLK','FKP','FLK_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(65,'Faroe Islands','Faroe Islands','298','FO','FRO','DKK','FRO_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(66,'Fiji','Fiji','679','FJ','FJI','FJD','FJI_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(67,'Finland','Finland','358','FI','FIN','EUR','FIN_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(68,'France','France','33','FR','FRA','EUR','FRA_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(69,'French Polynesia','French Polynesia','689','PF','PYF','XPF','PYF_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(70,'Gabon','Gabon','241','GA','GAB','XAF','GAB_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(71,'Gambia','Gambia','220','GM','GMB','GMD','GMB_s.png',18.00,0,'2019-03-05 14:13:10','2019-03-05 14:13:10'),
(72,'Georgia','Georgia','995','GE','GEO','GEL','GEO_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(73,'Germany','Germany','49','DE','DEU','EUR','DEU_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(74,'Ghana','Ghana','233','GH','GHA','GHS','GHA_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(75,'Gibraltar','Gibraltar','350','GI','GIB','GIP','GIB_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(76,'Greece','Greece','30','GR','GRC','EUR','GRC_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(77,'Greenland','Greenland','299','GL','GRL','DKK','GRL_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(78,'Guadeloupe','Guadeloupe','590','GP','GLP','EUR','GLP_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(79,'Guam','Guam','1','GU','GUM','USD','GUM_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(80,'Guatemala','Guatemala','502','GT','GTM','GTQ','GTM_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(81,'Guinea','Guinea','224','GN','GIN','GNF','GIN_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(82,'Guinea-Bissau','Guinea-Bissau','245','GW','GNB','XOF','GNB_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(83,'Guyana','Guyana','592','GY','GUY','GYD','GUY_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(84,'Haiti','Haiti','509','HT','HTI','HTG','HTI_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(85,'Honduras','Honduras','504','HN','HND','HNL','HND_s.png',18.00,0,'2019-03-05 14:13:11','2019-03-05 14:13:11'),
(86,'Hong Kong','Hong Kong','852','HK','HKG','HKD','HKG_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(87,'Hungary','Hungary','36','HU','HUN','HUF','HUN_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(88,'Iceland','Iceland','354','IS','ISL','ISK','ISL_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(89,'India','India','91','IN','IND','INR','IND_s.png',18.00,1,'2019-03-05 14:13:12','2019-03-05 12:28:09'),
(90,'Indonesia','Indonesia','62','ID','IDN','IDR','IDN_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(91,'Iran','Iran','98','IR','IRN','IRR','IRN_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(92,'Iraq','Iraq','964','IQ','IRQ','IQD','IRQ_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(93,'Ireland','Ireland','353','IE','IRL','EUR','IRL_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(94,'Isle of Man','Isle of Man','44','IM','IMN','IMP','IMN_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(95,'Israel','Israel','972','IL','ISR','ILS','ISR_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(96,'Italy','Italy','39','IT','ITA','EUR','ITA_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(97,'Ivory Coast','Ivory Coast','225','CI','CIV','XOF','CIV_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(98,'Jamaica','Jamaica','1','JM','JAM','JMD','JAM_s.png',18.00,0,'2019-03-05 14:13:12','2019-03-05 14:13:12'),
(99,'Japan','Japan','81','JP','JPN','JPY','JPN_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(100,'Jordan','Jordan','962','JO','JOR','JOD','JOR_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(101,'Kazakhstan','Kazakhstan','7','KZ','KAZ','KZT','KAZ_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(102,'Kenya','Kenya','254','KE','KEN','KES','KEN_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(103,'Kiribati','Kiribati','686','KI','KIR','AUD','KIR_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(104,'Kosovo','Kosovo','381','XK','XKX','Euro','XKX_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(105,'Kuwait','Kuwait','965','KW','KWT','KWD','KWT_s.png',5.00,1,'2019-03-05 14:13:13','2019-04-11 14:09:21'),
(106,'Kyrgyzstan','Kyrgyzstan','996','KG','KGZ','KGS','KGZ_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(107,'Laos','Laos','856','LA','LAO','LAK','LAO_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(108,'Latvia','Latvia','371','LV','LVA','EUR','LVA_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(109,'Lebanon','Lebanon','961','LB','LBN','LBP','LBN_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(110,'Lesotho','Lesotho','266','LS','LSO','LSL','LSO_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(111,'Liberia','Liberia','231','LR','LBR','LRD','LBR_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(112,'Libya','Libya','218','LY','LBY','LYD','LBY_s.png',18.00,0,'2019-03-05 14:13:13','2019-03-05 14:13:13'),
(113,'Liechtenstein','Liechtenstein','423','LI','LIE','CHF','LIE_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(114,'Lithuania','Lithuania','370','LT','LTU','LTL','LTU_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(115,'Luxembourg','Luxembourg','352','LU','LUX','EUR','LUX_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(116,'Macau','Macau','853','MO','MAC','MOP','MAC_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(117,'Macedonia','Macedonia','389','MK','MKD','MKD','MKD_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(118,'Madagascar','Madagascar','261','MG','MDG','MGA','MDG_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(119,'Malawi','Malawi','265','MW','MWI','MWK','MWI_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(120,'Malaysia','Malaysia','60','MY','MYS','MYR','MYS_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(121,'Maldives','Maldives','960','MV','MDV','MVR','MDV_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(122,'Mali','Mali','223','ML','MLI','XOF','MLI_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(123,'Malta','Malta','356','MT','MLT','EUR','MLT_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(124,'Marshall Islands','Marshall Islands','692','MH','MHL','USD','MHL_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(125,'Mauritania','Mauritania','222','MR','MRT','MRO','MRT_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(126,'Mauritius','Mauritius','230','MU','MUS','MUR','MUS_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(127,'Mexico','Mexico','52','MX','MEX','MXN','MEX_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(128,'Micronesia','Micronesia','691','FM','FSM','USD','FSM_s.png',18.00,0,'2019-03-05 14:13:14','2019-03-05 14:13:14'),
(129,'Moldova','Moldova','373','MD','MDA','MDL','MDA_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(130,'Monaco','Monaco','377','MC','MCO','EUR','MCO_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(131,'Mongolia','Mongolia','976','MN','MNG','MNT','MNG_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(132,'Montenegro','Montenegro','382','ME','MNE','EUR','MNE_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(133,'Montserrat','Montserrat','1','MS','MSR','XCD','MSR_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(134,'Morocco','Morocco','212','MA','MAR','MAD','MAR_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(135,'Mozambique','Mozambique','258','MZ','MOZ','MZN','MOZ_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(136,'Myanmar [Burma]','Myanmar [Burma]','95','MM','MMR','MMK','MMR_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(137,'Namibia','Namibia','264','NA','NAM','NAD','NAM_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(138,'Nauru','Nauru','674','NR','NRU','AUD','NRU_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(139,'Nepal','Nepal','977','NP','NPL','NPR','NPL_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(140,'Netherlands','Netherlands','31','NL','NLD','EUR','NLD_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(141,'New Caledonia','New Caledonia','687','NC','NCL','XPF','NCL_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(142,'New Zealand','New Zealand','64','NZ','NZL','NZD','NZL_s.png',18.00,0,'2019-03-05 14:13:15','2019-03-05 14:13:15'),
(143,'Nicaragua','Nicaragua','505','NI','NIC','NIO','NIC_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(144,'Niger','Niger','227','NE','NER','XOF','NER_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(145,'Nigeria','Nigeria','234','NG','NGA','NGN','NGA_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(146,'Niue','Niue','683','NU','NIU','NZD','NIU_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(147,'Norfolk Island','Norfolk Island','672','NF','NFK','AUD','NFK_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(148,'North Korea','North Korea','850','KP','PRK','KPW','PRK_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(149,'Northern Mariana Islands','Northern Mariana Islands','1','MP','MNP','USD','MNP_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(150,'Norway','Norway','47','NO','NOR','NOK','NOR_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(151,'Oman','Oman','968','OM','OMN','OMR','OMN_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(152,'Pakistan','Pakistan','92','PK','PAK','PKR','PAK_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(153,'Palau','Palau','680','PW','PLW','USD','PLW_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(154,'Panama','Panama','507','PA','PAN','PAB','PAN_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(155,'Papua New Guinea','Papua New Guinea','675','PG','PNG','PGK','PNG_s.png',18.00,0,'2019-03-05 14:13:16','2019-03-05 14:13:16'),
(156,'Paraguay','Paraguay','595','PY','PRY','PYG','PRY_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(157,'Peru','Peru','51','PE','PER','PEN','PER_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(158,'Philippines','Philippines','63','PH','PHL','PHP','PHL_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(159,'Pitcairn Islands','Pitcairn Islands','870','PN','PCN','NZD','PCN_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(160,'Poland','Poland','48','PL','POL','PLN','POL_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(161,'Portugal','Portugal','351','PT','PRT','EUR','PRT_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(162,'Puerto Rico','Puerto Rico','1','PR','PRI','USD','PRI_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(163,'Qatar','Qatar','974','QA','QAT','QAR','QAT_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(164,'Republic of the Congo','Republic of the Congo','242','CG','COG','XAF','COG_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(165,'Reunion','Reunion','262','RE','REU','EUR','REU_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(166,'Romania','Romania','40','RO','ROU','RON','ROU_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(167,'Russia','Russia','7','RU','RUS','RUB','RUS_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(168,'Rwanda','Rwanda','250','RW','RWA','RWF','RWA_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(169,'Saint Barthélemy','Saint Barthélemy','590','BL','BLM','EUR','BLM_s.png',18.00,0,'2019-03-05 14:13:17','2019-03-05 14:13:17'),
(170,'Saint Helena','Saint Helena','290','SH','SHN','SHP','SHN_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(171,'Saint Kitts and Nevis','Saint Kitts and Nevis','1','KN','KNA','XCD','KNA_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(172,'Saint Lucia','Saint Lucia','1','LC','LCA','XCD','LCA_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(173,'Saint Martin','Saint Martin','1','MF','MAF','EUR','MAF_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(174,'Saint Pierre and Miquelon','Saint Pierre and Miquelon','508','PM','SPM','EUR','SPM_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(175,'Saint Vincent and the Grenadines','Saint Vincent and the Grenadines','1','VC','VCT','XCD','VCT_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(176,'Samoa','Samoa','685','WS','WSM','WST','WSM_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(177,'San Marino','San Marino','378','SM','SMR','EUR','SMR_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(178,'Sao Tome and Principe','Sao Tome and Principe','239','ST','STP','STD','STP_s.png',18.00,0,'2019-03-05 14:13:18','2019-03-05 14:13:18'),
(179,'Saudi Arabia','Saudi Arabia','966','SA','SAU','SAR','SAU_s.png',10.00,1,'2019-03-05 14:13:18','2019-03-29 05:56:23'),
(180,'Senegal','Senegal','221','SN','SEN','XOF','SEN_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(181,'Serbia','Serbia','381','RS','SRB','RSD','SRB_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(182,'Seychelles','Seychelles','248','SC','SYC','SCR','SYC_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(183,'Sierra Leone','Sierra Leone','232','SL','SLE','SLL','SLE_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(184,'Singapore','Singapore','65','SG','SGP','SGD','SGP_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(185,'Slovakia','Slovakia','421','SK','SVK','SKK','SVK_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(186,'Slovenia','Slovenia','386','SI','SVN','EUR','SVN_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(187,'Solomon Islands','Solomon Islands','677','SB','SLB','SBD','SLB_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(188,'Somalia','Somalia','252','SO','SOM','SOS','SOM_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(189,'South Africa','South Africa','27','ZA','ZAF','ZAR','ZAF_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(190,'South Korea','South Korea','82','KR','KOR','KRW','KOR_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(191,'South Sudan','South Sudan','211','SS','SSD','SSP','SSD_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(192,'Spain','Spain','34','ES','ESP','EUR','ESP_s.png',18.00,0,'2019-03-05 14:13:19','2019-03-05 14:13:19'),
(193,'Sri Lanka','Sri Lanka','94','LK','LKA','LKR','LKA_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(194,'Sudan','Sudan','249','SD','SDN','SDG','SDN_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(195,'Suriname','Suriname','597','SR','SUR','SRD','SUR_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(196,'Swaziland','Swaziland','268','SZ','SWZ','CHF','SWZ_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(197,'Sweden','Sweden','46','SE','SWE','SEK','SWE_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(198,'Switzerland','Switzerland','41','CH','CHE','CHF','CHE_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(199,'Syria','Syria','963','SY','SYR','SYP','SYR_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(200,'Taiwan','Taiwan','886','TW','TWN','TWD','TWN_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(201,'Tajikistan','Tajikistan','992','TJ','TJK','TJS','TJK_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(202,'Tanzania','Tanzania','255','TZ','TZA','TZS','TZA_s.png',18.00,0,'2019-03-05 14:13:20','2019-03-05 14:13:20'),
(203,'Thailand','Thailand','66','TH','THA','THB','THA_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(204,'Togo','Togo','228','TG','TGO','XOF','TGO_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(205,'Tokelau','Tokelau','690','TK','TKL','NZD','TKL_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(206,'Trinidad and Tobago','Trinidad and Tobago','1','TT','TTO','TTD','TTO_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(207,'Tunisia','Tunisia','216','TN','TUN','TND','TUN_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(208,'Turkey','Turkey','90','TR','TUR','TRY','TUR_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(209,'Turkmenistan','Turkmenistan','993','TM','TKM','TMM','TKM_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(210,'Tuvalu','Tuvalu','688','TV','TUV','TVD','TUV_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(211,'Uganda','Uganda','256','UG','UGA','UGX','UGA_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(212,'Ukraine','Ukraine','380','UA','UKR','UAH','UKR_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(213,'United Arab Emirates','United Arab Emirates','971','AE','ARE','AED','ARE_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(214,'United Kingdom','United Kingdom','44','GB','GBR','GBP','GBR_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(215,'United States','United States','1','US','USA','USD','USA_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(216,'Uruguay','Uruguay','598','UY','URY','UYU','URY_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(217,'Uzbekistan','Uzbekistan','998','UZ','UZB','UZS','UZB_s.png',18.00,0,'2019-03-05 14:13:21','2019-03-05 14:13:21'),
(218,'Vanuatu','Vanuatu','678','VU','VUT','VUV','VUT_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22'),
(219,'Vatican','Vatican','39','VA','VAT','EUR','VAT_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22'),
(220,'Venezuela','Venezuela','58','VE','VEN','VEF','VEN_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22'),
(221,'Vietnam','Vietnam','84','VN','VNM','VND','VNM_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22'),
(222,'Western Sahara','Western Sahara','212','EH','ESH','MAD','ESH_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22'),
(223,'Yemen','Yemen','967','YE','YEM','YER','YEM_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22'),
(224,'Zambia','Zambia','260','ZM','ZMB','ZMW','ZMB_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22'),
(225,'Zimbabwe','Zimbabwe','263','ZW','ZWE','ZWD','ZWE_s.png',18.00,0,'2019-03-05 14:13:22','2019-03-05 14:13:22');

/*Table structure for table `coupons` */

DROP TABLE IF EXISTS `coupons`;

CREATE TABLE `coupons` (
  `id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1.Flat, 2.Percentage',
  `discount` decimal(18,2) DEFAULT NULL,
  `max_discount` decimal(18,2) DEFAULT NULL,
  `per_user_usage` int(5) DEFAULT '0' COMMENT '0.Unlimited',
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `coupons` */

/*Table structure for table `faq` */

DROP TABLE IF EXISTS `faq`;

CREATE TABLE `faq` (
  `id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_title` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `en_content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `faq` */

insert  into `faq`(`id`,`title`,`en_title`,`content`,`en_content`,`created_at`,`updated_at`) values 
(1,'كيف يعمل التطبيق','How App Works','lorem ipsum هو مجرد دميه النص من صناعه الطباعة والتنضيد. وكان lorem ipsum نص الصناعة القياسية دميه من اي وقت مضي منذ 1500s ، عندما أخذت طابعه غير معروفه من نوع المطبخ وسارعت إلى جعل نوع الكتاب عينه. فقد نجا ليس فقط خمسه قرون ، ولكن أيضا قفزه في التنضيد الكترونيه ، المتبقية أساسا دون تغيير.','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.','2019-03-12 10:51:42','2019-03-12 10:51:42');

/*Table structure for table `fcm_tokens` */

DROP TABLE IF EXISTS `fcm_tokens`;

CREATE TABLE `fcm_tokens` (
  `id` bigint(50) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(80) unsigned DEFAULT NULL,
  `fcm_id` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fcm_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `fcm_tokens` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(80) unsigned DEFAULT NULL,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_title` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `en_message` longtext COLLATE utf8mb4_unicode_ci,
  `attribute` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_type` tinyint(1) DEFAULT '0' COMMENT '0.Admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_to_user_id` (`user_id`),
  CONSTRAINT `notifications_to_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `attribute` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int(10) DEFAULT '0',
  `value` text COLLATE utf8mb4_unicode_ci,
  `en_value` text COLLATE utf8mb4_unicode_ci,
  `is_single` tinyint(1) DEFAULT '0',
  `is_textarea` tinyint(1) DEFAULT '0',
  `is_simple` tinyint(1) DEFAULT '0',
  `is_file` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`attribute`,`display_order`,`value`,`en_value`,`is_single`,`is_textarea`,`is_simple`,`is_file`,`created_at`,`updated_at`) values 
(1,'logo',1,'35345675248685030701604645236.png','35345675248685030701604645236.png',1,0,0,1,'2020-11-06 12:11:22','2020-11-06 06:47:16'),
(2,'company_name',0,'DEMO','DEMO',0,0,1,0,NULL,'2020-11-06 06:47:16');

/*Table structure for table `subscription_histories` */

DROP TABLE IF EXISTS `subscription_histories`;

CREATE TABLE `subscription_histories` (
  `id` bigint(80) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(80) unsigned DEFAULT NULL,
  `company_id` bigint(80) unsigned DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `mode_of_payment` tinyint(1) DEFAULT NULL COMMENT '1.Cash, 2.Online Banking',
  `transaction_id` varchar(250) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscription_id` (`subscription_id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `subscription_histories_ibfk_1` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `subscription_histories_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `laravel_setup`.`companies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `subscription_histories` */

/*Table structure for table `subscriptions` */

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `id` bigint(80) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `en_name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `duration` int(10) DEFAULT NULL COMMENT 'In days',
  `no_of_vendors` int(10) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `subscriptions` */

insert  into `subscriptions`(`id`,`name`,`en_name`,`price`,`duration`,`no_of_vendors`,`status`,`created_at`,`updated_at`) values 
(1,'خطه مجانية','Free Plan',0.00,0,0,1,'2019-03-17 18:00:46','2019-03-19 09:20:52');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(80) unsigned NOT NULL AUTO_INCREMENT,
  `profile_image` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dial_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_generated_at` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '0.Inactive, 1.Active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`profile_image`,`name`,`email`,`dial_code`,`mobile`,`password`,`remember_token`,`otp`,`otp_generated_at`,`status`,`created_at`,`updated_at`) values 
(1,NULL,'Test User','','966','512345678','$2y$10$G1aJHYFf4TqDqEuy4KPiluerQYD5dpKQUyqTBaFK7n88Gsgbc7qE6',NULL,NULL,NULL,1,'2019-07-12 06:23:26','2020-07-04 08:16:11');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
