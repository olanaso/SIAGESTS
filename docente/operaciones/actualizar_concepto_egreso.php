<?php
include "../../include/conexion.php";
include "../../include/busquedas.php";
include "../../include/funciones.php";
include("../include/verificar_sesion_secretaria.php");
if (!verificar_sesion($conexion)) {
	echo "<script>
				  alert('Error Usted no cuenta con permiso para acceder a esta página');
				  window.location.replace('../login/');
			  </script>";
  }else {


  
$id = $_POST['id'];
$concepto = $_POST['concepto'];
$unidad = $_POST['unidad'];

	$insertar = "UPDATE concepto_egreso SET concepto='$concepto', unidad= '$unidad' WHERE id = $id";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                alert('Actualización Existosa');
                window.location= '../concepto_egresos.php'
    			</script>";
	}else{
		echo "<script>
			alert('Error al registrar');
			window.history.back();
				</script>
			";
	};

mysqli_close($conexion);

}