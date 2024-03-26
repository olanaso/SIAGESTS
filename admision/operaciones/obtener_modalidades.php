<?php
include '../../include/conexion.php';
include "../../include/busquedas.php";
include "../../include/funciones.php";


$proceso = $_POST['id_proceso'];

	$ejec_cons = buscarModalidadesCuadroVacantes($conexion, $proceso);
	$contador = mysqli_num_rows($ejec_cons);
	$cadena = '<option value="" disabled selected>Seleccionar</option>';

	if($contador > 0){
		while ($modalidad=mysqli_fetch_array($ejec_cons)) {
			$cadena=$cadena.'<option value="'.$modalidad['Id'].'">'.$modalidad['Descripcion'].'</option>';
		}
		echo $cadena;
	}else{
		$res_modalidad_ordinaria = buscarModalidadOrdinario($conexion);
		$modalidad=mysqli_fetch_array($res_modalidad_ordinaria);
		$cadena=$cadena.'<option value="'.$modalidad['Id'].'">'.$modalidad['Descripcion'].'</option>';
		echo $cadena;
	}

?>