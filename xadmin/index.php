<?php session_start();?>
<?php include_once('config/enviroment.php');?>
<?php include_once('config/database.php');?>
    
<?php $accion = ""; ?>
<?php if(isset($_POST['login']) && $_POST['login'] == "Acceder"){ 
    include_once("libreria/ValidarLoginUsuario.php");
    if ($notificacion == 2) $accion == "login-acceso";
} ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Frijolito de la Suerte</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo $SITE_URL;?>lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo $SITE_URL;?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo $SITE_URL;?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo $SITE_URL;?>css/admin.css" rel="stylesheet">
</head>

<body>

    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container px-lg-5">
                    <div class="row g-5">
                        <a href="" class="navbar-brand p-0 text-center">
                            <img src="../img/logo-frijolito-de-la-suerte.jfif" alt="Frijolito de la suerte" class="img-fluid text-center" width="180">
                        </a>
                        <div class="row g-2">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="wow fadeInUp" data-wow-delay="0.2s">
		                            <form class="form-signin" action="index.php" method="post">
                                        <div class="row g-3">
                                            <div class="col-12 text-center">
                                                <h5 class="fw-bold text-white mb-4">Iniciar sesión</h5>
                                            </div>

                                            <?php if(isset($notificacion) && $notificacion == 1){?>
                                                <div class="alert alert-success">
                                                    <strong>¡Bienvenido!</strong> Credenciales correctas...
                                                </div>
                                            <?php }?>
                                            <?php if(isset($notificacion) && $notificacion == 2){?>
                                                <div class="alert alert-danger">
                                                    <strong>¡Error!</strong> Datos incorrectos...
                                                </div>
                                            <?php }?>

                                            <div class="col-md-12">
                                                <div class="form-floating text-center">
                                                    <input type="text" class="form-control text-center" name="username">
                                                    <label for="username">Usuario</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control text-center" name="password">
                                                    <label for="password">Contraseña</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12 text-center">
                                                <input type="submit" name="login" class="btn btn-secondary py-2 px-4 ms-3 text-center" value="Acceder">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12"></div>                        
                        </div>                   
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->

        
        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-white footer mt-5 wow fadeIn" data-wow-delay="0.1s">
            
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span style="color: #BBBB;">&copy;</span> <a class="border-bottom" href="#"><span style="color: #BBBB;">Frijolito de la Suerte</span></a><span style="color: #BBBB;">, Todos los Derechos Reservados.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>
</html>