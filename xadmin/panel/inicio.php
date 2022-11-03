<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>

<?php 
$sql_sorteo = "SELECT * FROM sorteos WHERE publicado = 1";
$datos_sorteo = mysqli_query($conexion, $sql_sorteo);
$num_sorteo = mysqli_num_rows($datos_sorteo);
$reg_sorteo = mysqli_fetch_array($datos_sorteo);
//echo $num_sorteos.'</br>';
?>

<?php // DISPONIBLES
$sql_disponibles = "SELECT COUNT(*) AS boletos FROM boletos 
                    WHERE estatus = 1  
                    AND sorteo_id = " . $reg_sorteo['id'];
$datos_disponibles = mysqli_query($conexion, $sql_disponibles);
$reg_disponibles = mysqli_fetch_array($datos_disponibles);?>
<?php // APARTADOS
$sql_apartados = "SELECT COUNT(*) AS boletos FROM boletos 
                    WHERE estatus = 2  
                    AND sorteo_id = " . $reg_sorteo['id'];
$datos_apartados = mysqli_query($conexion, $sql_apartados);
$reg_apartados = mysqli_fetch_array($datos_apartados);?>
<?php // VENDIDOS
$sql_vendidos = "SELECT COUNT(*) AS boletos FROM boletos 
                    WHERE estatus = 3  
                    AND sorteo_id = " . $reg_sorteo['id'];
$datos_vendidos = mysqli_query($conexion, $sql_vendidos);
$reg_vendidos = mysqli_fetch_array($datos_vendidos);?>

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
                <div class="row g-5 align-items-center">
                    <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-4">
                            <h1 class="mb-2">Estadísticas del sorteo</h1>
                        </div>
                        <!-- <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit clita duo justo magna dolore erat amet</p> -->
                        <div class="row g-3">
                            <div class="col-sm-3 wow fadeIn" data-wow-delay="0.1s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-users-cog fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up"><?php echo $reg_disponibles['boletos'];?></h2>
                                    <p class="mb-0">Disponibles</p>
                                </div>
                            </div>
                            <div class="col-sm-3 wow fadeIn" data-wow-delay="0.3s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up"><?php echo $reg_apartados['boletos'];?></h2>
                                    <p class="mb-0">Apartados</p>
                                </div>
                            </div>
                            <div class="col-sm-3 wow fadeIn" data-wow-delay="0.5s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-check fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up"><?php echo $reg_vendidos['boletos'];?></h2>
                                    <p class="mb-0">Vendidos</p>
                                </div>
                            </div>
                            <div class="col-sm-3 wow fadeIn" data-wow-delay="0.5s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-money fa-2x text-primary mb-2">$</i>
                                    <h2 class="mb-1" data-toggle="counter-up"><?php echo ($reg_vendidos['boletos']*$reg_sorteo['precio_boleto']);?></h2>
                                    <p class="mb-0">Ingresos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <!-- About End -->

<?php include("../estructura/footer.php");?>


</body>
</html>