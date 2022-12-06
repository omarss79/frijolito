<?php session_start();?>
<?php $_SESSION['id'] = session_id();?>
<?php // echo $_SESSION['id'];?>
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
    <title>Verificador - Frijolito de la Suerte</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="./img/favicon.ico" rel="icon">

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
    <link href="css/pagos.css" rel="stylesheet">
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
                <a href="pagos.php" class="navbar-pagos p-0">
                    <img src="img/tc.png" alt="Frijolito de la suerte" width="60" class="img-fluid">
                </a>
                <a href="index.php" class="navbar-brand p-0">
                    <img src="img/logo-frijolito-de-la-suerte.jfif" alt="Frijolito de la suerte" class="img-fluid">
                </a>
                <a href="<?php if($num_sorteo > 0){?>sorteo.php<?php }else{?>index.php<?php }?>" class="btn btn-secondary py-2 ">Verificador</a>
            </nav>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Pricing Start -->
        <br>
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Datos Bancarios</h1>
                    <!-- <p class="mb-1">Vero justo sed sed vero clita amet. Et justo vero sea diam elitr amet ipsum eos ipsum clita duo sed. Sed vero sea diam erat vero elitr sit clita.</p> -->
                </div>
            </div>
        </div>
        <!-- Pricing End -->

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
        
        <!-- Back to Top -->
        <a href="#boletos" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

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
    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>