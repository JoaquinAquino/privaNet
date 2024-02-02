<!DOCTYPE html>
<?php
	session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar</title>
    <link rel="stylesheet" href="publicar.css">
    <script src="publicar2.js"></script>

</head>
<body>
<?php
    date_default_timezone_set('America/Buenos_Aires');
    if(!(isset( $_SESSION['ingreso']))){
        header("Location: iniciarSesion.php");
        exit;
    }
    include_once("./clases/publicacion.class.php");
    if(isset($_POST['boton']) && isset($_POST['programarSubida'])){   // publicar con fecha programada
        $resultado=procesar();
        if($resultado==1){
            echo '<div id="redireccion">';
            echo '<h1>publicación programada para el                '.$_POST["fecha"].' a las '.$hora = $_POST['horaInput'].'. Redireccionando...</h1>';
            echo '</div>';
            header("refresh:5; url=index.php");
            exit;
        }else{
            echo '<div id="redireccion">';
            echo  '<h1>no se publico correctamente, redireccionando...</h1>';
            echo '</div>';
            header("refresh:3; url=index.php");
        }
    }else if (isset($_POST['boton'])) { // publicar sin fecha programada
        $resultado=procesar();
        if($resultado==1){
            echo '<div id="redireccion">';
            echo '<h1>publicado exitosamente, redireccionando...</h1>';
            echo '</div>';
            header("refresh:3; url=index.php");
            exit;
        }else{
            echo '<div id="redireccion">';
            echo  '<h1>no se publico correctamente, redireccionando...</h1>';
            echo '</div>';
            header("refresh:3; url=index.php");
        }
    }


    function procesar(){
        $texto = $_POST['texto'];
        $usuario = $_SESSION['nombre'];
    
        // Verificar si se seleccionó una imagen
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ubicacionTemporalImagen = $_FILES['image']['tmp_name'];
            $nombreImagen = $_FILES['image']['name'];
            $rutaImagen = './ImagenesSubidas/' . $nombreImagen; // Ruta donde se guardará la imagen en el servidor
    
            // Mover la imagen al directorio deseado
            move_uploaded_file($ubicacionTemporalImagen, $rutaImagen);

        } else {
            $rutaImagen = null;
        }
    
        // Verificar si se seleccionó un audio
        if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
            $ubicacionTemporalAudio = $_FILES['audio']['tmp_name'];
            $nombreAudio = $_FILES['audio']['name'];
            $rutaAudio = './AudiosSubidos/' . $nombreAudio; // Ruta donde se guardará el audio en el servidor
    
            // Mover el audio al directorio deseado
            move_uploaded_file($ubicacionTemporalAudio, $rutaAudio);
        } else {
            $rutaAudio = null;

        }
        

        if(isset($_POST['programarSubida'])){
            $hora = $_POST['horaInput'].":00";
            $fechaSola = $_POST['fecha'];
            $fecha=  $fechaSola." ".$hora;
        }else{
            $fecha= date("Y-m-d H:i:s");
 
        }

        return $resultado = Publicacion::subirPublicacion($texto, $rutaImagen, $rutaAudio, $usuario, $fecha);
    }

    ?>
    <section>
        <article>
            <a href="index.php">
                <img src="./imagenes/flecha.png" id="idImagen" alt="flecha izquierda">
            </a>
        </article>

        <article>    
            <div id="contenedor">
                <h1>Publicar </h1>
                <form action="publicar.php" id="idFormulario" name="formulario" method="post" enctype="multipart/form-data" onsubmit="return validarTodo();">
                    <div class="fila ">
                        <label class="subtitulo">Texto (500 caracteres como máximo)</label> 

                        <div id="contenedorTextBotones">
                        <textarea name="texto" id="idTexto"  onkeydown ="validarCaracteres();"></textarea>
                            <div id="contenedorBotones">
                                <button type="button" id="idBotonNegirat" onclick="actDesNegrita();">N</button>
                                <button type="button"> K</button>
                                <button type="button"> S</button>
                                <button type="button"> r</button>
                            </div>
                        </div>
                    </div>

                    <div class="fila">
                        <label class="subtitulo">Imagen (solo jpeg y 1600x1200px como máximo)</label> 
                        <input type="file" name="image" content="seleccionar imagen" id="idInputImagen" onchange="cambiarImagen();" class="file" accept="image/jpeg" max-width="1600" max-height="1200">
                        <label class="labelInput" for="idInputImagen">
                            <span class="file_texto"><span id="contenedorTextoImagen">Ninguna imagen seleccionada</span></span>
                            <span class="file_boton">Buscar imagen</span>
                        </label> 

                    </div>
                    <div class="fila">
                        <label class="subtitulo">Audio (solo mp3 y 30 segundos como máximo)</label> 
                        <input type="file" content="seleccionar audio" name="audio" id="idInputAudio" onchange="cambiarAudio();" class="file" accept="audio/mp3" max-length="30000">
                        <label class="labelInput" for="idInputAudio">
                            <span class="file_texto"> <span id="contenedorTextoAudio">Ningún audio seleccionada   </span></span>
                            <span class="file_boton">Buscar audio</span>
                        </label> 
                    </div>
                    <div class="fila">
                        <div>
                            <label class="subtitulo">Programar Subida</label> 
                            <input type="checkbox" name="programarSubida" id="idCheck"  onchange="activarProgramar();">
                        </div>
                    </div>

                    <div class="filaOculta">
                            <label class="subtitulo">Hora: </label> 
                            <input type="time" name="horaInput" id="idHoraInput" onchange="validarHora();">
                    </div>

                    <div class="filaOculta">  
                            <label class="subtitulo">Fecha: </label> 
                            <select name="fecha" id="idFechas"  onchange='validarFecha();'>
                                <option value="0">Seleccione una fecha</option>
                                <?php                  
                                    $fechaActual = date("Y-m-d");
                                    $fechaManana = date("Y-m-d", strtotime("+1 day"));
                                    $fechaPasadoManana = date("Y-m-d", strtotime("+2 day"));

                                    echo '<option value="' . $fechaActual . '">' . $fechaActual . '</option>';
                                    echo '<option value="' . $fechaManana . '">' . $fechaManana . '</option>';
                                    echo '<option value="' . $fechaPasadoManana . '">' . $fechaPasadoManana . '</option>';

                                ?>
                            </select>                      
                    </div>
                    <input type="hidden" id="idImagenBorrada" name="imagenBorrada">
                    <input type="hidden" id="idAudioBorrado" name="audioBorrado">
                    <input type="submit" name="boton"  id="idBoton" value="publicar">
                    <p id="idError"> </p>
                </form>
            </div>
        <article>

    </section>

</body>

</html>