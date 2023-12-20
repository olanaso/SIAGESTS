<?php
include("../include/conexion.php");
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
$id_competencia = $_GET['id'];
$ejec_busc_comp = buscarCompetenciasById($conexion, $id_competencia);
$res_busc_comp = mysqli_fetch_array($ejec_busc_comp);
$id_modulo = $res_busc_comp['id_modulo_formativo'];
$busc_modulo = buscarModuloFormativoById($conexion, $id_modulo);
$res_b_modulo = mysqli_fetch_array($busc_modulo);
$id_p_e = $res_b_modulo['id_programa_estudio'];
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

  <title>Competencias <?php include("../include/header_title.php"); ?></title>
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
  <!-- bootstrap-wysiwyg -->
  <link href="../Gentella/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../Gentella/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
  <!-- Switchery -->
  <link href="../Gentella/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
  <!-- starrr -->
  <link href="../Gentella/vendors/starrr/dist/starrr.css" rel="stylesheet">
  <!-- bootstrap-daterangepicker -->
  <link href="../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


  <!-- Custom Theme Style -->
  <link href="../Gentella/build/css/custom.min.css" rel="stylesheet">
  <!-- Script obtenido desde CDN jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <!--menu-->
      <?php
      include("include/menu_secretaria.php"); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="">
                  <h2 align="center">Editar Competencia</h2>


                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />



                  <div class="x_panel">


                    <div class="x_content">
                      <br />
                      <form role="form" action="operaciones/actualizar_competencia.php" class="form-horizontal form-label-left input_mask" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id_competencia; ?>">

                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Programa de Estudios : </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" id="carrera_m" name="carrera_m" value="<?php echo $id_p_e; ?>" required="">
                              <option></option>
                              <?php
                              $ejec_busc_car_prof = buscarCarreras($conexion);
                              while ($res_busc_car_prof = mysqli_fetch_array($ejec_busc_car_prof)) {
                                $id_car_prof = $res_busc_car_prof['id'];
                                $car_prof = $res_busc_car_prof['nombre'];
                              ?>
                                <option value="<?php echo $id_car_prof;
                                                ?>" <?php if ($id_car_prof == $id_p_e) {
                                    echo 'selected="selected"';
                                  }; ?>><?php echo $car_prof; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                            <br>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Módulo Formativo : </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" id="modulo" name="modulo" value="<?php echo $res_busc_comp['id_modulo']; ?>" required="required">
                              <?php
                              $ejec_busc_modu = buscarModuloFormativoByIdCarrera($conexion, $id_p_e);
                              while ($res_busc_modu = mysqli_fetch_array($ejec_busc_modu)) {
                                $id_modu = $res_busc_modu['id'];
                                $modu = $res_busc_modu['nro_modulo'];
                              ?>
                                <option value="<?php echo $id_modu;
                                                ?>" <?php if ($id_modu == $id_modulo) {
                                    echo 'selected="selected"';
                                  }; ?>><?php echo "M" . $modu . " - " . $res_busc_modu['descripcion']; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                            <br>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo de Competencia: </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class="form-control" id="tipo" name="tipo" value="<?php echo $res_busc_comp['tipo_competencia']; ?>" required="required">
                              <option value=""></option>
                              <option value="ESPECÍFICA" <?php if ("ESPECÍFICA" == $res_busc_comp['tipo_competencia']) {
                                                            echo "selected";
                                                          } ?>>ESPECÍFICA</option>
                              <option value="EMPLEABILIDAD" <?php if ("EMPLEABILIDAD" == $res_busc_comp['tipo_competencia']) {
                                                              echo "selected";
                                                            } ?>>EMPLEABILIDAD</option>
                            </select>
                            <br>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Código : </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="codigo" value="<?php echo $res_busc_comp['codigo']; ?>" required="required">
                            <br>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción : </label>
                          <div class="col-md-9 col-sm-9 col-xs-12">
                            <textarea class="form-control" rows="3" style="width: 100%; height: 165px;" name="descripcion" required="required"><?php echo $res_busc_comp['descripcion']; ?></textarea>
                            <br>
                            <br>
                          </div>
                        </div>

                        <div align="center">

                          <a href="javascript:history.back(-1);" class="btn btn-danger">Cancelar</a>
                          <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!--FIN DE CONTENIDO DE MODAL-->




                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <?php
      include("../include/footer.php");
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
  <!-- bootstrap-progressbar -->
  <script src="../Gentella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <!-- iCheck -->
  <script src="../Gentella/vendors/iCheck/icheck.min.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="../Gentella/vendors/moment/min/moment.min.js"></script>
  <script src="../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap-wysiwyg -->
  <script src="../Gentella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
  <script src="../Gentella/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
  <script src="../Gentella/vendors/google-code-prettify/src/prettify.js"></script>
  <!-- jQuery Tags Input -->
  <script src="../Gentella/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
  <!-- Switchery -->
  <script src="../Gentella/vendors/switchery/dist/switchery.min.js"></script>
  <!-- Select2 -->
  <script src="../Gentella/vendors/select2/dist/js/select2.full.min.js"></script>
  <!-- Parsley -->
  <script src="../Gentella/vendors/parsleyjs/dist/parsley.min.js"></script>
  <!-- Autosize -->
  <script src="../../Gentella/vendors/autosize/dist/autosize.min.js"></script>
  <!-- jQuery autocomplete -->
  <script src="../Gentella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
  <!-- starrr -->
  <script src="../Gentella/vendors/starrr/dist/starrr.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="../Gentella/build/js/custom.min.js"></script>


  <!--prueba tabla-->

  <script src="../include/tabla/jquery.dataTables.min.js"></script>
  <script src="../include/tabla/dataTables.bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        "language": {
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

    });
  </script>
  <!--script para obtener los modulos dependiendo de la carrera que seleccione-->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#carrera_m').change(function() {
        recargarlista();
      });
    })
  </script>
  <script type="text/javascript">
    function recargarlista() {
      $.ajax({
        type: "POST",
        url: "operaciones/obtener_modulos.php",
        data: "id_carrera=" + $('#carrera_m').val(),
        success: function(r) {
          $('#modulo').html(r);
        }
      });
    }
  </script>

  <?php mysqli_close($conexion); ?>
</body>

</html>
<?php }