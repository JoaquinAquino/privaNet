<!DOCTYPE html>
<?php
	session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
    <link rel="stylesheet" href="publicar.css">
    <script src="publicar2.js"></script>

</head>
<body>
<?php
    if(!(isset( $_SESSION['ingreso']))){
        header("Location: iniciarSesion.php");
        exit;
    }
    include_once("./clases/publicacion.class.php");

    if(isset($_POST['boton'])){   
		
		$resu = publicacion::eliminarPublicacion($_POST['idPublicacion']);
		if($resu==1){
            echo '<div id="redireccion">';
            echo '<h1>Publicacion eliminada correctamente. Redireccionando...</h1>';
            echo '</div>';
            header("refresh:5; url=misPublicaciones.php");
            exit;
        }else{
            echo '<div id="redireccion">';
            echo  '<h1>No se elimino correctamente, redireccionando...</h1>';
            echo '</div>';
            header("refresh:3; url=misPublicaciones.php");
        }
    }else{
        $publicacion=publicacion::traerPublicacion($_GET['id']);
        $texto=$publicacion->getTexto();
        $imagen=$publicacion->getImagen();
        $audio=$publicacion->getAudio();

    }


    ?>
    <section>
        <article>
            <a href="misPublicaciones.php">
                <img src="./imagenes/flecha.png" id="idImagen" alt="flecha izquierda">
            </a>
        </article>

        <article>    
            <div id="contenedor">
                <h1>Eliminar </h1>
                <form action="eliminar.php" id="idFormulario" name="formulario" method="post">
                    <div class="fila ">
                        <label class="subtitulo">Texto </label> 
                        <div id="contenedorTexto"><?php 
                        if(!is_null($texto)){
                            echo $texto ;
                        }
                        ?></div>              
                    </div>

                    <div class="fila">
                        <label class="subtitulo">Imagen</label>
                        <?php
                        if(!is_null($imagen)){
                            echo '<img src="' . $imagen . '" id="imagenPublicacion" alt="imagen de la publicación">';
                        }
                        ?>                    
                        </div>

                    <div class="fila">
                        <label class="subtitulo">Audio </label> 
                        <?php
                        if(!is_null($audio)){
                            echo '<audio controls>';
                            echo '<source src="' . $publicacion->getAudio() . '" type="audio/mpeg">';
                            echo '</audio>';                     
                        }
                    
                        ?>                
                    </div>
                    <input type="hidden" name="idPublicacion" value="<?php echo $_GET['id'] ?>">

                    <input type="submit" name="boton"  id="idBoton" value="aceptar">
                </form>
            </div>
        <article>

    </section>

</body>

</html>