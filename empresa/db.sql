create table empresa(
    id INT PRIMARY KEY AUTO_INCREMENT,
    razon_social varchar(100) not null,
    ruc char(11) not null unique,
    correo_institucional varchar(100) not null,
    ubicacion varchar(30) not null,
    ruta_logo varchar(200),
    contacto varchar(200) not null,
    celular_telefono varchar(20) not null,
    estado varchar(50) not null,
    motivo_estado text not null,
    usuario varchar(50) unique,
    password varchar(200),
    reset_password int,
    token_password varchar(100)
);

create table oferta_laboral(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_empresa INT not null,
    titulo varchar(200) not null,
    ubicacion varchar(30) not null,
    funciones text not null,
    requisitos text not null,
    condiciones text not null,
    beneficios text not null,
    salario decimal(8,2),
    vacantes int not null,
    modalidad varchar(100),
    turno varchar(100),
    fecha_inicio date not null,
    fecha_fin date not null,
    link_postulacion varchar(200),
    url_base varchar(200),
    estado varchar(50),
    fecha_estado datetime,
    CONSTRAINT FOREIGN KEY (id_empresa) REFERENCES empresa(id)
);

create table oferta_laboral_propia(
    id INT PRIMARY KEY AUTO_INCREMENT,
    empresa varchar(200) not null,
    titulo varchar(200) not null,
    ubicacion varchar(30) not null,
    funciones text not null,
    requisitos text not null,
    condiciones text not null,
    beneficios text not null,
    salario decimal(8,2),
    vacantes int not null,
    horario varchar(100),
    turno varchar(100),
    fecha_inicio date not null,
    fecha_fin date not null,
    link_postulacion varchar(200),
    url_base varchar(200),
    estado varchar(50),
    fecha_estado datetime,
);

create table oferta_documentos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ol int not null,
    tipo_documento varchar(100) not null,
    nombre_documento varchar(200) not null,
    url_documento varchar(200) not null,
    propietario varchar(100),
    CONSTRAINT FOREIGN KEY (id_ol) REFERENCES oferta_laboral(id)
);

create table oferta_postulantes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ol int not null,
    id_es int not null,
    fecha_registro datetime not null,
    url_documento varchar(200) not null,
    CONSTRAINT FOREIGN KEY (id_ol) REFERENCES oferta_laboral(id),
    CONSTRAINT FOREIGN KEY (id_es) REFERENCES estudiante(id)
);

create table oferta_programas(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ol int not null,
    id_pr int not null,
    propietario varchar(100),
    CONSTRAINT FOREIGN KEY (id_ol) REFERENCES oferta_laboral(id),
    CONSTRAINT FOREIGN KEY (id_pr) REFERENCES programa_estudios(id)
);

create table sesion_empresa(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_empresa int not null,
    fecha_hora_inicio datetime not null,
    fecha_hora_fin datetime not null,
    token varchar(200) not null
);


