<!--MODAL REGISTRAR-->
<div class="modal fade edit_<?php echo $proceso['Id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-mg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" align="center">Nuevo Proceso de Admisión</h4>
            </div>
            <div class="modal-body">
                <!--INICIO CONTENIDO DE MODAL-->
                <div class="x_panel">
                    <div class="x_content">
                        <form role="form" action="operaciones/actualizar_proceso_admision.php"
                            class="form-vertical form-label-right input_mask formularioEdit" method="POST">
                            <input type="hidden" name="id" value="<?php echo $proceso['Id']; ?>">
                            <div class="form-group">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12">Periodo *: </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select class="form-control" name="periodo" value="<?php echo $proceso['Periodo']; ?>"  required="required">
                                        <?php $anio = date("Y"); ?>
                                        <option value="<?php echo $anio."-I" ?>"
                                        <?php if($anio."-I" == $proceso['Periodo']){
                                          echo 'selected=""';};?>
                                        ><?php echo $anio."-I" ?></option>
                                        <option value="<?php echo $anio."-II" ?>"
                                        <?php if($anio."-II" == $proceso['Periodo']){
                                          echo 'selected=""';};?>
                                        ><?php echo $anio."-II" ?></option>
                                        <option value="<?php echo $anio."-III" ?>"
                                        <?php if($anio."-III" == $proceso['Periodo']){
                                          echo 'selected=""';};?>
                                        ><?php echo $anio."-III" ?></option>
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-12 col-sm-12 col-xs-12">Tipo de Proceso *: </label>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select class="form-control" name="tipo" value="<?php echo $proceso['Tipo']; ?>" required="required">
                                        <option value="ORDINARIO" <?php if("ORDINARIO" == $proceso['Tipo']){
                                echo 'selected=""';};?>>Ordinario</option>
                                        <option value="EXONERADO" <?php if("EXONERADO" == $proceso['Tipo']){
                                echo 'selected=""';};?>>Exonerado</option>
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label ">Inicio de Proceso *: </label>
                                <div class="">
                                    <input type="date" class="form-control" name="inicio" id="inicio"
                                    value="<?php echo $proceso['Fecha_Inicio']; ?>" required="required" >
                                    <br>
                                </div>
                            </div>
                            <div class="form-group form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label">Fin de Proceso *:
                                </label>
                                <div class="">
                                    <input type="date" class="form-control" name="fin" id="fin"
                                    value="<?php echo $proceso['Fecha_Fin']; ?>" required="required">
                                    <br>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label ">Inicio de Inscripciones *: </label>
                                <div class="">
                                    <input type="date" class="form-control" name="inicio_ins"
                                    value="<?php echo $proceso['Inicio_Inscripcion']; ?>" required="required" >
                                    <br>
                                </div>
                            </div>
                            <div class="form-group form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label">Fin de Inscripciones *:
                                </label>
                                <div class="">
                                    <input type="date" class="form-control" name="fin_ins"
                                    value="<?php echo $proceso['Fin_Inscripcion']; ?>" required="required">
                                    <br>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label ">Inicio Extemporaneo : </label>
                                <div class="">
                                    <input type="date" class="form-control" name="inicio_ext" value="<?php echo $proceso['Inicio_Extemporaneo']; ?>">
                                    <br>
                                </div>
                            </div>
                            <div class="form-group form-group col-md-6 col-sm-6 col-xs-12">
                                <label class="control-label">Fin Extemporaneo :
                                </label>
                                <div class="">
                                    <input type="date" class="form-control" name="fin_ext" value="<?php echo $proceso['Fin_Extemporaneo']; ?>">
                                    <br>
                                </div>
                            </div>
                            <div align="center">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL-->