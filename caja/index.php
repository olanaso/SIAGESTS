<?php
include("../include/conexion.php");
include("../include/busquedas.php");
include("../include/funciones.php");
include("include/verificar_sesion_caja.php");

if (!verificar_sesion($conexion)) {
    echo "<script>
                alert('Error Usted no cuenta con permiso para acceder a esta página');
                window.location.replace('login/');
    		</script>";
} else {

    $id_docente_sesion = buscar_docente_sesion($conexion, $_SESSION['id_sesion'], $_SESSION['token']);
	$b_docente = buscarDocenteById($conexion, $id_docente_sesion);
    $r_b_docente = mysqli_fetch_array($b_docente);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inicio<?php include("../include/header_title.php"); ?></title>
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
	<!-- Custom Theme Style -->
	<link href="../Gentella/build/css/custom.min.css" rel="stylesheet">
    <style>
        /* Estilos para los inputs con línea inferior */
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group textarea {
            border-top: none;
            border-left: none;
            border-right: none;
            border-radius: 0;
            box-shadow: none;
            background-color: transparent; 
        }
    </style>
</head>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<?php
			include("include/menu_caja.php"); ?>
			<!-- page content -->
			<div class="right_col row">
				<div class="col-md-8 col-sm-7 col-xs-5">
                    <center>
                    <h3>Bienvenido al módulo de Caja</h3>
                    </center>
                </div>
				<div class="col-md-4 col-sm-5 col-xs-7">
				<?php 
					$res_anuncion = buscarAnunciosActivos($conexion);
					$cantidad_anuncio = mysqli_num_rows($res_anuncion);
					$no_tiene_anuncio = true;
					if($cantidad_anuncio != 0){
					while ($anuncio = mysqli_fetch_array($res_anuncion)) {
						$anuncio_cargo = $anuncio['usuarios'];
						$cargos_seleccionados = explode('-', $anuncio_cargo);
						if(in_array($r_b_docente['id_cargo'],$cargos_seleccionados)){
						$no_tiene_anuncio = false;
					?>
						<div class="row">
							<div>
								<div class="x_panel">
									<div class="x_title">
										<div class="">
										<h2>
											<i class="fa fa-bullhorn blue">
											<b><?php echo $anuncio['tipo'] ?></b>
											</i>
										</h2>
										</div class="">
										<ul class="panel_toolbox" style="list-style: none;">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<div class="row">
										<b style="font-size: 14px;color: #37809f;"><?php echo $anuncio['titulo'] ?></b>
										<p style="text-align: justify;
													font-size: 14px;">
													<?php echo $anuncio['descripcion'] ?>
										</p>
										</div >
										<?php if($anuncio['enlace'] !== ""){?>
										<div class="text-right"><a class="btn btn-success" href="<?php echo $anuncio['enlace'] ?>" target="_blank">Ir al enlace</a></div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php } }
					}if($no_tiene_anuncio){
						echo "NO HAY ANUNCIOS PARA MOSTRAR";
					} ?>
				</div>
			</div>
			<?php
			include("../include/footer.php");
			?>
			<!--/footer content -->
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
	<!-- Custom Theme Scripts -->
	<script src="../Gentella/build/js/custom.min.js"></script>
</body>
</html>
<?php } ?>