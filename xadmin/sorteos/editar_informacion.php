<?php
if(    $_POST['nombre'] != "" && 
            $_POST['descripcion'] != "" && 
            $_POST['fecha_inicio'] != "" && 
            $_POST['fecha_limite'] != "" && 
            $_POST['numero_inicio'] != "" && 
            $_POST['numero_final'] != ""  
         ) {

        // UPDATE  
        $sql_sorteo_update='UPDATE sorteos SET
                                    nombre = "'.htmlspecialchars(strip_tags(trim($_POST['nombre']))).'", 
                                    descripcion = "'.htmlspecialchars(strip_tags(trim($_POST['descripcion']))).'", 
                                    fecha_inicio = "'.$_POST['fecha_inicio'].'", 
                                    fecha_limite = "'.$_POST['fecha_limite'].'", 
                                    numero_inicio = '.$_POST['numero_inicio'].', 
                                    numero_final = '.$_POST['numero_final'].'
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