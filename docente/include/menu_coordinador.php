<style>
  .new-label {
    display: inline-block;
    background-color: green;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    margin-left: 5px;
    font-size: smaller;
  }
</style>

<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">

    <?php
    $busc_user_sesion = buscarDocenteById($conexion, $id_docente_sesion);
    $res_b_u_sesion = mysqli_fetch_array($busc_user_sesion);
    $b_m_per_act = buscarPresentePeriodoAcad($conexion);
    $r_b_m_per_act = mysqli_fetch_array($b_m_per_act);
    $id_per_act_m = $r_b_m_per_act['id_periodo_acad'];
    ?>
    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="../img/logo.png" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Bienvenido,</span>
        <h2><?php echo $res_b_u_sesion['apellidos_nombres']; ?></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Menú de Navegación</h3>
        <ul class="nav side-menu">
          <li><a href="../docente/"><i class="fa fa-home"></i>Inicio</a>
          </li>
          <li><a><i class="fa fa-pencil-square-o"></i> Unidades Didácticas <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="calificaciones_unidades_didacticas.php">Mis Unidades Didácticas</a></li>
              <li class="sub_menu"><a href="pe_calificaciones_unidades_didacticas.php">Todas las Unidades Didácticas</a>
              </li>
            </ul>
          </li>
          <li><a href="reportes_coordinador.php"><i class="fa fa-bar-chart"></i> Reportes</a>
          </li>
          <li>
            <a>
              <i class="fa fa-wrench"></i>Soporte<span class="fa fa-chevron-down"></span><span
                class="new-label">Nuevo</span>
            </a>
            <ul class="nav child_menu">
              <li><a href="tickets_coordinador.php">Tickets </a></li>
              <li><a href="preguntas_frecuentes_coordinador.php">Preguntas Frecuentes </a>
              </li>
              <li><a href="manuales_videotutoriales_coordinador.php">Manuales y tutoriales </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="../img/no-image.jpeg" alt=""><?php echo $res_b_u_sesion['apellidos_nombres']; ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="mi_perfil.php"> Mi perfil <span class="new-label">Nuevo</span></a></li>
            <li><a href="login/enviar_correo.php"> Cambiar mi contraseña</a></li>
            <li><a href="../include/cerrar_sesion.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
          </ul>
        </li>
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <?php
            $busc_per_id = buscarPeriodoAcadById($conexion, $_SESSION['periodo']);
            $res_busc_per_id = mysqli_fetch_array($busc_per_id);
            echo $res_busc_per_id['nombre']; ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <?php
            $buscar_periodos = buscarPeriodoAcademicoInvert($conexion);
            while ($res_busc_periodos = mysqli_fetch_array($buscar_periodos)) {
              ?>
              <li><a href="operaciones/actualizar_sesion_periodo.php?dato=<?php echo $res_busc_periodos['id']; ?>"><?php if ($res_busc_periodos['id'] == $id_per_act_m) {
                   echo "<b>";
                 } ?><?php echo $res_busc_periodos['nombre']; ?><?php if ($res_busc_periodos['id'] == $id_per_act_m) {
                       echo "</b>";
                     } ?></a>
              </li>
              <?php
            }
            ?>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->