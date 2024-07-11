<?php

include("../include/conexion.php");
include("../include/busquedas.php");
include("../include/funciones.php");
include("../functions/funciones.php");
include("include/verificar_sesion_secretaria.php");

$dni = $_POST['dni'];
$comprobante = $_POST['comprobante'];
$tipo = $_POST['tipo'];
$res = buscarEstudianteByDni($conexion, $dni);
$cont = mysqli_num_rows($res);

if (!verificar_sesion($conexion)) {
  echo "<script>
  alert('Ah ocurrido un error, revice los datos ingresados y vuelva a intentarlo.');
  window.location.replace('certificado.php');
</script>";
}else{
  if($cont == 0){
    echo "<script>
      alert('El alumno no exíste en la base de datos.');
      window.location.replace('certificado.php');
    </script>";
  }else{
  $id_docente_sesion = buscar_docente_sesion($conexion, $_SESSION['id_sesion'], $_SESSION['token']);

  //DATOS

  $res = buscarEstudianteByDni($conexion, $dni);
  $estudiante_res = mysqli_fetch_array($res);
  $estudiante = $estudiante_res["apellidos_nombres"];
  $id_programa = $estudiante_res['id_programa_estudios'];
  $correo = $estudiante_res['correo'];
  $egresado = $estudiante_res['egresado'];

  $programa = buscarCarrerasById($conexion, $id_programa);
  $programa = mysqli_fetch_array($programa);
  $programa = $programa['nombre'];


  function compararTexto($texto1, $texto2) {
    // Función para eliminar tildes y caracteres especiales y convertir a mayúsculas
    $textoLimpio = function($texto) {
        // Reemplazar vocales tildadas con vocales no tildadas
        $texto = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'],
            ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'],
            $texto
        );
        $texto = mb_strtoupper($texto, 'UTF-8'); // Convertir a mayúsculas
        return trim($texto); // Eliminar espacios en blanco al inicio y al final
    };

    // Convertir los textos a cadenas limpias
    $texto1Limpio = $textoLimpio($texto1);
    $texto2Limpio = $textoLimpio($texto2);

    // Dividir los textos en palabras
    $palabrasTexto1 = explode(' ', $texto1Limpio);
    $palabrasTexto2 = explode(' ', $texto2Limpio);

    // Contadores para letras coincidentes y totales
    $palabrasCoincidentes = 0;
    $palabrasTotales = 0;

    // Comparar cada palabra de los textos
    foreach ($palabrasTexto1 as $indice => $palabra) {
      // Obtener las palabras correspondientes en ambos textos
      $palabraTexto1 = $palabra;
      $palabraTexto2 = isset($palabrasTexto2[$indice]) ? $palabrasTexto2[$indice] : '';

      // Si las palabras son iguales, aumentar el contador de palabras coincidentes
      if ($palabraTexto1 === $palabraTexto2) {
          $palabrasCoincidentes++;
      }
      $palabrasTotales++;
    }

    // Calcular el porcentaje de similitud
    $porcentajeSimilitud = ($palabrasCoincidentes / $palabrasTotales) * 100;

    if (count($palabrasTexto1) != count($palabrasTexto2)) {
      return $porcentajeSimilitud - 30;
    }
    return $porcentajeSimilitud;
}

  $res_notas_importadas2 = getNotasImportadaByDniUpdate($conexion, $dni);
  $unidades_didacticas2 = buscarUdByPrograma($conexion, $id_programa);
  
  // Iterar sobre cada registro de res_notas_importadas
  while ($notas_importadas = mysqli_fetch_array($res_notas_importadas2)) {
    // Iterar sobre cada registro de unidades_didacticas
    $id_ud1 = $notas_importadas['id'];

    while ($unidad_didactica = mysqli_fetch_array($unidades_didacticas2)) {
        $id_ud2 = $unidad_didactica['id'];
        $unidad_didactica1 = $notas_importadas['unidad_didactica'];
        $unidad_didactica2 = $unidad_didactica['descripcion'];
  
        if(($unidad_didactica1) == ($unidad_didactica2)){
          $query = "UPDATE `notas_antiguo` SET `id_unidad_didactica`='$id_ud2' WHERE id = $id_ud1";
          mysqli_query($conexion,$query);
        }

    }
    mysqli_data_seek($unidades_didacticas2, 0);
  }

  $res_notas_importadas = getNotasImportadaByDniUpdate($conexion, $dni);
  $unidades_didacticas = buscarUdByPrograma($conexion, $id_programa);
  
  // Iterar sobre cada registro de res_notas_importadas
  while ($notas_importadas = mysqli_fetch_array($res_notas_importadas)) {
    // Iterar sobre cada registro de unidades_didacticas
    $id_ud1 = $notas_importadas['id'];

    while ($unidad_didactica = mysqli_fetch_array($unidades_didacticas)) {
        $id_ud2 = $unidad_didactica['id'];
        $unidad_didactica1 = $notas_importadas['unidad_didactica'];
        $unidad_didactica2 = $unidad_didactica['descripcion'];
        if(compararTexto($unidad_didactica1, $unidad_didactica2) > 80){
        $query = "UPDATE `notas_antiguo` SET `id_unidad_didactica`='$id_ud2' WHERE id = $id_ud1";
        mysqli_query($conexion,$query); 
        }
    }
    mysqli_data_seek($unidades_didacticas, 0);
  }
  
  $not = getEstudianteNotasCertificado($conexion, $dni);
  $promedio = 0;
  $total_creditos = 0;
  

  $director = buscarDirector_All($conexion);
  $director = mysqli_fetch_array($director);

  $usuario = buscarDocenteById($conexion, $id_docente_sesion);
  $usuario = mysqli_fetch_array($usuario);
  $usuario = $usuario['apellidos_nombres'];

  $director = buscarDirector_All($conexion);
  $director = mysqli_fetch_array($director);
  $nombre_director = $director['apellidos_nombres'];

  $datos_iestp = buscarDatosSistema($conexion);
  $datos_iestp = mysqli_fetch_array($datos_iestp);
  $nombre_insti = $datos_iestp['pie_pagina'];


  $datos_lugar = buscarDatosGenerales($conexion);
  $datos_lugar = mysqli_fetch_array($datos_lugar);
  $lugar = ucwords(strtolower($datos_lugar['distrito']));

  $sistema = buscarDatosSistema($conexion);
  $sistema = mysqli_fetch_array($sistema);

  $nombre_doc = 'Certificado de estudios - ' . $dni.'.pdf';

  //CODIGO DE VERIFICACIÓN DE DOCUMENTO
  $codigo = uniqid();
  $url = $sistema['dominio_sistema'];
  //$ruta_qr = generarQRBoleta( $url."/verificar.php?codigo=".$codigo ,'CE_'.$dni);

  require_once('../tcpdf/tcpdf.php');

  class MYPDF extends TCPDF
      {}

      //CONFIGURACIÓN PDF
      $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetTitle("Certificado de Estudios - " . $estudiante);
      $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont('helvetica');
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->SetAutoPageBreak(TRUE,15);
      $pdf->SetFont('helvetica', '', 11);
      $pdf->AddPage('P', 'A4');
      $text_size = 9;



  $documento = '
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
              <td width="30%"><img src="../img/logo.jpg" alt="" height="30px"></td>
              <td width="10%"></td>
              <td width="30%" align="right"><img src="../img/logo_minedu.jpeg" alt="" height="30px"></td>
              <td width="30%" align="right"></td>
          </tr>
          <br />
          <tr>
              <td colspan="3" align="left"><font size="10"><b>CERTIFICADO DE ESTUDIOS DE EDUCACIÓN SUPERIOR TECNOLÓGICA</b></font></td>
          </tr>
          <tr>
              <td colspan="3" align="left"><font size="11">El que suscribe</font></td>
          </tr>
          <tr>
              <td colspan="3" align="left"><font size="11">'. $nombre_insti .'</font></td>
          </tr>
          <tr>
              <br />
              <td colspan="4" align="center"><font size="12"><b>CERTIFICA</b></font></td>
          </tr>
          <br />
          <tr>
              <td colspan = "4">Qué, '. $estudiante .' con código de alumno(a) N° '.$dni.' ha cursado las unidades didácticas, que se indican en el programa de estudios de '. $programa . '</td>
          </tr>
          <br />
          <tr>
              <td colspan = "4">El resultado final de las evaluaciones fue el siguiente:</td>
          </tr>
          
      </table>
      <br />
      <br />
  ';

  $documento .= '
      <table border="0.2" cellspacing="0" cellpadding="3" class="no-border">
      <tr>
          <th width="45%" align="center" rowspan="2" ><font size="9"><b>UNIDAD DIDÁCTICA</b></font></th>
          <th width="12%" align="center" rowspan="2"><font size="9"><b>CRÉDITOS</b></font></th>
          <th width="22%" align="center" colspan="2"><font size="9"><b>CALIFICATIVOS</b></font></th>
          <th width="8%" align="center" rowspan="2"><font size="9"><b>AÑO</b></font></th>
          <th width="13%" align="center" rowspan="2"><font size="9"><b>PER. ACAD.</b></font></th>
      </tr>
      <tr>
          <th width="11%" align="center"><font size="9"><b>NÚMEROS</b></font></th>
          <th width="11%" align="center"><font size="9"><b>LETRAS</b></font></th>
      </tr>
  ';

  $unidades = "";
  $creditos = "";
  $calificaciones = "";
  $semestres = "";
  $años = "";
  $calificaciones_letras = "";
  mysqli_data_seek($not, 0);
  while ($notas = mysqli_fetch_array($not)) {
    if($notas['id_semestre'] == 1){
      if(strlen($notas['unidad_didactica']) > 44){
        $unidades .='<br>'.$notas['unidad_didactica'];
        $creditos .='<br>'.$notas['cantidad_creditos'].'<br>';
        $calificaciones .='<br>'.$notas['calificacion'].'<br>';
        $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']).'<br>';
        $años .='<br>'.substr($notas['semestre_academico'],0,4).'<br>';
        $semestres .='<br>'.$notas['semestre_academico'].'<br>';
      }else{
        $unidades .='<br>'.$notas['unidad_didactica'];
        $creditos .='<br>'.$notas['cantidad_creditos'];
        $calificaciones .='<br>'.$notas['calificacion'];
        $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']);
        $años .='<br>'.substr($notas['semestre_academico'],0,4);
        $semestres .='<br>'.$notas['semestre_academico'];
      }
    }
  }
  // Iterar notas del estudiante
  $documento .= '
      <tr>
          <th ><font size="9"><b>PERIODO ACADEMICO I</b>'.$unidades.'</font></th>
          <th align="center" ><font size="9">'.$creditos.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones_letras.'</font></th>
          <th align="center" ><font size="9">'.$años.'</font></th>
          <th align="center" ><font size="9">'.$semestres.'</font></th>
      </tr>
  ';

  $unidades = "";
  $creditos = "";
  $calificaciones = "";
  $semestres = "";
  $años = "";
  $calificaciones_letras = "";
  mysqli_data_seek($not, 0);
      while ($notas = mysqli_fetch_array($not)) {
        if($notas['id_semestre'] == 2){
          if(strlen($notas['unidad_didactica']) > 44){
            $unidades .='<br>'.$notas['unidad_didactica'];
            $creditos .='<br>'.$notas['cantidad_creditos'].'<br>';
            $calificaciones .='<br>'.$notas['calificacion'].'<br>';
            $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']).'<br>';
            $años .='<br>'.substr($notas['semestre_academico'],0,4).'<br>';
            $semestres .='<br>'.$notas['semestre_academico'].'<br>';
          }else{
            $unidades .='<br>'.$notas['unidad_didactica'];
            $creditos .='<br>'.$notas['cantidad_creditos'];
            $calificaciones .='<br>'.$notas['calificacion'];
            $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']);
            $años .='<br>'.substr($notas['semestre_academico'],0,4);
            $semestres .='<br>'.$notas['semestre_academico'];
          }
        }
      }
      // Iterar notas del estudiante
      $documento .= '
          <tr>
              <th ><font size="9"><b>PERIODO ACADEMICO II</b>'.$unidades.'</font></th>
              <th align="center" ><font size="9">'.$creditos.'</font></th>
              <th align="center" ><font size="9">'.$calificaciones.'</font></th>
              <th align="center" ><font size="9">'.$calificaciones_letras.'</font></th>
              <th align="center" ><font size="9">'.$años.'</font></th>
              <th align="center" ><font size="9">'.$semestres.'</font></th>
          </tr>
          ';
  
          $unidades = "";
          $creditos = "";
          $calificaciones = "";
          $semestres = "";
          $años = "";
          $calificaciones_letras = "";
          mysqli_data_seek($not, 0);
  while ($notas = mysqli_fetch_array($not)) {
    if($notas['id_semestre'] == 3){
      if(strlen($notas['unidad_didactica']) > 44){
        $unidades .='<br>'.$notas['unidad_didactica'];
        $creditos .='<br>'.$notas['cantidad_creditos'].'<br>';
        $calificaciones .='<br>'.$notas['calificacion'].'<br>';
        $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']).'<br>';
        $años .='<br>'.substr($notas['semestre_academico'],0,4).'<br>';
        $semestres .='<br>'.$notas['semestre_academico'].'<br>';
      }else{
        $unidades .='<br>'.$notas['unidad_didactica'];
        $creditos .='<br>'.$notas['cantidad_creditos'];
        $calificaciones .='<br>'.$notas['calificacion'];
        $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']);
        $años .='<br>'.substr($notas['semestre_academico'],0,4);
        $semestres .='<br>'.$notas['semestre_academico'];
      }
    }
  }
  // Iterar notas del estudiante
  $documento .= '
      <tr>
          <th ><font size="9"><b>PERIODO ACADEMICO III</b>'.$unidades.'</font></th>
          <th align="center" ><font size="9">'.$creditos.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones_letras.'</font></th>
          <th align="center" ><font size="9">'.$años.'</font></th>
          <th align="center" ><font size="9">'.$semestres.'</font></th>
      </tr>
      ';
      
      $unidades = "";
  $creditos = "";
  $calificaciones = "";
  $semestres = "";
  $años = "";
  $calificaciones_letras = "";
  mysqli_data_seek($not, 0);
  while ($notas = mysqli_fetch_array($not)) {
    if($notas['id_semestre'] == 4){
      if(strlen($notas['unidad_didactica']) > 44){
        $unidades .='<br>'.$notas['unidad_didactica'];
        $creditos .='<br>'.$notas['cantidad_creditos'].'<br>';
        $calificaciones .='<br>'.$notas['calificacion'].'<br>';
        $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']).'<br>';
        $años .='<br>'.substr($notas['semestre_academico'],0,4).'<br>';
        $semestres .='<br>'.$notas['semestre_academico'].'<br>';
      }else{
        $unidades .='<br>'.$notas['unidad_didactica'];
        $creditos .='<br>'.$notas['cantidad_creditos'];
        $calificaciones .='<br>'.$notas['calificacion'];
        $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']);
        $años .='<br>'.substr($notas['semestre_academico'],0,4);
        $semestres .='<br>'.$notas['semestre_academico'];
      }
    }
  }
      // Iterar notas del estudiante
  $documento .= '
      <tr>
          <th ><font size="9"><b>PERIODO ACADEMICO IV</b>'.$unidades.'</font></th>
          <th align="center" ><font size="9">'.$creditos.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones_letras.'</font></th>
          <th align="center" ><font size="9">'.$años.'</font></th>
          <th align="center" ><font size="9">'.$semestres.'</font></th>
      </tr>
    </table>
      ';

    
      $documento .= '
      <br><br>
      <table border="0.2" cellspacing="0" cellpadding="3" class="no-border">
      <tr>
          <th width="45%" align="center" rowspan="2" ><font size="9"><b>UNIDAD DIDÁCTICA</b></font></th>
          <th width="12%" align="center" rowspan="2"><font size="9"><b>CRÉDITOS</b></font></th>
          <th width="22%" align="center" colspan="2"><font size="9"><b>CALIFICATIVOS</b></font></th>
          <th width="8%" align="center" rowspan="2"><font size="9"><b>AÑO</b></font></th>
          <th width="13%" align="center" rowspan="2"><font size="9"><b>PER. ACAD.</b></font></th>
      </tr>
      <tr>
          <th width="11%" align="center"><font size="9"><b>NÚMEROS</b></font></th>
          <th width="11%" align="center"><font size="9"><b>LETRAS</b></font></th>
      </tr>
  ';

  $unidades = "";
  $creditos = "";
  $calificaciones = "";
  $semestres = "";
  $años = "";
  $calificaciones_letras = "";
  mysqli_data_seek($not, 0);
    while ($notas = mysqli_fetch_array($not)) {
      if($notas['id_semestre'] == 5){
        if(strlen($notas['unidad_didactica']) > 44){
          $unidades .='<br>'.$notas['unidad_didactica'];
          $creditos .='<br>'.$notas['cantidad_creditos'].'<br>';
          $calificaciones .='<br>'.$notas['calificacion'].'<br>';
          $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']).'<br>';
          $años .='<br>'.substr($notas['semestre_academico'],0,4).'<br>';
          $semestres .='<br>'.$notas['semestre_academico'].'<br>';
        }else{
          $unidades .='<br>'.$notas['unidad_didactica'];
          $creditos .='<br>'.$notas['cantidad_creditos'];
          $calificaciones .='<br>'.$notas['calificacion'];
          $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']);
          $años .='<br>'.substr($notas['semestre_academico'],0,4);
          $semestres .='<br>'.$notas['semestre_academico'];
        }
      }
    }
          // Iterar notas del estudiante
  $documento .= '
      <tr>
          <th ><font size="9"><b>PERIODO ACADEMICO V</b>'.$unidades.'</font></th>
          <th align="center" ><font size="9">'.$creditos.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones.'</font></th>
          <th align="center" ><font size="9">'.$calificaciones_letras.'</font></th>
          <th align="center" ><font size="9">'.$años.'</font></th>
          <th align="center" ><font size="9">'.$semestres.'</font></th>
      </tr>
      ';


  $unidades = "";
  $creditos = "";
  $calificaciones = "";
  $semestres = "";
  $años = "";
  $calificaciones_letras = "";
  
  mysqli_data_seek($not, 0);
  while ($notas = mysqli_fetch_array($not)) {
                if($notas['id_semestre'] == 6){
                  if(strlen($notas['unidad_didactica']) > 44){
                    $unidades .='<br>'.$notas['unidad_didactica'];
                    $creditos .='<br>'.$notas['cantidad_creditos'].'<br>';
                    $calificaciones .='<br>'.$notas['calificacion'].'<br>';
                    $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']).'<br>';
                    $años .='<br>'.substr($notas['semestre_academico'],0,4).'<br>';
                    $semestres .='<br>'.$notas['semestre_academico'].'<br>';
                  }else{
                    $unidades .='<br>'.$notas['unidad_didactica'];
                    $creditos .='<br>'.$notas['cantidad_creditos'];
                    $calificaciones .='<br>'.$notas['calificacion'];
                    $calificaciones_letras .='<br>'.convertirNumeroALetra($notas['calificacion']);
                    $años .='<br>'.substr($notas['semestre_academico'],0,4);
                    $semestres .='<br>'.$notas['semestre_academico'];
                  }
                }
  }
              // Iterar notas del estudiante
  $documento .= '
                  <tr>
                      <th ><font size="9"><b>PERIODO ACADEMICO VI</b>'.$unidades.'</font></th>
                      <th align="center" ><font size="9">'.$creditos.'</font></th>
                      <th align="center" ><font size="9">'.$calificaciones.'</font></th>
                      <th align="center" ><font size="9">'.$calificaciones_letras.'</font></th>
                      <th align="center" ><font size="9">'.$años.'</font></th>
                      <th align="center" ><font size="9">'.$semestres.'</font></th>
                  </tr>
                  ';
  $res_notas = getEstudianteNotasCertificado($conexion, $dni);
  while($nota_g = mysqli_fetch_array($res_notas)){
    $total_creditos += $nota_g['cantidad_creditos'];
    $promedio += $nota_g['cantidad_creditos']*$nota_g['calificacion'];
  }

  $documento .= '
    <tr>
        <th align="center" colspan="6"><font size="9"><b>
        <br>PROMEDIO PONDERADO: '.number_format(($promedio/$total_creditos),2).'
        <br>
        TOTAL CREDITOS: '.$total_creditos.'
        <br>
        </b></font></th>
    </tr>
    ';
               
  // Cerrar la tabla
  $documento .= '</table>';

  $documento .= '<br />
      <br>
      Así consta en los libros de actas de evaluaciones, a los que nos remitimos en caso sea necesario
      <br>
      <br>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
              <td align="rigth">Lugar y Fecha: '. $lugar .', '. obtenerFecha() . '</td>
          </tr>
          <br><br><br><br><br><br><br>
          <tr>
              <td width="5%"></td>
              <td width="45%" align="center"><font size="9">______________________________<br>DIRECTOR GENERAL</font></td>
              <td width="45%" align="center"><font size="9">______________________________<br>SECRETARIO ACADÉMICO</font></td>
              <td width="5%"></td>
          </tr>
      </table>
  ';

      // Escribir el contenido HTML en el PDF
      $pdf->writeHTML($documento, true, false, true, false, ''); 
      $rutaArchivo = '../documentos/certificado_de_estudios/'. $nombre_doc;
      // Guardar el contenido en el archivo
      $pdfContent = $pdf->Output('', 'S');
      // Enviar el PDF al navegador
      file_put_contents($rutaArchivo, $pdfContent);

      $consulta = "INSERT INTO certificado_estudios (codigo ,nombre_usuario, dni_estudiante, apellidos_nombres, programa_estudio,ruta_documento,num_comprobante, fecha_emision) 
      VALUES ('$codigo' ,'$usuario','$dni', '$estudiante' ,'$programa','$rutaArchivo','$comprobante', CURRENT_TIMESTAMP())";
      mysqli_query($conexion, $consulta); 

  };
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="es-ES">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>Estudiantes <?php include ("../include/header_title.php"); ?></title>
    <!--icono en el titulo-->
    <link rel="shortcut icon" href="../img/favicon.ico">
    <!-- Bootstrap -->
    <link href="../Gentella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../Gentella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../Gentella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../Gentella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../Gentella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../Gentella/build/css/custom.min.css" rel="stylesheet">

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!--menu-->
          <?php 
          include ("include/menu_secretaria.php"); ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
           
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="">
                    <a href="certificado.php" class="btn btn-danger">Regresar</a>
                    <div class="clearfix"></div>
                </div>
                <div class="">
                  <br>
                  <input type="email" id="correoInput" class="form-control" style="width:300px; margin-bottom:2px;" value="<?= $correo?>">

                  <!-- Agrega un ID al enlace para facilitar la referencia desde JavaScript -->
                  <a href="#" id="enviarCorreoBtn" class="btn btn-success"><i class="fa fa-plus-square"></i> Enviar por Correo</a>
                </div>
                    <iframe src="<?php echo $rutaArchivo ?>" width="100%" height="600px"></iframe>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
        <!-- /page content -->

         <!-- footer content -->
         <?php
        include ("../include/footer.php"); 
        ?>
        <!-- /footer content -->
      </div>
    </div>


  <script>
    document.getElementById('enviarCorreoBtn').addEventListener('click', function() {
        // Obtiene el valor del campo de entrada
        var correoValue = document.getElementById('correoInput').value;

        // Construye la URL con el valor del correo
        var url = "./login/enviar_certificado_correo.php?documento=<?= $rutaArchivo ?>&dni=<?= $dni ?>&correo=" + encodeURIComponent(correoValue);

        // Redirecciona a la nueva URL
        window.location.href = url;
    });
  </script>

    <!-- jQuery -->
   <script src="../Gentella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../Gentella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../Gentella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../Gentella/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../Gentella/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../Gentella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../Gentella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../Gentella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../Gentella/vendors/jszip/dist/jszip.min.js"></script>
    <script src="../Gentella/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../Gentella/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../Gentella/build/js/custom.min.js"></script>
    <script>
    $(document).ready(function() {
    $('#example').DataTable({
      "language":{
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ registros",
    "zeroRecords": "No se encontraron resultados",
    "emptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    "search": "Buscar:",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
        "first": "Primero",
        "last": "Último",
        "next": "Siguiente",
        "previous": "Anterior"
    },
      }
    });

    } );
    </script>
     <?php mysqli_close($conexion); ?>
  </body>
</html>