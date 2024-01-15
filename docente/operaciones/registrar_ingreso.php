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
	$dni_estudiante = $_POST['dni'];

	$res_estudiante = buscarEstudianteByDni($conexion,$dni_estudiante);
	$count_estudiante = mysqli_num_rows($res_estudiante);

	$res_ingreso = buscarIngresosByCodigo($conexion, $codigo);
	$count = mysqli_num_rows($res_ingreso);

	if($count != 0 ){
		echo "<script>
				  alert('Este codigo de comprobante ya fue utilizado con anterioridad!.');
				  window.history.back();
			  </script>";
	}
	elseif($count_estudiante == 0 ){
		echo "<script>
				  alert('El estudiante no esta registrado!.');
				  window.history.back();
			  </script>";
	}
	else{

		$res_ci = buscarConceptoIngresosById($conexion, $id_concepto);
		$con_ingreso = mysqli_fetch_array($res_ci);
		$estudiante = mysqli_fetch_array($res_estudiante);
		$concepto = $con_ingreso['concepto'];
		$monto = $con_ingreso['monto'];

		$estudiante_nombre = $estudiante['apellidos_nombres'];

		$insertar = "INSERT INTO `ingresos`(`dni`, `estudiante`,`concepto`, `comprobante`, `fecha_pago`, `monto_total`, `estado_pago`) VALUES ('$dni_estudiante','$estudiante_nombre','$concepto','$codigo', CURRENT_TIMESTAMP() ,'$monto', 'PAGADO')";
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