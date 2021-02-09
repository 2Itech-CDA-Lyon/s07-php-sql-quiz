-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `php_quiz`;
CREATE DATABASE `php_quiz` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `php_quiz`;

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `question_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `answer` (`id`, `text`, `question_id`) VALUES
(1,	'15 secondes',	3),
(2,	'8 minutes',	3),
(3,	'2 heures',	3),
(4,	'3 mois',	3),
(10,	'5',	5),
(11,	'7',	5),
(12,	'11',	5),
(13,	'235',	5),
(14,	'Janvier',	6),
(15,	'Février',	6),
(16,	'Mars',	6),
(17,	'Avril',	6),
(18,	'Le Verseau',	7),
(19,	'Le Cancer',	7),
(20,	'Le Scorpion',	7),
(21,	'Les Poissons',	7),
(22,	'2',	8),
(23,	'3',	8),
(24,	'4',	8),
(25,	'5, comme tout le monde',	8);

DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `right_answer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `question` (`id`, `text`, `order`, `right_answer_id`) VALUES
(3,	'Combien de temps la lumière du soleil met-elle pour nous parvenir?',	2,	2),
(5,	'Combien de joueurs y a-t-il dans une équipe de football?',	1,	12),
(6,	'En 1582, le pape Grégoire XIII a décidé de réformer le calendrier instauré par Jules César. Mais quel était le premier mois du calendrier julien?',	3,	16),
(7,	'Lequel de ces signes du zodiaque n\'est pas un signe d\'Eau?',	4,	18),
(8,	'Combien de doigts ai-je dans mon dos?',	5,	25);

-- 2021-02-09 10:26:20