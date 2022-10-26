<?php
if(     $_POST['invitacion'] != "" && 
        $_POST['precio_boleto'] != "" && 
        $_POST['premio_1'] != "" && 
        $_POST['premio_2'] != "" && 
        $_POST['premio_3'] != "" 
    ) {

        // UPDATE  
        $sql_sorteo_update='UPDATE sorteos SET
                                    invitacion = "'.trim($_POST['invitacion']).'", 
                                    precio_boleto = '.($_POST['precio_boleto'] + 0).', 
                                    premio_1 = "'.trim($_POST['premio_1']).'", 
                                    premio_2 = "'.trim($_POST['premio_2']).'", 
                                    premio_3 = "'.trim($_POST['premio_3']).'", 
                                    premio_1_url = "'.trim($_POST['premio_1_url']).'", 
                                    premio_2_url = "'.trim($_POST['premio_2_url']).'", 
                                    premio_3_url = "'.trim($_POST['premio_3_url']).'" 
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