/* mysql -uroot -p cyberhawk < ./install.sql */

DROP DATABASE IF EXISTS `cyberhawk`;

CREATE DATABASE `cyberhawk` DEFAULT CHARACTER SET latin1;
USE `cyberhawk`;



CREATE TABLE `users` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NULL,
  `last_name` VARCHAR(50) NULL,
  `email` VARCHAR(50) NOT NULL UNIQUE,
  `passwd` VARCHAR(50) NULL,
  `salt` CHAR(40) NULL,
  `token` CHAR(40) NOT NULL,
  `active` BOOLEAN NOT NULL,
  `storage` INT(5) NULL,
  `retention` INT(5) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `log_types` (
  `id` INT(2) NOT NULL,
  `type` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `log_states` (
  `id` INT(2) NOT NULL,
  `state` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `logs` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `log_type_id` INT NOT NULL,
  `log_state_id` INT NOT NULL,
  `time` DATETIME NOT NULL,
  `ip` VARCHAR(15) NOT NULL,
  `details` VARCHAR(200) NOT NULL,
  `filename` VARCHAR(200) NULL,
  `md5` CHAR(32) NULL,
  `sha1` CHAR(40) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `logs_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `logs_fk2` FOREIGN KEY (`log_type_id`) REFERENCES `log_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `logs_fk3` FOREIGN KEY (`log_state_id`) REFERENCES `log_states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `shared_files` (
  `id` INT(5) NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `filename` VARCHAR(1024) NOT NULL,
  `token` CHAR(40) NOT NULL,
  `valid_time` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `shared_files_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `log_states` VALUES (1, "Success");
INSERT INTO `log_states` VALUES (2, "Failure");


INSERT INTO `log_types` VALUES (1, "User Creation (No validation required)");
INSERT INTO `log_types` VALUES (2, "User Creation (Validation required)");
INSERT INTO `log_types` VALUES (3, "User Login");
INSERT INTO `log_types` VALUES (4, "User Logout");
INSERT INTO `log_types` VALUES (5, "User Deactivation");
INSERT INTO `log_types` VALUES (6, "User Activation");
INSERT INTO `log_types` VALUES (7, "User Deletion");
INSERT INTO `log_types` VALUES (8, "User Password Reset");
INSERT INTO `log_types` VALUES (9, "User Password Change");
INSERT INTO `log_types` VALUES (10, "User Information Change");
INSERT INTO `log_types` VALUES (11, "File Upload");
INSERT INTO `log_types` VALUES (12, "File Download");
INSERT INTO `log_types` VALUES (13, "File Deletion");
