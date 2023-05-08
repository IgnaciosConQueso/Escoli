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
TRUNCATE TABLE `Karma`;
TRUNCATE TABLE `Imagenes`;

INSERT INTO `Profesores` (`id`, `nombre`) VALUES
('1', 'Walter White'),
('2', 'Profesor Bacterio'),
('3', 'Severus Snape'),
('4', 'Albus Dumbledore'),
('5', 'Minerva McGonagall'),
('6', 'Rubeus Hagrid'),
('7', 'Dr. Strange'),
('8', 'Señor Miyagi'),
('9', 'Gandalf'),
('10', 'Yoda'),
('11', 'Lara Croft');

INSERT INTO `Universidades` (`id`, `nombre`) VALUES
('1', 'Universidad Complutense de Madrid'),
('2', 'Universidad de Hogwarts'),
('3', 'Universidad de Narnia'),
('4', 'Universidad de la Tierra Media'),
('5', 'Universidad de Oz'),
('6', 'Universidad de Wakanda'),
('7', 'Universidad de Coruscant');

INSERT INTO `Facultades` (`id`, `idUniversidad`, `nombre`) VALUES
('1', '1', 'Facultad de Informatica'),
('2', '1', 'Facultad de Medicina'),
('3', '2', 'Facultad de Magia y Hechicería'),
('4', '2', 'Facultad de Criaturas Mágicas'),
('5', '3', 'Facultad de Artes Marciales'),
('6', '4', 'Facultad de Estudios Aslánicos'),
('7', '6', 'Facultad de Ciencias'),
('8', '6', 'Facultad de Artes'),
('9', '6', 'Facultad de Tecnología'),
('10', '7', 'Facultad de Jedi'),
('11', '7', 'Facultad de Sith'),
('12', '7', 'Facultad de Ingeniería');

INSERT INTO `Asignaturas` (`id`, `idFacultad`, `idProfesor`, `nombre`) VALUES
('1', '1', '1', 'Programacion'),
('2', '1', '1', 'Base de Datos'),
('3', '2', '2', 'Anatomia'),
('4', '3', '3', 'Defensa Contra las Artes Oscuras'),
('5', '3', '4', 'Transformaciones'),
('6', '4', '5', 'Cuidado de Criaturas Mágicas'),
('7', '5', '6', 'Herbología'),
('8', '1', '7', 'Física Cuántica'),
('9', '2', '8', 'Karate'),
('10', '3', '9', 'Hechicería'),
('11', '4', '10', 'Fuerza y Sabiduría Jedi'),
('12', '5', '11', 'Artefactos Sith'),
('13', '6', '7', 'Programación en Python'),
('14', '7', '8', 'Meditación');

