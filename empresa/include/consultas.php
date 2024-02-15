<?php
// -------------------  FUNCIONES BUSCAR ------------------------------
function buscarEmpresa($conexion){
	$sql = "SELECT * FROM empresa";
	$res = mysqli_query($conexion, $sql);
    $res = mysqli_fetch_array($res);
    return $res;
}

function buscarEmpresaById($conexion, $id){
	$sql = "SELECT * FROM empresa WHERE id = '$id'";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboral($conexion){
	$sql = "SELECT * FROM oferta_laboral";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarOfertaLaboralById($conexion, $id){
	$sql = "SELECT * FROM oferta_laboral WHERE id = $id";
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
	$sql = "SELECT pe.nombre FROM oferta_programas op INNER JOIN programa_estudios pe ON op.id_pr = pe.id WHERE op.id_ol = $id_ol";
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
	$sql = "SELECT id_pr FROM `oferta_programas` WHERE `id_ol` = $id_ol";
	$res = mysqli_query($conexion, $sql);
	$programasDirigidosSeleccionados = array(); // Inicializamos la lista de números
	while ($row = mysqli_fetch_array($res)) {
    	$programasDirigidosSeleccionados[] = $row['id_pr']; // Agregamos el id_pr a la lista
	}
	return $programasDirigidosSeleccionados;
}

function buscarDocumentosByIdOferta($conexion, $id_oferta){
	$sql = "SELECT * FROM oferta_documentos WHERE id_ol = $id_oferta";
	$res = mysqli_query($conexion, $sql);
    return $res;
}

function buscarPostulantesByIdOferta($conexion, $id_ol){
	$sql = "SELECT op.url_documento, es.dni, es.apellidos_nombres, es.telefono, es.correo FROM oferta_postulantes op INNER JOIN estudiante es ON op.id_es = es.id WHERE op.id_ol = $id_ol";
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