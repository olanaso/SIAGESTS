<?php
include ("../include/conexion.php");
include ("../include/busquedas.php");
include ("../include/funciones.php");

include ("include/verificar_sesion_administrador.php");

if (!verificar_sesion($conexion)) {
  echo "<script>
                alert('Error Usted no cuenta con permiso para acceder a esta página');
                window.location.replace('index.php');
    		</script>";
} else {

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


    <!-- <style>
      .ui-pnotify.dark {
        opacity: 0;
        display: none;
      }

      .dataTables_filter {
        display: none;
      }
    </style> -->

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!--menu-->
        <?php
        include ("include/menu_administrador.php"); ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <div class="container">
                    <h2 align="center">Administrativos y Docentes</h2>
                    <br>
                    <div class="row">
                      <div class="col-lg-3">
                        <div><b>Filtrar Por Cargo: </b></div>
                        <div class="form-group ">
                          <select id="filtro" class="form-control">
                            <option value="">TODOS</option>
                            <?php
                            $ejec_busc_car = buscarCargo($conexion);
                            while ($res__busc_car = mysqli_fetch_array($ejec_busc_car)) {
                              $id_car = $res__busc_car['id'];
                              $cargo = $res__busc_car['descripcion'];
                              ?>
                              <option value="<?php echo $cargo;
                              ?>"><?php echo $cargo; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div><b>Filtrar por Estado: </b></div>
                        <div class="form-group ">
                          <select id="filtro_estado" class="form-control">
                            <option value="">TODOS</option>
                            <option value="SI">ACTIVOS</option>
                            <option value="NO">NO ACTIVOS</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="x_content">
                    <br />

                    <table id="tabla-usuarios" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                          <th>Nro</th>
                          <th>DNI</th>
                          <th>Apellidos y Nombres</th>
                          <th>Cond. Laboral</th>
                          <th>Fecha de Nacimiento</th>
                          <th>Teléfono</th>
                          <th>Correo</th>
                          <th>Cargo</th>
                          <th>Activo</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $contr = 0; 
                          $ejec_busc_doc = buscarDocenteOrdesByApellidosNombres($conexion); 
                          while ($res_busc_doc=mysqli_fetch_array($ejec_busc_doc)){
                            $contr +=1;
                        ?>
                        <tr>
                          <td><?php echo $contr; ?></td>
                          <td><?php echo $res_busc_doc['dni']; ?></td>
                          <td><?php echo $res_busc_doc['apellidos_nombres']; ?></td>
                          <td><?php echo $res_busc_doc['cond_laboral']; ?></td>
                          <td><?php echo $res_busc_doc['fecha_nac']; ?></td>
                          <td><?php echo $res_busc_doc['telefono']; ?></td>
                          <td><?php echo $res_busc_doc['correo']; ?></td>
                          <?php
                            $id_cargo = $res_busc_doc['id_cargo'];
                            $ejec_busc_carg = buscarCargoById($conexion, $id_cargo);
                            $res_busc_carg=mysqli_fetch_array($ejec_busc_carg);
                          ?>
                          <td><?php echo $res_busc_carg['descripcion']; ?></td>
                          <td><?php if ($res_busc_doc['activo']== 0) { echo "NO";}else { echo "SI";} ?></td>
                        </tr>  
                        <?php
                          };
                        ?>

                      </tbody>
                    </table>
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
    <!-- <script>
      $(document).ready(function () {
        var tabla = $('#tabla-usuarios').DataTable({
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
          },
          "order": [1, "desc"],
          "searching": true,
        });

        // Capturar el cambio en el select y realizar la búsqueda
        $('#filtro').on('change', function () {
          var valorSeleccionado = $(this).val(); // Obtener el valor seleccionado del select
          tabla.search(valorSeleccionado).draw(); // Realizar la búsqueda en DataTables y dibujar la tabla
        });

      });
    </script> -->

    <script>
      $(document).ready(function () {
        $('#tabla-usuarios').DataTable({
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
          },

        });

      });
    </script>

    <script>
      $(document).ready(function () {
        var table = $('#tabla-usuarios').DataTable();

        // Custom filter for Programa de Estudios
        $('#filtro').on('change', function () {
          var filtro = $(this).val();
          table.column(7).search(filtro).draw();
        }    
      );
      });
    </script>

    <script>
      $(document).ready(function () {
        var table = $('#tabla-usuarios').DataTable();
        // Filtro por estado
        $('#filtro_estado').on('change', function () {
          var filtro = $(this).val();
          table.column(8).search(filtro).draw();
        }
                
      );
      });
    </script>

    <?php mysqli_close($conexion); ?>
  </body>

  </html>
  <?php
}
