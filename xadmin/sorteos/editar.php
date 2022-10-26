<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>
<?php include("../libreria/Fechas.php");?>

<?php if(isset($_GET['id'])) $sorteo_id = $_GET['id'];
else if(isset($_POST['id'])) $sorteo_id = $_POST['id'];
else  $sorteo_id = "";?>

<?php // INSERT SORTEO
$notificacion = 0;
if(isset($_POST['sorteo_editar_informacion']) && $_POST['sorteo_editar_informacion'])
    include_once("editar_informacion.php");
if(isset($_POST['sorteo_editar_configuraciones']) && $_POST['sorteo_editar_configuraciones'])
    include_once("editar_configuraciones.php");
if(isset($_POST['sorteo_editar_pagina_principal']) && $_POST['sorteo_editar_pagina_principal'])
    include_once("editar_pagina_principal.php");
?>

<?php 
$sql_sorteo = "SELECT * FROM sorteos WHERE id = " . $sorteo_id;
$datos_sorteo = mysqli_query($conexion, $sql_sorteo);
$reg_sorteo = mysqli_fetch_array($datos_sorteo);
$num_sorteo = mysqli_num_rows($datos_sorteo);
// echo $num_sorteo.'</br>';
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
                    <h1 class="mb-3">Sorteos / Editar</h1>
                </div>
                <div class="row g-5 position-relative">
                    <div class="col-12 pe-lg-5">

                    <div class="row gy-3 gx-5">
                        <div class="col-12 wow fadeInUp" style="text-align: center;">
                            &nbsp;
                        <?php if($notificacion == 1){?>
                            <div class="alert alert-success" role="alert">
                                El sorteo se actualizó correctamente...
                            </div>
                        <?php }
                        else if($notificacion == 2){?>
                            <div class="alert alert-danger" role="alert">
                                Error al actualizar el sorteo, consulte con su administrador...
                            </div>
                        <?php }
                        else if($notificacion == 3){?>
                            <div class="alert alert-warning" role="alert">
                                Atención, debe completar todos los campos del sorteo...
                            </div>
                        <?php }?>
                        </div>
                    </div>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button <?php if(!(isset($_POST) && isset($_POST['sorteo_editar_informacion']))) echo ' collapsed';?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="<?php if(isset($_POST) && isset($_POST['sorteo_editar_informacion'])) echo 'true'; else echo 'false';?>" aria-controls="collapseOne">
                                Informacion General
                            </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse <?php if(isset($_POST) && isset($_POST['sorteo_editar_informacion'])) echo ' show';?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form action="editar.php" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php if($reg_sorteo['nombre']!="") echo $reg_sorteo['nombre'];?>" placeholder="Nombre del sorteo">
                                                <label for="nombre">Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="datetime-local" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php if($reg_sorteo['fecha_inicio']!="") echo $reg_sorteo['fecha_inicio'];?>" placeholder="Fecha de Inicio">
                                                <label for="fecha_inicio">Fecha de Inicio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="datetime-local" class="form-control" name="fecha_limite" id="fecha_limite" value="<?php if($reg_sorteo['fecha_limite']!="") echo $reg_sorteo['fecha_limite'];?>" placeholder="Fecha Límite">
                                                <label for="fecha_limite">Fecha Límite</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="numero_inicio" id="numero_inicio" maxlength="6" value="<?php if($reg_sorteo['numero_inicio']!="") echo $reg_sorteo['numero_inicio'];?>" placeholder="Número de boleto inicial">
                                                <label for="numero_inicio">Número de boleto inicial</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="numero_final" id="numero_final" maxlength="6" value="<?php if($reg_sorteo['numero_final']!="") echo $reg_sorteo['numero_final'];?>" placeholder="Número de boleto final">
                                                <label for="numero_final">Número de boleto final</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Descripción" name="descripcion" id="descripcion" style="height: 150px"><?php if($reg_sorteo['descripcion']!="") echo $reg_sorteo['descripcion'];?></textarea>
                                                <label for="descripcion">Descripción</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary w-100 py-3" name="sorteo_editar_informacion" value="Actualizar Información General">
                                            <input type="hidden" name="id" value="<?php echo $sorteo_id;?>">
                                        </div>
                                    </div>
                                </form>

                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button <?php if(!(isset($_POST) && isset($_POST['sorteo_editar_configuraciones']))) echo ' collapsed';?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="<?php if(isset($_POST['sorteo_editar_configuraciones'])) echo 'true'; else echo 'false';?>" aria-controls="collapseTwo">    
                            Configuraciones
                            </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse <?php if(isset($_POST) && isset($_POST['sorteo_editar_configuraciones'])) echo ' show';?>" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form action="editar.php" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="oportunidades" id="oportunidades" maxlength="2" value="<?php if($reg_sorteo['oportunidades']!="") echo $reg_sorteo['oportunidades'];?>" placeholder="Número de oportunidades">
                                                <label for="oportunidades">Oportunidades</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary w-100 py-3" name="sorteo_editar_configuraciones" value="Actualizar Configuraciones">
                                            <input type="hidden" name="id" value="<?php echo $sorteo_id;?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button  <?php if(!(isset($_POST) && isset($_POST['sorteo_editar_pagina_principal']))) echo ' collapsed';?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="<?php if(isset($_POST['sorteo_editar_pagina_principal'])) echo 'true'; else echo 'false';?>" aria-controls="collapseThree">
                                P&aacute;gina Principal
                            </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse <?php if(isset($_POST) && isset($_POST['sorteo_editar_pagina_principal'])) echo ' show';?>" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form action="editar.php" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="invitacion" id="invitacion" maxlength="50" value="<?php if($reg_sorteo['invitacion']!="") echo $reg_sorteo['invitacion'];?>" placeholder="Invitaci&oacute;n al sorteo">
                                                <label for="invitacion">Invitaci&oacute;n</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="precio_boleto" id="precio_boleto" maxlength="5" value="<?php if($reg_sorteo['precio_boleto']!="") echo $reg_sorteo['precio_boleto'];?>" placeholder="Precio del boleto">
                                                <label for="precio_boleto">Precio del boleto</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="premio_1" id="premio_1" maxlength="50" value="<?php if($reg_sorteo['premio_1']!="") echo $reg_sorteo['premio_1'];?>" placeholder="Primer premio">
                                                <label for="premio_1">Primer premio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="premio_1_url" id="premio_1_url" maxlength="300" value="<?php if($reg_sorteo['premio_1_url']!="") echo $reg_sorteo['premio_1_url'];?>" placeholder="Url de Primer premio">
                                                <label for="premio_1_url">Url de Primer premio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="premio_2" id="premio_2" maxlength="50" value="<?php if($reg_sorteo['premio_2']!="") echo $reg_sorteo['premio_2'];?>" placeholder="Segundo premio">
                                                <label for="premio_2">Segundo premio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="premio_2_url" id="premio_2_url" maxlength="300" value="<?php if($reg_sorteo['premio_2_url']!="") echo $reg_sorteo['premio_2_url'];?>" placeholder="Url de Segundo premio">
                                                <label for="premio_2_url">Url de Segundo premio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="premio_3" id="premio_3" maxlength="50" value="<?php if($reg_sorteo['premio_3']!="") echo $reg_sorteo['premio_3'];?>" placeholder="Tercer premio">
                                                <label for="premio_3">Tercer premio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="premio_3_url" id="premio_3_url" maxlength="300" value="<?php if($reg_sorteo['premio_3_url']!="") echo $reg_sorteo['premio_3_url'];?>" placeholder="Url de Tercer premio">
                                                <label for="premio_3_url">Url de Tercer premio</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary w-100 py-3" name="sorteo_editar_pagina_principal" value="Actualizar Pagina Principal">
                                            <input type="hidden" name="id" value="<?php echo $sorteo_id;?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            </div>
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
    $('#oportunidades').on('input', function () { validarNumeros(this);});
    function validarNumeros(field) { 
        if(event.shiftKey) event.preventDefault();
        let old_input = field.value;
        field.value = old_input.replace(/[^0-9]/g,'');
        if(field.value.length >= 5) event.preventDefault();
    }
</script>

</body>
</html>