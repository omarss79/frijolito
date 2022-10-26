<?php include_once('../config/database.php');?>
<?php
    $b=61653;
    while($b <= 100000){

        // INSERTAR  
        $sql_boleto_insert='INSERT INTO boletos (
                    numero, 
                    sorteo_id 
                )
                VALUES (
                    '.$b.', 
                    1  
                )';
                
        // echo $sql_boleto_insert;
        mysqli_query($conexion, $sql_boleto_insert);
        $b++;
    }
?>