<?php
function regresarEstatusBoleto($estatus){
    if($estatus == 1){
        return "Disponible";
    }
    else if($estatus == 2){
        return "Apartado";
    }
    else if($estatus == 3){
        return "Vendido";
    }
}

?>