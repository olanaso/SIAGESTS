CREATE TABLE `soporte_ticket` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `fecha_registro` datetime NOT NULL,
    `descripcion` text NOT NULL,
    `enlace` varchar(255) DEFAULT NULL,
    `usuario` int(11) NOT NULL,
    `instituto` varchar(255) NOT NULL,
    `estado` varchar(255) NOT NULL,
    `comentario` text NOT NULL,
    `imagen1` varchar(200) DEFAULT NULL,
    `codigo` varchar(10) DEFAULT NULL,
    `imagen2` varchar(200) DEFAULT NULL,
    `imagen3` varchar(200) DEFAULT NULL,
    `imagen4` varchar(200) DEFAULT NULL,
    `imagen5` varchar(200) DEFAULT NULL,
    PRIMARY KEY (`id`)
);

ALTER TABLE
    `sistema`
ADD
    COLUMN `email_soporte` VARCHAR(255) NOT NULL;

CREATE TABLE anuncio(
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_activa_inicio DATE NOT NULL,
    fecha_activa_fin DATE NOT NULL,
    imagen VARCHAR(255) NULL,
    enlace VARCHAR(255) NULL,
    usuarios VARCHAR(255) NOT NULL,
    tipo VARCHAR(255) NOT NULL
);

ALTER TABLE
    `notas_antiguo`
ADD
    COLUMN `id_unidad_didactica` INT(11) NOT NULL;

CREATE TABLE `actividades_egresado`(
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_estudiante` INT(11) NOT NULL,
    `tipo` VARCHAR(100) NOT NULL,
    `nombre_cargo` VARCHAR(255) NOT NULL,
    `nombre_organizacion` VARCHAR(255) NOT NULL,
    `lugar` VARCHAR(255) NOT NULL,
    `descripcion` TEXT NOT NULL,
    `fecha_inicio` DATE NOT NULL,
    `fecha_fin` DATE NULL,
    CONSTRAINT `actividades_egresado_id_estudiante_foreign` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante`(`id`)
);

CREATE TABLE `documento_docente`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_docente` BIGINT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `archivo` VARCHAR(255) NOT NULL,
    `fecha_registro` DATETIME default current_timestamp()
);

ALTER TABLE
    `documento_docente`
ADD
    INDEX `documento_docente_id_docente_index`(`id_docente`);

ALTER TABLE
    `docente`
ADD
    COLUMN `foto` VARCHAR(200) NULL DEFAULT '../img/no-image.jpeg';

CREATE TABLE `horario_programacion`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_programacion_unidad` INT,
    `dia` VARCHAR(20) NOT NULL,
    `hora_inicio` TIME NOT NULL,
    `hora_fin` TIME NOT NULL,
    `fecha_inicial` DATE NOT NULL,
    CONSTRAINT `horario_programacion` FOREIGN KEY (`id_programacion_unidad`) REFERENCES `programacion_unidad_didactica`(`id`)
);

CREATE TABLE `asistencia_docente`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_horario_programacion` INT NOT NULL,
    `fecha_asistencia` date NOT NULL,
    `estado` VARCHAR(100) DEFAULT 'PENDIENTE',
    `fecha_registro` datetime NULL,
    CONSTRAINT `asistencia_docente_horario` FOREIGN KEY (`id_horario_programacion`) REFERENCES `horario_programacion`(`id`)
);

ALTER TABLE `programacion_unidad_didactica` 
ADD COLUMN `activar_asistencia` CHAR(2) NOT NULL DEFAULT 'SI' AFTER `sugerencias`;

CREATE TABLE `informacion_socioeconomica`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `familiares` TEXT NOT NULL,
    `cant_familiares` INT NOT NULL,
    `problema_hogar` TEXT NOT NULL,
    `familiar_confianza` TEXT NOT NULL,
    `trabajo_familiares` TEXT NOT NULL,
    `rango_ingreso` TEXT NOT NULL,
    `ingreso_prio` TEXT NOT NULL,
    `tipo_trabajo` TEXT NOT NULL,
    `gasto_trabajo` TEXT NOT NULL,
    `vivienda` TEXT NOT NULL,
    `tipo_vivienda` TEXT NOT NULL,
    `servicios` TEXT NOT NULL,
    `equipos_electronicos` TEXT NOT NULL,
    `vehiculos` TEXT NOT NULL,
    `minutos_casa_insti` TEXT NOT NULL,
    `dificultad_fisica` TEXT NOT NULL,
    `seguro_salud` TEXT NOT NULL,
    `enfermedad` TEXT NOT NULL,
    `id_estudiante` INT,
    CONSTRAINT `info_socio_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante`(`id`)
);

CREATE TABLE preguntas_frecuentes (
    id SERIAL PRIMARY KEY,
    pregunta TEXT NOT NULL,
    respuesta TEXT NOT NULL,
    roles VARCHAR(255) NOT NULL
);

CREATE TABLE `oferta_laboral_propia` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `empresa` varchar(255) DEFAULT NULL,
 `titulo` varchar(255) DEFAULT NULL,
 `ubicacion` varchar(255) DEFAULT NULL,
 `funciones` text DEFAULT NULL,
 `requisitos` text DEFAULT NULL,
 `condiciones` text DEFAULT NULL,
 `beneficios` text DEFAULT NULL,
 `salario` decimal(10,2) DEFAULT NULL,
 `vacantes` int(11) DEFAULT NULL,
 `modalidad` varchar(50) DEFAULT NULL,
 `turno` varchar(50) DEFAULT NULL,
 `fecha_inicio` date DEFAULT NULL,
 `fecha_fin` date DEFAULT NULL,
 `link_postulacion` varchar(255) DEFAULT NULL,
 `estado` varchar(50) DEFAULT NULL,
 `fecha_estado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
 PRIMARY KEY (`id`)
);

ALTER TABLE `sistema` 
ADD COLUMN `req_bolsa_laboral` VARCHAR(250) NOT NULL DEFAULT 'about:blank' AFTER `email_soporte`,
ADD COLUMN `req_admision` VARCHAR(250) NOT NULL DEFAULT 'about:blank' AFTER `req_bolsa_laboral`;

ALTER TABLE `docente` 
ADD COLUMN `profesion` VARCHAR(150) NULL AFTER `nivel_educacion`,
ADD COLUMN `hoja_vida` VARCHAR(250) NULL AFTER `profesion`;

DROP TABLE `documento_docente`;

ALTER TABLE `oferta_laboral_propia` 
ADD COLUMN `celular_contacto` VARCHAR(11) NULL AFTER `empresa`;