/* 30 valoraiones distintas */
INSERT INTO `Valoraciones` (`idUsuario`, `idProfesor`, `idAsignatura`, `comentario`, `puntuacion`, `likes`) VALUES
('1', '1', '1', 'Es un profesor maravilloso', '4', '0'),
('1', '1', '2', 'Me gusta más que ninguno', '3', '0'),
('1', '2', '3', 'Un profesor excepcional', '5', '0'),
('1', '4', '4', 'Muy sabio y amable', '4', '0'),
('1', '5', '5', 'Tiene un gran conocimiento de las criaturas mágicas', '4', '0'),
('1', '6', '6', 'Sus clases son muy interesantes y divertidas', '5', '0'),
('1', '2', '7', 'Es un profesor muy bueno', '4', '0'),
('1', '7', '8', 'Es uno de los mejores profesores que he tenido', '5', '0'),
('1', '8', '9', 'Un gran maestro, siempre aprendo mucho en sus clases', '4', '0'),
('1', '9', '10', 'Gandalf es un mago muy sabio y poderoso', '5', '0'),
('1', '10', '11', 'Yoda es un maestro Jedi inigualable', '5', '0'),
('1', '11', '12', 'Lara Croft es una experta en artefactos antiguos', '4', '0'),
('1', '7', '13', 'Aprendí mucho sobre programación en su clase', '4', '0'),
('1', '8', '14', 'Las meditaciones que nos enseña son muy beneficiosas para la concentración', '5', '0'),
( '1', '1', '1', 'El profesor Walter White es muy exigente pero se aprende mucho con él', '4', '0'),
( '1', '1', '2', 'La asignatura de Base de Datos con Walter White es muy aburrida', '2', '0'),
( '1', '2', '3', 'El profesor Bacterio es muy amable y siempre está dispuesto a ayudar', '5', '0'),
('1', '2', '7', 'El profesor Bacterio tiene un acento un poco difícil de entender', '3', '0'),
('1', '3', '4', 'El profesor Severus Snape es un genio en Defensa Contra las Artes Oscuras', '5', '0'),
('1', '3', '4', 'Pero su forma de enseñar es bastante intimidante', '3', '0'),
('1', '4', '5', 'El profesor Albus Dumbledore es un sabio y un líder inspirador', '5', '0'),
('1', '4', '5', 'Pero su asignatura de Transformaciones es muy difícil de entender', '3', '0'),
('1', '5', '6', 'La profesora Minerva McGonagall es muy estricta pero justa', '4', '0'),
('1', '5', '6', 'A veces su asignatura de Cuidado de Criaturas Mágicas se hace un poco monótona', '3', '0'),
('1', '6', '7', 'El profesor Rubeus Hagrid es muy amable pero poco organizado en sus clases', '3', '0'),
('1', '6', '7', 'A veces se pierde hablando sobre criaturas que no tienen nada que ver con la asignatura', '2', '0'),
('1', '1', '1', 'El profesor Walter White no es muy simpático y eso dificulta el aprendizaje', '2', '0'),
('1', '2', '2', 'La asignatura de Medicina con el profesor Bacterio es muy exigente y estresante', '3', '0'),
('1', '3', '3', 'El profesor Severus Snape no es muy accesible y cuesta hacerle preguntas', '2', '0'),
('1', '4', '4', 'El profesor Albus Dumbledore a veces parece no tener en cuenta las dificultades de los alumnos', '3', '0'),
('1', '5', '5', 'La profesora Minerva McGonagall se centra demasiado en la teoría y se hace pesada', '2', '0'),
('1', '6', '6', 'El profesor Rubeus Hagrid es un poco lento explicando y se hace difícil seguir sus clases', '2', '0'),
('1', '3', '3', 'El profesor Severus Snape es demasiado exigente en sus calificaciones', '3', '0'),
('1', '5', '5', 'La asignatura de Transformaciones con Albus Dumbledore es muy difícil y poco práctica', '2', '0');



INSERT INTO `Imagenes` (`id`, `ruta`, `nombre`, `tipo`) VALUES
(1, 'usuarios/defaultUser.png', 'defaultUser.png', 'image/png'),
(2, 'profesores/defaultProf.png', 'defaultProf.png', 'image/png'),
(3, 'centros/defaultFacultad.png', 'defaultFacultad.png', 'image/png'),
(4, 'centros/defaultUniversidad.png', 'defaultUniversidad.png', 'image/png');

INSERT INTO `Usuarios` (`id`, `nombreUsuario`, `email`, `password`, `idImagen`) VALUES
(1, 'default', 'admin@escoli.es', '$2y$10$M44I/PdKB3F7vv4qXxRpR.R5dgye5xLtZUJMpB0tb9X9DT7Ej5kw.',1);

INSERT INTO `Usuarios` (`id`, `nombreUsuario`, `email`, `password`, `idImagen`) VALUES
(2, 'default', 'escoli@escoli.es', '$2y$10$3gUCohJ1fqgHP0kdhiOOkOZPaaKoMuQuV2RYGw4EWt5zty8KEiJLS', 1);

UPDATE `RolesUsuario` SET `rol` = 'admin' WHERE `RolesUsuario`.`idUsuario` = 1;