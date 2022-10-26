<?php
if(    $_POST['oportunidades'] != "" ) {

        // UPDATE  
        $sql_sorteo_update='UPDATE sorteos SET
                                    oportunidades = '.($_POST['oportunidades'] + 0).' 
                            WHERE id = ' . $sorteo_id;
                                
        // echo $sql_sorteo_update;
        $update = mysqli_query($conexion, $sql_sorteo_update);
        
        if ($update) {
            $notificacion = 1;
            // echo '<meta http-equiv="refresh" content="2;URL=listado.php">';
        }
        else  $notificacion = 2;
    } else $notificacion = 3;
?>