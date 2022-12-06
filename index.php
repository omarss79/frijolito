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
                <a href="pagos.php" class="navbar-pagos p-0">
                    <img src="img/tc.png" alt="Frijolito de la suerte" width="60" class="img-fluid">
                </a>
                <a href="index.php" class="navbar-brand p-0">
                    <img src="img/logo-frijolito-de-la-suerte.jfif" alt="Frijolito de la suerte" class="img-fluid">
                </a>
                <a href="<?php if($num_sorteo > 0){?>sorteo.php<?php }else{?>index.php<?php }?>" class="btn btn-secondary py-2 ">Comprar Boletos</a>
            </nav>

            <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <?php if($num_sorteo > 0){?>
                        <div class="row g-5">
                            <div class="col-lg-6 pt-5 text-center text-lg-start">
                                <h1 class="display-4 text-white mb-4 animated slideInLeft"><?php echo $reg_sorteo['invitacion'];?></h1>
                                <h6 class="display-6 text-white mb-2 animated slideInLeft"><?php echo $reg_sorteo['premio_1'];?></h6>
                                <p class="text-white animated slideInLeft">Sorteo: <?php echo regresarFechaDiaMesAno($reg_sorteo['fecha_limite']);?></p>
                                <h1 class="text-white mb-4 animated slideInLeft">
                                    <small class="align-top fw-normal" style="font-size: 15px; line-height: 25px;">Boleto:</small>
                                    <span>$<?php echo $reg_sorteo['precio_boleto'];?></span>
                                    <!-- <small class="align-bottom fw-normal" style="font-size: 15px; line-height: 33px;">/ Mo</small> -->
                                </h1>
                                <a href="sorteo.php" class="btn btn-secondary py-sm-3 px-sm-5 me-3 animated slideInLeft">¡Participa!</a>
                            </div>
                            <div class="col-lg-6 text-center text-lg-start">
                                <img class="img-thumbnail animated zoomIn" src="<?php echo $reg_sorteo['premio_1_url'];?>" alt="">
                            </div>
                        </div>
                    <?php }
                    else{?>
                        <div class="row g-5">
                            <div class="col-lg-12 pt-5 text-center text-lg-start">
                                <!-- <h1 class="display-4 text-white mb-4 animated slideInLeft"><?php echo $reg_sorteo['invitacion'];?></h1> -->
                                <h6 class="display-6 text-white mb-2 animated slideInLeft">Por el momento no se tiene sorteo publicado</h6>
                            </div>
                            <div class="col-lg-12 pt-5 text-center text-lg-start"><br></div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Domain Search Start -->
        <br>
        <div class="container-xxl domain mb-5" style="margin-top: 90px;">
            <div class="container px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="section-title position-relative text-center mx-auto mb-4 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                            <h1 class="mb-3">¿CÓMO SE ELIGE A LOS GANADORES?</h1>
                            <h5>Todos nuestros sorteos se realizan en base a la<br><a href="http://www.lotenal.gob.mx" target="_blank">Lotería Nacional para la Asistencia Pública</a> mexicana.</h5>
                            <p class="mb-1">El ganador de Sorteos Frijolito De La Suerte será el participante cuyo número de boleto coincida con las últimas cifras del primer premio ganador de la Lotería Nacional (las fechas serán publicadas en nuestra página oficial, así como los ganadores).</p>
                        </div>
                        <div class="section-title position-relative text-center mx-auto mb-4 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                            <h1 class="mb-3">¿QUÉ SUCEDE CUANDO EL NÚMERO GANADOR ES UN BOLETO NO VENDIDO?</h1>
                            <p class="mb-1">Se elige un nuevo ganador realizando la misma dinámica en otra fecha cercana (se anunciará la nueva fecha).</p>
                            <p class="mb-1">Esto significa que, ¡Tendrías el doble de oportunidades de ganar con tu mismo boleto!</p>
                            <p class="mb-1">En pre-sorteos se valorará si se pasa a la fecha más cercana de otro sorteo o se realiza una dinámica diferente (como tomar el segundo lugar si este aun no ha salido, esto será anunciado con anticipación si fuera este el caso).</p>
                        </div>
                        <div class="section-title position-relative text-center mx-auto mb-4 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                            <h1 class="mb-3">¿DÓNDE SE PUBLICA A LOS GANADORES?</h1>
                            <p class="mb-1">¡En nuestra página oficial de Facebook Sorteos Frijolito De La Suerte puedes encontrar todos y cada uno de nuestros sorteos anteriores, así como las transmisiones en vivo con Lotería Nacional y las entregas de premios a los ganadores!</p>
                            <p class="mb-1">Encuentra transmisión en vivo de los sorteos en nuestra página de Facebook en las fechas indicadas a las 19:00 horas Culiacán. ¡No te lo pierdas!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Domain Search End -->


        <!-- About Start -->
        <a name="nosotros"></a>
        <br>
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-4">
                            <h1 class="mb-2">ACERCA DE NOSOTROS</h1>
                        </div>
                        <p class="mb-4">Sorteos entre amigos basados en La Lotería Nacional</p>
                        <p class="mb-4">Haga más con menos porque el que busca encuentra.</p>
                    </div>
                    <div class="col-lg-5">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="img/logo-frijolito-de-la-suerte-blanco.jfif">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

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
        
        <?php if($num_sorteo > 0){?>
            <div class="container-xxl py-5">
                <div class="container px-lg-5">
                    <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                        <h1 class="mb-3">PREMIOS</h1>
                        <p class="mb-1">Con tu boleto liquidado participas por:</p>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item border-top border-5 border-primary rounded shadow overflow-hidden">
                                <div class="text-center p-4">
                                    <img class="img-fluid rounded-circle mb-4" src="<?php echo $reg_sorteo['premio_1_url'];?>" alt="">
                                    <h5 class="fw-bold mb-1"><?php echo $reg_sorteo['premio_1'];?></h5>
                                </div>
                                <div class="text-center d-flex justify-content-center bg-primary p-3">
                                    <div class="fw-bold text-white mb-4">Primer Premio <br> <?php echo regresarFechaDiaMesAno($reg_sorteo['fecha_limite']);?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4"><div class="col-12">&nbsp;<br></div></div>
                    <div class="row g-4">
                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item border-top border-5 border-primary rounded shadow overflow-hidden">
                                <div class="text-center p-4">
                                    <!-- <img class="img-fluid rounded-circle mb-4" src="img/logo-frijolito-de-la-suerte.jfif" alt=""> -->
                                    <h5 class="fw-bold mb-1"><?php echo $reg_sorteo['premio_2'];?></h5>
                                </div>
                                <div class="d-flex justify-content-center bg-primary p-3">
                                    <div class="fw-bold text-white mb-4">Segundo Premio</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item border-top border-5 border-primary rounded shadow overflow-hidden">
                                <div class="text-center p-4">
                                    <!-- <img class="img-fluid rounded-circle mb-4" src="img/logo-frijolito-de-la-suerte.jfif" alt=""> -->
                                    <h5 class="fw-bold mb-1"><?php echo $reg_sorteo['premio_3'];?></h5>
                                </div>
                                <div class="d-flex justify-content-center bg-primary p-3">
                                    <div class="fw-bold text-white mb-4">Tercer Premio</div>
                                </div>
                            </div>
                        </div>
                        
                </div>
            </div>
        <?php }?>

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


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>