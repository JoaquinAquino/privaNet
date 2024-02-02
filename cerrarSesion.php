<?php
	session_start();
    date_default_timezone_set('America/Buenos_Aires');
    $fechaActual = new DateTime();
    $fechaActualFormateada = $fechaActual->format('Y-m-d');
    if (isset($_SESSION['nombre'])){
    setcookie($_SESSION['nombre'], $fechaActualFormateada, time()+(30 * 24 * 60 * 60));
    }
	$_SESSION=array();
	session_destroy();
    header('Location: index.php');

?>