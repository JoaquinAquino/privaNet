<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="registrarse.css">
</head>
<body>
<?php
    if(isset($_POST['boton'])){
        include_once("./clases/usuario.class.php");
        $pass_cifrado=password_hash($_POST['contrasenia'],PASSWORD_DEFAULT);
        $resu = Usuario::subirUsuario($_POST['nombre'],$pass_cifrado,$_POST['correo'],$_POST['fechaNac'],$_POST['paises'],);
        if($resu==1){     
            ?>
            <div id="redireccion">
                <h1>Registro exitoso, redireccionando...</h1>
            </div>
            <?php
            header("refresh:5; url=iniciarSesion.php");
            exit;
        }else{
            ?>
            <div id="redireccion">
                <h1>Registro no exitoso</h1>
            </div>
            <?php
            header("refresh:5; registrarse.php");
            exit;
        }
        exit;
    }

    ?>
    <section>
        <article>
            <div id="formu">
                <h1>Registrarse</h1>
                <form action="registrarse.php" id="idFormulario" name="formulario" method="post">

                    <div class="fila">
                        <label id="idLabelNombre">Nombre de usuario  <span id="idCampoNombre"> </span></label>
                        <input  type="text" name="nombre" class="input1" maxlength="26"  id="idNombreUsuario" onkeyup='validarNombre();' required>
                    </div>

                    <div class="fila">
                        <label>fecha de nacimiento <span id="idCampoFecha"> </span></label>
                        <input type="date"  name="fechaNac" class="input1" id="idFechaNac"  oninput='validarFecha();' required>
                    </div>

                    <div class="fila">
                        <label>pais de residencia <span id="idCampoPais"> </span></label>
                        <select name="paises" id="idPaises"  oninput='validarPais();'>
                            <option value="0">Seleccione un país</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Uruguay">Uruguay</option>
                            <option value="Brasil">Brasil</option>
                            <option value="Chile">Chile</option>
                        </select>                   
                    </div>

                    <div class="fila">
                        <label>correo <span id="idCampoCorreo"> </span></label>
                        <input type="email" name="correo"  class="input1" maxlength="30" id="idCorreo" onchange='validarCorreo();' required>
                    </div>

                    <div class="fila">
                        <label>Contrasenia <span id="idCampoContrasenia"> </span></label>
                        <input type="password" name="contrasenia" class="input1" maxlength="26" oninput='validarContrasenia();' id="idContrasenia" required>
                    </div>

                    <div class="fila">
                        <label>Vuelva a escribir su contrasenia <span id="idCampoContraseniaRepetida"> </span></label>
                        <input type="password" name="contraseniaRepetida" class="input1" maxlength="26" oninput='validarContraseniaRepetida();' id="idContraseniaRepetida" required>
                    </div>

                    <input type="submit" name="boton" id="idBoton" value="registrarse">
                </form>
                <div id="registrarse"><a href="iniciarSesion.php">Ya tienes una cuenta? inicia sesion </a></div>
            </div>
        <article>

    </section>
    <script src="registrarse.js"></script>

</body>
</html>