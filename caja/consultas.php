<?php
// -------------------  FUNCIONES BUSCAR ------------------------------
function buscarConceptoIngresos($conexion){
	$sql = "SELECT * FROM concepto_ingreso";
	return mysqli_query($conexion, $sql);
}

function buscarConceptoIngresosById($conexion, $id_ingreso){
	$sql = "SELECT * FROM concepto_ingreso WHERE id = '$id_ingreso'";
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
	$sql = "SELECT * FROM ingresos WHERE estado_pago = 'PAGADO' ORDER BY fecha_pago DESC";
	return mysqli_query($conexion, $sql);
}

function buscarConceptoIngresosBoleta($conexion){
	$sql = "SELECT * FROM concepto_ingreso WHERE concepto = 'BOLETA DE NOTA'";
	return mysqli_query($conexion, $sql);
}

function buscarConceptoIngresosCertificado($conexion){
	$sql = "SELECT * FROM concepto_ingreso WHERE concepto = 'CERTIFICADO DE ESTUDIOS'";
	return mysqli_query($conexion, $sql);
}

function buscarIngresosByCodigo($conexion, $codigo){
	$sql = "SELECT * FROM ingresos WHERE comprobante = '$codigo'";
	return mysqli_query($conexion, $sql);
}

function buscarEgresos($conexion){
	$sql = "SELECT * FROM egresos WHERE estado_pago = 'PAGADO' ORDER BY fecha_pago DESC";
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