/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/

DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `RolesUsuario`;
DROP TABLE IF EXISTS `Universidades`;
DROP TABLE IF EXISTS `Facultades`;
DROP TABLE IF EXISTS `Profesores`;
DROP TABLE IF EXISTS `Asignaturas`;
DROP TABLE IF EXISTS `Valoraciones`;
DROP TABLE IF EXISTS `Encuestas`;
DROP TABLE IF EXISTS `CamposEncuestas`;
DROP TABLE IF EXISTS `Imagenes`;
DROP TABLE IF EXISTS `Karma`;

CREATE TABLE IF NOT EXISTS `Imagenes` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `ruta` VARCHAR(100) NOT NULL,
    `nombre` VARCHAR(30) NOT NULL,
    `tipo` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombreUsuario` CHAR(20) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `idImagen` INT(11) DEFAULT '1',
    PRIMARY KEY (`id`),
    UNIQUE (`nombreUsuario`),
    UNIQUE (`email`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `RolesUsuario` (
    `idUsuario` INT NOT NULL,
    `rol` ENUM('user', 'mod', 'admin') NOT NULL,
    PRIMARY KEY (`idUsuario`, `rol`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Universidades` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `idImagen` INT(11) DEFAULT '4',
    PRIMARY KEY (`id`),
    UNIQUE (`nombre`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Facultades` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idUniversidad` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `idImagen` INT(11) DEFAULT '3',
    PRIMARY KEY (`id`),
    UNIQUE (`nombre`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Profesores` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `idImagen` INT(11) DEFAULT '2',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Asignaturas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idFacultad` INT NOT NULL,
    `idProfesor` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Valoraciones` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idUsuario` INT NOT NULL,
    `idProfesor` INT NOT NULL,
    `idAsignatura` INT NOT NULL,
    `fecha` DATE NULL DEFAULT CURRENT_TIMESTAMP,
    `comentario` VARCHAR(1000) NULL,
    `puntuacion` DECIMAL(1,0) NOT NULL,
    `likes` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Encuestas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idUsuario` INT NOT NULL,
    `fecha` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `CamposEncuestas` (
    `idEncuesta` INT NOT NULL,
    `campo` VARCHAR(30) NOT NULL,
    `votos` INT NOT NULL DEFAULT '0',
    PRIMARY KEY (`idEncuesta`, `campo`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Karma` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `idUsuario` INT NOT NULL,
    `idValoracion` INT NOT NULL,
    `valor` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;


ALTER TABLE `Usuarios` ADD CONSTRAINT `Usuarios_idImagen` FOREIGN KEY (`idImagen`) REFERENCES `Imagenes`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `Universidades` ADD CONSTRAINT `Universidades_idImagen` FOREIGN KEY (`idImagen`) REFERENCES `Imagenes`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `Facultades` ADD CONSTRAINT `Facultades_idImagen` FOREIGN KEY (`idImagen`) REFERENCES `Imagenes`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `Profesores` ADD CONSTRAINT `Profesores_idImagen` FOREIGN KEY (`idImagen`) REFERENCES `Imagenes`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `Facultades` ADD CONSTRAINT `Facultades_idUniversidad` FOREIGN KEY (`idUniversidad`) REFERENCES `Universidades`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Asignaturas` ADD CONSTRAINT `Asignaturas_idFacultad` FOREIGN KEY (`idFacultad`) REFERENCES `Facultades`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Asignaturas` ADD CONSTRAINT `Asignaturas_idProfesor` FOREIGN KEY (`idProfesor`) REFERENCES `Profesores`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `RolesUsuario` ADD CONSTRAINT `Roles_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Valoraciones` ADD CONSTRAINT `Valoraciones_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Valoraciones` ADD CONSTRAINT `Valoraciones_idProfesor` FOREIGN KEY (`idProfesor`) REFERENCES `Profesores`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Valoraciones` ADD CONSTRAINT `Valoraciones_idAsignatura` FOREIGN KEY (`idAsignatura`) REFERENCES `Asignaturas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Valoraciones` ADD CHECK (puntuacion >= 0 AND puntuacion <= 5);

ALTER TABLE `Encuestas` ADD CONSTRAINT `Encuestas_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `CamposEncuestas` ADD CONSTRAINT `CamposEncuestas_idEncuesta` FOREIGN KEY (`idEncuesta`) REFERENCES `Encuestas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Karma` ADD CONSTRAINT `Karma_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Karma` ADD CONSTRAINT `Karma_idValoracion` FOREIGN KEY (`idValoracion`) REFERENCES `Valoraciones`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `Karma` ADD CHECK (valor = -1 OR valor = 1);
ALTER TABLE `Karma` ADD CONSTRAINT `unique_Karma_idUsuario` UNIQUE (`idUsuario`, `idValoracion`);

DELIMITER $$
CREATE OR REPLACE TRIGGER insertar_rol_despues_de_insertar_usuario
AFTER INSERT ON Usuarios
FOR EACH ROW
BEGIN
    INSERT INTO RolesUsuario (idUsuario, rol) VALUES (NEW.id, 'user');
END$$
DELIMITER ;

DELIMITER $$
CREATE OR REPLACE TRIGGER cambio_rol
AFTER UPDATE on Valoraciones
FOR EACH ROW
BEGIN
    IF(SELECT rol FROM RolesUsuario WHERE idUsuario = NEW.idUsuario) <> 'admin' AND (SELECT SUM(likes) FROM Valoraciones WHERE idUsuario = NEW.idUsuario) >= 20 THEN
        UPDATE RolesUsuario SET rol = 'mod' WHERE idUsuario = NEW.idUsuario;
    END IF;
END$$
DELIMITER ;
