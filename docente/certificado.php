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
                    <h2 align="center">Certificado de Estudios</h2>
                    <button class="btn btn-success" data-toggle="modal" data-target=".registrar"><i class="fa fa-plus-square"></i> Nuevo </button>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Encargado</th>
                          <th>DNI</th>
                          <th>Apellidos y Nombres</th>
                          <th>Programa de Estudios</th>
                          <th>Fecha Emisión</th>
                          <th>N° Comprobante</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $ejec_busc_est = buscarAllCertificados($conexion); 
                          while ($res_busc_est=mysqli_fetch_array($ejec_busc_est)){
                        ?>
                        <tr>
                          <td><?php echo $res_busc_est['nombre_usuario']; ?></td>
                          <td><?php echo $res_busc_est['dni_estudiante']; ?></td>
                          <td><?php echo $res_busc_est['apellidos_nombres']; ?></td>
                          <td><?php echo $res_busc_est['programa_estudio']; ?></td>
                          <td><?php echo $res_busc_est['fecha_emision']; ?></td>
                          <td><?php echo $res_busc_est['num_comprobante']; ?></td>
                          <td>
                          <a title="Ver PDF" class="btn btn-success" href="<?php echo $res_busc_est['ruta_documento']; ?>" target="_blank"><i class="fa fa-file"></i></a></td>
                        </tr>  
                        <?php
                          
                          };
                        ?>
                      </tbody>
                    </table>
                    

                    <!--MODAL REGISTRAR-->
  <div class="modal fade registrar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel" align="center">Registrar Certificado de Estudios</h4>
            </div>
            <div class="modal-body">
              <!--INICIO CONTENIDO DE MODAL-->
              <div class="x_panel">

                <div class="" align="center">
                <h2></h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                <form role="form" id="certificadoForm" action="imprimir_certificado_estudios.php" class="form-horizontal form-label-left input_mask" method="POST">
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">DNI Estudiante : </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="dni" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        <br>
                        </div>
                        </div>
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">N° de Comprobante : </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="comprobante" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        <br>
                    </div>
                    </div>

            
                    <div align="center">
                    <button type="submit" class="btn btn-primary" name="rechazar" onclick="setFormAction('imprimir_certificado_estudios.php')">Generar en Formato del Anexo 1A</button>
                    <button type="submit" class="btn btn-primary" name="aceptar" onclick="setFormAction('imprimir_certificado_estudios_personalizado.php')">Generar en Formato Personalizado</button>
                  <br><br>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>  
                  </div>
                </form>
                </div>
                </div>
              <!--FIN DE CONTENIDO DE MODAL-->
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL REGISTRAR-->

<!--MODAL REGISTRAR ACTUAL-->
<div class="modal fade registrar_actual" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel" align="center">Registrar Certificado de Estudios</h4>
            </div>
            <div class="modal-body">
              <!--INICIO CONTENIDO DE MODAL-->
              <div class="x_panel">

                <div class="" align="center">
                <h2></h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <br />
                <form role="form" action="imprimir_certificado_estudios_nuevo.php" class="form-horizontal form-label-left input_mask" method="POST">
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">DNI Estudiante : </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="dni" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        <br>
                        </div>
                        </div>
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">N° de Comprobante : </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="comprobante" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                        <br>
                    </div>
                    </div>

            
                    <div align="center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

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

<!-- FIN MODAL REGISTRAR ACTUAL-->


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
      function setFormAction(action) {
          document.getElementById('certificadoForm').action = action;
      }
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
      },
      "order": [4, 'desc']
    });

    } );
    </script>
     <?php mysqli_close($conexion); ?>
  </body>
</html>
<?php
}
