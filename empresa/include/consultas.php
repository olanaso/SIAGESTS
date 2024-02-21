<?php
// -------------------  FUNCIONES BUSCAR ------------------------------
function buscarSolicitudEmpresa($conexion){
	$sql = "SELECT * FROM empresa WHERE estado = 'Por confirmar'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarEmpresas($conexion){
	$sql = "SELECT * FROM empresa WHERE estado = 'Activo'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarEmpresaById($conexion, $id){
	$sql = "SELECT * FROM empresa WHERE id = '$id'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboral($conexion){
	$sql = "SELECT * FROM oferta_laboral WHERE estado != 'ARCHIVADO'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralAdministrador($conexion){
	$sql = "SELECT id, empresa, titulo, ubicacion, funciones, requisitos, condiciones, beneficios, salario, vacantes, fecha_inicio, fecha_fin, link_postulacion, estado, fecha_estado
	FROM oferta_laboral_propia WHERE estado != 'ARCHIVADO'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralEmpresa($conexion){
	$sql = "SELECT o.id, e.razon_social as empresa, e.ruc, e.contacto, e.correo_institucional as correo, e.celular_telefono as celular, o.titulo , o.ubicacion, o.funciones, o.requisitos, o.condiciones, o.beneficios, o.salario, o.vacantes, o.fecha_inicio, o.fecha_fin, o.link_postulacion, o.estado, o.fecha_estado
	FROM
		oferta_laboral o
	INNER JOIN
		empresa e ON e.id = o.id_empresa WHERE o.estado != 'ARCHIVADO'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralArchivada($conexion){
	$sql = "SELECT * FROM oferta_laboral WHERE estado = 'ARCHIVADO'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralById($conexion, $id){
	$sql = "SELECT * FROM oferta_laboral WHERE id = $id";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralEmpresaById($conexion, $id){
	$sql = "SELECT ol.*, e.razon_social as empresa
	FROM  oferta_laboral ol INNER JOIN empresa e ON 
		e.id = ol.id_empresa WHERE ol.id = $id";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarEmpresaByIdOferta($conexion, $id){
	$sql = "SELECT e.razon_social FROM oferta_laboral o INNER JOIN empresa e ON e.id = o.id_empresa  WHERE o.id = $id";
	$res = mysqli_query($conexion, $sql);
	$empresa = mysqli_fetch_array($res);
	$empresa = $empresa['razon_social'];
    return $empresa;
}

function buscarOfertaLaboralByIdIestp($conexion, $id){
	$sql = "SELECT * FROM oferta_laboral_propia WHERE id = $id";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralByIdEmpresa($conexion, $id_empresa){
	$sql = "SELECT * FROM oferta_laboral WHERE id_empresa = $id_empresa AND estado != 'ARCHIVADO'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralByEmpresaArchivado($conexion, $id_empresa){
	$sql = "SELECT * FROM oferta_laboral WHERE id_empresa = $id_empresa AND estado = 'ARCHIVADO'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarEmpresaUsuario($conexion, $usuario){
	$sql = "SELECT * FROM empresa WHERE usuario = '$usuario'";
	$res = mysqli_query($conexion, $sql);
	return $res;
}

function buscarProgramasByIdOferta($conexion, $id_ol){
	$sql = "SELECT pe.nombre FROM oferta_programas op INNER JOIN programa_estudios pe ON op.id_pr = pe.id WHERE op.id_ol = $id_ol AND op.propietario != 'iestp'";
	$res = mysqli_query($conexion, $sql);
	return $res;
}

function buscarProgramasByIdOfertaIestp($conexion, $id_ol){
	$sql = "SELECT pe.nombre FROM oferta_programas op INNER JOIN programa_estudios pe ON op.id_pr = pe.id WHERE op.id_ol = $id_ol AND op.propietario = 'iestp'";
	$res = mysqli_query($conexion, $sql);
	return $res;
}

function cantidadDocumentos($conexion){
	$sql = "SELECT COUNT(*) as total FROM `oferta_documentos`";
	$res = mysqli_query($conexion, $sql);
	$res = mysqli_fetch_array($res);
	return $res['total'];
}

function buscarProgramasByOferta($conexion, $id_ol){
	$sql = "SELECT id_pr FROM `oferta_programas` WHERE `id_ol` = $id_ol AND propietario != 'iestp'";
	$res = mysqli_query($conexion, $sql);
	$programasDirigidosSeleccionados = array(); // Inicializamos la lista de números
	while ($row = mysqli_fetch_array($res)) {
    	$programasDirigidosSeleccionados[] = $row['id_pr']; // Agregamos el id_pr a la lista
	}
	return $programasDirigidosSeleccionados;
}

function buscarProgramasByOfertaIestp($conexion, $id_ol){
	$sql = "SELECT id_pr FROM `oferta_programas` WHERE `id_ol` = $id_ol AND propietario = 'iestp'";
	$res = mysqli_query($conexion, $sql);
	$programasDirigidosSeleccionados = array(); // Inicializamos la lista de números
	while ($row = mysqli_fetch_array($res)) {
    	$programasDirigidosSeleccionados[] = $row['id_pr']; // Agregamos el id_pr a la lista
	}
	return $programasDirigidosSeleccionados;
}

function buscarDocumentosByIdOferta($conexion, $id_oferta){
	$sql = "SELECT * FROM oferta_documentos WHERE id_ol = $id_oferta AND propietario != 'iestp'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarDocumentosByIdOfertaIestp($conexion, $id_oferta){
	$sql = "SELECT * FROM oferta_documentos WHERE id_ol = $id_oferta AND propietario = 'iestp'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarPostulantesByIdOferta($conexion, $id_ol){
	$sql = "SELECT op.url_documento, es.dni, es.apellidos_nombres, es.telefono, es.correo FROM oferta_postulantes op INNER JOIN estudiante es ON op.id_es = es.id WHERE op.id_ol = $id_ol AND propietario != 'iestp'";
	$res = mysqli_query($conexion, $sql);
	return $res;
}

function buscarPostulantesByIdOfertaIestp($conexion, $id_ol){
	$sql = "SELECT op.url_documento, es.dni, es.apellidos_nombres, es.telefono, es.correo FROM oferta_postulantes op INNER JOIN estudiante es ON op.id_es = es.id WHERE op.id_ol = $id_ol";
	$res = mysqli_query($conexion, $sql);
	return $res;
}

function buscarOfertasDisponiblesByPrograma($conexion, $id_programa){
	$sql = "SELECT ol.id,ol.fecha_inicio,ol.fecha_fin, ol.titulo,ol.ubicacion,ol.vacantes,ol.turno,ol.salario,ol.modalidad,ol.estado, e.razon_social as empresa, 'empresa' as propietario 
	FROM  oferta_laboral ol INNER JOIN `oferta_programas` op ON op.id_ol = ol.id INNER JOIN empresa e ON 
		e.id = ol.id_empresa WHERE op.id_pr = $id_programa AND ol.estado != 'ARCHIVADO' and op.propietario != 'iestp'
		UNION
		SELECT o.id,o.fecha_inicio, o.fecha_fin, o.titulo, o.ubicacion, o.vacantes, o.turno, o.salario, o.modalidad, o.estado, o.empresa, 'iestp' as propietario FROM oferta_laboral_propia o INNER JOIN `oferta_programas` op2 ON op2.id_ol = o.id where op2.id_pr = $id_programa and  o.estado != 'ARCHIVADO'";
	$res = mysqli_query($conexion, $sql);
	return $res;
}

function buscarOfertasEstudiante($conexion, $id_estudiante){
	$sql = "SELECT ol.id,ol.fecha_inicio,ol.fecha_fin, ol.titulo,ol.ubicacion,ol.vacantes,ol.turno,ol.salario,ol.modalidad,ol.estado, em.razon_social as empresa, 'empresa' as propietario  FROM  oferta_laboral ol INNER JOIN `oferta_postulantes` op ON op.id_ol = ol.id INNER JOIN `empresa` em ON ol.id_empresa = em.id INNER JOIN estudiante e ON 
	e.id = op.id_es  WHERE op.id_es = $id_estudiante GROUP BY ol.id";
	$res = mysqli_query($conexion, $sql);
	return $res;
}

function buscarTotalOfertasArchivadas($conexion){
	$sql = "SELECT ol.id,ol.fecha_inicio,ol.fecha_fin, ol.titulo,ol.ubicacion,ol.vacantes,ol.turno,ol.modalidad,ol.estado, e.razon_social as empresa, 'empresa' as propietario FROM oferta_laboral ol INNER JOIN empresa e ON e.id = ol.id_empresa WHERE ol.estado = 'ARCHIVADO' UNION SELECT o.id,o.fecha_inicio, o.fecha_fin, o.titulo, o.ubicacion, o.vacantes, o.turno, o.modalidad, o.estado, o.empresa, 'iestp' as propietario FROM oferta_laboral_propia o where o.estado = 'ARCHIVADO';";
	$res = mysqli_query($conexion, $sql);
	return $res;
}


/*       SESIONES EMPRESA       */

function buscarSesionEmpresaLoginById($conexion, $id){
	$sql = "SELECT * FROM sesion_empresa WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}

//FUNCIONES DE TIEMPO Y ESTADO

function determinarEstado($fechaInicio, $fechaFin) {
    $fechaActual = date('Y-m-d'); // Fecha actual del equipo

	$fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fechaInicio);
    $fechaFinObj = DateTime::createFromFormat('Y-m-d', $fechaFin);
    $fechaActualObj = new DateTime($fechaActual);

	$intervalo = $fechaFinObj->diff($fechaActualObj);
	$diasRestantes = $intervalo->days;

    if ($fechaActualObj < $fechaInicioObj) {
        return "Por comenzar";
    } elseif ($fechaActualObj >= $fechaInicioObj && $fechaActualObj <= $fechaFinObj) {
        return "En proceso";
    } elseif ($fechaActualObj > $fechaFinObj) {
        return "Finalizado";
    }
}

?>