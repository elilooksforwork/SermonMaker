-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table elitest.bible
CREATE TABLE IF NOT EXISTS `bible` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `verse` varchar(35) CHARACTER SET utf8 NOT NULL,
  `scripture` varchar(1500) CHARACTER SET utf8 NOT NULL,
  `tags` varchar(900) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_bible__verse_tags` (`verse`,`tags`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12287 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for procedure elitest.spgetbibleverses
DELIMITER //
CREATE PROCEDURE `spgetbibleverses`(
	IN `Ttag` varchar(50)
)
BEGIN
	SET Ttag = CONCAT("%",Ttag,"%");
	SELECT * FROM bible WHERE tags LIKE Ttag;
END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
