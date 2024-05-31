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
              <li class="sub_menu"><a href="calificaciones_unidades_didacticas.php">Unidades Didácticas</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-briefcase"></i> Bolsa Laboral <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="convocatorias_docente.php">Convocatorias</a></li>
            </ul>
          </li>
          <li>
            <a>
              <i class="fa fa-wrench"></i>Soporte<span class="fa fa-chevron-down"></span><span
                class="new-label">Nuevo</span>
            </a>
            <ul class="nav child_menu">
              <li><a href="tickets_docente.php">Tickets </a></li>
              <li><a href="preguntas_frecuentes_docente.php">Preguntas Frecuentes </a></li>
              <li><a href="manuales_videotutoriales_docente.php">Manuales y tutoriales </a>
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
        <?php if ($res_b_u_sesion['cargo_inmutable'] == 2) { ?>
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <?php
              $res_cargo = buscarCargoById($conexion, $res_b_u_sesion['id_cargo']);
              $cargo = mysqli_fetch_array($res_cargo);
              echo $cargo['descripcion']; ?>
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu  pull-right">
              <?php if ($res_b_u_sesion['carga_academica'] == 1 && $res_b_u_sesion['id_cargo'] == 2) {
                $res_cargo = buscarCargoById($conexion, 5);
                $cargo = mysqli_fetch_array($res_cargo);
                ?>
                <li><a href="operaciones/actualizar_cargo.php?cargo=5"><?php echo $cargo['descripcion']; ?></a></li>
              <?php }
              if ($res_b_u_sesion['id_cargo'] == 5) {
                $res_cargo = buscarCargoById($conexion, 2);
                $cargo = mysqli_fetch_array($res_cargo); ?>
                <li><a href="operaciones/actualizar_cargo.php?cargo=2"><?php echo $cargo['descripcion']; ?></a></li>
              <?php } ?>
            </ul>
          </li> <?php } ?>

        <?php if ($res_b_u_sesion['cargo_inmutable'] == 6) { ?>
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <?php
              $res_cargo = buscarCargoById($conexion, $res_b_u_sesion['id_cargo']);
              $cargo = mysqli_fetch_array($res_cargo);
              echo $cargo['descripcion']; ?>
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu  pull-right">
              <?php if ($res_b_u_sesion['carga_academica'] == 1 && $res_b_u_sesion['id_cargo'] == 6) {
                $res_cargo = buscarCargoById($conexion, 5);
                $cargo = mysqli_fetch_array($res_cargo);
                ?>
                <li><a href="operaciones/actualizar_cargo.php?cargo=5"><?php echo $cargo['descripcion']; ?></a></li>
              <?php }
              if ($res_b_u_sesion['id_cargo'] == 5) {
                $res_cargo = buscarCargoById($conexion, 6);
                $cargo = mysqli_fetch_array($res_cargo); ?>
                <li><a href="operaciones/actualizar_cargo.php?cargo=6"><?php echo $cargo['descripcion']; ?></a></li>
              <?php } ?>
            </ul>
          </li> <?php } ?>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->