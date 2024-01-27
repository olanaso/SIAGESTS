<?php
// -------------------  FUNCIONES BUSCAR ------------------------------
function buscarDatosGenerales($conexion){
	$sql = "SELECT * FROM datos_institucionales WHERE id=1";
	return mysqli_query($conexion, $sql);
}
function buscarDatosSistema($conexion){
	$sql = "SELECT * FROM sistema WHERE id=1";
	return mysqli_query($conexion, $sql);
}
function buscarPresentePeriodoAcad($conexion){
	$sql = "SELECT * FROM presente_periodo_acad ORDER BY id LIMIT 1";
	return mysqli_query($conexion, $sql);
}
function buscarPeriodoAcademico($conexion){
	$sql = "SELECT * FROM periodo_academico";
	return mysqli_query($conexion, $sql);
}
function buscarPeriodoAcademicoInvert($conexion){
	$sql = "SELECT * FROM periodo_academico ORDER BY id DESC";
	return mysqli_query($conexion, $sql);
}
function buscarPeriodoAcadById($conexion, $id){
	$sql = "SELECT * FROM periodo_academico WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarEstudiante($conexion){
	$sql = "SELECT * FROM estudiante";
	return mysqli_query($conexion, $sql);
}
function buscarEstudianteById($conexion,$id){
	$sql = "SELECT * FROM estudiante WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarEstudianteByDni($conexion,$dni){
	$sql = "SELECT * FROM estudiante WHERE dni='$dni'";
	return mysqli_query($conexion, $sql);
}
function buscarEstudianteByDniPe($conexion,$pe,$dni){
	$sql = "SELECT * FROM estudiante WHERE dni='$dni' AND id_programa_estudios='$pe'";
	return mysqli_query($conexion, $sql);
}
function buscarEstudianteByApellidosNombres($conexion,$dato){
	$sql = "SELECT * FROM estudiante WHERE apellidos_nombres='$dato'";
	return mysqli_query($conexion, $sql);
}
function buscarEstudianteByApellidosNombres_like($conexion,$pe,$dato){
	$sql = "SELECT * FROM estudiante WHERE apellidos_nombres LIKE '%$dato%' AND id_programa_estudios='$pe'";
	return mysqli_query($conexion, $sql);
}
function buscarDocente($conexion){
	$sql = "SELECT * FROM docente";
	return mysqli_query($conexion, $sql);
}
function buscarDocenteOrdesByApellidosNombres($conexion){
	$sql = "SELECT * FROM docente ORDER BY apellidos_nombres";
	return mysqli_query($conexion, $sql);
}
function buscarDocenteById($conexion, $id){
	$sql = "SELECT * FROM docente WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarDocenteByDni($conexion, $dni){
	$sql = "SELECT * FROM docente WHERE dni='$dni'";
	return mysqli_query($conexion, $sql);
}
function buscarDocentesByIdPe($conexion, $id_pe){
	$sql = "SELECT * FROM docente WHERE id_programa_estudio='$id_pe' AND activo='1'";
	return mysqli_query($conexion, $sql);
}
function buscarCoordinadorAreaByIdPe($conexion, $id_pe){
	$sql = "SELECT * FROM docente WHERE id_programa_estudio='$id_pe' AND id_cargo='4' AND activo='1'";
	return mysqli_query($conexion, $sql);
}
function buscarCoordinadorArea_All($conexion){
	$sql = "SELECT * FROM docente WHERE id_cargo='4' AND activo='1'";
	return mysqli_query($conexion, $sql);
}
function buscarDirector_All($conexion){
	$sql = "SELECT * FROM docente WHERE id_cargo='1' AND activo='1'";
	return mysqli_query($conexion, $sql);
}




function buscarCarreras($conexion){
	$sql = "SELECT * FROM programa_estudios";
	return mysqli_query($conexion, $sql);
}
function buscarCarrerasById($conexion, $id){
	$sql = "SELECT * FROM programa_estudios WHERE id=$id";
	return mysqli_query($conexion, $sql);
}

