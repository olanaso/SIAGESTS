<?php
include "../../include/conexion.php";
include "../../include/busquedas.php";
include "../../include/funciones.php";

    //EVALUADOR
    $exito = False;

    //POSTULANTE
    $dni = $_POST['dni'];
    $apellido_paterno = $_POST['paterno'];
    $apellido_materno = $_POST['materno'];
    $nombres = $_POST['nombres'];
    
    $rutaTemporalFotografia = $_FILES['fotografia']["tmp_name"];
    $nombreArchivo = $_FILES['fotografia']["name"];

    // Obtener la extensión del archivo
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    // Nuevo nombre de archivo
    $nuevoNombre = $dni .'.'. $extension;
    $carpetaDestino = "../utils/documentos/";
    // Ruta de destino con el nuevo nombre de archivo
    $fotografia = substr($carpetaDestino . $nuevoNombre,3);

    $genero = $_POST['genero'];
    $estado_civil = $_POST['est_civil'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $lengua_materna = $_POST['len_materna'];
    $discapacidad = $_POST['discapacidad'];
    $tipo_discapacidad = isset($_POST['tipo_discapacidad']) ? $_POST['tipo_discapacidad'] : null;
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];

    $sql = "INSERT INTO `postulante`(`Dni`, `Apellido_Paterno`, `Apellido_Materno`, `Nombres`, `Fotografia`, 
    `Sexo`, `Correo`, `Celular`, `Estado_Civil`, `Fecha_Nacimiento`, `Domicilio_Actual`, 
    `Lengua_Materna`, `Presenta_Discapacidad`, `Tipo_Discapacidad`) 
    VALUES ('$dni','$apellido_paterno','$apellido_materno','$nombres','$fotografia','$genero','$correo',
    '$celular','$estado_civil','$fecha_nacimiento','$direccion','$lengua_materna',
    '$discapacidad','$tipo_discapacidad')";
    $res = mysqli_query($conexion, $sql);
    if($res){

        // Mover el archivo de la ruta temporal al directorio destino
        move_uploaded_file($rutaTemporalFotografia, $carpetaDestino . $nuevoNombre);

        $id_postulante = mysqli_insert_id($conexion);
    
        //COLEGIO
        $id_colegio = $_POST['colegio'];
        $tipo_colegio = $_POST['tipo_colegio'];
        $anio_egreso = $_POST['anio_egreso'];
        
        $sql_colegio = "INSERT INTO `detalle_colegio`(`Id_Colegio`, `Tipo`, `Anio_Egreso`) 
        VALUES ('$id_colegio','$tipo_colegio','$anio_egreso')";
        $res_colegio = mysqli_query($conexion, $sql_colegio);

        if($res_colegio){
            
            $id_detalle_colegio = mysqli_insert_id($conexion);

            //PADRES
            $ap_dni = isset($_POST['ap_dni']) ? $_POST['ap_dni'] : null;
            $ap_apellidos = isset($_POST['ap_apellidos']) ? $_POST['ap_apellidos'] : null;
            $ap_nombres = isset($_POST['ap_nombres']) ? $_POST['ap_nombres'] : null;
            $ap_celular = isset($_POST['ap_celular']) ? $_POST['ap_celular'] : null;
            
            //DETALLE INSCRIPCION
            $id_proceso_admision = $_POST['proceso'];
            $id_modalidad = $_POST['modalidad'];
            $id_programa = $_POST['programa'];
            $id_programa_opcional = isset($_POST['segun_opcion']) ? $_POST['segun_opcion'] : "0";

            //REQUISITOS
            $id_medio_pago = $_POST['metodo_pago'];
            $difusion = $_POST['difusion'];

            $total_admision = cantidadPostulaciones($conexion);

            $codigo_unico = generarCodigoAdmision($dni, $total_admision);

            if($id_programa_opcional == "0"){
                $sql_postulacion = "INSERT INTO `detalle_postulacion`(`Id_Postulante`, `Id_Detalle_Colegio`, `Id_Modalidad`, `Id_Proceso_Admision`, 
                `Id_Programa_Estudio`, `Id_Metodo_Pago`, `Dni_Apoderado`, `Apellidos_Apoderado`, 
                `Nombres_Apoderado`, `Celular_Apoderado`, `Medio_Difusion`, `Codigo_Unico`) VALUES ('$id_postulante',
                '$id_detalle_colegio','$id_modalidad','$id_proceso_admision','$id_programa','$id_medio_pago','$ap_dni',
                '$ap_apellidos','$ap_nombres','$ap_celular','$difusion','$codigo_unico')";
                $res_postulacion = mysqli_query($conexion, $sql_postulacion);
            }else{
                $sql_postulacion = "INSERT INTO `detalle_postulacion`(`Id_Postulante`, `Id_Detalle_Colegio`, `Id_Modalidad`, `Id_Proceso_Admision`, 
                `Id_Programa_Estudio`,`Id_Segunda_Opcion`, `Id_Metodo_Pago`, `Dni_Apoderado`, `Apellidos_Apoderado`, 
                `Nombres_Apoderado`, `Celular_Apoderado`, `Medio_Difusion`, `Codigo_Unico`) VALUES ('$id_postulante',
                '$id_detalle_colegio','$id_modalidad','$id_proceso_admision','$id_programa', '$id_programa_opcional','$id_medio_pago','$ap_dni',
                '$ap_apellidos','$ap_nombres','$ap_celular','$difusion','$codigo_unico')";
                $res_postulacion = mysqli_query($conexion, $sql_postulacion);
            }

            if($res_postulacion){
                $id_detalle_postulacion = mysqli_insert_id($conexion);
                $directorioDestino = '../utils/documentos/';
                $res_generales = buscarRequisitosGeneralesPorProceso($conexion, $id_proceso_admision);
                while ($req_generales = mysqli_fetch_array($res_generales)) {
                    // (archivo cargado)
                    $id_requisito = $req_generales['Id'];
                    $nombreArchivo =$id_requisito.$dni.".pdf";
                    $rutaTemporal = $_FILES[$id_requisito]["tmp_name"];
                    $rutaFinal = substr($directorioDestino . $nombreArchivo,3);
                    $sql_requisito = "INSERT INTO `documento_postulacion`(`Id_Detalle_Postulacion`, `Id_Requisito`, `Documento`) 
                    VALUES ('$id_detalle_postulacion','$id_requisito','$rutaFinal')";
                    $res_requisito = mysqli_query($conexion, $sql_requisito);
                    if($res_requisito){
                        $exito = True;
                        // Mover el archivo de la ruta temporal al directorio destino
                        move_uploaded_file($rutaTemporal, $directorioDestino . $nombreArchivo);
                    }
                }
                $res_especiales = buscarRequisitosEspecificosPorProcesoModalidad($conexion, $id_proceso_admision, $id_modalidad);
                while ($req_especiales = mysqli_fetch_array($res_especiales)) {
                    // (archivo cargado)
                    $id_requisito = $req_especiales['Id'];
                    $nombreArchivo = $id_requisito.$dni.".pdf";

                    $rutaTemporal = $_FILES[$id_requisito]["tmp_name"];
                    $rutaFinal = substr($directorioDestino . $nombreArchivo,3);
                    $sql_requisito_e = "INSERT INTO `documento_postulacion`(`Id_Detalle_Postulacion`,`Id_Requisito`, `Documento`) 
                    VALUES ('$id_detalle_postulacion','$id_requisito','$rutaFinal')";
                    $res_requisito_e = mysqli_query($conexion, $sql_requisito_e);
                    if($res_requisito_e){
                        $exito = True;
                        // Mover el archivo de la ruta temporal al directorio destino
                        move_uploaded_file($rutaTemporal, $directorioDestino . $nombreArchivo);
                    }
                }
                
            }else{
                echo "<script>
                alert('Error al registrar requisitos');
                window.location.replace('../inscripcion.php');
                    </script>
                ";
            }
        }else{
            echo "<script>
			alert('Error al registrar datos de colegio y procedencia');
            window.location.replace('../inscripcion.php');
				</script>
			";
        }

    }else{
        echo "<script>
			alert('Error al registrar datos del postulante');
            window.location.replace('../inscripcion.php');
				</script>
			";
    }
    

    if($exito){ ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Language" content="es-ES">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admisión
            <?php include ("../include/header_title.php"); ?>
        </title>
        <!--icono en el titulo-->
        <link rel="shortcut icon" href="../img/favicon.ico">
        <link rel="stylesheet" href="soft-ui-dashboard-tailwind.css" />
        <!-- Google Icons -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Script obtenido desde CDN jquery -->
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
    </head>
    <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }

    .container-card {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .content {
        text-align: center;
        background-color: #fff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 80%;
        /* Ajustar el ancho máximo del contenido */
    }

    .icono-exitoso img {
        width: 100px;
        margin-bottom: 20px;
    }

    .creditos {
        color: #989898;
    }

    /* Media queries para dispositivos móviles */
    @media screen and (max-width: 600px) {
        .content {
            padding: 10px;
            /* Reducir el espacio interior */
        }

        .icono-exitoso img {
            width: 80px;
            /* Reducir el tamaño del icono */
        }

        button {
            padding: 8px 16px;
            /* Ajustar el tamaño del botón */
        }
    }
</style>

<body>
    <div class="container-card">
        <div class="content">
            <center>
            <div class="icono-exitoso">
                <img src="../utils/controlar.png" alt="Éxito">

            </div>
            <a href="https://www.flaticon.es/iconos-gratis/okay" class="creditos" title="okay iconos">Okay iconos
                creados por
                PureSolution - Flaticon</a>
            </center>
            <h1 class ="green">¡Registro Exitoso!</h1>
            <span>Su código para acceder a su perfil de postulante es: <b> <?php echo $codigo_unico; ?> </b> </span>
            <p>De igual manera se envio al correo propocionado la credencial para acceder al perfil del postulante.</p>
            <br>
            <a href="../login_postulante/index.php"><button class="btn btn-success">Ir al Perfil de Postulante</button></a>
            <br><br>
            <p id="contador">La página se cerrará en <span id="segundos">60</span> segundos.</p>
        </div>
    </div>
    <script>
        setTimeout(function () {
            window.location.replace('../inscripcion.php'); // Redirige a otra página después de 1 minuto
        }, 60000); // 60000 milisegundos = 1 minuto
    </script>
    <script>
        var segundos = 60; // Inicializar el contador de segundos

        // Función para actualizar el contador de segundos y cerrar la ventana después de 1 minuto
        var temporizador = setInterval(function () {
            document.getElementById('segundos').textContent = segundos; // Actualizar el texto del contador
            segundos--; // Decrementar el contador
            if (segundos < 0) {
                clearInterval(temporizador); // Detener el temporizador cuando llegue a cero
                window.close(); // Cerrar la ventana
            }
        }, 1000); // Actualizar cada segundo (1000 milisegundos = 1 segundo)
        // Modificar el historial del navegador para evitar el acceso a la página de registro exitoso mediante el botón de retroceso
        window.history.replaceState({}, document.title, window.location.href);
    </script>
</body>
<?php }   
    mysqli_close($conexion); ?>