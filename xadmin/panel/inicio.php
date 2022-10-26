<?php session_start();?>
<?php include_once('../config/enviroment.php');?>
<?php include("../estructura/header.php");?>

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
                <p class="mb-1">&nbsp;</p>
                <p class="mb-1">&nbsp;</p>
                <p class="mb-1">&nbsp;</p>
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h5 class="mb-3">www.sorteosfrijolitodelasuerte.com</h5>
                    <p class="mb-1">&nbsp;</p>
                </div>
                <p class="mb-1">&nbsp;</p>
                <p class="mb-1">&nbsp;</p>
                <p class="mb-1">&nbsp;</p>
            </div>
        </div>
        <!-- Comparison Start -->

<?php include("../estructura/footer.php");?>


</body>
</html>