function buscarSemestre($conexion){
	$sql = "SELECT * FROM semestre";
	return mysqli_query($conexion, $sql);
}
function buscarSemestreById($conexion, $id){
	$sql = "SELECT * FROM semestre WHERE id=$id";
	return mysqli_query($conexion, $sql);
}
function buscarUdByCarSem($conexion, $idCarrera, $idSemestre){
	$sql = "SELECT * FROM unidad_didactica WHERE id_programa_estudio = '$idCarrera' AND id_semestre= '$idSemestre' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarUdByModSem($conexion, $idModulo, $idSemestre){
	$sql = "SELECT * FROM unidad_didactica WHERE id_modulo = '$idModulo' AND id_semestre= '$idSemestre' ORDER BY id";
	return mysqli_query($conexion, $sql);
}

function buscarUnidadDidactica($conexion){
	$sql = "SELECT * FROM unidad_didactica";
	return mysqli_query($conexion, $sql);
}
function buscarUdById($conexion, $id){
	$sql = "SELECT * FROM unidad_didactica WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarUdByIdModulo($conexion, $id){
	$sql = "SELECT * FROM unidad_didactica WHERE id_modulo='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarModuloFormativo($conexion){
	$sql = "SELECT * FROM modulo_profesional";
	return mysqli_query($conexion, $sql);
}
function buscarModuloFormativoById($conexion, $id){
	$sql = "SELECT * FROM modulo_profesional WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarModuloFormativoByIdCarrera($conexion, $id){
	$sql = "SELECT * FROM modulo_profesional WHERE id_programa_estudio = '$id' ORDER BY id";
	return mysqli_query($conexion, $sql);
}


function buscarMatricula($conexion){
	$sql = "SELECT * FROM matricula";
	return mysqli_query($conexion, $sql);
}
function buscarMatriculaById($conexion, $id){
	$sql = "SELECT * FROM matricula WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarMatriculaByIdPeriodo($conexion, $id){
	$sql = "SELECT * FROM matricula WHERE id_periodo_acad='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarMatriculaByIdPeriodoCarrera($conexion, $id_per, $id_pe){
	$sql = "SELECT * FROM matricula WHERE id_periodo_acad='$id_per' AND id_programa_estudio = '$id_pe'";
	return mysqli_query($conexion, $sql);
}
function buscarMatriculaByIdPeriodoCarreraSem($conexion, $id_per, $id_pe, $id_sem){
	$sql = "SELECT * FROM matricula WHERE id_periodo_acad='$id_per' AND id_programa_estudio = '$id_pe' AND id_semestre = '$id_sem'";
	return mysqli_query($conexion, $sql);
}
function buscarMatriculaByEstudiantePeriodo($conexion, $id_estudiante, $id_periodo_acad){
	$sql = "SELECT * FROM matricula WHERE id_estudiante='$id_estudiante' AND id_periodo_acad = '$id_periodo_acad'";
	return mysqli_query($conexion, $sql);
}
function buscarDetalleMatriculaById($conexion, $id){
	$sql = "SELECT * FROM detalle_matricula_unidad_didactica WHERE id = '$id'";
	return mysqli_query($conexion, $sql);
}
function buscarDetalleMatriculaByIdMatricula($conexion, $id){
	$sql = "SELECT * FROM detalle_matricula_unidad_didactica WHERE id_matricula = '$id'";
	return mysqli_query($conexion, $sql);
}
function buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog){
	$sql = "SELECT * FROM detalle_matricula_unidad_didactica WHERE id_programacion_ud = '$id_prog' ORDER BY orden";
	return mysqli_query($conexion, $sql);
}
function buscarDetalleMatriculaByIdMatriculaProgramacion($conexion, $id_mat, $id_prog){
	$sql = "SELECT * FROM detalle_matricula_unidad_didactica WHERE id_matricula = '$id_mat' AND id_programacion_ud='$id_prog'";
	return mysqli_query($conexion, $sql);
}



function buscarMatriculaByIdPeriodoSinLicencia($conexion, $id){
	$sql = "SELECT * FROM matricula WHERE id_periodo_acad='$id' AND licencia =''";
	return mysqli_query($conexion, $sql);
}
function buscarLicenciaPeriodo($conexion, $id_periodo_acad){
	$sql = "SELECT * FROM matricula WHERE id_periodo_acad = '$id_periodo_acad' AND licencia !=''";
	return mysqli_query($conexion, $sql);
}



