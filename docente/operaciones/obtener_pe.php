<?php
include '../../include/conexion.php';
include "../../include/busquedas.php";
include "../../include/funciones.php";


$id_est = $_POST['id'];

	$ejec_cons = buscarCarrerasById($conexion, $id_est);

		$cadena = '<option></option>';
		$id_programa = 0;
		while ($mostrar=mysqli_fetch_array($ejec_cons)) {
		    $id_programa = intval($mostrar['id']);
			$cadena=$cadena.'<option value='.$mostrar['id'].' >'. $mostrar['nombre'].' - '.$mostrar['plan_estudio'].'</option>';
		}
		if($id_programa == 5){
		    $ejec_cons = buscarCarrerasById($conexion, 4);
		    while ($mostrar=mysqli_fetch_array($ejec_cons)) {
    		    $id_programa = $mostrar['id'];
    			$cadena=$cadena.'<option value='.$mostrar['id'].' selected >'. $mostrar['nombre'].' - '.$mostrar['plan_estudio'].'</option>';
    		}
		}
		
		if($id_programa == 3){
		    $ejec_cons = buscarCarrerasById($conexion, 2);
		    while ($mostrar=mysqli_fetch_array($ejec_cons)) {
    		    $id_programa = $mostrar['id'];
    			$cadena=$cadena.'<option value='.$mostrar['id'].' selected >'. $mostrar['nombre'].' - '.$mostrar['plan_estudio'].'</option>';
    		}
		}
		
		echo $cadena;

?>