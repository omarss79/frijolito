<?php
//echo $_SESSION['usu_clave'] .' - '. $_SESSION['usu_usuario'] .' - '. $_SESSION['rol_clave'];

if(
		!isset($_SESSION['usu_clave']) || 
		!isset($_SESSION['usu_usuario']) || 
		!isset($_SESSION['rol_clave']) || 
	
		$_SESSION['usu_clave'] == "" || 
		$_SESSION['usu_usuario'] == "" || 
		$_SESSION['rol_clave'] == ""
		) 
{
	die('

		<div class="container">
	
			<div class="row">
				
				<div class="span12" align="center">
					<br><br><br>
					<div class="error-container">
						<h1>SESION EXPIRADA</h1>
						
						<h2>El tiempo de tu sesi&oacute;n se agoto.</h2>
						
						<div class="error-details">
							Debe iniciar sesion: <a href="../index.php">P&aacute;gina de inicio</a>
							
						</div> <!-- /error-details -->
						
									
					</div> <!-- /error-container -->			
					
				</div> <!-- /span12 -->
				
			</div> <!-- /row -->
			
		</div> <!-- /container -->

		');
}?>