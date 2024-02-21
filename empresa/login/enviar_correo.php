<?php
include "../../include/conexion.php";
include '../../include/busquedas.php';
include '../../include/funciones.php';
include '../include/consultas.php';
include '../operaciones/sesiones.php';

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//enviar correo
require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

if (!isset($_POST['email'])) {
    $id_sesion = $_SESSION['id_sesion_emp'];
    $token = $_SESSION['token'];
    $b_sesion = buscarSesionEmpresaLoginById($conexion, $id_sesion);
    $r_b_sesion = mysqli_fetch_array($b_sesion);
    if (password_verify($r_b_sesion['token'], $token)) {
        $id_emp = buscar_empresa_sesion($conexion, $id_sesion, $token);
        $enviar = 1;
    } else {
        $enviar = 0;
    }
    
} else {
    $correo = $_POST['email'];


    $busc_emp = "SELECT * FROM empresa WHERE correo_institucional='$correo'";
    $ejec_busc_emp = mysqli_query($conexion, $busc_emp);
    $cont_emp = mysqli_num_rows($ejec_busc_emp);
    if ($cont_emp > 0) {
        $res_busc_emp = mysqli_fetch_array($ejec_busc_emp);
        $id_emp = $res_busc_emp['id'];
        $enviar = 1;
    } else {
        $enviar = 0;
    }
    echo $enviar;
}

$llave = generar_llave();
$token = password_hash($llave, PASSWORD_DEFAULT);

if ($enviar) {
    

    $b_datos_institucion = buscarDatosGenerales($conexion);
    $r_b_datos_institucion = mysqli_fetch_array($b_datos_institucion);

    $b_datos_sistema = buscarDatosSistema($conexion);
    $r_b_datos_sistema = mysqli_fetch_array($b_datos_sistema);

    $b_emp = buscarEmpresaById($conexion, $id_emp);
    $r_b_emp = mysqli_fetch_array($b_emp);

    //enviamos correo


    $asunto = "Cambio de Contraseña";
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $r_b_datos_sistema['host_email'];                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $r_b_datos_sistema['email_email'];                     //SMTP username
        $mail->Password   = $r_b_datos_sistema['password_email'];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = $r_b_datos_sistema['puerto_email'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $titulo_correo = 'SISPA '.$r_b_datos_sistema['titulo'];
        //Recipients
        $mail->setFrom($r_b_datos_sistema['email_email'], $titulo_correo);
        $mail->addAddress($r_b_emp['correo_institucional'], $r_b_emp['contacto']);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $asunto;
        $link = 'https://'.$r_b_datos_sistema['dominio_sistema'].'/empresa/login/recuperar_password.php?id=' . $id_emp . '&token='.$token;
        $mail->Body = '<!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                    </head>
                    <body>
                    <div style="width: 100%; font-family: Roboto; font-size: 0.8em; display: inline;">
                        <div style="background-color:'.$r_b_datos_sistema['color_correo'].'; border-radius: 10px 10px 0px 0px; text-align: center;">
                            <img src="https://sispa.iestphuanta.edu.pe/img/logo.png" alt="'.$r_b_datos_sistema['pagina'].'" style="padding: 0.5em; text-align: center;" height="50px">
                        </div>
                        <div style="background-color:'.$r_b_datos_sistema['color_correo'].'; border-radius: 0px 0px 0px 0px; height: 60px; margin-top: 0px; padding-top: 2px; padding-bottom: 10px;">
                            <p style="text-align: center; font-size: 1.0rem; color: #f1f1f1; text-shadow: 2px 2px 2px #cfcfcf; ">'.$r_b_datos_institucion['nombre_institucion'].'</p>
                        </div>
                        <div>
                            <h2 style="text-align:center;">SA (Sistema Académico)</h2>
                            <h3 style="text-align:center; color: #3c4858;">CAMBIO DE CONTRASEÑA</h3>
                            <p style="font-size:1.0rem; color: #2A2C2B; margin-top: 2em; margin-bottom: 2em; margin-left: 1.5em;">
                    
                                Hola, para poder recuperar tu contraseña, Haz click <a href="'.$link.'">Aquí</a>.<br>
                                
                                
                                <br>
                                <br>
                                Por favor, no responda sobre este correo.
                                <br><br><br>
                    
                            </p>
                        </div>
                        <div style="color: #f1f1f1; width: 100%; height: 120px; background:'.$r_b_datos_sistema['color_correo'].'; text-align: center;  border-radius: 0px 0px 10px 10px; ">
                            <br>
                            <p style="margin: 0px;">
                                <strong>
                                    <a"
                                       style="text-decoration: none; color: #f1f1f1; ">'.$r_b_datos_institucion['direccion'].'
                                        &nbsp;|&nbsp; Teléfono: '.$r_b_datos_institucion['telefono'].'</a>
                                    <br> '.$r_b_datos_institucion['nombre_institucion'].'
                                </strong>
                            </p>
                        </div>
                    </div>
                    </body>
                    </html>';
        //$mail->AltBody = '';

        $mail->send();
        //echo 'Correo enviado';
        $sql = "UPDATE empresa SET reset_password=1, token_password='$llave' WHERE id='$id_emp'";
        $ejec_consulta = mysqli_query($conexion, $sql);
        echo "<script>
    alert('Verifique su correo, sino encuentra en su bandeja de entrada. Verifique en Seccion de Spam');
    window.location= '../index.php'
    </script>
    ";
    } catch (Exception $e) {
        echo "Error correo: {$mail->ErrorInfo}";
    }
}else{
    echo "<script>
    alert('Ops, Ocurrio un Error al enviar Correo');
    window.location= '../index.php'
    </script>";
}
