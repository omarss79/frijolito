<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>
<?php include("../libreria/Fechas.php");?>


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
                    <h1 class="mb-3">Boletos / Filtro</h1>
                </div>
                <div class="row g-5 position-relative">
                    <div class="col-12 pe-lg-5">
                        <div class="row gy-3 gx-5">
                            <div class="col-12 wow fadeInUp" data-wow-delay="0.2s">
                                <form action="listado.php" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-4 offset-md-4">
                                            <div class="form-floating">
                                                <select class="form-control" name="boletos" id="boletos">
                                                    <option value=""></option>
                                                    <option value="1">Disponibles</option>
                                                    <option value="2">Apartados</option>
                                                    <option value="3">Vendidos</option>
                                                </select>
                                                <label for="boletos">Estatus de boletos</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 offset-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="boleto" id="boleto">
                                                <label for="boleto">Número de boleto</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 offset-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="nombre" id="nombre">
                                                <label for="nombre">Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 offset-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="celular" id="celular">
                                                <label for="celular">Número de celular</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">&nbsp;</div>
                                    <div class="row g-3">
                                        <div class="col-md-4 offset-md-4">
                                            <input type="submit" class="btn btn-primary w-100 py-3" name="boletos_filtro" value="Filtrar">
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <!-- Comparison Start -->

<?php include("../estructura/footer.php");?>
</body>
</html>