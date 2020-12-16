-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.14-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para facturacion
CREATE DATABASE IF NOT EXISTS `facturacion` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `facturacion`;
-- Volcando estructura para tabla facturacion.fact_clients
CREATE TABLE IF NOT EXISTS `fact_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(50) NOT NULL DEFAULT '0',
  `client_surname` varchar(50) NOT NULL DEFAULT '0',
  `client_dni` varchar(13) NOT NULL DEFAULT '0',
  `client_address` varchar(200) DEFAULT '0',
  `client_phone` varchar(20) DEFAULT '0',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla facturacion.fact_clients: ~2 rows (aproximadamente)

-- Volcando estructura para tabla facturacion.fact_products
CREATE TABLE IF NOT EXISTS `fact_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_description` varchar(200) NOT NULL DEFAULT '0',
  `product_price` float NOT NULL DEFAULT 0,
  `product_status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla facturacion.fact_products: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `fact_products` DISABLE KEYS */;
INSERT INTO `fact_products` (`product_id`, `product_description`, `product_price`, `product_status`) VALUES
	(1, 'Lenovo ryzen 5 8RAM 256ROM SSD', 800, 1),
	(2, 'Asus vivobook 15.6 pulgadas 16 RAM 512 SSD', 950, 1),
	(8, 'Mouse', 15, 1),
	(9, 'Teclado', 20.6, 1);
/*!40000 ALTER TABLE `fact_products` ENABLE KEYS */;
CREATE TABLE IF NOT EXISTS `fact_users_profiles` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(50) NOT NULL,
  `profile_status` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='Profiles of users';

-- Volcando datos para la tabla facturacion.fact_users_profiles: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `fact_users_profiles` DISABLE KEYS */;
INSERT INTO `fact_users_profiles` (`profile_id`, `profile_name`, `profile_status`) VALUES
	(1, 'ADMINISTRADOR', 1),
	(2, 'CONTADOR', 1);
-- Volcando estructura para tabla facturacion.fact_users
CREATE TABLE IF NOT EXISTS `fact_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `user_status` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `FK1_user_profile` (`profile_id`),
  CONSTRAINT `FK1_user_profile` FOREIGN KEY (`profile_id`) REFERENCES `fact_users_profiles` (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='Users list of database';

-- Volcando datos para la tabla facturacion.fact_users: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `fact_users` DISABLE KEYS */;
INSERT INTO `fact_users` (`user_id`, `user_name`, `user_email`, `user_password`, `profile_id`, `user_status`) VALUES
	(2, 'contador', 'contador@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1),
	(13, 'Administrador', 'admin@gmail.com', '15d94630de24c0b7e23420776c8456a7', 1, 1);
/*!40000 ALTER TABLE `fact_users` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.fact_users_profiles

/*!40000 ALTER TABLE `fact_users_profiles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
-- Volcando estructura para tabla facturacion.fact_invoice
CREATE TABLE IF NOT EXISTS `fact_invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `invoice_amount` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`invoice_id`),
  KEY `FK1_invoice_client` (`client_id`),
  KEY `FK2_invoice_user` (`user_id`),
  CONSTRAINT `FK1_invoice_client` FOREIGN KEY (`client_id`) REFERENCES `fact_clients` (`client_id`),
  CONSTRAINT `FK2_invoice_user` FOREIGN KEY (`user_id`) REFERENCES `fact_users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;



-- Volcando estructura para tabla facturacion.fact_invoice_details
CREATE TABLE IF NOT EXISTS `fact_invoice_details` (
  `details_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`details_id`),
  KEY `FK1_details_invoice` (`invoice_id`),
  KEY `FK2_details_product` (`product_id`),
  CONSTRAINT `FK1_details_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `fact_invoice` (`invoice_id`),
  CONSTRAINT `FK2_details_product` FOREIGN KEY (`product_id`) REFERENCES `fact_products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
