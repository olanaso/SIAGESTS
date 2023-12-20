<?php
include("../include/conexion.php");
include("../include/busquedas.php");
include("../include/funciones.php");
include 'include/verificar_sesion_coordinador.php';
if (!verificar_sesion($conexion)) {
  echo "<script>
                alert('Error Usted no cuenta con permiso para acceder a esta página');
                window.location.replace('index.php');
    		</script>";
}else {
  
  $id_docente_sesion = buscar_docente_sesion($conexion, $_SESSION['id_sesion'], $_SESSION['token']);
  $b_docente = buscarDocenteById($conexion, $id_docente_sesion);
  $r_b_docente = mysqli_fetch_array($b_docente);


  $id_pe = $_POST['car_consolidado'];
  $id_sem = $_POST['sem_consolidado'];

  $per_select = $_SESSION['periodo'];
  $array_estudiantes = [];
  // armar la nomina de estudiantes para poder mostrar todos los estudiantes del semestre
    $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);
    $cont_ud_sem = mysqli_num_rows($b_ud_pe_sem);
    while ($r_b_ud = mysqli_fetch_array($b_ud_pe_sem)) {
      $id_ud = $r_b_ud['id'];
      //buscar si la unidad didactica esta programado en el presente periodo
      $b_ud_prog = buscarProgramacionByUd_Peridodo($conexion, $id_ud, $per_select);
      $r_b_ud_prog = mysqli_fetch_array($b_ud_prog);
      $cont_res = mysqli_num_rows($b_ud_prog);
      if ($cont_res > 0) {
        $id_prog_ud = $r_b_ud_prog['id'];
        //buscar detalle de matricula matriculas a la programacion de la unidad didactica
        $b_det_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog_ud);
        while ($r_b_det_mat = mysqli_fetch_array($b_det_mat)) {
          // buscar matricula para obtener datos del estudiante
          $id_mat = $r_b_det_mat['id_matricula'];
          $b_mat = buscarMatriculaById($conexion, $id_mat);
          $r_b_mat = mysqli_fetch_array($b_mat);
          $id_estudiante = $r_b_mat['id_estudiante'];
          // buscar estudiante
          $b_estudiante = buscarEstudianteById($conexion,$id_estudiante);
          $r_b_estudiante = mysqli_fetch_array($b_estudiante);
          $array_estudiantes[] = $r_b_estudiante['apellidos_nombres'];
        }
        $aa = "SI";
      }else{
        $aa = "NO";
      }
      //echo $r_b_ud['descripcion']." - ".$aa."<br>";
    }
    $n_array_estudiantes = array_unique($array_estudiantes);
    $collator = collator_create("es");
    $collator->sort($n_array_estudiantes);
  
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reportes<?php include ("../include/header_title.php"); ?></title>
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
    <!-- bootstrap-progressbar -->
    <link href="../Gentella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../Gentella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../Gentella/build/css/custom.min.css" rel="stylesheet">

    <style>
      p.verticalll {
        /* idéntico a rotateZ(45deg); */

        writing-mode: vertical-lr;
        transform: rotate(180deg);
        
      }

      .nota_input {
        width: 3em;
      }
    </style>
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
          <?php 
          include ("include/menu_coordinador.php"); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <h2 align="center"><b>Nómina de Matrícula  <?php echo $r_b_ud['descripcion']; ?></b></h2>
            <a href="reportes_coordinador.php" class="btn btn-danger">Regresar</a>
                
                  <div class="table-responsive">
                    <table id="" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th rowspan="2">  
                            <center>Nro Orden</center>
                          </th>
                          <th rowspan="2">
                            <center>DNI</center>
                          </th>
                          <th rowspan="2">
                            <center>APELLIDOS Y NOMBRES</center>
                          </th>
                          <th colspan="<?php echo $cont_ud_sem; ?>">
                            <center>UNIDADES DIDÁCTICAS</center>
                          </th>
                        </tr>
                        <tr>
                          <?php
                          $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);
                          while ($r_bb_ud = mysqli_fetch_array($b_ud_pe_sem)) {
                            $id_udd = $r_bb_ud['id'];
                            //BUSCAR UD
                            $b_uddd = buscarUdById($conexion, $id_udd);
                            $r_b_udd = mysqli_fetch_array($b_uddd);
                            //buscar capacidad
                            $cont_ind_logro_cap_ud = 0;
                            $b_cap_ud = buscarCapacidadesByIdUd($conexion, $id_udd);
                            while ($r_b_cap_ud = mysqli_fetch_array($b_cap_ud)) {
                              $id_cap_ud = $r_b_cap_ud['id'];
                              // buscar indicadores de capacidad
                              $b_ind_l_cap_ud = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id_cap_ud);
                              $cant_id_cap_ud = mysqli_num_rows($b_ind_l_cap_ud);
                              $cont_ind_logro_cap_ud += $cant_id_cap_ud;
                            }
                            
                            ?>
                            <th>
                              <p class="verticalll"><?php echo $r_b_udd['descripcion']; ?></p>
                            </th>
                            <?php
                          }
                          ?>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach($n_array_estudiantes as $key => $val){
                          $key+=1;
                          //buscar estudiante para su id
                          $b_est = buscarEstudianteByApellidosNombres($conexion,$val);
                          $r_b_est = mysqli_fetch_array($b_est);
                          $id_est = $r_b_est['id'];
                          ?>
                          <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $r_b_est['dni']; ?></td>
                            <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                            <?php
                            //buscar si estudiante esta matriculado en una unidad didactica
                            $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);
                            while ($r_bb_ud = mysqli_fetch_array($b_ud_pe_sem)) {
                              $id_udd = $r_bb_ud['id'];
                              $b_prog_ud = buscarProgramacionByUd_Peridodo($conexion, $id_udd, $per_select);
                              $r_b_prog_ud = mysqli_fetch_array($b_prog_ud);
                              $id_prog = $r_b_prog_ud['id'];

                              //buscar matricula de estudiante
                              $b_mat_est = buscarMatriculaByEstudiantePeriodo($conexion, $id_est, $per_select);
                              $r_b_mat_est = mysqli_fetch_array($b_mat_est);
                              $id_mat_est = $r_b_mat_est['id'];
                              //buscar detalle de matricula
                              $b_det_mat_est = buscarDetalleMatriculaByIdMatriculaProgramacion($conexion, $id_mat_est, $id_prog);
                              $r_b_det_mat_est = mysqli_fetch_array($b_det_mat_est);
                              $cont_r_b_det_mat = mysqli_num_rows($b_det_mat_est);
                              $id_det_mat = $r_b_det_mat_est['id'];
                              if ($cont_r_b_det_mat > 0) {
                                echo "<td>SI</td>";

                                



                              }else {
                                
                                echo '<td>NO</td>';
                              }
                              
                            }
                            ?>
                          </tr>
                        <?php
                        }
                        ?>
                        
                      </tbody>
              </table>

            </div>
                      <center><a href="reportes_coordinador.php" class="btn btn-danger">Regresar</a></center>

          
          
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
    <!-- Chart.js -->
    <script src="../Gentella/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../Gentella/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../Gentella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../Gentella/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../Gentella/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../Gentella/vendors/Flot/jquery.flot.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.time.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../Gentella/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../Gentella/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../Gentella/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../Gentella/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../Gentella/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../Gentella/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../Gentella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../Gentella/vendors/moment/min/moment.min.js"></script>
    <script src="../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../Gentella/build/js/custom.min.js"></script>
	 
  </body>
</html>
<?php }