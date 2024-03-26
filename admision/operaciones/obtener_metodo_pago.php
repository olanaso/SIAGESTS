<?php
include '../../include/conexion.php';
include "../../include/busquedas.php";
include "../../include/funciones.php";


$id = $_POST['id_metodo'];


	$ejec_cons = buscarTodosMetodosPagoPorId($conexion, $id);

	while ($metodo = mysqli_fetch_array($ejec_cons)) {
		$banco = "";
		$cuenta = "";
		$cci = "";
		if($metodo['Banco'] !== "No requiere") $banco = ' - ' .$metodo['Banco'];
		if($metodo['Cuenta'] !== "No requiere") $cuenta = ' - '.$metodo['Cuenta'];
		if($metodo['CCI'] !== "No requiere") $cci = ' - '.$metodo['CCI'];
		$cadena= '
		<div class="custom-container">
		<div class="custom-card">
			<p class="custom-card-title">'.$metodo['Metodo'] .' '. $banco .' '. $cuenta  .' '. $cci .'</p>
			<div class="custom-card-content">
				<p class="custom-card-text">'.$metodo['Titular'].'</p>
			</div>
		</div>
	</div>';
	}

	echo $cadena;

?>