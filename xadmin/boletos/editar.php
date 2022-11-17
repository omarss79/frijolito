<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>
<?php include("../libreria/Fechas.php");?>
<?php include("../libreria/Boleto.php");?>
<?php $notificacion=0;?>

<?php if(isset($_GET['accion'])) $accion = $_GET['accion'];
else if(isset($_POST['accion'])) $accion = $_POST['accion'];
else  $accion = "";?>

<?php if(isset($_GET['apartado_id'])) $apartado_id = $_GET['apartado_id'];
else if(isset($_POST['apartado_id'])) $apartado_id = $_POST['apartado_id'];
else  $apartado_id = "";?>

<?php if(isset($accion) && $accion == "eliminar-boletos-apartados"){
    include("eliminar.php");
}?>

<?php if(isset($accion) && $accion == "editar-boletos-apartados"){
    
    $sql_boletos = "SELECT 
                        apartados.id AS apartado_id,
                        apartados_detalles.apartadod_id AS apartadod_id, 
                        boletos.numero AS numero, 
                        boletos.estatus AS estatus 
                    FROM 
                        boletos, 
                        apartados_detalles, 
                        apartados 
                    WHERE 
                        boletos.numero = apartados_detalles.numero AND 
                        apartados_detalles.apartado_id = apartados.id AND 
                        apartados.id = ".$apartado_id." 
                    ORDER BY 
                        apartados.id ASC,
                        apartados_detalles.numero_seleccionado ASC,
                        apartados_detalles.oportunidad ASC";
    $datos_boletos = mysqli_query($conexion, $sql_boletos);
    $num_boletos = mysqli_num_rows($datos_boletos);
    //echo $num_boletos.'</br>';
    if( $num_boletos > 0 ) {
        $ok = 0;$err = 0;
        while($reg_boletos = mysqli_fetch_array($datos_boletos)){

            // UPDATE  
            $sql_boleto_update='UPDATE boletos SET
                                        estatus = '.($_POST['estatus'] + 0).' 
                                WHERE numero = ' . $reg_boletos['numero'];
                                    
            //echo $sql_boleto_update.'<br>';
            $update = mysqli_query($conexion, $sql_boleto_update);
            
            if ($update) $ok++;
            else  $err++;
            if($ok == $num_boletos) $notificacion = 1;
            else $notificacion = 2;
            
            // DELETE apartados
            if($_POST['estatus'] == 1){
                $sql_boleto_delete='DELETE FROM apartados_detalles  
                                    WHERE apartadod_id = ' . $reg_boletos['apartadod_id'] . ' 
                                    AND apartado_id = ' . $reg_boletos['apartado_id'] . ' 
                                    AND numero = ' . $reg_boletos['numero'];
                                        
                // echo $sql_boleto_delete.'<br>';
                $delete = mysqli_query($conexion, $sql_boleto_delete);
            }
        }
        // DELETE apartados
        if($_POST['estatus'] == 1){
            $sql_apartado_delete='DELETE FROM apartados   
                                WHERE id = ' . $apartado_id;
                                    
            // echo $sql_apartado_delete.'<br>';
            $delete = mysqli_query($conexion, $sql_apartado_delete);

        }
    } else $notificacion = 3;
} ?>

<?php 
$sql_sorteo = "SELECT * FROM sorteos WHERE publicado = 1";
$datos_sorteo = mysqli_query($conexion, $sql_sorteo);
$reg_sorteo = mysqli_fetch_array($datos_sorteo);
$num_sorteo = mysqli_num_rows($datos_sorteo);
// echo $num_sorteo.'</br>';
?>

<?php 
$sql_apartados = "  SELECT 
                        apartados.*, 
                        estados.estado AS estado
                    FROM apartados, estados  
                    WHERE apartados.estado_id = estados.id 
                    AND apartados.id = " . $apartado_id;
$datos_apartados = mysqli_query($conexion, $sql_apartados);
$reg_apartados = mysqli_fetch_array($datos_apartados);
$num_apartados = mysqli_num_rows($datos_apartados);
// echo $num_sorteo.'</br>';
?>

<?php 
$sql_boletos = "SELECT 
                    apartados.id AS apartado_id,
                    apartados.nombre AS nombre, 
                    apartados.apellidos AS apellidos, 
                    apartados.fecha_creacion AS fecha_creacion, 
                    apartados.fecha_actualizacion AS fecha_actualizacion, 
                    apartados_detalles.oportunidad AS oportunidad, 
                    apartados_detalles.numero_seleccionado AS numero_seleccionado, 
                    boletos.numero AS numero, 
                    boletos.estatus AS estatus 
                FROM 
                    boletos, 
                    apartados_detalles, 
                    apartados 
                WHERE 
                    boletos.numero = apartados_detalles.numero AND 
                    apartados_detalles.apartado_id = apartados.id AND 
                    apartados.id = ".$apartado_id." 
                ORDER BY 
                    apartados.id ASC,
                    apartados_detalles.numero_seleccionado ASC,
                    apartados_detalles.oportunidad ASC";
