create table concepto_ingreso(
    id INT PRIMARY KEY AUTO_INCREMENT,
    concepto varchar(50) not null,
    monto decimal(6,2) not null,
    codigo varchar(20) not null,
    unidad varchar(30)
);

create table comprobantes_pago(
    id INT PRIMARY KEY AUTO_INCREMENT,
    comprobante varchar(50) not null,
    codigo varchar(4) not null unique,
    longitud int not null
);

create table ingresos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    dni char(8) not null,
    usuario varchar(30) not null,
    tipo_comprobante varchar(100) not null,
    codigo varchar(20) not null,
    fecha_pago datetime not null,
    monto_total decimal(10,2) not null,
    estado varchar(30) not null,
    ruta_archivo varchar(100) not null,
    responsable varchar(100) not null,
    metodo_pago varchar(100) not null
);


create table detalle_ingresos
(
    id_ingreso  INT NOT NULL,
    id_concepto INT NOT NULL,
    cantidad INT NOT NULL,
    subtotal numeric(10,2) not null,
    CONSTRAINT FOREIGN KEY (id_concepto) REFERENCES concepto_ingreso(id),
    CONSTRAINT FOREIGN KEY (id_ingreso) REFERENCES ingresos(id));

create table egresos(
    id INT PRIMARY KEY AUTO_INCREMENT,
    empresa varchar(100) not null,
    ruc varchar(100) not null,
    concepto varchar(100) not null,
    tipo_comprobante varchar(50) not null,
    comprobante varchar(20) not null unique,
    fecha_pago date not null,
    fecha_registro datetime not null,
    monto_total decimal(10,2) not null,
    estado varchar(30) not null,
    responsable varchar(100) not null
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