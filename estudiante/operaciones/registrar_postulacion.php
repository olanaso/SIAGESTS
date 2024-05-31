<?php

	include("../../include/conexion.php");
	include("../../include/busquedas.php");
	include("../../include/funciones.php");
	include '../include/verificar_sesion_estudiante.php';
    include("../../empresa/include/consultas.php");

	if (!verificar_sesion($conexion)) {
		echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('index.php');
          </script>";
	} else {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los datos del formulario
            $id_estudiante = $_POST["id"];
            $id_convocatoria = $_POST["convocatoria"];
            $dni = $_POST["dni"];
            $nombre = $_POST["nombre"];
            $direccion = $_POST["direccion"];
            $celular = $_POST["celular"];
            $correo = $_POST["correo"];
            
            $sql = "UPDATE estudiante SET dni='$dni', apellidos_nombres='$nombre',  direccion='$direccion', correo='$correo', telefono='$celular' WHERE id=$id_estudiante";
            $ejec_consulta = mysqli_query($conexion, $sql);

            // Datos del tercer paso (archivo cargado)
            $nombreArchivo = "CL".$id_convocatoria."CV-".$dni.".pdf";
            $rutaTemporal = $_FILES["documento"]["tmp_name"];
            $directorioDestino = '../../empresa/files/';
            
            // Mover el archivo de la ruta temporal al directorio destino
            move_uploaded_file($rutaTemporal, $directorioDestino . $nombreArchivo);
    
            // Aquí puedes realizar cualquier validación adicional de los datos antes de guardarlos en la base de datos
    
            $rutaFinal = $directorioDestino . $nombreArchivo;
            $rutaFinal = substr($rutaFinal,3);
            
            // Consulta para insertar los datos en la base de datos
            $sql = "INSERT INTO `oferta_postulantes`( `id_ol`, `id_es`, `url_documento`) VALUES ($id_convocatoria,$id_estudiante,'$rutaFinal')";
            $res = mysqli_query($conexion, $sql);
            if ($res) {
                echo "<script>
                alert('Su registro se ha realizado de manera exitosa!!');
                window.location.replace('../mis_postulaciones.php');
                </script>";
            } else {
                echo "<script>
                alert('Ops, Ocurrio un error al guardar en base de datos!');
                window.history.back();
                </script>";
            }
    
            // Cerrar la conexión a la base de datos
            $conexion->close();
        }
        
    }

?>