$datos_boletos = mysqli_query($conexion, $sql_boletos);
$num_boletos = mysqli_num_rows($datos_boletos);
//echo $num_boletos.'</br>';
?>


    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        
        <?php include("../estructura/navbar.php");?>

        <!-- Comparison Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Boletos / Editar</h1>
                </div>
                <div class="row g-5 position-relative">
                    <div class="col-12 pe-lg-5">
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeInUp" style="text-align: right;">
                                <a href="filtro.php" style="margin-bottom: 25px;">Regresar</a>
                            </div>
                        </div>
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeInUp" style="text-align: center;">
                                &nbsp;
                            <?php if($notificacion == 1){?>
                                <div class="alert alert-success" role="alert">
                                    El estatus de los boletos se actualizaron correctamente...
                                </div>
                            <?php }
                            else if($notificacion == 2){?>
                                <div class="alert alert-danger" role="alert">
                                    Error al actualizar el estatus de los boletos, consulte con su administrador...
                                </div>
                            <?php }
                            else if($notificacion == 3){?>
                                <div class="alert alert-warning" role="alert">
                                    Atención, no fue posible actualizar el estatus de los boletos...
                                </div>
                            <?php }?>
                            </div>
                        </div>
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.2s">
                                <form id="form_estatus" action="editar.php" method="POST">
                                    <!-- Comparison Start -->
                                    <div class="container-xxl py-5">
                                        <div class="container px-lg-5">
                                            <div class="row g-5 comparison position-relative">
                                                <div class="col-lg-6 col-sm-12">
                                                    <div class="section-title position-relative mx-auto mb-4 pb-4">
                                                        <h3 class="fw-bold mb-0"><?php echo $reg_apartados['nombre']." ".$reg_apartados['apellidos'];?></h3>
                                                    </div>
                                                    <div class="row gy-3 gx-5">
                                                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                                            <h6 class="fw-bold">Estado: <?php echo $reg_apartados['estado'];?></h6>
                                                            <p class="fw-bold">Celular: <a href="https://api.whatsapp.com/send?phone=521<?php echo $reg_apartados['celular'];?>" target="_blank"><?php echo $reg_apartados['celular'];?></a></p>
                                                            <p>Fecha creación: <?php echo $reg_apartados['fecha_creacion'];?></p>
                                                            <p>Fecha actualizacion: <?php echo $reg_apartados['fecha_actualizacion'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12">
                                                    <div class="section-title position-relative mx-auto mb-4 pb-4">
                                                        <h3 class="fw-bold mb-0">
                                                            <?php if(($num_boletos/$reg_sorteo["oportunidades"]) == 1) echo "1 Boleto";
                                                            else  echo ($num_boletos/$reg_sorteo["oportunidades"]) . " Boletos";?>
                                                        </h3>
                                                            <h6 class="fw-bold mb-0">
                                                                <?php echo $num_boletos . " oportunidades";?>
                                                            </h6>
                                                    </div>
                                                    <div class="row gy-3 gx-5">
                                                        <div class="col-sm-12 wow fadeIn" data-wow-delay="0.1s">
                                                            <?php $estatus = "";?>
                                                            <?php while($reg_boletos = mysqli_fetch_array($datos_boletos)){ ?>
                                                                <h6 class="fw-bold">
                                                                    <?php $apartado = $reg_boletos['apartado_id'];?>
                                                                    <?php $seleccion = $reg_boletos['numero_seleccionado'];?>
                                                                    <?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?>
                                                                    <?php $reg_boletos = mysqli_fetch_array($datos_boletos);?>
                                                                    [<?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?>,
                                                                    <?php $reg_boletos = mysqli_fetch_array($datos_boletos);?>
                                                                    <?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?>]
                                                                    <img src="../../img/eliminar.png" alt="Eliminar boletos" ondblclick="eliminarBoleto(<?php echo $apartado;?>,<?php echo $seleccion;?>);">                                                                    
                                                                </h6>
                                                                <?php $estatus = $reg_boletos['estatus'];?>
                                                            <?php }?>
                                                            <hr>
                                                            <p><h6 class="fw-bold mb-0">Estatus:</h6></p>

                                                            <p><input type="radio" name="estatus" id="estatus" value="1" <?php if($estatus == 1) echo " checked";?>> Disponible</p>
                                                            <p><input type="radio" name="estatus" id="estatus" value="2" <?php if($estatus == 2) echo " checked";?>> Apartado</p>
                                                            <p><input type="radio" name="estatus" id="estatus" value="3" <?php if($estatus == 3) echo " checked";?>> Vendido</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="apartado_id" name="apartado_id" value="<?php echo $apartado_id;?>">
                                            <input type="hidden" id="actualizar_estatus" name="actualizar_estatus" value="1">
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-4 offset-md-4">
                                            <input type="button" class="btn btn-primary w-100 py-3" id="boletos_actualizar" name="boletos_actualizar" value="Actualizar" onclick="actualizarBoletos();">
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Comparison Start -->

<?php include("../estructura/footer.php");?>

<script>
    function actualizarBoletos(){
        let estatus = document.querySelector('input[name="estatus"]:checked').value;
        let pregunta = '¿Deseas actualizar el estatus de los boletos?';
        let detalle = '';
        switch (estatus) {
            case '1':
                detalle = 'La acción cambiará a DISPONIBLE los boletos y\n eliminará los datos del cliente...';
                break;
            case '2':
                detalle = 'La acción cambiará a APARTADOS los boletos...';
                break;
            case '3':
                detalle = 'La acción cambiará a VENDIDOS los boletos...';
                break;
        }
        swal({
            title: pregunta,
            text: detalle,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willSend) => {
            if (willSend) {
                document.getElementById("form_estatus").submit();
            }
        });
    }

    function eliminarBoleto(apartado_id, seleccion_id) {
        swal({
            title: '¿Deseas eliminar el boleto seleccionado: '+seleccion_id+'?',
            text: 'Esta acción liberará el número y estará disponible a la venta.',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDel) => {
            if (willDel) {
                window.location = "editar.php?accion=eliminar-boletos-apartados&apartado_id="+apartado_id+"&seleccion_id="+seleccion_id;
            }
        });


    }
</script>

</body>
</html>