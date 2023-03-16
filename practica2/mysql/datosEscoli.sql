/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
TRUNCATE TABLE `Usuarios`;
TRUNCATE TABLE `RolesUsuario`;
TRUNCATE TABLE `Profesores`;
TRUNCATE TABLE `Universidades`;
TRUNCATE TABLE `Facultades`;
TRUNCATE TABLE `Asignaturas`;
TRUNCATE TABLE `Valoraciones`;
TRUNCATE TABLE `Encuestas`;
TRUNCATE TABLE `CamposEncuestas`;


INSERT INTO `Usuarios` (`id`, `nombreUsuario`, `email`, `password`) VALUES
('1', 'Escoli', 'ignatiuswithcheese@gmail.com', 'Escoli');

INSERT INTO `Profesores` (`id`, `nombre`) VALUES
('1', 'Walter White');

INSERT INTO `Universidades` (`id`, `nombre`) VALUES
('1', 'Universidad Complutense de Madrid');

INSERT INTO `Facultades` (`id`, `idUniversidad`, `nombre`) VALUES
('1', '1', 'Facultad de Informatica'),
('2', '1', 'Facultad de Medicina');

INSERT INTO `valoraciones` (`id`, `idUsuario`, `idProfesor`, `fecha`, `comentario`, `puntuacion`) VALUES
('1', '1', '1', current_timestamp(), 'Es un profesor maravilloso', '4'),
('2', '1', '1', current_timestamp(), 'Me gusta más que ninguno', '3');