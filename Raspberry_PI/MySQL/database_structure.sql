# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.57-0+deb8u1)
# Datenbank: ALEXA
# Erstellt am: 2017-09-30 12:22:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Export von Tabelle devices
# ------------------------------------------------------------

CREATE TABLE `devices` (
  `internal_id` int(11) unsigned NOT NULL,
  `unique_id` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `state` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `reachable` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `model` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `bridge_name` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `bridge_ip` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `key` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`internal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


# Export von Tabelle functions
# ------------------------------------------------------------

CREATE TABLE `functions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) COLLATE utf8_bin NOT NULL DEFAULT '',
  `request_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

# Export von Tabelle hue
# ------------------------------------------------------------

CREATE TABLE `hue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


# Export von Tabelle requests
# ------------------------------------------------------------

CREATE TABLE `requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(1024) COLLATE utf8_bin NOT NULL DEFAULT '',
  `requestString` varchar(1024) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

# Export von Tabelle settings
# ------------------------------------------------------------

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  `value` varchar(1024) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`id`, `name`, `value`)
VALUES
	(1,X'4150495F4B6579',X'426F55414E5355375843306946444A7A59456F3159794E73756E386664687945766936393151364F6935584E7978636E3272645151513962353767386446437A4F78784564736A6C6E37594D74325A6C6A34325A4A3131445738423143347067714E4C743756466B527457626C4D6D7646646B6634624A513061484334574A6B'),
	(2,X'6E656564735F72656C6F6164',X'74727565');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
