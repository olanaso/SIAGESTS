<?php
function verificar_sesion($conexion){
	session_start();
	if (isset($_SESSION['id_sesion'])) {

		$sesion_activa = sesion_si_activa($conexion, $_SESSION['id_sesion'], $_SESSION['token']);
		if (!$sesion_activa) {
			echo "<script>
                alert('La Sesion Caducó, Inicie Sesión');
                window.location.replace('../include/login/cerrar_sesion.php');
    		</script>";
		}else {
				return 1;
		}
		
	}else {
		return 0;
	}
}
?>