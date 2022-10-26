<?php session_start();?>
<?php include_once('xadmin/config/database.php');?>
<?php include("xadmin/libreria/Fechas.php");?>
<?php // Sorteo publicado
$sql_sorteo = "SELECT * FROM sorteos WHERE publicado = 1";
$datos_sorteo = mysqli_query($conexion, $sql_sorteo);
$reg_sorteo = mysqli_fetch_array($datos_sorteo);
$num_sorteo = mysqli_num_rows($datos_sorteo);
// echo $num_sorteo.'</br>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Frijolito de la Suerte</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
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
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-lg-0">
                <a href="index.php" class="navbar-brand p-0">
                    <img src="img/logo-frijolito-de-la-suerte.jfif" alt="Frijolito de la suerte" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="index.php#" class="nav-item nav-link active">Inicio</a>
                        <a href="index.php#contacto" class="nav-item nav-link">Contacto</a>
                    </div>
                    <!-- <butaton type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></butaton> -->
                    <!-- <a href="" class="btn btn-secondary py-2 px-4 ms-3">Comprar Boletos</a> -->
                </div>
            </nav>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Pricing Start -->
        <a name="sorteos"></a>
        <br>
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Listado de Boletos</h1>
                    <!-- <p class="mb-1">Vero justo sed sed vero clita amet. Et justo vero sea diam elitr amet ipsum eos ipsum clita duo sed. Sed vero sea diam erat vero elitr sit clita.</p> -->
                </div>
                <div class="row gy-5 gx-4">
                    <div class="col-lg-3 col-md-3 col-sm-12 wow fadeInUp" data-wow-delay="0.2s"></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="position-relative shadow rounded border-top border-5 border-primary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-secondary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-server text-white"></i>
                            </div>
                            <div class="p-4">
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>1 BOLETO POR $40.00 (4 oportunidades)</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>3 BOLETOS POR $120.00 (12 oportunidades)</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>5 BOLETOS POR $200.00 (20 oportunidades)</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>10 BOLETOS POR $400.00 (40 oportunidades)</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>20 BOLETOS POR $800.00 (80 oportunidades)</p>
                                <p class="border-bottom pb-3"><i class="fa fa-check text-primary me-3"></i>50 BOLETOS POR $2,000.00 (200 oportunidades)</p>
                                <p class="mb-0"><i class="fa fa-check text-primary me-3"></i>100 BOLETOS POR $4,000.00 (400 oportunidades)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pricing End -->
        
        
        <!-- Team Start -->
        <a name="boletos"></a>
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">BOLETOS</h1>
                    <p class="mb-1">¡Participa y gana!</p>
                </div>
                <div class="row g-2 text-center">
                <div id="blockBoletos" class="col-lg-12 col-md-12 col-sm-1 boletos-listado text-center justify-content-center">
                </div>
                </div>
            </div>
        </div>
        <!-- Team End -->

        <!-- Contact Start -->
        <a name="contacto"></a>
        <br>
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Contáctanos</h1>
                    <p class="mb-1">WHATSAPP:   <a href="https://api.whatsapp.com/send?phone=5216674681712&amp;text=Hola,+me+podrias+dar+mas+informacion..." target="_blank" title="">(667) 468 1712</a>   y   <a href="https://api.whatsapp.com/send?phone=5216672532900&amp;text=Hola,+me+podrias+dar+mas+informacion..." target="_blank" title="">(667) 253 2900</a></p>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.2s">

                    <div class="row g-5">
                        <div class="col-lg-3 col-md-3 col-sm-12"></div>
                        <div class="col-lg-3 col-md-3 col-sm-12 text-center">
                            <a href="#"><img src="img/redes/facebook.png" alt="Contáctanos" width="100"></a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 text-center">
                            <a href="#"><img src="img/redes/instagram.png" alt="Contáctanos" width="100"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
        

        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-white footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row gy-5 gx-4 pt-5">
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Frijolito de la Suerte</a>, Todos los Derechos Reservados. 
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
        <div id="listadoBoletos" class="row boletos-seleccionados bg-success">
            <div class="col-12 text-white text-center">
            <button id="btnApartar" class="btn btn-lg btn-secondary btn-sm">APARTAR</button>
            </div>
            <div class="col-12">
                <div id="pedidoBoletosAgregados" class="col-lg-6 offset-lg-3 text-center text-white boletos-agregados overflow-auto justify-content-center">
                </div>
            </div>
            
            <div class="col-12">
                <div id="pedidoBoletosListado" class="col-lg-6 offset-lg-3 text-center text-white boletos-listado overflow-auto justify-content-center">
                </div>
            </div>
        </div>

        <button id="btnBoletos" class="btn btn-lg btn-secondary btn-lg-square btn-boletos boletos">Boletos</button>>

        <!-- Back to Top -->
        <a href="#boletos" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <script>
        var sorteo_id = <?php echo $reg_sorteo['id'];?>;
        document.getElementById("listadoBoletos").style.display = "none";
    </script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>