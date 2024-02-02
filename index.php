<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>privaNet</title>
	<link rel="stylesheet" href="menuInicial.css">
	<script src="menuInicial3.js"></script>

</head>
<?php
	if (isset($_SESSION['ingreso'])){
		$nombre = $_SESSION['nombre'];
		echo '<body onload="traerPublicacionesLog(0,\'' . $nombre . '\', \'paraTi\');">';
	} else {
		echo '<body onload="traerPublicacionesNoLog(0);">'; 
	}

?>	
	<header id="contenedorSuperior">

			<div id="logo">
				<img src="./imagenes/logo.svg" id="logo" alt="logo priva net" />	
			</div>

			<div id="contenedorBuscador">
				<input type="text" name="buscador" id="idBuscador" placeholder="Buscar" onKeyup="buscarPublicaciones();" list="resultados">
				<div id="resultados"></div>
				<button type="sumbit" name="buscador" id="idBotonBuscador"><img src="./imagenes/lupa.png" id="idLupa" alt="lupa" />
			</div>


			<?php
			date_default_timezone_set('America/Buenos_Aires');
			if (isset($_SESSION['ingreso'])){
				$fechaAlmacenada = $_COOKIE[$_SESSION['nombre']];
				$fechaActual = new DateTime();
				$fechaAlmacenada = DateTime::createFromFormat('Y-m-d', $fechaAlmacenada);
				$intervalo = $fechaActual->diff($fechaAlmacenada);
				$diasPasados = $intervalo->format("%a"); // Obtener el número de días del intervalo
			?>	
			<div class="menuSuperior" id="contenedorBienvenida">
				<div id="contenedorTextoBienvenida"><p class="bienvenida">Bienvenido <?php echo $_SESSION['nombre'].". Lleva ".$diasPasados." dias desde su ultimo acceso"?></p></div>
				<nav>
				<a href="cerrarSesion.php">Cerrar sesión </a>
				</nav>

			
			<?php
			}else{	
			?>
			<nav class="menuSuperior">
				<a href="iniciarSesion.php">Iniciar sesión </a>
				<a href="registrarse.php">Registrarse</a>
			</nav>
			<?php
			}
			?>
			</div>

	</header>
		<div id="contenedorIzquierdo">
			<nav  id="menuIzquierdo">
				<a href="publicar.php">Publicar</a>
				<a href="misPublicaciones.php">Mis publicaciones</a>
				<a href="meGustas.php">Me gustas</a>
				<a href="favoritos.php">Favoritos</a>
				<a href="noMeGustas.php">No me gustas</a>
			</nav>
		</div>
		<div id="contenedorCentral">
			


		</div>
		<div id="contenedorDerecho">
			<div id="contenedorCambiarModo">
				<p <?php if (isset($_SESSION['ingreso'])){ echo 'onclick="cambiarParati(\'' . $nombre . '\')"'; }?>;>Para ti</p>
				<p <?php if (isset($_SESSION['ingreso'])){ echo 'onclick="cambiarExplorar(\'' . $nombre . '\')"';  }?>;>Explorar</p>
			</div>
			<div id="contenedorIrVolver">
				<img src="./imagenes/volverChiquito.svg" <?php 
					if (isset($_SESSION['ingreso'])){	
						echo 'onclick="volver(\'' . $nombre . '\')"'; }
					else{
						echo 'onclick="volverNolog()"'; 
					}
				?>id="volverId" alt="volver" />	
				<img src="./imagenes/irChiquito.svg" <?php 
					if (isset($_SESSION['ingreso'])){	
						echo 'onclick="avanzar(\'' . $nombre . '\')"'; }
					else{
						echo 'onclick="avanzarNolog()"'; 
					}				
				?>id="irId" alt="ir" />	
			</div>
		</div>

</body>
</html>