function buscarCalificacionById($conexion, $id){
	$sql = "SELECT * FROM calificaciones WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCalificacionByIdDetalleMatricula($conexion, $id_detalle){
	$sql = "SELECT * FROM calificaciones WHERE id_detalle_matricula = '$id_detalle' ORDER BY nro_calificacion";
	return mysqli_query($conexion, $sql);
}
function buscarCalificacionByIdDetalleMatricula_nro($conexion, $id_detalle, $nro_calificacion){
	$sql = "SELECT * FROM calificaciones WHERE id_detalle_matricula = '$id_detalle' AND nro_calificacion='$nro_calificacion'";
	return mysqli_query($conexion, $sql);
}
function buscarEvaluacionById($conexion, $id){
	$sql = "SELECT * FROM evaluacion WHERE id = '$id'";
	return mysqli_query($conexion, $sql);
}
function buscarEvaluacionByIdCalificacion($conexion, $id){
	$sql = "SELECT * FROM evaluacion WHERE id_calificacion = '$id' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarEvaluacionByIdCalificacion_detalle($conexion, $id, $detalle){
	$sql = "SELECT * FROM evaluacion WHERE id_calificacion = '$id' AND detalle='$detalle' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarCriterioEvaluacionByEvaluacion($conexion, $id){
	$sql = "SELECT * FROM criterio_evaluacion WHERE id_evaluacion = '$id' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarCriterioEvaluacionByEvaluacionOrden($conexion, $id, $orden){
	$sql = "SELECT * FROM criterio_evaluacion WHERE id_evaluacion = '$id' AND orden='$orden' ORDER BY id";
	return mysqli_query($conexion, $sql);
}


