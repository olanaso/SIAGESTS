<?php
  include "../include/conexion.php";
  include "../include/busquedas.php";

  $res_procesos = buscarProcesosActivos($conexion);
  $contador = mysqli_num_rows($res_procesos);
  if ($contador === 0) {
    echo "<script>
                  alert('No hay procesos de admisión activos en este momento!');
                  window.history.back();
              </script>";
  }else {
  $res_medios_pago = buscarTodosMetodosPago($conexion);
  $res_programas = buscarCarreras($conexion);
  $res_modalidades = buscarTodasModalidades($conexion);
  $res_regiones = obtenerRegiones($conexion);

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="es-ES">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>Inscripciones <?php include ("../include/header_title.php"); ?></title>
   
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
    <!-- Script obtenido desde CDN jquery -->
    <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>

    <style>
        .custom-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;

        }

        .custom-card {
            background-color: #fff;
            border-top: 8px solid #ff9900;
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        .custom-card-title {
            font-size: 16px;
            font-weight: bold;
            font-family: sans-serif;
            margin-bottom: 10px;
        }

        .custom-card-text {
            color: #666;
            font-size: 12px;
            line-height: 1.5;
        }

        .card {
        background-color: #fff;
        padding: 20px;
        max-width: 600px;
        width: 100%;
        border: 1px solid #ddd;
        border-top: none;

    }

    .card-content {
        text-align: center;
    }

    .card-title {
        margin-bottom: 20px;
        font-size: 24px;
    }

    .image-container {
        width: 200px;
        height: 280px;
        margin: 0 auto;
        overflow: hidden;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .image-container img {
        max-width: 100%;
        max-height: 100%;
        display: block;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 8px 12px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
    }

    .card-content input[type="file"] {
        display: none;
    }
    body{
        height: 100vh;
    }

    </style>

</head>

<body>
    <div class="container body">
        <div class="main_container">
            <div class="right_col main" role="main">
                <div class="">
                    <div class="">
                        <div class="x_panel" align="center">
                            <div class="">
                                <h2><b>Formulario de Inscripción</b></h2>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- Div en el centro de la página -->
                <form action="operaciones/guardar_inscripcion.php" method="POST" enctype="multipart/form-data">
                    <div  class="x_panel paso" id="paso1">
                        <h4><b>Información del Postulante</b></h4> <hr>
                        <div class="row">
                            <div class="col-md-4 col-sm-5 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="custom-container">
                                            <div class="custom-card">
                                                <p class="custom-card-title">Fotografia</p>
                                                <div class="custom-card-content">
                                                    <p class="custom-card-text">La foto del postulante tiene que contar con fondo blanco y con la mirada al frente. Procure que la imagen encage en el cuadro de abajo.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <center>
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="image-container">
                                                    <img id="carnet-image" src="utils/carnet_default.png" alt="Carnet Image">
                                                </div>
                                                <input type="file" name="fotografia" id="upload" accept="image/*" onchange="loadImage(event)">
                                                <label for="upload" class="custom-file-upload">Seleccionar imagen</label>
                                            </div>
                                        </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-7 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label ">D.N.I. *: </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="dni" required="required" >
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label">Apellido Paterno *:
                                            </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="paterno" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label ">Apellido Materno *: </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="materno" required="required" >
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label">Nombres *:
                                            </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="nombres" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label ">Género *: </label>
                                            <div class="">
                                                <div class="row">
                                                    <label class="col-md-6">
                                                            <input type="radio" name="genero" value="0">
                                                            M
                                                        </label>
                                                        
                                                        <label class="col-md-6" >
                                                            <input type="radio" name="genero" value="1">
                                                            F
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label">Estado Civil *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="" name="est_civil" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Soltero/a"  >Soltero/a</option>
                                                    <option value="Casado/a"  >Casado/a</option>
                                                    <option value="Divorciado/a"  >Divorciado/a</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label ">Fecha de Nacimiento *: </label>
                                            <div class="">
                                                <input type="date" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento" required="required" >
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label">Lengua Materna *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="" name="len_materna" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Castellano"  >Castellano</option>
                                                    <option value="Quechua"  >Quechua</option>
                                                    <option value="Aymara"  >Aymara</option>
                                                    <option value="Ingles"  >Ingles</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label ">Es Discapacidado? *: </label>
                                            <div class="">
                                                <div class="row">
                                                    <label class="col-md-6">
                                                            <input type="radio" name="discapacidad" value="1">
                                                            Si
                                                        </label>
                                                        
                                                        <label class="col-md-6" >
                                                            <input type="radio" name="discapacidad" value="0">
                                                            No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label">Tipo de Discapacidad *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="" name="tipo_discapacidad" value="">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Física"> Física</option>
                                                    <option value="Visual"> Visual</option>
                                                    <option value="Auditiva"> Auditiva</option>
                                                    <option value="Intelectual"> Intelectual</option>
                                                    <option value="Mental"> Mental</option>
                                                    <option value="Sensorial"> Sensorial</option>
                                                    <option value="Cognitiva"> Cognitiva</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label ">Correo Electrónico *: </label>
                                            <div class="">
                                                <input type="email" class="form-control" name="correo" required="required" >
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-3 col-sm-6 col-xs-12">
                                            <label class="control-label">Número de Celular *:
                                            </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="celular" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-9 col-sm-12 col-xs-12">
                                            <label class="control-label ">Dirección Actual *: </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="direccion" required="required" >
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="" id="padres" style="display: none;">
                                    <div class="x_content">
                                        <h4><b>  Información de Apoderado</b></h4>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label ">D.N.I. *: </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="ap_dni">
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label">Apellidos *:
                                            </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="ap_apellidos" >
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label">Nombres *:
                                            </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="ap_nombres">
                                            </div>
                                        </div>
                                        <div class="form-group form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label">Número de Celular *:
                                            </label>
                                            <div class="">
                                                <input type="text" class="form-control" name="ap_celular" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class ="row">
                            <div align="right"><button class="btn btn-primary" onclick="siguientePaso()">Siguiente</button></div>
                        </div>
                    </div>
                    <!-- Div en el centro de la página -->
                    <div  class="x_panel paso" id="paso3" style="display: none;">
                        <h4><b>Información de Colegio y Procedencia</b></h4> <hr>
                        <div class="row">
                            <div class="col-md-4 col-sm-5 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="custom-container">
                                            <div class="custom-card">
                                                <p class="custom-card-title">Educación</p>
                                                <div class="custom-card-content">
                                                    <p class="custom-card-text">Recuerde que debe de contar con su certificado de estudios original y que la información proporcionada sea válida.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-7 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label ">Region *: </label>
                                            <div class="">
                                                <select class="form-control" id="region" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <?php while($region = mysqli_fetch_array($res_regiones)) {?>
                                                    <option value="<?php echo $region['Departamento'] ?>"><?php echo $region['Departamento'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label">Provincia *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="provincia" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label ">Distrito *: </label>
                                            <div class="">
                                                <select class="form-control" id="distrito" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label ">Colegio *: </label>
                                            <div class="">
                                                <select class="form-control" id="colegio" name="colegio" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label">Tipo Institución *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="" name="tipo_colegio" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Pública - Basica Regular">Pública - Basica Regular</option>
                                                    <option value="Pública - Basica Alternativa">Pública - Basica Alternativa</option>
                                                    <option value="Privada - Basica Regular">Privada - Basica Regular</option>
                                                    <option value="Privada - Basica Alternativa">Privada - Basica Alternativa</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                            <label class="control-label "> Año Egreso </label>
                                            <div class="">
                                                <input type="number" class="form-control" name="anio_egreso" required="required" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class ="row">
                            <div class="col-md-6 col-sm-6 col-xs-6" align="left"><button class="btn" onclick="retrocederPaso()">Retroceder</button></div>
                            <div class="col-md-6 col-sm-6 col-xs-6" align="right"><button class="btn btn-primary" onclick="siguientePaso()">Siguiente</button></div>
                        </div>
                    </div>
                    <!-- Div en el centro de la página -->
                    <div class="x_panel paso" id="paso4" style="display: none;">
                        <h4><b>Modalidad y Programa</b></h4> <hr>
                        <div class="row">
                            <div class="col-md-4 col-sm-5 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="custom-container">
                                            <div class="custom-card">
                                                <p class="custom-card-title">Documentos</p>
                                                <div class="custom-card-content">
                                                    <p class="custom-card-text">Recuerde tener los documentos que son requisitos de la modalidad seleccionada. Esa información fue publicada en el portal de admisión.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-7 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label ">Proceso de Admisión *: </label>
                                            <div class="">
                                                <select class="form-control" id="proceso" name="proceso" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <?php while($procesos = mysqli_fetch_array($res_procesos)) {?>
                                                    <option value="<?php echo $procesos['Id'] ?>"><?php echo  $procesos['Periodo']."  ". $procesos['Tipo'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label">Modalidad *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="modalidad" name="modalidad" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label ">Programa Elegible *: </label>
                                            <div class="">
                                                <select class="form-control" id="programa" name="programa" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <label class="control-label ">Programa - Segunda Opción *: </label>
                                            <div class="">
                                                <select class="form-control" id="" name="segun_opcion" value="">
                                                    <option value="0" disabled selected>Seleccionar</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class ="row">
                            <div class="col-md-6 col-sm-6 col-xs-6" align="left"><button class="btn" onclick="retrocederPaso()">Retroceder</button></div>
                            <div class="col-md-6 col-sm-6 col-xs-6" align="right"><button class="btn btn-primary" onclick="siguientePaso()">Siguiente</button></div>
                        </div>
                    </div>
                    <!-- Div en el centro de la página -->
                    <div class="x_panel paso" id="paso5" style="display: none;">
                        <h4><b>Carga de Requisitos</b></h4> <hr>
                        <div class="row">
                            <div class="col-md-4 col-sm-5 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="form-group form-group col-md-12 col-sm-12 col-xs-12">
                                            <h4><b>Total a pagar <span id="monto_pagar"></span></b></h4>
                                            <label class="control-label">Método de Pago *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="metodo_pago" name="metodo_pago" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <?php while($medios_pago = mysqli_fetch_array($res_medios_pago)){ ?>
                                                    <option value="<?php echo $medios_pago['Id'] ?>"  ><?php echo $medios_pago['Metodo'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br> <br>
                                        <div id="card_pago"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-7 col-xs-12">
                                <div class="">
                                    <div class="x_content" id="requisitos">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class ="row">
                            <div class="col-md-6 col-sm-6 col-xs-6" align="left"><button class="btn" onclick="retrocederPaso()">Retroceder</button></div>
                            <div class="col-md-6 col-sm-6 col-xs-6" align="right"><button class="btn btn-primary" onclick="siguientePaso()">Siguiente</button></div>
                        </div>
                    </div>
                    <!-- Div en el centro de la página -->
                    <div class="x_panel paso" id="paso6" style="display: none;">
                        <h4><b>Finalizar</b></h4> <hr>
                        <div class="row">
                            <div class="col-md-4 col-sm-5 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                        <div class="custom-container">
                                            <div class="custom-card">
                                                <p class="custom-card-title">Recuerde</p>
                                                <div class="custom-card-content">
                                                    <p class="custom-card-text">Revise la información proporcionada, recuerde que la portulación debe de contar con información verídica que sera revisada cuidadosamente.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-7 col-xs-12">
                                <div class="">
                                    <div class="x_content">
                                    <div class="form-group form-group col-md-12 col-sm-12 col-xs-12">
                                            <label class="control-label">Medio de Difusión *:
                                            </label>
                                            <div class="">
                                                <select class="form-control" id="" name="difusion" value="" required="required">
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Radio o Televisión">Radio o Televisión</option>
                                                    <option value="Pagina Web">Pagina Web</option>
                                                    <option value="Redes Sociales">Redes Sociales</option>
                                                    <option value="Familiar o Amigos">Familiar o Amigos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class ="row">
                            <div class="col-md-6 col-sm-6 col-xs-6" align="left"><button class="btn" onclick="retrocederPaso()">Retroceder</button></div>
                            <div class="col-md-6 col-sm-6 col-xs-6" align="right"><button class="btn btn-success" type="submit">Finalizar</button></div>
                        </div>
                    </div>
                </form>
            </div>
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
    <!--script para obtener los modulos dependiendo de la carrera que seleccione-->
    <script type="text/javascript">
      $(document).ready(function(){
        recargarlista();
        recargarListaProgramas();
        recargarListaRequisitos();
        $('#proceso').change(function(){
          recargarlista();
          recargarListaProgramas();
          recargarListaRequisitos();

        });
        $('#modalidad').change(function(){
            recargarListaProgramas();
            recargarListaRequisitos();
            obtenerPrecioModalidad();

        });
        $('#metodo_pago').change(function(){
            recuperarMetodoPago();

        });
        $('#region').change(function(){
            recuperarProvincia();
        });
        $('#provincia').change(function(){
            recuperarDistrito();
        });
        $('#distrito').change(function(){
            recuperarColegio();
        });
      })
    </script>
    <script type="text/javascript">
     function recargarlista(){
      $.ajax({
        type:"POST",
        url:"operaciones/obtener_modalidades.php",
        data:"id_proceso="+ $('#proceso').val(),
          success:function(r){
            $('#modalidad').html(r);
          }
      });
     }
    </script>
    <script type="text/javascript">
     function recargarListaProgramas(){

        var idProceso = $('#proceso').val();
        var idModalidad = $('#modalidad').val();

      $.ajax({
        type:"POST",
        url:"operaciones/obtener_programas.php",
        data: {
            id_proceso: idProceso,
            id_modalidad: idModalidad
        },
          success:function(r){
            $('#programa').html(r);
          }
      });
     }
    </script>

    <script type="text/javascript">
     function obtenerPrecioModalidad(){

        var idProceso = $('#proceso').val();
        var idModalidad = $('#modalidad').val();

      $.ajax({
        type:"POST",
        url:"operaciones/obtener_precio_modalidad.php",
        data: {
            id_modalidad: idModalidad,
            id_proceso: idProceso
        },
          success:function(r){
            $('#monto_pagar').html(r);
          }
      });
     }
    </script>

    <script type="text/javascript">
     function recargarListaRequisitos(){

        var idProceso = $('#proceso').val();
        var idModalidad = $('#modalidad').val();

      $.ajax({
        type:"POST",
        url:"operaciones/obtener_requisitos.php",
        data: {
            id_proceso: idProceso,
            id_modalidad: idModalidad
        },
          success:function(r){
            $('#requisitos').html(r);
          }
      });
     }
    </script>

    <script type="text/javascript">
     function recuperarMetodoPago(){

        var idMetodoPago = $('#metodo_pago').val();

      $.ajax({
        type:"POST",
        url:"operaciones/obtener_metodo_pago.php",
        data: {
            id_metodo: idMetodoPago
        },
          success:function(r){
            $('#card_pago').html(r);
          }
      });
     }
    </script>

    <script type="text/javascript">
     function recuperarProvincia(){

        var region = $('#region').val();

      $.ajax({
        type:"POST",
        url:"operaciones/obtener_provincia.php",
        data: {
            region: region
        },
          success:function(r){
            $('#provincia').html(r);
          }
      });
     }
    </script>

    <script type="text/javascript">
     function recuperarDistrito(){

        var region = $('#region').val();
        var provincia = $('#provincia').val();

      $.ajax({
        type:"POST",
        url:"operaciones/obtener_distrito.php",
        data: {
            region: region,
            provincia: provincia
        },
          success:function(r){
            $('#distrito').html(r);
          }
      });
     }
    </script>

    <script type="text/javascript">
     function recuperarColegio(){

        var provincia = $('#provincia').val();
        var distrito = $('#distrito').val();

      $.ajax({
        type:"POST",
        url:"operaciones/obtener_colegio.php",
        data: {
            distrito: distrito,
            provincia: provincia
        },
          success:function(r){
            $('#colegio').html(r);
          }
      });
     }
    </script>

    <script>
        // JavaScript para mostrar los nombres de los archivos seleccionados
        const inputsArchivo = document.querySelectorAll('.archivo');    
        inputsArchivo.forEach(inputArchivo => {
            inputArchivo.addEventListener('change', function() {
                const nombreArchivo = this.nextElementSibling.querySelector('.nombre-archivo');
                if (this.files.length > 0) {
                    let nombres = Array.from(this.files).map(file => file.name).join(', ');
                    nombreArchivo.textContent = nombres;
                } else {
                    nombreArchivo.textContent = 'Seleccionar archivo';
                }
            });
        });
    </script>

    <script>
        function loadImage(event) {
            var image = document.getElementById('carnet-image');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <script>
            document.getElementById('fecha_nacimiento').addEventListener('change', function() {
                var fechaNacimiento = new Date(this.value);
                var hoy = new Date();
                var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
                var mes = hoy.getMonth() - fechaNacimiento.getMonth();
                
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                    edad--;
                }

                if (edad < 18) {
                    document.getElementById('padres').style.display = 'block';
                } else {
                    document.getElementById('padres').style.display = 'none';
                }
            });
    </script>

    <script>
        function siguientePaso() {
            var pasoActual = document.querySelector('.paso:not([style*="display: none;"])');
            var siguientePaso = pasoActual.nextElementSibling;
            if (siguientePaso) {
                pasoActual.style.display = 'none';
                siguientePaso.style.display = 'block';
                window.scrollTo(0, 0);
            }
        }

        function retrocederPaso() {
            var pasoActual = document.querySelector('.paso:not([style*="display: none;"])');
            var pasoAnterior = pasoActual.previousElementSibling;
            if (pasoAnterior) {
                pasoActual.style.display = 'none';
                pasoAnterior.style.display = 'block';
                window.scrollTo(0, 0);
            }
        }
    </script>
    
    <?php mysqli_close($conexion); ?>
  </body>
</html>
<?php } ?>