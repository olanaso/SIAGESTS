<style>
  @media (min-width: 900px) {
    .scroll-view::-webkit-scrollbar {
      width: 1px;
      /* Anchura del scrollbar */
    }

    .scroll-view::-webkit-scrollbar-thumb {
      background-color: #dddddd;
      /* Color del scrollbar */
    }

    .scroll-view {
      max-height: calc(100vh - 50px);
      /* Resta la altura del top navigation si lo tienes */
      overflow-y: auto;
      /* Agrega scroll vertical si el contenido excede la altura máxima */
    }
  }

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

<div class="col-md-3 left_col menu_fixed scroll-view">
  <div class="left_col">
    <!-- <div class="navbar nav_title" style="border: 0;">
      <a href="index.php" class=""><i class=""></i> <span>Biblioteca</span></a>
    </div>-->
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

          <li><a><i class="fa fa-table"></i> Admisión <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="estadisticas.php">Estadísticas</a></li>
              <li><a href="requisitos.php">Requisitos Generales</a></li>
              <li><a href="modalidades.php">Modalidades</a></li>
              <li><a href="medios_pago.php">Medios de Pago</a></li>
              <li><a href="procesos_admision.php">Proceso de Admisión</a></li>
            </ul>
          </li>

          <li><a><i class="fa fa-calendar"></i> Planificacion <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="periodo_academico.php">Periodos Académicos</a></li>
              <li><a href="presente_periodo.php">Datos del Presente Académico</a></li>
              <li><a href="programacion.php">Programación de Clases</a></li>
              <li><a href="anuncio.php">Anuncios <span class="new-label">Nuevo</span></a></li>
              <li><a href="encuesta.php">Encuestas <span class="new-label">Nuevo</span></a></li>
            </ul>
          </li>

          <li><a><i class="fa fa-check-square-o"></i> Matrículas <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="matriculas.php">Registro de Matrícula</a></li>
              <li class="sub_menu"><a href="licencias.php">Licencias</a></li>
            </ul>
          </li>

          <li><a><i class="fa fa-file"></i> Documentos <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="certificado.php">Certificado de estudios</a></li>
              <li class="sub_menu"><a href="boleta_de_notas.php">Boleta de Notas</a></li>
            </ul>
          </li>
          <li><a href="administrativo_docente.php"><i class="fa fa-users"></i> Administrativos y Docentes</a>
          </li>
          <li><a href="estudiante.php"> <i class="fa fa-graduation-cap"></i> Estudiantes</a>
          </li>
          <li><a href="egresados.php"><i class="fa fa-suitcase"></i> Egresados <span class="new-label">Nuevo</span></a>
          </li>
          <li><a><i class="fa fa-book"></i> Evaluación <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li class="sub_menu"><a href="calificaciones_unidades_didacticas.php">Registro de Evaluación</a></li>
            </ul>
          </li>
          <li><a><i class="fa fa-gears"></i>Mantenimiento<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="datos.php">Datos Institucionales</a></li>
              <li><a href="programa_estudio.php">Programas de estudio</a></li>
              <li><a href="modulo_formativo.php">Módulos Formativos</a></li>
              <li><a href="semestre.php">Semestre</a></li>
              <li><a href="unidad_didactica.php">Unidades Didacticas</a></li>
              <li><a href="competencias.php">Competencias</a></li>
              <li><a href="capacidades.php">Capacidades</a></li>
              <li><a href="cargo.php">Cargos</a></li>
              <li><a href="sistema.php">Sistema</a></li>
            </ul>
          </li>
          <li>
            <a>
              <i class="fa fa-wrench"></i>Soporte<span class="fa fa-chevron-down"></span><span class="new-label">Nuevo</span> 
            </a>
            <ul class="nav child_menu">
              <li><a href="tickets.php">Tickets  </a></li>
              <li><a href="preguntas_frecuentes.php">Preguntas Frecuentes  </a></li>
              <li><a href="manuales_videotutoriales.php">Manuales y tutoriales  </a></li>
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
            <li>
              <a href="login/enviar_correo.php"> Cambiar mi contraseña</a>
            </li>
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
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <?php
            $res_cargo = buscarCargoById($conexion, $res_b_u_sesion['id_cargo']);
            $cargo = mysqli_fetch_array($res_cargo);
            echo $cargo['descripcion']; ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu  pull-right">
            <?php if ($res_b_u_sesion['carga_academica'] == 1 || $res_b_u_sesion['id_cargo'] == 2) {
              $res_cargo = buscarCargoById($conexion, 5);
              $cargo = mysqli_fetch_array($res_cargo);
              ?>
              <li><a href="operaciones/actualizar_cargo.php?cargo=5"><?php echo $cargo['descripcion']; ?></a></li>
            <?php }
            if ($res_b_u_sesion['id_cargo'] == 5) { ?>
              <li><a href="operaciones/actualizar_cargo.php?cargo=2"><?php echo $cargo['descripcion']; ?></a></li>
            <?php } ?>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->