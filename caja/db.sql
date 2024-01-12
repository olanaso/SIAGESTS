create table concepto_egreso(
    id INT PRIMARY KEY AUTO_INCREMENT,
    concepto varchar(50) not null,
    unidad varchar(50)
);

create table concepto_ingreso(
    id INT PRIMARY KEY AUTO_INCREMENT,
    concepto varchar(50) not null,
    codigo varchar(20) not null unique,
    monto decimal(6,2) not null,
    unidad varchar(50)
);

create table ingresos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    dni char(8) not null,
    estudiante varchar(30) not null,
    concepto varchar(100) not null,
    comprobante varchar(20) not null,
    fecha_pago datetime not null,
    monto_total decimal not null,
    estado_pago varchar(20) not null
);

create table egresos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    concepto varchar(100) not null,
    comprobante varchar(20) not null,
    fecha_pago datetime not null,
    monto_total decimal(6,2) not null,
    estado_pago varchar(20) not null,
    descripcion varchar(200)
);

create table egresos_anulados(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_egreso INT not null,
    responsable varchar(100) not null,
    fecha_anulacion datetime not null,
    motivo varchar(200) not null,
    CONSTRAINT FOREIGN KEY (id_egreso) REFERENCES egresos(id)
);

create table ingresos_anulados(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ingreso INT not null,
    responsable varchar(100) not null,
    fecha_anulacion datetime not null,
    motivo varchar(200) not null,
    CONSTRAINT FOREIGN KEY (id_ingreso) REFERENCES ingresos(id)
);
