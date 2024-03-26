<?php
include "../../include/conexion.php";
include "../../include/busquedas.php";
include "../../include/funciones.php";
include("../include/verificar_sesion_secretaria.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//enviar correo
require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

if (!verificar_sesion($conexion)) {
	echo "<script>
				  alert('Error Usted no cuenta con permiso para acceder a esta página');
				  window.location.replace('../../login/');
			  </script>";
  }else {

    $id_postulacion = $_POST["id"];
    $detalle_post = buscarDetallePostulacionPorId($conexion, $id_postulacion);
    $detalle_post = mysqli_fetch_array($detalle_post);
    $id_proceso_admision = $detalle_post['Id_Proceso_Admision'];
    $codigo_unico = $detalle_post['Codigo_Unico'];
    $correo = $_POST["correo"];

    if ($_POST['tipo'] == "observado"){
        
        // Consulta para insertar los datos en la base de datos
        $sql = "UPDATE `detalle_postulacion` SET `Estado`= 3 WHERE Id = $id_postulacion";
        $res = mysqli_query($conexion, $sql);
        if ($res) {
            echo "<script>
            window.location.replace('../postulantes_admision.php?id=".$id_proceso_admision."');
            </script>";
        } else {
            echo "<script>
            alert('Ops, Ocurrio un error al guardar!');
            window.history.back();
            </script>";
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
        
    } 
    if ($_POST['tipo'] == "aceptado"){
        
        $rutaTemporal = $_FILES['documento']["tmp_name"];
        $ruta_destino = "../../admision/utils/documentos/";
		$nombre_archivo = basename($_FILES['documento']['name']);
         // Obtener la extensión del archivo
        $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
        // Nuevo nombre de archivo
        $nuevoNombre = $codigo_unico .'.'. $extension;
		$ruta_completa = $ruta_destino . $nuevoNombre;
		$ruta_db =substr($ruta_completa,15);
        

        $sql = "UPDATE `detalle_postulacion` SET `Estado`= 2,`Ficha_Postulante`='$ruta_db' WHERE Id = '$id_postulacion'";
        $res = mysqli_query($conexion, $sql);
        
        if ($res) {
            // Mover el archivo de la ruta temporal al directorio destino
            move_uploaded_file($rutaTemporal, $ruta_completa);

            
            echo "<script>
            alert('Registro exitoso!!');
            window.location.replace('../postulantes_admision.php?id=".$id_proceso_admision."');
            </script>";
        } else {
            echo "<script>
            alert('Ops, Ocurrio un error al aceptar!');
            window.history.back();
            </script>";
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
    }
}
?>

