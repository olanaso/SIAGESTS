<?php
include "../../include/conexion.php";
include "../../include/busquedas.php";
include "../../caja/consultas.php";
include "../../include/funciones.php";
include("../include/verificar_sesion_secretaria.php");
if (!verificar_sesion($conexion)) {
	echo "<script>
				  alert('Error Usted no cuenta con permiso para acceder a esta página');
				  window.location.replace('../login/');
			  </script>";
  }else {

	$id_concepto = $_POST['concepto'];
	$codigo = $_POST['codigo'];
	$descripcion = $_POST['descripcion'];
	$monto = floatval($_POST['monto']);

	$res_egreso = buscarEgresosByCodigo($conexion, $codigo);
	$count = mysqli_num_rows($res_egreso);

	if($count != 0 ){
		echo "<script>
				  alert('Este codigo de comprobante ya fue utilizado con anterioridad!.');
				  window.history.back();
			  </script>";
	}
	else{

		$res_ce = buscarConceptoEgresosById($conexion, $id_concepto);
		$con_egreso = mysqli_fetch_array($res_ce);
		$concepto = $con_egreso['concepto'];

		$insertar = "INSERT INTO `egresos`(`concepto`, `comprobante`, `fecha_pago`, `monto_total`, `estado_pago`, `descripcion`) VALUES ('$concepto','$codigo', CURRENT_TIMESTAMP() ,'$monto', 'PAGADO', '$descripcion')";
		$ejecutar_insetar = mysqli_query($conexion, $insertar);
		if ($ejecutar_insetar) {
				echo "<script>
					alert('Registro Existoso');
					window.location= '../movimientos.php'
					</script>";
		}else{
			echo "<script>
				alert('Error al registrar, por favor verifique sus datos');
				window.history.back();
					</script>
				";
		};
	}
	mysqli_close($conexion);

}