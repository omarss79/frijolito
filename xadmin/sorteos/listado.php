<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>
<?php include("../libreria/Fechas.php");?>

<?php 
$sql_sorteos = "SELECT * FROM sorteos ORDER BY id DESC";
$datos_sorteos = mysqli_query($conexion, $sql_sorteos);
$num_sorteos = mysqli_num_rows($datos_sorteos);
//echo $num_sorteos.'</br>';
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
                    <h1 class="mb-3">Sorteos</h1>
                </div>
                <div class="row g-5 position-relative">
                    <div class="col-12 pe-lg-5">
                        <div class="row gy-3 gx-5">
                            <div class="col-12" style="text-align: right;">
                                <a href="nuevo.php">Nuevo</a>
                            </div>
                        </div>
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeInUp" style="text-align: right;">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
                                <table class="table text-center">
                                    <thead class="table-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Estatus</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col" class="d-none d-lg-table-cell">Periodo</th>
                                        <th scope="col" class="d-none d-lg-table-cell">Rango</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php if($num_sorteos>0){ ?>
                                            <?php while($reg_sorteos = mysqli_fetch_array($datos_sorteos)){ ?>
                                                <tr>
                                                    <th scope="row"><?php echo $reg_sorteos['id'];?></th>
                                                    <td><?php echo $reg_sorteos['publicado'];?></td>
                                                    <td><?php echo $reg_sorteos['nombre'];?></td>
                                                    <td class="d-none d-lg-table-cell"><?php echo regresarFechaDDMMMAAAA($reg_sorteos['fecha_inicio'],0,10) . ' - ' . regresarFechaDDMMMAAAA($reg_sorteos['fecha_limite']);?></td>
                                                    <td class="d-none d-lg-table-cell"><?php echo $reg_sorteos['numero_inicio'] . '-' . $reg_sorteos['numero_final'];?></td>
                                                    <td><a href="editar.php?id=<?php echo $reg_sorteos['id'];?>">Editar</a></td>
                                                </tr>
                                            <?php }?>
                                        <?php }
                                        else { ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No hay sorteos registrados...</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Comparison Start -->

<?php include("../estructura/footer.php");?>

</body>
</html>