-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tb_account`;
CREATE TABLE `tb_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` text,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tb_account` (`id`, `name`, `email`, `username`, `password`, `role`) VALUES
(1,	'Administrator',	'admin_asik@yahoo.com',	'admin',	'03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',	1);

DROP TABLE IF EXISTS `tb_class`;
CREATE TABLE `tb_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tb_class` (`id`, `name`, `description`) VALUES
(1,	'TKj4',	'learn computer');

DROP TABLE IF EXISTS `tb_student`;
CREATE TABLE `tb_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `photo` text,
  `address` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tb_student` (`id`, `name`, `photo`, `address`) VALUES
(1,	'joko',	'foto_photo_99533_2019_04_03_02_52_51.jpg',	'bintara 9');

DROP TABLE IF EXISTS `tb_token`;
CREATE TABLE `tb_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_a` int(11) DEFAULT NULL,
  `token` text,
  `expired_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `tb_token` (`id`, `id_a`, `token`, `expired_date`) VALUES
(1,	1,	'efbaab0efb818fec1e06f40906cc80bad66881cedade169794dd0dce085f6502',	'2019-04-10 03:41:29');

-- 2019-04-03 03:41:47
