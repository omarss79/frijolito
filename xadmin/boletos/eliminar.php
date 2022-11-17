<?php
if($accion == "eliminar-boletos-apartados"){
    
    if(isset($_GET['seleccion_id'])) $seleccion_id = $_GET['seleccion_id'];
    else if(isset($_POST['seleccion_id'])) $seleccion_id = $_POST['seleccion_id'];
    else  $seleccion_id = "";

    // select
    $sql_del_apartados = " SELECT * FROM apartados_detalles 
                       WHERE apartado_id = " . $apartado_id . "
                       AND numero_seleccionado = " . $seleccion_id;

    $datos_del_boletos = mysqli_query($conexion, $sql_del_apartados);
    $num_del_boletos = mysqli_num_rows($datos_del_boletos);
    echo $sql_del_apartados.'</br>';

    while($reg_del_boletos = mysqli_fetch_array($datos_del_boletos)){
        // UPDATE BOLETO 
        $sql_estatus_update='UPDATE boletos SET
                estatus = 1 
        WHERE numero = ' . $reg_del_boletos['numero'];
        echo $sql_estatus_update;

        if (mysqli_query($conexion, $sql_estatus_update)){
            
            // DELETE DETALLE APARTADO 
            $sql_estatus_delete='DELETE FROM apartados_detalles 
                                 WHERE apartado_id = ' . $reg_del_boletos['apartado_id'] .' 
                                 AND numero = ' . $reg_del_boletos['numero'];

            echo $sql_estatus_delete;
            mysqli_query($conexion, $sql_estatus_delete);

        }

    }

    // eliminar padre
    
    $sql_del_apartados = " SELECT * FROM apartados_detalles 
                       WHERE apartado_id = " . $apartado_id;

    $datos_del_boletos = mysqli_query($conexion, $sql_del_apartados);
    $num_del_boletos = mysqli_num_rows($datos_del_boletos);

    if($num_del_boletos == 0){
        // DELETE DETALLE APARTADO 
        $sql_estatus_delete='DELETE FROM apartados 
                             WHERE id = ' . $apartado_id;

        echo $sql_estatus_delete;
        mysqli_query($conexion, $sql_estatus_delete);
        echo '<meta http-equiv="refresh" content="1;URL=filtro.php">';

    }

}

?>