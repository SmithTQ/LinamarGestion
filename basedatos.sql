-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.1.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

-- Volcando estructura de base de datos para bdlinamargestion
DROP DATABASE IF EXISTS `bdlinamargestion2`;
CREATE DATABASE IF NOT EXISTS `bdlinamargestion2`;
USE `bdlinamargestion2`;


-- Volcando estructura para tabla bdlinamargestion.tb_ubigeo
DROP TABLE IF EXISTS `bdlinamargestion2`.`tb_ubigeo`;
CREATE TABLE IF NOT EXISTS `bdlinamargestion2`.`tb_ubigeo` (
  `inIdubigeo` int(4) NOT NULL,
  `inIddepartamento` int(6) NOT NULL,
  `vcDescdepartamento` varchar(250) NOT NULL,
  `inIdprovincia` int(6) NOT NULL,
  `vcDescprovincia` varchar(250) NOT NULL,
  `vcDescdistrito` varchar(250) NOT NULL,
  `vcMacroregion` varchar(50) NOT NULL,
  `tsFechacreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `tsFechamodificacion` timestamp NULL DEFAULT NULL,
  `inHabilitado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando estructura para tabla bdlinamargestion.tb_detalles
DROP TABLE IF EXISTS `bdlinamargestion2`.`tb_detalles`;
CREATE TABLE IF NOT EXISTS `bdlinamargestion2`.`tb_detalles` (
    `inIdDetalle` CHAR(36) NOT NULL COMMENT 'Campo de tipo UUID' , 
    `vcNombreDetalle` VARCHAR(250) NOT NULL , 
    `vcDescDetalle` TEXT, 
    `vcUrlImagenDetalle` TEXT NOT NULL , 
    `vcTipoImagenDetalle` VARCHAR(10), 
    `tsFechaCreacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `tsFechaModificacion` TIMESTAMP NULL, 
    `tsFechaEliminacion` TIMESTAMP NULL, 
    `inVersion` INT(2), 
    `inHabilitado` INT(1) NOT NULL 
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- Volcando estructura para tabla bdlinamargestion.tb_detalles
DROP TABLE IF EXISTS `bdlinamargestion2`.`tb_preciodetalles`;
CREATE TABLE IF NOT EXISTS `bdlinamargestion2`.`tb_preciodetalles` (
    `inIdPrecioDetalle` CHAR(36) NOT NULL , 
    `inIdDetalle` CHAR(36) NOT NULL COMMENT 'ForeignKey tabla tb_detalles' , 
    `inSolPrecioDetalle` DOUBLE(10) NOT NULL , 
    `inDolarPrecioDetalle` DOUBLE(10) NULL , 
    `tsFechaCreacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `tsFechaModificacion` TIMESTAMP NULL , 
    `tsFechaEliminacion` TIMESTAMP NULL ,
    `inVersion` INT NOT NULL , 
    `inHabilitado` INT NOT NULL , 
    PRIMARY KEY (`inIdPrecioDetalle`(36)),
    FOREIGN KEY (inIdDetalle) REFERENCES tb_detalles(inIdDetalle) ON DELETE CASCADE
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;
