
<?php
//echo $_SESSION['usu_clave'] .' - '. $_SESSION['usu_usuario'] .' - '. $_SESSION['rol_clave'];

if( $_SESSION['rol_clave'] <> 100 ) 
{
	session_start();
	session_destroy();

	die('

		<div class="container">
	
			<div class="row">
				
				<div class="span12" align="center">
					<br><br><br>
					
					<div class="error-container">
						<h1>ERROR DE USUARIO</h1>
						
						<h2>Su usuario no tiene permiso para este modulo del sistema.</h2>
						
						<div class="error-details">
							Debe iniciar sesi&oacute;n: <a href="../index.php">P&aacute;gina de inicio</a>
							
						</div> <!-- /error-details -->
									
					</div> <!-- /error-container -->			
					
				</div> <!-- /span12 -->
				
			</div> <!-- /row -->
			
		</div> <!-- /container -->

		');
}
?>