function buscarProgramacion($conexion){
	$sql = "SELECT * FROM programacion_unidad_didactica";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionEspecial($conexion, $extra){
	$sql = "SELECT * FROM programacion_unidad_didactica ".$extra;
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionById($conexion, $id){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByIdDocente($conexion, $id){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_docente='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByIdPeriodo($conexion, $id){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_periodo_acad='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByIdDocentePeriodo($conexion, $id_docente, $id_periodo){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_docente='$id_docente' AND id_periodo_acad='$id_periodo'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByUd_Peridodo($conexion, $id_ud, $periodo){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_unidad_didactica='$id_ud' AND id_periodo_acad='$periodo'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByUdDocentePeriodo($conexion, $ud, $docente, $periodo){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_unidad_didactica='$ud' AND id_docente='$docente' AND id_periodo_acad='$periodo'";
	return mysqli_query($conexion, $sql);
}
function buscarCargo($conexion){
	$sql = "SELECT * FROM cargo";
	return mysqli_query($conexion, $sql);
}
function buscarCargoById($conexion, $id){
	$sql = "SELECT * FROM cargo WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarGenero($conexion){
	$sql = "SELECT * FROM genero";
	return mysqli_query($conexion, $sql);
}

function buscarCompetencias($conexion){
	$sql = "SELECT * FROM competencias";
	return mysqli_query($conexion, $sql);
}
function buscarCompetenciasById($conexion, $id){
	$sql = "SELECT * FROM competencias WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCompetenciasByIdModulo($conexion, $id){
	$sql = "SELECT * FROM competencias WHERE id_modulo_formativo='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCompetenciasEspecialidadByIdModulo($conexion, $id){
	$sql = "SELECT * FROM competencias WHERE id_modulo_formativo='$id' AND tipo_competencia='ESPECÍFICA'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCompetenciasById($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_competencia WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCompetenciasByIdCompetencia($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_competencia WHERE id_competencia='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarCapacidades($conexion){
	$sql = "SELECT * FROM capacidades";
	return mysqli_query($conexion, $sql);
}
function buscarCapacidadesById($conexion, $id){
	$sql = "SELECT * FROM capacidades WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCapacidadesByIdUd($conexion, $id){
	$sql = "SELECT * FROM capacidades WHERE id_unidad_didactica='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCapacidadById($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_capacidad WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_capacidad WHERE id_capacidad='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarSilaboById($conexion, $id){
	$sql = "SELECT * FROM silabo WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarSilaboByIdProgramacion($conexion, $id){
	$sql = "SELECT * FROM silabo WHERE id_programacion_unidad_didactica='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarProgActividadesSilaboById($conexion, $id){
	$sql = "SELECT * FROM programacion_actividades_silabo WHERE id='$id' ORDER BY semana";
	return mysqli_query($conexion, $sql);
}
function buscarProgActividadesSilaboByIdSilabo($conexion, $id){
	$sql = "SELECT * FROM programacion_actividades_silabo WHERE id_silabo='$id' ORDER BY semana";
	return mysqli_query($conexion, $sql);
}
function buscarProgActividadesSilaboByIdSilabo_16($conexion, $id){
	$sql = "SELECT * FROM programacion_actividades_silabo WHERE id_silabo='$id' ORDER BY semana LIMIT 16";
	return mysqli_query($conexion, $sql);
}
function buscarProgActividadesSilaboByIdSilaboAndSemana($conexion, $idSilabo, $semana){
	$sql = "SELECT * FROM programacion_actividades_silabo WHERE id_silabo='$idSilabo' AND semana='$semana'";
	return mysqli_query($conexion, $sql);
}

function buscarSesionById($conexion, $id){
	$sql = "SELECT * FROM sesion_aprendizaje WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarSesionByIdProgramacionActividades($conexion, $id){
	$sql = "SELECT * FROM sesion_aprendizaje WHERE id_programacion_actividad_silabo='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarMomentosSesionByIdSesion($conexion, $id){
	$sql = "SELECT * FROM momentos_sesion_aprendizaje WHERE id_sesion_aprendizaje='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarActividadesEvaluacionByIdSesion($conexion, $id){
	$sql = "SELECT * FROM actividad_evaluacion_sesion_aprendizaje WHERE id_sesion_aprendizaje='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarAsistenciaBySesionAndEstudiante($conexion, $id, $estudiante){
	$sql = "SELECT * FROM asistencia WHERE id_sesion_aprendizaje='$id' AND id_estudiante='$estudiante'";
	return mysqli_query($conexion, $sql);
}
function buscarAsistenciaByIdSesion($conexion, $id){
	$sql = "SELECT * FROM asistencia WHERE id_sesion_aprendizaje='$id'";
	return mysqli_query($conexion, $sql);
}



/// buscar sesion

function buscarSesionLoginById($conexion, $id){
	$sql = "SELECT * FROM sesion WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarSesionEstudianteLoginById($conexion, $id){
	$sql = "SELECT * FROM sesion_estudiante WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}


////TUTORIA
function buscarTutoriaByIdDocenteAndIdPeriodo($conexion, $id_docente, $id_periodo_acad){
	$sql = "SELECT * FROM tutoria WHERE id_docente='$id_docente' AND id_periodo_acad='$id_periodo_acad'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaByIdAndIdPeriodo($conexion, $id, $id_periodo_acad){
	$sql = "SELECT * FROM tutoria WHERE id='$id' AND id_periodo_acad='$id_periodo_acad'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaById($conexion, $id){
	$sql = "SELECT * FROM tutoria WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaEstudiantesById($conexion, $id){
	$sql = "SELECT * FROM tutoria_estudiantes WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaEstudiantesByIdTutoria($conexion, $id_tutoria){
	$sql = "SELECT * FROM tutoria_estudiantes WHERE id_tutoria='$id_tutoria'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoria_EstudianteByIdEstudiante($conexion, $id_estudiante){
	$sql = "SELECT * FROM tutoria_estudiantes WHERE id_estudiante='$id_estudiante'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaEstudiantesByIdTutoriaAndIdEst($conexion, $id_tutoria, $id_estudiante){
	$sql = "SELECT * FROM tutoria_estudiantes WHERE id_tutoria='$id_tutoria' AND id_estudiante='$id_estudiante'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaRecojoInfoByIdTutEst($conexion, $id_tut_est){
	$sql = "SELECT * FROM tutoria_recojo_informacion WHERE id_tutoria_estudiante='$id_tut_est'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaSesIndivById($conexion, $id){
	$sql = "SELECT * FROM tutoria_sesion_individual WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaSesIndivByIdTutEst($conexion, $id_tut_est){
	$sql = "SELECT * FROM tutoria_sesion_individual WHERE id_tutoria_estudiante='$id_tut_est'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaSesGrupalById($conexion, $id){
	$sql = "SELECT * FROM tutoria_sesion_grupal WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaSesGrupalByIdTutoria($conexion, $id_tutoria){
	$sql = "SELECT * FROM tutoria_sesion_grupal WHERE id_tutoria='$id_tutoria'";
	return mysqli_query($conexion, $sql);
}
function buscarTutoriaSesGrupalByIdAndIdTutoria($conexion,$id, $id_tutoria){
	$sql = "SELECT * FROM tutoria_sesion_grupal WHERE id='$id' AND id_tutoria='$id_tutoria'";
	return mysqli_query($conexion, $sql);
}

//-------------------------Nuevas Consultas----------------------------

function buscarComprobante($conexion){
	$sql = "SELECT * FROM comprobantes_pago";
	return mysqli_query($conexion, $sql);
}

function buscarAllBoletasNotas($conexion){
	$sql = "SELECT * FROM boleta_notas";
	return mysqli_query($conexion, $sql);
}

function buscarAllCertificados($conexion){
	$sql = "SELECT * FROM certificado_estudios";
	return mysqli_query($conexion, $sql);
}

function buscarMatriculado($conexion, $id_estudiante, $id_periodo){
	$sql = "SELECT * FROM matricula WHERE  id_periodo_acad = '$id_periodo' AND id_estudiante = '$id_estudiante'";
	return mysqli_query($conexion, $sql);
}

function getCalificacionFinalByDni($conexion, $dni){
	$sql = "SELECT u.descripcion, u.creditos , CAST(ROUND(pf.promedio) AS SIGNED)  as promedio_final, pa.nombre as periodo FROM estudiante e INNER JOIN matricula m ON e.id = m.id_estudiante
    INNER JOIN programa_estudios p ON m.id_programa_estudio = p.id INNER JOIN periodo_academico pa ON pa.id = m.id_periodo_acad
    INNER JOIN detalle_matricula_unidad_didactica dm ON dm.id_matricula = m.id INNER JOIN programacion_unidad_didactica pu ON
    pu.id_unidad_didactica = dm.id_programacion_ud INNER JOIN unidad_didactica u ON u.id = pu.id_unidad_didactica
    INNER JOIN promedio_final pf ON pf.id_detalle_matricula = dm.id WHERE e.dni = '$dni' ORDER BY periodo ASC";
	return mysqli_query($conexion,$sql);
}

function getCertificadoByCodigo($conexion,$codigo){
	$sql = "SELECT * FROM certificado_estudios WHERE codigo = '$codigo'";
	return mysqli_query($conexion, $sql);
}

function getBoletaByCodigo($conexion,$codigo){
	$sql = "SELECT * FROM boleta_notas WHERE codigo = '$codigo'";
	return mysqli_query($conexion, $sql);
}

//---------------------PARA ESTUDIANTES ANTIGUOS AL USO DEL SISTEMA --------------------
function getEstudianteAntiguo($conexion, $dni){
	$sql = "SELECT * from estudiante_antiguo WHERE dni = '$dni'";
    return mysqli_query($conexion,$sql);
}

function getEstudianteNotasAntigua($conexion, $dni, $programa){
    $sql = "SELECT * from notas_antiguo WHERE dni = '$dni' AND nombre_programa = '$programa'" ;
    return mysqli_query($conexion,$sql);
}

function getCalificacionFinalByDniAndPeriodo($conexion, $dni, $periodo){
	$sql = "SELECT u.descripcion, u.creditos , CAST(ROUND(pf.promedio) AS SIGNED)  as promedio_final FROM estudiante e INNER JOIN matricula m ON e.id = m.id_estudiante
    INNER JOIN programa_estudios p ON m.id_programa_estudio = p.id INNER JOIN periodo_academico pa ON pa.id = m.id_periodo_acad
    INNER JOIN detalle_matricula_unidad_didactica dm ON dm.id_matricula = m.id INNER JOIN programacion_unidad_didactica pu ON
    pu.id_unidad_didactica = dm.id_programacion_ud INNER JOIN unidad_didactica u ON u.id = pu.id_unidad_didactica
    INNER JOIN promedio_final pf ON pf.id_detalle_matricula = dm.id WHERE e.dni = '$dni' AND pa.nombre = '$periodo'";
	return mysqli_query($conexion,$sql);
}




// -------------------------- FUNCIONES ACTUALIZAR --------------------------








// --------------------------- FUNCIONES ELIMINAR----------------------------







?>