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


INSERT INTO `Profesores` (`id`, `nombre`) VALUES
('1', 'Walter White'),
('2', 'Profesor Bacterio'),
('3', 'Severus Snape'),
('4', 'Albus Dumbledore'),
('5', 'Minerva McGonagall'),
('6', 'Rubeus Hagrid');

INSERT INTO `Universidades` (`id`, `nombre`) VALUES
('1', 'Universidad Complutense de Madrid'),
('2', 'Universidad de Hogwarts'),
('3', 'Universidad de Narnia'),
('4', 'Universidad de la Tierra Media'),
('5', 'Universidad de Oz');

INSERT INTO `Facultades` (`id`, `idUniversidad`, `nombre`) VALUES
('1', '1', 'Facultad de Informatica'),
('2', '1', 'Facultad de Medicina'),
('3', '2', 'Facultad de Magia y Hechicería'),
('4', '2', 'Facultad de Criaturas Mágicas'),
('5', '3', 'Facultad de Artes Marciales'),
('6', '4', 'Facultad de Estudios Aslánicos');

INSERT INTO `Asignaturas` (`id`, `idFacultad`, `idProfesor`, `nombre`) VALUES
('1', '1', '1', 'Programacion'),
('2', '1', '1', 'Base de Datos'),
('3', '2', '1', 'Anatomia'),
('4', '3', '3', 'Defensa Contra las Artes Oscuras'),
('5', '3', '4', 'Transformaciones'),
('6', '4', '5', 'Cuidado de Criaturas Mágicas'),
('7', '5', '6', 'Herbología');

INSERT INTO `Valoraciones` (`id`, `idUsuario`, `idProfesor`, `fecha`, `comentario`, `puntuacion`, `likes`) VALUES
('1', '1', '1', current_timestamp(), 'Es un profesor maravilloso', '4', '0'),
('2', '1', '1', current_timestamp(), 'Me gusta más que ninguno', '3', '0'),
('3', '1', '1', current_timestamp(), 'Un profesor excepcional', '5', '0'),
('4', '1', '4', current_timestamp(), 'Muy sabio y amable', '4', '0'),
('5', '1', '5', current_timestamp(), 'Tiene un gran conocimiento de las criaturas mágicas', '4', '0'),
('6', '1', '6', current_timestamp(), 'Sus clases son muy interesantes y divertidas', '5', '0');