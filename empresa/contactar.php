<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <!-- Datatables -->
    <link href="../Gentella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../Gentella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	<!-- Custom Theme Style -->
	<link href="../Gentella/build/css/custom.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            width: 600px; /* Ancho del contenedor */
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
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
        .container-input {
            text-align: center;
            border: 1px solid #dfdfdf;
            padding: 50px 0;
            border-radius: 6px;
            margin: 0 auto;
            margin-bottom: 20px;
        }
        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        .inputfile + label {
            max-width: 80%;
            font-size: 1.25rem;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: inline-block;
            overflow: hidden;
            padding: 0.625rem 1.25rem;
        }
        .inputfile + label svg {
            width: 1em;
            height: 1em;
            vertical-align: middle;
            fill: currentColor;
            margin-top: -0.25em;
            margin-right: 0.25em;
        }
        .iborrainputfile {
            font-size:16px; 
            font-weight:normal;
        }
        .inputfile-3 + label {
            color: #242424;
        }
        .inputfile-3:focus + label,
        .inputfile-3.has-focus + label,
        .inputfile-3 + label:hover {
            color: blue;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Formulario de registro de empresa con jQuery Steps -->
            <div class="page-title">
                <h1>Quiere publicar sus ofertas laborales con nosotros?</h1>
                <p>Registre a su empresa para que nuestros estudiantes y egresados puedan ser parte de su equipo. Una vez finalizado el registro, espera a que nos contactemos con usted.</p>
                <p>Los campos con *, son campos obligatorios!</p>
            </div>
            <br><br><br><br><br><br>
            <form id="registro_empresa_form" action="operaciones/registrar_empresa.php" method="post" enctype="multipart/form-data">
                <div id="wizard">
                    <h3>Datos de la Empresa</h3>
                    <section>
                        <!-- Campos de datos de la empresa -->
                        <div class="form-group">
                            <label for="nombre_empresa">Nombre de la Empresa*:</label>
                            <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" required>
                        </div>
                        <div class="form-group">
                            <label for="ruc">RUC*:</label>
                            <input type="text" class="form-control" id="ruc" name="ruc" required>
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Ciuadad*:</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label label-align" for="logo"><i class="fa fa-file-pdf-o"></i> Subir Logo:
                            </label>                                                
                            <div class="">
                                <div class="container-input">
                                    <input type="file" name="logo" id="file-3" class="inputfile inputfile-3" data-multiple-caption="{count} archivos seleccionados" multiple  accept=".png, .jpeg, .jpg" />
                                    <label for="file-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                                    <span class="iborrainputfile">Seleccionar archivo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>Datos de Contacto</h3>
                    <section>
                        <!-- Campos de datos de contacto -->
                        <div class="form-group">
                            <label for="contacto">Apellidos y Nombre de Representante*:</label>
                            <input type="text" class="form-control" id="contacto" name="contacto" required>
                        </div>
                        <div class="form-group">
                            <label for="cargo">Cargo:</label>
                            <input type="text" class="form-control" id="cargo" name="cargo">
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo Institucional*:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label for="celular">Telefono - Celular*:</label>
                            <input type="text" class="form-control" id="celular" name="celular" required>
                        </div>
                    </section>
                </div>
                <!-- Botón de enviar formulario -->
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-success">Registrar Empresa</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts de Gentella y otros scripts necesarios (si es necesario) -->
    <!-- Scripts de jQuery y jQuery Steps -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#wizard").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft"
            });
        });
    </script>
    <script>
        'use strict';
        ;( function ( document, window, index )
        {
            var inputs = document.querySelectorAll( '.inputfile' );
            Array.prototype.forEach.call( inputs, function( input )
            {
                var label	 = input.nextElementSibling,
                    labelVal = label.innerHTML;
                input.addEventListener( 'change', function( e )
                {
                    var fileName = '';
                    if( this.files && this.files.length > 1 )
                        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                    else
                        fileName = e.target.value.split( '\\' ).pop();
                    if( fileName )
                        label.querySelector( 'span' ).innerHTML = fileName;
                    else
                        label.innerHTML = labelVal;
                });
            });
        }( document, window, 0 ));
    </script> 
    <!-- Scripts de Gentella y otros scripts necesarios (si es necesario) -->
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
