
<?php
include_once("./clases/usuario.class.php");
$usuarios = Usuario::obtenerNombres();
$letras= $_GET['letras'];

$estado = "usuario valido";

foreach ($usuarios as $usuario) {
	
    if ($letras == $usuario->getNombre()) {
		$estado = "usuario no valido";
		break;	
    }
}

$myJSON =json_encode($estado);
echo $myJSON;

?>