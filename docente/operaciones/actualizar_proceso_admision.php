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
	$tipo = $_POST['tipo'];
	$periodo = $_POST['periodo'];
	$inicio = $_POST['inicio'];
	$fin = $_POST['fin'];
	$inicio_ins = $_POST['inicio_ins'];
	$fin_ins = $_POST['fin_ins'];
	$inicio_ext = $_POST['inicio_ext'];
	$fin_ext = $_POST['fin_ext'];

	$insertar = "UPDATE proceso_admision SET Tipo='$tipo',Periodo='$periodo',Fecha_Inicio= '$inicio',Fecha_Fin= '$fin',
	Inicio_Inscripcion= '$inicio_ins',Fin_Inscripcion= '$fin_ins',Inicio_Extemporaneo= '$inicio_ext',Fin_Extemporaneo= '$fin_ext' WHERE Id = $id";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                alert('Actualización Existosa');
                window.location= '../procesos_admision.php'
    			</script>";
	}else{
		echo "<script>
			alert('Error al actualizar');
			window.history.back();
				</script>
			";
	};

mysqli_close($conexion);

}