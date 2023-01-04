<?php session_start();
// echo 'Session: ' . $_SESSION['id'] .'<br>';
if(isset($_SESSION['id']) && $_SESSION['id'] == session_id()){
    
    include_once('../xadmin/config/database.php');
    include_once('../xadmin/libreria/Boleto.php');

    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    if( $input['boleto'] != "" ) {
        //Verificar 
        $boleto = filter_var($input['boleto'], FILTER_SANITIZE_NUMBER_INT);

        $longitud = strlen($boleto);

        $sql_boletos = "SELECT 
                            apartados.id AS apartado_id,
                            apartados.nombre AS nombre, 
                            apartados.apellidos AS apellidos, 
                            apartados.fecha_creacion AS fecha_creacion, 
                            apartados.fecha_actualizacion AS fecha_actualizacion, 
                            apartados_detalles.oportunidad AS oportunidad, 
                            boletos.numero AS numero, 
                            boletos.estatus AS estatus 
                        FROM 
                            boletos, 
                            apartados_detalles, 
                            apartados 
                        WHERE 
                            boletos.numero = apartados_detalles.numero AND 
                            apartados_detalles.apartado_id = apartados.id ";

        if($longitud == 10)
            $sql_boletos .= " AND apartados.celular = '".$boleto."' ";
        else 
            $sql_boletos .= " AND boletos.numero = ".$boleto." ";



        $sql_boletos .= " ORDER BY 
                            apartados.id ASC,
                            apartados_detalles.numero_seleccionado ASC,
                            apartados_detalles.oportunidad ASC";

        $datos_boletos = mysqli_query($conexion, $sql_boletos);
        $num_boletos = mysqli_num_rows($datos_boletos);
        //  echo $sql_boletos.'</br>';

        if($num_boletos > 0){
            // Responder estatus

            $itemRecords=array();
            $itemRecords["items"]=array(); 
            while ($reg_boletos = mysqli_fetch_array($datos_boletos)) { 	
                extract($reg_boletos); 
                $itemDetails=array(
                    "numero" => str_pad($numero, 5, "0", STR_PAD_LEFT),
                    "nombre" => $nombre,
                    "apellidos" => $apellidos,
                    "estatus" => regresarEstatusBoleto($estatus)	
                ); 
               array_push($itemRecords["items"], $itemDetails);
            } 
            
            http_response_code(201);    
            echo json_encode($itemRecords);

        }
        else{
            // En caso de no existir
            $disponible = 'BOLETO DISPONIBLE: <b>'.str_pad($boleto, 5, "0", STR_PAD_LEFT) .'</b>';
            http_response_code(200); 
            echo json_encode(array("html" => $disponible));

        }

    }
    else {
        http_response_code(400);    
        echo json_encode(array("message" => "No fue posible verificar el boleto, algunos datos estan incompletos..."));
    }
}
else{
    http_response_code(401);     
    echo json_encode(array("message" => "Usuario sin autorización para apartar boletos."));
}


?>