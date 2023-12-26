CREATE TABLE notas_antiguo(
    id int primary key auto_increment,
    dni char(8) not null,
    nombre_programa varchar(100) not null,
    unidad_didactica varchar(100) not null,
    cantidad_creditos float(2,1) not null,
    calificacion int not null,
    semestre_academico varchar(10) not null,
    periodo varchar(10) not null
);

CREATE TABLE estudiante_antiguo(
    id int primary key auto_increment,
    dni char(8) not null,
    apellidos_nombres varchar(200) not null,
    genero char(1) not null,
    fecha_nacimiento date not null,
    direccion varchar(150),
    correo varchar(100) not null,
    telefono varchar(10) not null,
    anio_ingreso char(4) not null,
    seccion char(1),
    turno varchar(20),
    discapacidad char(2),
    programa_estudio varchar(100) not null,
    anio_plan_estudio char(4)
);

CREATE TABLE certificado_estudios(
    id int primary key auto_increment,
    codigo varchar(100) unique not null,
    nombre_usuario varchar(100) not null,
    dni_estudiante char(8) not null,
    apellidos_nombres varchar(100) not null,
    programa_estudio varchar(100) not null,
    ruta_documento varchar(100) not null,
    num_comprobante varchar(20) unique not null,
    fecha_emision timestamp not null
);

CREATE TABLE boleta_notas(
    id int primary key auto_increment,
    codigo varchar(100) unique not null,
    nombre_usuario varchar(100) not null,
    dni_estudiante char(8) not null,
    apellidos_nombres varchar(100) not null,
    programa_estudio varchar(100) not null,
    periodo_acad varchar(10) not null,
    ruta_documento varchar(100) not null,
    num_comprobante varchar(20) unique not null,
    fecha_emision timestamp not null
);


CREATE VIEW promedio_criterio_evaluacion AS SELECT t1.id, t1.id_calificacion, t1.ponderado, t1.detalle, SUM(t2.ponderado * t2.calificacion/100) AS promedio
FROM evaluacion t1
INNER JOIN criterio_evaluacion t2 ON t1.id = t2.id_evaluacion
GROUP BY t1.id, t1.ponderado, t1.detalle;

CREATE VIEW promedio_evaluacion AS SELECT t1.id, t1.ponderado, t1.id_detalle_matricula, SUM(t2.ponderado * t2.promedio/100) AS promedio
FROM calificaciones t1
INNER JOIN promedio_criterio_evaluacion t2 ON t1.id = t2.id_calificacion
GROUP BY t1.id, t1.ponderado;

CREATE VIEW promedio_final AS SELECT t2.id_detalle_matricula, t1.id_programacion_ud, t1.id_matricula, SUM(t2.ponderado * t2.promedio/100) AS promedio
FROM detalle_matricula_unidad_didactica t1
INNER JOIN promedio_evaluacion t2 ON t1.id = t2.id_detalle_matricula
GROUP BY t2.id_detalle_matricula;


SELECT u.descripcion, u.creditos , CAST(ROUND(pf.promedio) AS SIGNED)  as promedio_final FROM estudiante e INNER JOIN matricula m ON e.id = m.id_estudiante
    INNER JOIN programa_estudios p ON m.id_programa_estudio = p.id INNER JOIN periodo_academico pa ON pa.id = m.id_periodo_acad
    INNER JOIN detalle_matricula_unidad_didactica dm ON dm.id_matricula = m.id INNER JOIN programacion_unidad_didactica pu ON
    pu.id_unidad_didactica = dm.id_programacion_ud INNER JOIN unidad_didactica u ON u.id = pu.id_unidad_didactica
    INNER JOIN promedio_final pf ON pf.id_detalle_matricula = dm.id WHERE e.dni = '47134927' AND pa.nombre = '2024-I'
;