<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>
<?php include("../libreria/Fechas.php");?>

<?php // INSERT SORTEO
$notificacion = 0;
if(isset($_POST['sorteo_nuevo']) && $_POST['sorteo_nuevo']){
    if(    $_POST['nombre'] != "" && 
            $_POST['descripcion'] != "" && 
            $_POST['fecha_inicio'] != "" && 
            $_POST['fecha_limite'] != "" && 
            $_POST['numero_inicio'] != "" && 
            $_POST['numero_final'] != ""  
         ) {

        // INSERTAR  
        $sql_sorteo_insert='INSERT INTO sorteos (
                                    nombre, 
                                    descripcion, 
                                    fecha_inicio, 
                                    fecha_limite, 
                                    numero_inicio, 
                                    numero_final 
                                )
                                VALUES (
                                    "'.htmlspecialchars(strip_tags(trim($_POST['nombre']))).'", 
                                    "'.htmlspecialchars(strip_tags(trim($_POST['descripcion']))).'", 
                                    "'.$_POST['fecha_inicio'].'", 
                                    "'.$_POST['fecha_limite'].'", 
                                     '.$_POST['numero_inicio'].', 
                                     '.$_POST['numero_final'].' 
                                )';
                                
        echo $sql_sorteo_insert;
        $insert = mysqli_query($conexion, $sql_sorteo_insert);
        //$categoria_orden = mysqli_insert_id ($conexion);
        
        if ($insert) {
            $notificacion = 1;
            echo '<meta http-equiv="refresh" content="1;URL=listado.php">';
        }
        else  $notificacion = 2;
    } else $notificacion = 3;
} 
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
                    <h1 class="mb-3">Sorteos / Nuevo</h1>
                </div>
                <div class="row g-5 position-relative">
                    <div class="col-12 pe-lg-5">
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeInUp" style="text-align: right;">
                                <a href="listado.php" style="margin-bottom: 25px;">Regresar</a>
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
                                <form action="nuevo.php" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php if(isset($_POST['nombre']) && $_POST['nombre']!="") echo $_POST['nombre'];?>" placeholder="Nombre del sorteo">
                                                <label for="nombre">Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="datetime-local" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php if(isset($_POST['fecha_inicio']) && $_POST['fecha_inicio']!="") echo $_POST['fecha_inicio'];?>" placeholder="Fecha de Inicio">
                                                <label for="fecha_inicio">Fecha de Inicio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="datetime-local" class="form-control" name="fecha_limite" id="fecha_limite" value="<?php if(isset($_POST['fecha_limite']) && $_POST['fecha_limite']!="") echo $_POST['fecha_limite'];?>" placeholder="Fecha Límite">
                                                <label for="fecha_limite">Fecha Límite</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="numero_inicio" id="numero_inicio" maxlength="6" value="<?php if(isset($_POST['numero_inicio']) && $_POST['numero_inicio']!="") echo $_POST['numero_inicio'];?>" placeholder="Número de boleto inicial">
                                                <label for="numero_inicio">Número de boleto inicial</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="numero_final" id="numero_final" maxlength="6" value="<?php if(isset($_POST['numero_final']) && $_POST['numero_final']!="") echo $_POST['numero_final'];?>" placeholder="Número de boleto final">
                                                <label for="numero_final">Número de boleto final</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Descripción" name="descripcion" id="descripcion" style="height: 150px"><?php if(isset($_POST['descripcion']) && $_POST['descripcion']!="") echo $_POST['descripcion'];?></textarea>
                                                <label for="descripcion">Descripción</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary w-100 py-3" name="sorteo_nuevo" value="Crear nuevo sorteo">
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
    $('#numero_inicio').on('input', function () { validarNumeros(this);});
    $('#numero_final').on('input', function () { validarNumeros(this);});
    function validarNumeros(field) { 
        if(event.shiftKey) event.preventDefault();
        let old_input = field.value;
        field.value = old_input.replace(/[^0-9]/g,'');
        if(field.value.length >= 5) event.preventDefault();
    }
</script>

</body>
</html>