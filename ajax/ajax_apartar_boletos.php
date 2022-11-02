<?php session_start();
// echo 'Session: ' . $_SESSION['id'] .'<br>';
if(isset($_SESSION['id']) && $_SESSION['id'] == session_id()){
    
    include_once('../xadmin/config/database.php');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);
    
    // Buscar ocupados

        // En caso de haber ocupados, regresar respuesta

    // INSERT apartados
    if( $input['celular'] != ""  &&
        $input['nombre'] != "" &&
        $input['apellidos'] != "" &&
        $input['estado_id'] != ""
    ) {
        //Verificar apartados
        $boletos_apartados = $input['boletos'];
        $elementos = count($boletos_apartados);
        $sql_ocupados = "SELECT * FROM boletos WHERE estatus > 1 AND (";
        for ($i=0; $i<$elementos; $i++){
            if($i>0) $sql_ocupados.= " OR ";
            $sql_ocupados.= " numero = " . intval($boletos_apartados[$i]['oportunidad_1']).' OR ';
            $sql_ocupados.= " numero = " . intval($boletos_apartados[$i]['oportunidad_2']).' OR ';
            $sql_ocupados.= " numero = " . intval($boletos_apartados[$i]['oportunidad_3']).' OR ';
            $sql_ocupados.= " numero = " . intval($boletos_apartados[$i]['oportunidad_4']).' ';
        }
        $sql_ocupados .= ")";
        $datos_ocupados = mysqli_query($conexion, $sql_ocupados);
        $num_ocupados = mysqli_num_rows($datos_ocupados);
        if($num_ocupados == 0){
            $estado_id = ($input['estado_id'] + 0);
            // INSERTAR  
            $sql_apartado_insert='INSERT INTO apartados (
                                        celular, 
                                        nombre, 
                                        apellidos,
                                        estado_id
                                    )
                                    VALUES (
                                        "'.addslashes(trim($input['celular'])).'",
                                        "'.addslashes(trim($input['nombre'])).'",
                                        "'.addslashes(trim($input['apellidos'])).'",
                                        '.$estado_id.'
                                    )';

            //echo $sql_apartado_insert;
            $insert = mysqli_query($conexion, $sql_apartado_insert);
            $apartado_id = mysqli_insert_id ($conexion);
            
            if ($insert) {
                $boletos_apartados = $input['boletos'];
                $elementos = count($boletos_apartados);
                $respuesta = "";
                for ($i=0; $i<$elementos; $i++){
                    // DETALLES APARTADO  
                    $sql_detalle_insert='INSERT INTO apartados_detalles (
                        oportunidad_1, oportunidad_2, oportunidad_3, oportunidad_4, apartado_id
                    )
                    VALUES (
                        '.intval($boletos_apartados[$i]['oportunidad_1']).', 
                        '.intval($boletos_apartados[$i]['oportunidad_2']).', 
                        '.intval($boletos_apartados[$i]['oportunidad_3']).', 
                        '.intval($boletos_apartados[$i]['oportunidad_4']).', 
                        '.$apartado_id.'  
                    )';
                    mysqli_query($conexion, $sql_detalle_insert);
                    $apartadod_id = mysqli_insert_id ($conexion);
                    
                    // UPDATES
                    for($j=1;$j<=4;$j++){
                        $sql_boleto_update='UPDATE boletos SET 
                            estatus = 2, 
                            apartado_id = '.$apartado_id.', 
                            apartadod_id = '.$apartadod_id.' 
                        WHERE numero = '.intval($boletos_apartados[$i]['oportunidad_'.$j]);
                        mysqli_query($conexion, $sql_boleto_update);
                    }
                }
                http_response_code(201);         
                echo json_encode(array("message" => "Boletos apartados correctamente."));
            }
            else  {
                http_response_code(503);        
                echo json_encode(array("message" => "Error al guardar los datos del cliente."));
            }
        } 
        else{
            $numeros_ocupados = "";
            $b = 0;
            while($reg_ocupados = mysqli_fetch_array($datos_ocupados)){
                $numeros_ocupados .= $reg_ocupados['numero'];
                if($b < ($num_ocupados-1)) $numeros_ocupados .= ", ";
                $b++;
            }
            //echo $sql_ocupados.' - '.$numeros_ocupados;
            http_response_code(400);    
            echo json_encode(array("message" => "ATENCION: No fue posible apartar los boletos, algunos se encuentran ocupados...", "ocupados" => $numeros_ocupados));
        }  
    }
    else {
        http_response_code(400);    
        echo json_encode(array("message" => "No fue posible apartar los boletos, algunos datos estan incompletos..."));
    }
}
else{
    http_response_code(401);     
    echo json_encode(array("message" => "Usuario sin autorización para apartar boletos."));
}


?>