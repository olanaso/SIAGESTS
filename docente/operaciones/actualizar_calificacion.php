<?php
include "../../include/conexion.php";
include "../../include/busquedas.php";
include "../../include/funciones.php";
include("../include/verificar_sesion_docente_coordinador_secretaria.php");

if (!verificar_sesion($conexion)) {
    echo "<script>
                  alert('Error Usted no cuenta con permiso para acceder a esta página');
                  window.location.replace('../index.php');
              </script>";
} else {

    $id_prog = $_POST['id_prog'];
    $nro_calificacion = $_POST['nro_calificacion'];

    $b_prog = buscarProgramacionById($conexion, $id_prog);
    $res_b_prog = mysqli_fetch_array($b_prog);
    $b_periodo_acad = buscarPeriodoAcadById($conexion, $res_b_prog['id_periodo_acad']);
    $r_per_acad = mysqli_fetch_array($b_periodo_acad);
    $fecha_actual = strtotime(date("d-m-Y"));
    $fecha_fin_per = strtotime($r_per_acad['fecha_fin']);
    if ($fecha_actual <= $fecha_fin_per) {


        $b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
        while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
            $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
            $r_b_mat = mysqli_fetch_array($b_matricula);
            $b_estudiante = buscarEstudianteById($conexion, $r_b_mat['id_estudiante']);
            $r_b_est = mysqli_fetch_array($b_estudiante);

            $b_calificacion = buscarCalificacionByIdDetalleMatricula_nro($conexion, $r_b_det_mat['id'], $nro_calificacion);
            while ($r_b_calificacion = mysqli_fetch_array($b_calificacion)) {
                $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $r_b_calificacion['id']);
                while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
                    $b_criterio_evaluacion = buscarCriterioEvaluacionByEvaluacion($conexion, $r_b_evaluacion['id']);


                    while ($r_b_criterio_evaluacion = mysqli_fetch_array($b_criterio_evaluacion)) {
                        $nota =  $_POST[$r_b_est['dni'] . '_' . $r_b_criterio_evaluacion['id']];
                        if ((is_numeric($nota)) && ($nota >= 0 && $nota <= 20)) {
                            if (($nota >= 0 && $nota < 10) && strlen($nota) == 1) {
                                $calificacion = "0" . $nota;
                            } else {
                                $calificacion = $nota;
                            }
                        } else {
                            $calificacion = "";
                        }
                        $id_crit = $r_b_criterio_evaluacion['id'];
                        $consulta = "UPDATE criterio_evaluacion SET calificacion='$calificacion' WHERE id='$id_crit'";
                        $ejec_consulta = mysqli_query($conexion, $consulta);
                    }
                }
            }
        }
    } else {
        echo "<script>
            alert('Periodo Finalizado, No puede Realizar Cambios');
			window.location= '../evaluacion_b.php?data=" . $id_prog . "&data2=" . $nro_calificacion . "';
		</script>
	";
    }

    echo "<script>
			window.location= '../evaluacion_b.php?data=" . $id_prog . "&data2=" . $nro_calificacion . "';
		</script>
	";
}
