/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `Roles`;
DROP TABLE IF EXISTS `Universidades`;
DROP TABLE IF EXISTS `Facultades`;
DROP TABLE IF EXISTS `Profesores`;
DROP TABLE IF EXISTS `Asignaturas`;
DROP TABLE IF EXISTS `Valoraciones`;
DROP TABLE IF EXISTS `Encuestas`;
DROP TABLE IF EXISTS `CamposEncuestas`;

CREATE TABLE IF NOT EXISTS `Usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` CHAR(20) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`username`),
    UNIQUE (`email`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Roles` (
    `idUsuario` INT NOT NULL,
    `rol` ENUM('user', 'mod', 'admin') NOT NULL,
    PRIMARY KEY (`idUsuario`, `rol`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Universidades` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`nombre`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Facultades` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idUniversidad` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`, `idUniversidad`),
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Profesores` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Asignaturas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idFacultad` INT NOT NULL,
    `idProfesor` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`idFacultad`),
    UNIQUE (`idProfesor`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Valoraciones` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idUsuario` INT NOT NULL,
    `idProfesor` INT NOT NULL,
    `fecha` DATE NULL DEFAULT CURRENT_TIMESTAMP,
    `comentario` VARCHAR(1000) NULL,
    `puntuacion` DECIMAL(1,0) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`idUsuario`),
    UNIQUE (`idProfesor`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Encuestas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idUsuario` INT NOT NULL,
    `fecha` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`, `idUsuario`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `CamposEncuestas` (
    `idEncuesta` INT NOT NULL,
    `campo` VARCHAR(30) NOT NULL,
    `votos` INT NOT NULL DEFAULT '0',
    PRIMARY KEY (`idEncuesta`, `campo`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;



ALTER TABLE `Facultades` ADD CONSTRAINT `Facultades_idUniversidad` FOREIGN KEY (`idUniversidad`) REFERENCES `Universidades`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Asignaturas` ADD CONSTRAINT `Asignaturas_idFacultad` FOREIGN KEY (`idFacultad`) REFERENCES `Facultades`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Asignaturas` ADD CONSTRAINT `Asignaturas_idProfesor` FOREIGN KEY (`idProfesor`) REFERENCES `Profesores`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Roles` ADD CONSTRAINT `Roles_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Valoraciones` ADD CONSTRAINT `Valoraciones_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Valoraciones` ADD CONSTRAINT `Valoraciones_idProfesor` FOREIGN KEY (`idProfesor`) REFERENCES `Profesores`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Valoraciones` ADD CHECK (puntuacion >= 0 AND puntuacion <= 5);

ALTER TABLE `Encuestas` ADD CONSTRAINT `Encuestas_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `CamposEncuestas` ADD CONSTRAINT `CamposEncuestas_idEncuesta` FOREIGN KEY (`idEncuesta`) REFERENCES `Encuestas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
CREATE OR REPLACE TRIGGER insertar_rol_despues_de_insertar_usuario
AFTER INSERT ON usuarios
FOR EACH ROW
BEGIN
    INSERT INTO roles (idUsuario, rol) VALUES (NEW.id, 'user');
END$$
DELIMITER ;