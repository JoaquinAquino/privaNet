<!DOCTYPE html>
<?php
	session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me gustas</title>
    <link rel="stylesheet" href="pagina.css">
    <script src="menuInicial3.js"></script>

</head>
<?php
    if(!(isset( $_SESSION['ingreso']))){
        header("Location: iniciarSesion.php");
        exit;
    }
    $nombre=$_SESSION['nombre'];

    ?>
<body onload="traerPublicacionesLog('0', '<?php echo $nombre; ?>', 'likes');">
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
        <div id="contenedorIrVolver">
                    <img src="./imagenes/volverChiquito.svg" <?php 
                    echo 'onclick="volverLikesDislikesFav(\'' . $nombre . '\', \'likes\')"'; 
                    
                    ?>id="volverId" alt="volver" />	
                    <img src="./imagenes/irChiquito.svg" <?php 
                    echo 'onclick="avanzarLikesDislikesFav(\'' . $nombre . '\', \'likes\')"'; 
            
                    ?>id="irId" alt="ir" />	
        </div>
    </div>

</body>

</html>