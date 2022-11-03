<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>
<?php include("../libreria/Fechas.php");?>
<?php include("../libreria/Boleto.php");?>
<?php $notificacion=0;?>

<?php if(isset($_GET['apartado_id'])) $apartado_id = $_GET['apartado_id'];
else if(isset($_POST['apartado_id'])) $apartado_id = $_POST['apartado_id'];
else  $apartado_id = "";?>

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
                                    El sorteo se registro correctamente...
                                </div>
                            <?php }
                            else if($notificacion == 2){?>
                                <div class="alert alert-danger" role="alert">
                                    Error al guardar el sorteo, consulte con su administrador...
                                </div>
                            <?php }
                            else if($notificacion == 3){?>
                                <div class="alert alert-warning" role="alert">
                                    Atención, debe completar todos los campos del sorteo...
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
                                                <div class="col-lg-6 pe-lg-5">
                                                    <div class="section-title position-relative mx-auto mb-4 pb-4">
                                                        <h3 class="fw-bold mb-0"><?php echo $reg_apartados['nombre']." ".$reg_apartados['apellidos'];?></h3>
                                                    </div>
                                                    <div class="row gy-3 gx-5">
                                                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                                            <h6 class="fw-bold"><?php echo $reg_apartados['celular'];?></h6>
                                                            <h6 class="fw-bold"><?php echo $reg_apartados['estado'];?></h6>
                                                            <p>Fecha creación: <?php echo $reg_apartados['fecha_creacion'];?></p>
                                                            <p>Fecha actualizacion: <?php echo $reg_apartados['fecha_actualizacion'];?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 ps-lg-5">
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
                                                                    <?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?>
                                                                    <?php $reg_boletos = mysqli_fetch_array($datos_boletos);?>
                                                                    [<?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?>,
                                                                    <?php $reg_boletos = mysqli_fetch_array($datos_boletos);?>
                                                                    <?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?>]
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
                                            <input type="hidden" name="apartado_id" value="<?php echo $apartado_id;?>">
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-4 offset-md-4">
                                            <input type="button" class="btn btn-primary w-100 py-3" name="boletos_actualizar" value="Actualizar" onclick="actualizarBoletos();">
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
    function actualizarBoletos(apartado_id){
        swal({
            title: "¿Deseas actualizar el estatus de los boletos?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                document.getElementById("form_estatus").submit();
            } 
            // else {
            //     swal("Your imaginary file is safe!");
            // }
        });
    }
</script>

</body>
</html>