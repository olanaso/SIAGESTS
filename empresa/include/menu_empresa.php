<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="clearfix"></div>

      <!-- menu profile quick info -->
      <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../img/logo.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido</span>
                <h2></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu de Navegación</h3>
                <ul class="nav side-menu">
                  <li><a href="../empresa/"><i class="fa fa-home"></i>Inicio</a>
                  </li>
                  <li><a><i class="fa fa-pencil-square-o"></i> Ofertas Laborales <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class="sub_menu"><a href="convocatoria.php"> Convocatorias </a></li>
                      <li class="sub_menu"><a href="archivado.php"> Archivados</a></li>
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
                    <img src="../img/no-image.jpeg" alt=""> <?php $empresa =   buscarEmpresa($conexion,1); 
                    echo $empresa['razon_social'] ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                      <li><a href="login/enviar_correo.php"> Cambiar mi contraseña</a></li>
                    <li><a href="login/cerrar_sesion_empresa.php"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->