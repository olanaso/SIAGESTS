<?php
include("../include/conexion.php");
include("../include/busquedas.php");
include("../caja/consultas.php");
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
	  
    <title>Programa de Estudio<?php include ("../include/header_title.php"); ?></title>
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
                  <div class="x_content">
                  <div class="">
                    <h2 align="center">Movimiestos</h2>
                  </div>
                    <!-- Tabs -->
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">INGRESOS</a></li>
                    <li><a data-toggle="tab" href="#tab2">EGRESOS</a></li>
                  </ul>
                  <!-- Contenido de los Tabs -->
                  <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active">
                      <br>
                      <button class="btn btn-success" data-toggle="modal" data-target=".registrar"><i class="fa fa-plus-square"></i> Nuevo</button>
                      <br><br>
                      <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>DNI</th>
                            <th>Estudiante</th>
                            <th>Concepto</th>
                            <th>Comprobante</th>
                            <th>Monto Total</th>
                            <th>Fecha Pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $busc_ingr = buscarIngresos($conexion); 
                            while ($ingresos=mysqli_fetch_array($busc_ingr)){
                          ?>
                          <tr>
                            <td><?php echo $ingresos['id']; ?></td>
                            <td><?php echo $ingresos['dni']; ?></td>
                            <td><?php echo $ingresos['estudiante']; ?></td>
                            <td><?php echo $ingresos['concepto']; ?></td>
                            <td><?php echo $ingresos['comprobante']; ?></td>
                            <td><?php echo $ingresos['fecha_pago']; ?></td>
                            <td><?php echo $ingresos['monto_total']; ?></td>
                            <td><?php echo $ingresos['estado_pago']; ?></td>
                            <td>
                              <a href= <?php echo "operaciones/eliminar_concepto_ingreso.php?id=" .  $ingresos['id']?> class="btn btn-danger"><i class="fa fa-ban"></i> Anular</a></td>
                          </tr>  
                          <?php
                          include('include/acciones_concepto_ingreso.php');
                            };
                          ?>

                        </tbody>
                      </table>
                    </div>
                    <div id="tab2" class="tab-pane fade">
                    <br>
                      <button class="btn btn-success" data-toggle="modal" data-target=".registrar_egreso"><i class="fa fa-plus-square"></i> Nuevo</button>
                      <br><br>
                      <table id="exa" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>Concepto</th>
                            <th>Descripcion</th>
                            <th>Comprobante</th>
                            <th>Monto Total</th>
                            <th>Fecha Pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $busc_egr = buscarEgresos($conexion); 
                            while ($egresos=mysqli_fetch_array($busc_egr)){
                          ?>
                          <tr>
                            <td><?php echo $egresos['id']; ?></td>
                            <td><?php echo $egresos['concepto']; ?></td>
                            <td><?php echo $egresos['descripcion']; ?></td>
                            <td><?php echo $egresos['comprobante']; ?></td>
                            <td><?php echo $egresos['fecha_pago']; ?></td>
                            <td><?php echo $egresos['monto_total']; ?></td>
                            <td><?php echo $egresos['estado_pago']; ?></td>
                            <td>
                              <a href= <?php echo "operaciones/eliminar_concepto_ingreso.php?id=" .  $egresos['id']?> class="btn btn-danger"><i class="fa fa-ban"></i> Anular</a></td>
                          </tr>  
                          <?php
                          include('include/acciones_concepto_ingreso.php');
                            };
                          ?>

                        </tbody>
                      </table>
                    </div>
                  </div>

                    <!--MODAL REGISTRAR INGRESOS-->
                <div class="modal fade registrar" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel" align="center">Registrar Nuevo Ingreso</h4>
                        </div>
                        <div class="modal-body">
                          <!--INICIO CONTENIDO DE MODAL-->
                  <div class="x_panel">
                    
                  <div class="" align="center">
                    <h2 ></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form role="form" action="operaciones/registrar_ingreso.php" class="form-horizontal form-label-left input_mask" method="POST" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">D.N.I.: </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" id="dni" name="dni" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Concepto : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" id="concepto" name="concepto" value="" required="required">
                            <option></option>
                          <?php 
                            $res_ci = buscarConceptoIngresos($conexion);
                            while ($ingresos = mysqli_fetch_array($res_ci)) {
                              $id_ci = $ingresos['id'];
                              $concepto = $ingresos['concepto'];
                              ?>
                              <option value="<?php echo $id_ci;
                              ?>"><?php echo $concepto; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Código Comprobante : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="codigo" value="" required="required">
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
                </div>
                          <!--FIN DE CONTENIDO DE MODAL-->
                
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL REGISTRAR-->


        <!--MODAL REGISTRAR EGRESO-->
                    <div class="modal fade registrar_egreso" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel" align="center">Registrar Nuevo Egreso</h4>
                        </div>
                        <div class="modal-body">
                          <!--INICIO CONTENIDO DE MODAL-->
                  <div class="x_panel">
                    
                  <div class="" align="center">
                    <h2 ></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form role="form" action="operaciones/registrar_egreso.php" class="form-horizontal form-label-left input_mask" method="POST" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Concepto : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" id="concepto" name="concepto" value="" required="required">
                            <option></option>
                          <?php 
                            $res_ce = buscarConceptoEgresos($conexion);
                            while ($egresos = mysqli_fetch_array($res_ce)) {
                              $id_ci = $egresos['id'];
                              $concepto = $egresos['concepto'];
                              ?>
                              <option value="<?php echo $id_ci;
                              ?>"><?php echo $concepto; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Código Comprobante : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="codigo" value="" required="required">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Monto a pagar : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="monto" value="" required="required">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripcion : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="descripcion" value="" required="required">
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
                </div>
                          <!--FIN DE CONTENIDO DE MODAL-->
                
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL REGISTRAR-->




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
    <script>
    $(document).ready(function() {
    $('#exa').DataTable({
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
<?php }