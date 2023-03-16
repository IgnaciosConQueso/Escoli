/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
TRUNCATE TABLE `Usuarios`;
TRUNCATE TABLE `Roles`;
TRUNCATE TABLE `Profesores`;
TRUNCATE TABLE `Universidades`;
TRUNCATE TABLE `Facultades`;
TRUNCATE TABLE `Asignaturas`;
TRUNCATE TABLE `Valoraciones`;
TRUNCATE TABLE `Encuestas`;
TRUNCATE TABLE `CamposEncuestas`;


INSERT INTO `Usuarios` (`id`, `username`, `email`, `password`) VALUES
(0, 'Escoli', 'ignatiuswithcheese@gmail.com', 'Escoli');

INSERT INTO `Profesores` (`id`, `nombre`) VALUES
(0, 'Walter White');

INSERT INTO `Universidades` (`id`, `nombre`) VALUES
('0', 'Universidad Complutense de Madrid');

INSERT INTO `Facultades` (`id`, `idUniversidad`, `nombre`) VALUES
(0, 0, 'Facultad de Informatica'),
(1, 0, 'Facultad de Medicina');

INSERT INTO `valoraciones` (`id`, `idUsuario`, `idProfesor`, `fecha`, `comentario`, `puntuacion`) VALUES
(NULL, '0', '0', current_timestamp(), 'Es un profesor maravilloso', '4'),
(NULL, '0', '0', current_timestamp(), 'Me gusta más que ninguno', '3');