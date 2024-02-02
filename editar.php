<!DOCTYPE html>
<?php
	session_start();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
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
    $error="";
    if(isset($_GET['id'])){
        $publicacion=publicacion::traerPublicacion($_GET['id']);
    }else{
        $publicacion=publicacion::traerPublicacion($_POST['idPublicacion']);    
    }

    $texto=$publicacion->getTexto();
    $imagenTraida=$publicacion->getImagen();
    $audioTraido=$publicacion->getAudio();

    if(isset($_POST['boton']) ){
        $subcondicionAudio=$_FILES['audio']['name'] != "" || (!(is_null($audioTraido)) && $_FILES['audio']['name'] == "" && $_POST['audioBorrado']!="si");   
        $subcondicionImagen=$_FILES['image']['name'] != "" || (!(is_null($imagenTraida))&& $_FILES['image']['name'] == "" && $_POST['imagenBorrada']!="si");   
        $condicion = trim($_POST['texto']) != "" || $subcondicionImagen || $subcondicionAudio;

		if($condicion){
            $resu = procesar($imagenTraida,$audioTraido);
            if($resu==1){
                echo '<div id="redireccion">';
                echo '<h1>Publicacion editada correctamente. Redireccionando...</h1>';
                echo '</div>';
                header("refresh:5; url=misPublicaciones.php");
                exit;
            }else{
                echo '<div id="redireccion">';
                echo  '<h1>No se edito correctamente, redireccionando...</h1>';
                echo '</div>';
                header("refresh:3; url=misPublicaciones.php");
                exit;
            }
        }else{
            $error="Debe completar minimo con un texto,audio o imagen";
        }
    }
    
    

    function procesar($imagenTraida,$audioTraido){
        if(isset($_POST['texto'])){
            $texto=$_POST['texto'];
        }else{
            $texto=null;
        }
    
        if($_POST['imagenBorrada']=="si"){
            $rutaImagen= null;
        }elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {        // Verificar si se seleccionó una imagen

            $ubicacionTemporalImagen = $_FILES['image']['tmp_name'];
            $nombreImagen = $_FILES['image']['name'];
            $rutaImagen = './ImagenesSubidas/' . $nombreImagen; // Ruta donde se guardará la imagen en el servidor
            // Verificar si la imagen ya existe antes de intentar subirla

            if (!file_exists($rutaImagen)) {
                // Mover la imagen al directorio deseado
                move_uploaded_file($ubicacionTemporalImagen, $rutaImagen);
            }
        }elseif(!is_null($imagenTraida)){
            $rutaImagen=$imagenTraida;
        }else{
            $rutaImagen = null;
        }
    
        if($_POST['audioBorrado']=="si"){
            $rutaAudio= null;
        }elseif (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {        // Verificar si se seleccionó un audio
            $ubicacionTemporalAudio = $_FILES['audio']['tmp_name'];
            $nombreAudio = $_FILES['audio']['name'];
            $rutaAudio = './AudiosSubidos/' . $nombreAudio; // Ruta donde se guardará el audio en el servidor
             // Verificar si el audio ya existe antes de intentar subirlo
        if (!file_exists($rutaAudio)) {
            // Mover el audio al directorio deseado
            move_uploaded_file($ubicacionTemporalAudio, $rutaAudio);
        }
        } elseif(!is_null($audioTraido)){
            $rutaAudio = $audioTraido;
        }
        else {
            $rutaAudio = null;
        }

        return $resultado = Publicacion::actualizarPublicacion($_POST['idPublicacion'],$texto, $rutaImagen, $rutaAudio);
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
                <h1>Editar </h1>
                <form action="editar.php" id="idFormulario" name="formulario" method="post" enctype="multipart/form-data" >

                    <div class="fila ">
                        <label class="subtitulo">Texto (500 caracteres como máximo)</label> 

                        <div id="contenedorTextBotones">
                        <textarea name="texto" id="idTexto"  onkeydown ="validarCaracteres();"><?php if(!is_null($texto)){
                                echo $texto ;
                            }else{echo "";}?></textarea>

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
                        <input type="file" name="image" content="seleccionar imagen" id="idInputImagen" onchange="cambiarImagen();" value="<?php  if(!is_null($imagenTraida)){ echo  $imagenTraida;}else{echo "";}?>" class="file" accept="image/jpeg" max-width="1600" max-height="1200">
                        <label class="labelInput" for="idInputImagen">
                            <span class="file_texto"><span id="contenedorTextoImagen"><?php  if(!is_null($imagenTraida)){ echo  $imagenTraida;}else{echo "Ninguna imagen seleccionada";}?> </span></span>
                            <span class="file_boton">Buscar imagen</span>
                            <button type="button" id="idBorrarImagen" onclick="borrarImagen();"  class="botonBorrar"> Borrar Imagen</button>

                        </label> 
                    </div>
                    <input type="hidden" id="idImagenBorrada" name="imagenBorrada">
                    <div class="fila">
                        <label class="subtitulo">Audio (solo mp3 y 30 segundos como máximo)</label> 
                        <input type="file" content="seleccionar audio" name="audio" id="idInputAudio" onchange="cambiarAudio();" class="file" value="<?php  if(!is_null($audioTraido)){ echo  $audioTraido;}else{echo "";}?>" accept="audio/mp3" max-length="30000">
                        <label class="labelInput" for="idInputAudio">
                            <span class="file_texto"> <span id="contenedorTextoAudio"><?php  if(!is_null($audioTraido)){ echo  $audioTraido;}else{echo "Ningun audio seleccionado";}?>   </span></span>
                            <span class="file_boton">Buscar audio</span>
                            <button type="button" id="idBorrarAudio" onclick="borrarAudio();" class="botonBorrar"> Borrar Audio</button>
                        </label> 
                    </div>
                    <input type="hidden" id="idAudioBorrado" name="audioBorrado">
                    <input type="hidden" name="idPublicacion" value=
                    "<?php  if(isset($_GET['id'])){
                        echo $_GET['id'];
                    }else{
                        echo $_POST['idPublicacion'];}                   
                    ?>">

                    <input type="submit" name="boton"  id="idBoton" value="aceptar">
                    <p><?php echo $error; ?> </p>

                </form>
            </div>
        <article>

    </section>

</body>

</html>