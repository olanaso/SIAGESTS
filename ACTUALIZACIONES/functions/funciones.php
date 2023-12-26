<?php

function generarQRBoleta($texto, $nombre_archivo){
    $apiKey = 'RWQldSV8eB_FzfNTFmTgfZ-d_472fko71zb19j2aU7_ZFqR_ses5gXLNSXC5iA_9'; // Reemplaza con tu clave de API

        // URL de la API
    $url = "https://api.qr-code-generator.com/v1/create?access-token=". $apiKey;

    // Datos del cuerpo de la solicitud
    $data = array(
        "frame_name" => "bottom-frame",
        "qr_code_text" => $texto,
        "qr_code_logo" => "no-logo",
        "image_format" => "JPG",
        "image_width" => 500,
        "frame_color"  => "#008FFF",
        "frame_icon_name" => "pdf",
        "frame_text" => "Verificar",
        "marker_left_template" => "version13",
        "marker_right_template" => "version13",
        "marker_bottom_template" => "version13"
    );

    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar la solicitud POST
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Configurar para recibir la respuesta como cadena
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la solicitud
    $response = curl_exec($ch);

    // Verificar errores
    if (curl_errno($ch)) {
        echo 'Error al realizar la solicitud: ' . curl_error($ch);
    }

    // Cerrar la sesión cURL
    curl_close($ch);
    // Guardar el código QR SVG en un archivo
    $rutaCodigoQR = '../img/QRCode/'.$nombre_archivo.'.jpg';
    file_put_contents($rutaCodigoQR, $response);

    // Devolver la ruta del código QR SVG generado
    return $rutaCodigoQR;
}

function convertirNumeroALetra($numero) {
    $diccionario = [
        0 => 'Cero',
        1 => 'Uno',
        2 => 'Dos',
        3 => 'Tres',
        4 => 'Cuatro',
        5 => 'Cinco',
        6 => 'Seis',
        7 => 'Siete',
        8 => 'Ocho',
        9 => 'Nueve',
        10 => 'Diez',
        11 => 'Once',
        12 => 'Doce',
        13 => 'Trece',
        14 => 'Catorce',
        15 => 'Quince',
        16 => 'Dieciséis',
        17 => 'Diecisiete',
        18 => 'Dieciocho',
        19 => 'Diecinueve',
        20 => 'Veinte',
    ];

    return isset($diccionario[$numero]) ? $diccionario[$numero] : '';
}

function obtenerFecha(){
    //CONFIGURAR FECHA
    $traducciones = array(
        'Monday'    => 'lunes',
        'Tuesday'   => 'martes',
        'Wednesday' => 'miércoles',
        'Thursday'  => 'jueves',
        'Friday'    => 'viernes',
        'Saturday'  => 'sábado',
        'Sunday'    => 'domingo',
        'January'   => 'enero',
        'February'  => 'febrero',
        'March'     => 'marzo',
        'April'     => 'abril',
        'May'       => 'mayo',
        'June'      => 'junio',
        'July'      => 'julio',
        'August'    => 'agosto',
        'September' => 'septiembre',
        'October'   => 'octubre',
        'November'  => 'noviembre',
        'December'  => 'diciembre'
    );

    // Crear una instancia de DateTime
    $fechaActual = new DateTime();

    // Obtener el nombre del día y mes en español
    $nombreDia = $traducciones[$fechaActual->format('l')];
    $nombreMes = $traducciones[$fechaActual->format('F')];

    // Imprimir la fecha formateada en español
    $fecha = $nombreDia . ' ' . $fechaActual->format('j') . ' de ' . $nombreMes . ' del ' . $fechaActual->format('Y');

    return $fecha;
}

function verificarDatos($conexion, $dni, $id_periodo){
    include("../include/conexion.php");
    $estudiante_res = buscarEstudianteByDni($conexion, $dni);
    $estudiante_res = mysqli_fetch_array($estudiante_res);
    $es_matriculado = buscarMatriculado($conexion, $estudiante_res['id'], $id_periodo);
    $cant_filas = mysqli_fetch_row($es_matriculado);

    if($cant_filas == 0){
        return false;
    }
    return true;
}

?>