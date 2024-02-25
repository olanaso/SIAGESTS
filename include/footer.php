<?php 
       
       $buscar = buscarDatosSistema($conexion);
       $res = mysqli_fetch_array($buscar);

       ?>
       
       <footer>
          <div class="pull-right">
            <?php echo $res['pie_pagina']; ?>
          </div>
          <div class="clearfix"></div>
        </footer>