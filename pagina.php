<!DOCTYPE html>
<?php
	session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagina</title>
    <link rel="stylesheet" href="pagina.css">
    <script src="menuInicial3.js"></script>

</head>
<?php
    if(!(isset( $_SESSION['ingreso']))){
        header("Location: iniciarSesion.php");
        exit;
    }
    $nombreUsuario=$_SESSION['nombre'];
    $idPublicacion=$_GET['id'];
    include_once("./clases/interaccion.class.php");
    include_once("./clases/publicacion.class.php");
    $like=Interaccion::obtenerLike($idPublicacion,$nombreUsuario);
    $dislike=Interaccion::obtenerDisLike($idPublicacion,$nombreUsuario);
    $favorito=Interaccion::obtenerFavorito($idPublicacion,$nombreUsuario);
    $publicacion=Publicacion::traerPublicacion($idPublicacion);
    $texto = empty($publicacion->getTexto()) ? "vacio" : $publicacion->getTexto();
    $audio = empty($publicacion->getAudio()) ? "vacio" : $publicacion->getAudio();
    $imagen = empty($publicacion->getImagen()) ? "vacio" : $publicacion->getImagen();

    echo '<body onload="crearPublicacionUnica(\'' . $texto . '\', \'' . $publicacion->getidPublicacion() . '\', \'' . $audio . '\', \'' .  $imagen . '\', \'' . $publicacion->getFecha() . '\', \'' . $publicacion->getNombreAutor() . '\', ' . $like . ', ' . $dislike . ', ' . $favorito . ');">';

      ?>

	<header id="contenedorSuperior">
        <div id="logo">
            <img src="./imagenes/logo.png" id="logo" alt="logo priva net" />	
        </div>
    </header>


    <div id="contenedorIzquierdo">
        <a href="index.php">
            <img src="./imagenes/flecha.png" id="idImagen" alt="flecha izquierda">
        </a>
    </div>
    <div id="contenedorCentral">
    </div>
    <div id="contenedorDerecho">
    </div>

</body>

</html>