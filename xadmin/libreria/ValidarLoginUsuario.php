<?php if (isset($_POST['username']) && isset($_POST['password'])){

$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

$sql_usuario='SELECT * FROM usuarios 
                WHERE usuario = "'.addslashes($username).'" 
                AND contrasena = "'.md5(trim($password)).'"';
                
//echo $sql_usuario.'</br>';
$datos_usuario=mysqli_query($conexion, $sql_usuario);
$num_usuario=mysqli_num_rows($datos_usuario);

//$num_usuario=0;

if ($num_usuario==1){

    $reg_usuario=mysqli_fetch_array($datos_usuario);
    
    // USUARIO
    // Clave del usuario
    $_SESSION['usu_clave']=$reg_usuario['id'];
    
    // Nombre del usuario
    $_SESSION['usu_usuario']=$reg_usuario['usuario'];
                
    // Rol de usuario
    $_SESSION['rol_clave']=$reg_usuario['rol_id'];
    
    //echo $_SESSION['usu_clave'] .' - '. $_SESSION['usu_usuario'] .' - '. $_SESSION['rol_clave'];
    
    switch ($_SESSION['rol_clave']) {

        //ADMIN
    
        case 100:
            echo '<meta http-equiv="refresh" content="1;URL= panel/inicio.php">';
            break;

            
        default:
            echo '<meta http-equiv="refresh" content="1;URL=index.php">';
            break;
    }
    $notificacion=1;
} else $notificacion=2;
}?>