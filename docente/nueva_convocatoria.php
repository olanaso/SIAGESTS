<?php
include("../include/conexion.php");
include("../caja/consultas.php");
include("../empresa/include/consultas.php");
include("../include/busquedas.php");
include("../include/funciones.php");

include("include/verificar_sesion_secretaria.php");

if (!verificar_sesion($conexion)) {
  echo "<script>
                alert('Error Usted no cuenta con permiso para acceder a esta página');
                window.location.replace('index.php');
    		</script>";
}else {
  
  $id_docente_sesion = buscar_docente_sesion($conexion, $_SESSION['id_sesion'], $_SESSION['token']);
  
  function generarCodigo($prefijo, $longitud, $numero) {
    // Crear el formato del número con ceros a la izquierda
    $numeroFormateado = sprintf('%0' . $longitud . 'd', $numero);

    // Combinar el prefijo con el número formateado
    $codigoCompleto = $prefijo. "-" . $numeroFormateado;

    return $codigoCompleto;
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
	  
    <title>Caja <?php include ("../include/header_title.php"); ?></title>
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
    
    <style>
      .comenzar{
        background-color: #337AB7;
      }
      .proceso{
        background-color: #26B99A;
      }
      .finalizar{
        background-color: #F0AD4E;
      }
      .Finalizado{
        background-color: #D9534F;
      }
    </style>

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
                  <div class="x_content">
                  <div class="">
                    <h2 align="center">Nueva Convocatoria Laboral</h2>
                  </div>
                  <a href="mis_convocatorias.php" class="btn btn-danger"><i class="fa fa-mail-reply"></i> Regresar</a>
                  </div>
                  <div class="x_panel">
                    <div class="x_title">
                        <h2>Formulario de Registro</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form role="form" action="operaciones/agregar_convocatoria.php" class="form-horizontal form-label-center"  method="POST" >
                        <p>Todos los campos con (*), son campos obligatorios.</p>
                        <div id="wizard" class="form_wizard wizard_horizontal">
                            <ul class="wizard_steps">
                                <li>
                                    <a href="#step-1">
                                        <span class="step_no">1</span>
                                        <span class="step_descr">
                                            Paso 1<br />
                                            <small>Información Especifica</small>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step-2">
                                        <span class="step_no">2</span>
                                        <span class="step_descr">
                                            Paso 2<br />
                                            <small>Información Detallada</small>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="step-1">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="empresa">Empresa <span
                                            class="required">* :</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" id="empresa" name="empresa" required="required" class="form-control  ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="titulo">Título <span
                                            class="required">* :</span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" id="titulo" name="titulo" required="required" class="form-control  ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="ubicacion">Lugar de Trabajo <span
                                            class="required">* : </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" id="ubicacion" name="ubicacion" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="vacante"># Vacantes <span
                                            class="required">* : </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="number" id="vacante" name="vacante" data-validate-minmax="1,20" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="salario">Salario <span
                                            >: </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="number" id="salario" name="salario" data-validate-minmax="1,20"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="modalidad" class="col-form-label col-md-3 col-sm-3 label-align">Modalidad * :</label>
                                    <div class="col-md-9 col-sm-9 ">
                                                <select class="form-control" id="modalidad" name="modalidad" required="required">
                                                    <option value="Presencial">Presencial</option>
                                                    <option value="Semipresencial">Semipresencial</option>
                                                    <option value="Remoto">Remoto</option>
                                                </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="horario" class="col-form-label col-md-3 col-sm-3 label-align">Turno * :</label>
                                    <div class="col-md-9 col-sm-9 ">
                                                <select class="form-control" id="horario" name="horario" required="required">
                                                    <option value="COMPLETO">Completo</option>
                                                    <option value="MAÑANA">Turno Mañana</option>
                                                    <option value="TARDE">Turno Tarde</option>
                                                    <option value="NOCHE">Turno Noche</option>
                                                </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="inicio">Inicio Convocatoria <span
                                            class="required">* : </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="date" id="inicio" name="inicio" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="fin">Fin Convocatoria <span
                                            class="required">* : </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="date" id="fin" name="fin" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for = "url">U.R.L. (en otra plataforma) * :
                                    </label>
                                    <div class="col-md-9 col-sm-9">
                                        <input id="url" name="url" class="date-picker form-control" type="text" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Programa Dirigido * :
                                    </label>
                                    <div class="col-md-9 col-sm-9">
                                        <?php 
                                            $carreras = buscarCarreras($conexion);
                                            while ($carrera = mysqli_fetch_array($carreras)) {
                                        ?>
                                           <input  type="checkbox" class="concepto-checkbox" data-monto="<?php echo $carrera['id'] ?>" name="carreras[]" value="<?php echo $carrera['id'] ?>" id="<?php echo $carrera['id'] ?>">
                                            <label class="form-check-label" for="<?php echo $carrera['id']; ?>"><?php echo $carrera['nombre']; ?></label> <br>
                                        <?php }; ?>            
                                    </div>
                                </div>
                            </div>
                            <div id="step-2">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Requisitos * :
                                    </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <textarea class="form-control" required="required" name="requisitos" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Funciones * :
                                    </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <textarea class="form-control" required="required" name="funciones" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Beneficios * :
                                    </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <textarea class="form-control" required="required" name="beneficios" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Condiciones :
                                    </label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <textarea class="form-control" name="condiciones" rows="5"></textarea>
                                    </div>
                                </div>  
                                <br>   
                                <div class="form-group" align="center">
                                    <input class="btn btn-primary" type="submit" value="Registrar Oferta Laboral">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
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

<!-- jQuery -->
<script src="../Gentella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../Gentella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../Gentella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../Gentella/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../Gentella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <script src="../Gentella/vendors/iCheck/icheck.min.js"></script>
    <script src="../Gentella/vendors/jszip/dist/jszip.min.js"></script>
    <script src="../Gentella/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../Gentella/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="../Gentella/vendors/pnotify/dist/pnotify.js"></script>
    <script src="../Gentella/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../Gentella/vendors/pnotify/dist/pnotify.nonblock.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../Gentella/build/js/custom.min.js"></script>

     <?php mysqli_close($conexion); ?>
  </body>
</html>
<?php } ?>