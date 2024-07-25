# SA
 sistema academico para iest peru, proyecto trabajado con php utilizando plantilla Gentella de Bootstrap

 Pasos pra la instalacion:

 1.- clonar repositorio de github a hosting
 2.- crear subdominio apuntanda la carpeta clonada
 3.- crear base de datos con su respectivo usuario
 4.- importar base de datos
 5.- iniciar el sistema abriendo el subdominio
 6.- iniciar con la configuración en datos de sistema e institucionales

CREATE VIEW `promedio_final` AS select `t2`.`id_detalle_matricula` AS `id_detalle_matricula`,`t1`.`id_programacion_ud` AS `id_programacion_ud`,`t1`.`id_matricula` AS `id_matricula`,sum(`t2`.`ponderado` * `t2`.`promedio` / 100) AS `promedio` from (`detalle_matricula_unidad_didactica` `t1` join `promedio_evaluacion` `t2` on(`t1`.`id` = `t2`.`id_detalle_matricula`)) group by `t2`.`id_detalle_matricula`