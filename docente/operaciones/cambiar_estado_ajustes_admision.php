<?php
include "../../include/conexion.php";
include "../../include/busquedas.php";
include "../../caja/consultas.php";
include "../../include/funciones.php";
include "../../empresa/include/consultas.php";
include("../include/verificar_sesion_secretaria.php");

if (!verificar_sesion($conexion)) {
	echo "<script>
				  alert('Error Usted no cuenta con permiso para acceder a esta página');
				  window.location.replace('../../login/');
			  </script>";
  }else {
    $id = $_POST["id"];
    $estado = $_POST["estado"];

    // Consulta para insertar los datos en la base de datos
    $sql = "UPDATE `ajustes_admision` SET `estado`= $estado WHERE id = $id";
    $res = mysqli_query($conexion, $sql);
    $conexion->close();
}
?>
