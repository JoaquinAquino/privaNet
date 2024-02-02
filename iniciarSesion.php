<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="inicioSesion.css">

</head>
<body>
    <?php
    $nombreCampo="";
    $contraseniaCampo="";
    $nombre="";
    $contrasenia="";

    if(isset($_POST['boton'])){
        date_default_timezone_set('America/Buenos_Aires');
        include_once("./clases/usuario.class.php");
        $nombre=$_POST['nombre'];
        $contrasenia=$_POST['contrasenia'];


        switch (Usuario::userExist($nombre,$contrasenia)) {
            case '1':/*el nombre no coincide*/
                $nombreCampo=" **nombre incorrecto!!";
            break;
            case '2':/*el nombre y la contrasenia coinciden*/
                if (!isset($_COOKIE[$nombre])){
                    $fecha=date("Y-m-d");
                    setcookie($nombre,$fecha,time()+(30 * 24 * 60 * 60));
                }
                    $_SESSION['ingreso']=true;
                    $_SESSION['nombre']=$nombre;

                    header("Location: index.php");
                    exit;
            break;
            case '3':/*la contrasenia no coincide*/
                $contraseniaCampo=" **contrasennia incorrecta!!";

            break;
        }
                
    }
    ?>
    <section>
        <article><img src="./imagenes/logo2.svg" id="logo" alt="logo priva net" /></article>
        <article>
            <div id="formu">
                <h1>Inicio de sesión</h1>
                <form action="iniciarSesion.php" id="idFormulario" name="formulario" method="post">
                    <div class="fila">
                        <label>Nombre de usuario</label> <p id="error"><?php echo $nombreCampo; ?></P>
                        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required>
                    </div>
                    <div class="fila">
                        <label>contrasenia </label> <p id="error"><?php echo $contraseniaCampo; ?></P>
                        <input type="password" name="contrasenia" value="<?php echo $contrasenia; ?>" required>
                    </div>
                    
                    <input type="submit" name="boton" value="Iniciar">
                </form>
                <div id="registrarse"><a href="registrarse.php"> Crear cuenta nueva</a></div>
            </div>
        <article>    
    </section>
</body>
</html>
