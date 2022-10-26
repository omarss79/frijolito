<?php 

// REGRESA EL NOMBRE  DEL MES
function regresarNombreMes($numero_mes)
{
	$nombre_mes = "";
	
	switch ($numero_mes) 
	{
		case 1:
			$nombre_mes = "Enero";
			break;
			
		case 2:
			$nombre_mes = "Febrero";
			break;
			
		case 3:
			$nombre_mes = "Marzo";
			break;
			
		case 4:
			$nombre_mes = "Abril";
			break;
			
		case 5:
			$nombre_mes = "Mayo";
			break;
			
		case 6:
			$nombre_mes = "Junio";
			break;
			
		case 7:
			$nombre_mes = "Julio";
			break;
			
		case 8:
			$nombre_mes = "Agosto";
			break;
			
		case 9:
			$nombre_mes = "Septiembre";
			break;
			
		case 10:
			$nombre_mes = "Octubre";
			break;
			
		case 11:
			$nombre_mes = "Noviembre";
			break;
			
		case 12:
			$nombre_mes = "Diciembre";
			break;
	}
	
	return $nombre_mes;
}

// REGRESA EL NOMBRE  DEL MES
function regresarNombreCortoMes($numero_mes)
{
	$nombre_mes = "";
	
	switch ($numero_mes) 
	{
		case 1:
			$nombre_mes = "Ene";
			break;
			
		case 2:
			$nombre_mes = "Feb";
			break;
			
		case 3:
			$nombre_mes = "Mar";
			break;
			
		case 4:
			$nombre_mes = "Abr";
			break;
			
		case 5:
			$nombre_mes = "May";
			break;
			
		case 6:
			$nombre_mes = "Jun";
			break;
			
		case 7:
			$nombre_mes = "Jul";
			break;
			
		case 8:
			$nombre_mes = "Ago";
			break;
			
		case 9:
			$nombre_mes = "Sep";
			break;
			
		case 10:
			$nombre_mes = "Oct";
			break;
			
		case 11:
			$nombre_mes = "Nov";
			break;
			
		case 12:
			$nombre_mes = "Dic";
			break;
	}
	
	return $nombre_mes;
}

// 
function regresarNumeroMesesDuracionProyecto($fecha_inicio, $fecha_termino)
{
	$mes_inicio = intval(substr($fecha_inicio,5,2));
	$ano_inicio = intval(substr($fecha_inicio,0,4));
	
	$mes_termino = intval(substr($fecha_termino,5,2));
	$ano_termino = intval(substr($fecha_termino,0,4));
	
	$mes_control = $mes_inicio;
	$ano_control = $ano_inicio;
	
	$d=0;
	
	while($ano_control<=$ano_termino){
		
		if ($ano_control < $ano_termino) {
			$d = $d + (13 - $mes_control);
			$mes_control = 1;
		}
		else{
			while($mes_control<=$mes_termino){
				$d++;
				$mes_control++;
			}
		}
		$ano_control++;
		
	}
	
	return $d;

}



function regresarFechaDDMMMAAAA($fecha)
{
	$mes = substr($fecha,5,2);
	$dia = substr($fecha,8,2);
	$ano = substr($fecha,0,4);
	
	$mes_nombre = regresarNombreMes(intval($mes));
	
	$fecha = $dia . '/' .substr($mes_nombre,0,3) . '/' . $ano;
	
	return $fecha;
}

function regresarFechaDDMMM($fecha)
{
	$mes = substr($fecha,5,2);
	$dia = substr($fecha,8,2);
	$ano = substr($fecha,0,4);
	
	$mes_nombre = regresarNombreMes(intval($mes));
	
	$fecha = $dia . '/' .substr($mes_nombre,0,3);
	
	return $fecha;
}

function regresarFechaDiaMesAno($fecha)
{
	$mes = substr($fecha,5,2);
	$dia = substr($fecha,8,2);
	$ano = substr($fecha,0,4);
	
	$mes_nombre = regresarNombreMes(intval($mes));
	
	$fecha = $dia . ' de ' .$mes_nombre . ' de ' . $ano;
	
	return $fecha;
}



function regresarFechaMesAno($fecha)
{
	$mes = substr($fecha,5,2);
	$ano = substr($fecha,0,4);
	
	$mes_nombre = regresarNombreMes(intval($mes));
	
	$fecha = $mes_nombre . '/' . $ano;
	
	return $fecha;
}


function calcularEdad($fecha){
	$cadena = explode("-",$fecha);
	$año = $cadena[0];
	$añoActual = date("Y");
	if ($año >= $añoActual){
		return "Ingrese una fecha menor a la actual.";
	} else {
		$edad = $añoActual - $año;
		if ($edad > 1){
			return $edad;
		} else{
			return $edad;
		}
	}
}



function regresarEdad($fecha){
	$cadena = explode("-",$fecha);
	$año = $cadena[0];
	$añoActual = date("Y");

	if ($año > 0){
		if ($año == $añoActual){
			return "No registrada";
		} else {
			$edad = $añoActual - $año;
			if ($edad > 1){
				return $edad;
			} else{
				return $edad;
			}
		}
	} else return "No registrada";
}

function regresarNombreDiaSemana($nombredia) {
	$dias = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
	$fecha = $dias[date('N', strtotime($nombredia))];
	return $fecha;
}

?>