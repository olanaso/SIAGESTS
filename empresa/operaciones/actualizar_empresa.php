<?php

include("../../include/conexion.php");
include("../../include/busquedas.php");
include("../include/consultas.php");
include("../include/verificar_sesion_empresa.php");
include("../operaciones/sesiones.php");

if (!verificar_sesion($conexion)) {
    echo "<script>
                alert('Error Usted no cuenta con permiso para acceder a esta página');
                window.location.replace('login/');
    		</script>";
} else {

    $id = $_POST["id"];
    $ubicacion = $_POST["ubicacion"];
    $contacto = $_POST["contacto"];
    $cargo = $_POST["cargo"];
    $correo = $_POST["correo"];
    $celular = $_POST["celular"];

    $nombreArchivo = $_FILES['logo']['name'];
    $tipoArchivo = $_FILES['logo']['type'];
    $tamañoArchivo = $_FILES['logo']['size'];
    $tempArchivo = $_FILES['logo']['tmp_name'];
    $errorArchivo = $_FILES['logo']['error'];

    $rutaDestino = "";

    if ($nombreArchivo !== "Actualizar") {
        // No se ha subido ningún archivo
        $rutaDestino = '../files/img_defaul_empresa.png';
    }
    // Verificar si no hubo errores al subir la imagen
    if($errorArchivo === 0) {
        // Mover la imagen de la ubicación temporal a la ubicación deseada
        $rutaDestino = '../files/' . $nombreArchivo;
        move_uploaded_file($tempArchivo, $rutaDestino);
    
    }

    $rutaDestino = substr($rutaDestino,3);

    // Consulta para insertar los datos en la base de datos
    $sql = "UPDATE `empresa` SET `correo_institucional`='$correo',`ubicacion`='$ubicacion',`ruta_logo`='$rutaDestino',
    `contacto`='$contacto',`cargo`='$cargo',`celular_telefono`='$celular',`usuario`='$correo' WHERE id = $id";
    $res = mysqli_query($conexion, $sql);
    if ($res) {
        echo "<script>
        alert('Se ha actualizado a la empresa!!');
        window.location.replace('../index.php');
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
?>
