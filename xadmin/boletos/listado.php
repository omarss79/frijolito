<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>
<?php include("../libreria/Fechas.php");?>
<?php include("../libreria/Boleto.php");?>

<?php if(isset($_POST['boletos']) && $_POST['boletos'] > 0) $boletos = $_POST['boletos']; else $boletos = "";?>
<?php if(isset($_POST['boleto']) && $_POST['boleto'] > 0) $boleto = $_POST['boleto']; else $boleto = 0;?>
<?php if(isset($_POST['nombre']) && $_POST['nombre'] != "") $nombre = $_POST['nombre']; else $nombre = "";?>
<?php if(isset($_POST['celular']) && $_POST['celular'] != "") $celular = $_POST['celular']; else $celular = "";?>

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
                    apartados_detalles.apartado_id = apartados.id AND ";

$sql_boletos .= " boletos.estatus = ".$boletos." ";

if($boleto > 0)
    $sql_boletos .= " AND boletos.numero = ".$boleto." ";

if($nombre != ""){
    $sql_boletos .= " AND (
        apartados.nombre LIKE '%".$nombre."%' OR 
        apartados.apellidos LIKE '%".$nombre."%' 
    )";
}

if($celular != "")
    $sql_boletos .= " AND apartados.celular = '".$celular."' ";

$sql_boletos .= " ORDER BY 
                    apartados.id ASC,
                    apartados_detalles.numero_seleccionado ASC,
                    apartados_detalles.oportunidad ASC";

$datos_boletos = mysqli_query($conexion, $sql_boletos);
$num_boletos = mysqli_num_rows($datos_boletos);
//echo $sql_boletos.'</br>';
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
                    <h1 class="mb-3">Boletos / Listado</h1>
                </div>
                <div class="row g-5 position-relative">
                    <div class="col-12 pe-lg-5">
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeInUp" style="text-align: right;">
                                <a href="filtro.php" style="margin-bottom: 25px;">Regresar</a>
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
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Hora</th>
                                        <th scope="col">Op 1 </th>
                                        <?php if($boleto == 0){?>
                                            <th scope="col">Op 2 </th>
                                            <th scope="col">Op 3 </th>
                                        <?php }?>
                                        <th scope="col">Estatus</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php if($num_boletos>0){ ?>
                                            <?php $apartadoID = "";?>
                                            <?php while($reg_boletos = mysqli_fetch_array($datos_boletos)){ ?>
                                                <tr>
                                                    <td><?php if($apartadoID != $reg_boletos['apartado_id']) echo $reg_boletos['apartado_id'];?></td>
                                                    <td><?php if($apartadoID != $reg_boletos['apartado_id']) echo $reg_boletos['nombre'].' '.$reg_boletos['apellidos'];?></td>
                                                    <td class="d-none d-lg-table-cell"><?php  if($apartadoID != $reg_boletos['apartado_id']) echo regresarFechaDDMMMAAAA(substr($reg_boletos['fecha_actualizacion'],0,10));?></td>
                                                    <td class="d-none d-lg-table-cell"><?php  if($apartadoID != $reg_boletos['apartado_id']) echo substr($reg_boletos['fecha_actualizacion'],11,5);?></td>
                                                    <td scope="row"><?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?></td>
                                                    <?php if($boleto == 0){?>
                                                        <?php $reg_boletos = mysqli_fetch_array($datos_boletos);?>
                                                        <td scope="row"><?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?></td>
                                                        <?php $reg_boletos = mysqli_fetch_array($datos_boletos);?>
                                                        <td scope="row"><?php echo str_pad($reg_boletos['numero'], 5, "0", STR_PAD_LEFT);?></td>
                                                    <?php }?>
                                                    <td><?php echo regresarEstatusBoleto($reg_boletos['estatus']);?></td>


                                                    <td><?php if($apartadoID != $reg_boletos['apartado_id']) {?><a href="editar.php?apartado_id=<?php echo $reg_boletos['apartado_id'];?>">Editar</a><?php }?></td>
                                                </tr>
                                                <?php $apartadoID = $reg_boletos['apartado_id'];?>
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