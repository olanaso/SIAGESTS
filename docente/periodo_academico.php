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
	  
    <title>Periodos Académicos<?php include ("../include/header_title.php"); ?></title>
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
                    <h2 align="center">Periodos Académicos</h2>
                    <button class="btn btn-success" data-toggle="modal" data-target=".registrar"><i class="fa fa-plus-square"></i> Nuevo</button>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Identificador</th>
                          <th>Periodo Académico</th>
                          <th>Fecha Inicio</th>
                          <th>Fecha Fin</th>
                          <th>Director</th>
                          <th>Fecha Actas</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $ejec_busc_per_acad = buscarPeriodoAcademico($conexion); 
                          while ($res_busc_per_acad=mysqli_fetch_array($ejec_busc_per_acad)){
                            $id_director = $res_busc_per_acad['director'];
                            $busc_direc = buscarDocenteById($conexion, $id_director);
                            $res_busc_direc = mysqli_fetch_array($busc_direc);
                        ?>
                        <tr>
                          <td><?php echo $res_busc_per_acad['id']; ?></td>
                          <td><?php echo $res_busc_per_acad['nombre']; ?></td>
                          <td><?php echo $res_busc_per_acad['fecha_inicio']; ?></td>
                          <td><?php echo $res_busc_per_acad['fecha_fin']; ?></td>
                          <td><?php echo $res_busc_direc['apellidos_nombres']; ?></td>
                          <td><?php echo $res_busc_per_acad['fecha_actas']; ?></td>
                          <td>
                            <button class="btn btn-success" data-toggle="modal" data-target=".edit_<?php echo $res_busc_per_acad['id']; ?>"><i class="fa fa-pencil-square-o"></i> Editar</button></td>
                        </tr>  
                        <?php
                         include('include/acciones_periodo_academico.php');
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
                          <h4 class="modal-title" id="myModalLabel" align="center">Registrar Periodo Academico</h4>
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
                    <form role="form" action="operaciones/registrar_periodo_academico.php" class="form-horizontal form-label-left input_mask" method="POST" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Periodo Académico : </label>
                        <div class="row"> 
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <?php $anio = date("Y")-2; ?>
                          <select class="form-control" name="anio" id="anio" required>
                            <option value=""></option>
                            <?php for ($i=0; $i <= 5; $i++) { ?>
                              <option value="<?php echo $anio+$i; ?>"><?php echo $anio+$i; ?></option>
                            <?php } ?>
                          </select>
                          <br>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <?php $anio = date("Y")-2; ?>
                          <select class="form-control" name="per" id="per" required>
                            <option value=""></option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                          </select>
                          <br>
                        </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Inicio : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" name="fecha_inicio" required="required">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Fin : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" name="fecha_fin" required="required">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Director : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12" >
                          <select class="form-control" id="director" name="director" value="" required="required">
                            <option></option>
                          <?php
                            $busc_dir = buscarDirector_All($conexion);
                            while ($res_busc_dir = mysqli_fetch_array($busc_dir)) {
                              $id_doc = $res_busc_dir['id'];
                              $doc = $res_busc_dir['apellidos_nombres'];
                              ?>
                              <option value="<?php echo $id_doc;
                              ?>"><?php echo $doc; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha para Actas : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" name="fecha_actas" required="required">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Unidades Didácticas a Programar :
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <?php 
                            $b_pe = buscarCarreras($conexion);
                            while ($r_b_pe = mysqli_fetch_array($b_pe)) {
                          ?>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" class="flat" name="pe_<?php echo $r_b_pe['id']; ?>"> <?php echo $r_b_pe['nombre'];  ?>
                            </label>
                          </div>
                          <?php } ?>
                          <br><br>
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
<?php }