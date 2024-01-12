<?php
// -------------------  FUNCIONES BUSCAR ------------------------------
function buscarConceptoIngresos($conexion){
	$sql = "SELECT * FROM concepto_ingreso";
	return mysqli_query($conexion, $sql);
}

function buscarConceptoEgresos($conexion){
	$sql = "SELECT * FROM concepto_egreso";
	return mysqli_query($conexion, $sql);
}

function buscarConceptoEgresosById($conexion, $id_egreso){
	$sql = "SELECT * FROM concepto_egreso WHERE id = '$id_egreso'";
	return mysqli_query($conexion, $sql);
}

function buscarIngresos($conexion){
	$sql = "SELECT * FROM ingresos";
	return mysqli_query($conexion, $sql);
}

function buscarIngresosByCodigo($conexion, $codigo){
	$sql = "SELECT * FROM ingresos WHERE comprobante = '$codigo'";
	return mysqli_query($conexion, $sql);
}

function buscarEgresos($conexion){
	$sql = "SELECT * FROM egresos";
	return mysqli_query($conexion, $sql);
}

function buscarEgresosByCodigo($conexion, $codigo){
	$sql = "SELECT * FROM egresos WHERE comprobante = '$codigo'";
	return mysqli_query($conexion, $sql);
}

function buscarIngresosAnulados($conexion){
	$sql = "SELECT estudiante, concepto, comprobante, monto_total, responsable, motivo, fecha_anulacion FROM ingresos i INNER JOIN ingresos_anulados ia ON i.id = ia.id_ingreso";
	return mysqli_query($conexion, $sql);
}

function buscarEgresosAnulados($conexion){
	$sql = "SELECT concepto, comprobante, monto_total, responsable, motivo, fecha_anulacion FROM egresos e INNER JOIN egresos_anulados ea ON e.id = ea.id_egreso";
	return mysqli_query($conexion, $sql);
}

?>