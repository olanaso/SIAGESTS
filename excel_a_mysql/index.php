<?php
/**
 * Created by PhpStorm.
 * User: HILARI
 * Date: 02/01/2020
 * Time: 9:45
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Importador de datos Excel a Mysql</title>
</head>

<script src="xlsx.js"></script>
<script src="jquery-1.9.1.js"></script>
<script language="JavaScript">
    var oFileIn;
    //Código JQuery
    $(function() {
        oFileIn = document.getElementById('my_file_input');
        if (oFileIn.addEventListener) {
            oFileIn.addEventListener('change', filePicked, false);
        }
    });

    //Método que hace el proceso de importar excel a html
    function filePicked(oEvent) {
        // Obtener el archivo del input
        var oFile = oEvent.target.files[0];
        var sFilename = oFile.name;
        // Crear un Archivo de Lectura HTML5
        var reader = new FileReader();

        // Leyendo los eventos cuando el archivo ha sido seleccionado
        reader.onload = function(e) {
            var data = e.target.result;
            var cfb = XLS.CFB.read(data, {
                type: 'binary'
            });
            var wb = XLS.parse_xlscfb(cfb);
            // Iterando sobre cada sheet
            wb.SheetNames.forEach(function(sheetName) {
                // Obtener la fila actual como CSV
                var sCSV = XLS.utils.make_csv(wb.Sheets[sheetName]);
                var data = XLS.utils.sheet_to_json(wb.Sheets[sheetName], {
                    header: 1
                });
                $.each(data, function(indexR, valueR) {
                    var sRow = "<tr>";
                    $.each(data[indexR], function(indexC, valueC) {
                        sRow = sRow + "<td>" + valueC + "</td>";
                    });
                    sRow = sRow + "</tr>";
                    $("#my_file_output").append(sRow);
                });
            });
            $("#imgImport"). css("display", "none");
        };


// Llamar al JS Para empezar a leer el archivo .. Se podría retrasar esto si se desea
        reader.readAsBinaryString(oFile);
    }
</script>

<body style="background-color: #c0c0c0">
<div class="container-fluid">
    <center><h2><u>Importador de datos Excel a MySql</u></h2></center>
    <br>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">Importador de datos</div>
                <div class="panel-body">
                    <div class="form-group">
                        <input type="file" id="my_file_input" class="form-control"  accept=".xls, .xlsx"/>
                        <div id="imgImport">
                            <br>
                            <center>
                                <img src="datos.jpg" alt="" width="70%" >
                            </center>
                        </div>
                        <br>
                        <div class="table table-responsive">
                            <table id='my_file_output' border=""
                                   class="table table-bordered table-condensed table-striped"></table>
                        </div>
                        <button id="btn_lectura" class="btn btn-info">Registrar Datos</button>
                        <a href="index.php" class="btn btn-default ">Cancelar</a>
                        <p id="respuesta">

                        </p>
                        <p id="contador">

                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>


<script>
    $('#btn_lectura').click(function () {
        valores=new Array();
        var contador = 0;
        $('#my_file_output tr').each(function () {

            var d1= $(this).find('td').eq(0).html();
            var d2 = $(this).find('td').eq(1).html();
            var d3 = $(this).find('td').eq(2).html();
            var d4 = $(this).find('td').eq(3).html();
            valor=new Array(d1, d2, d3, d4);
            valores.push(valor);
            console.log (valor);
           // alert(valor);
            $.post('insertar.php', {d1:d1, d2:d2, d3:d3, d4:d4}, function (datos) {
                $('#respuesta').html(datos);
            });

            contador = contador + 1;
            $('#contador').html("Se registro "+contador+" registros correctamente.");

        });



    });
</script>
</body>
</html>

