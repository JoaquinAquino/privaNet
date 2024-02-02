
<?php
include_once("./clases/publicacion.class.php");


$nro = $_POST["publicacionesVistas"];

function cambiadorNulo($variable){
if (is_null($variable)){
	return "vacio";
}else{
	return $variable;
}
}
$publicaciones = Publicacion::obtenerPublicacionesnoLog($nro);


$listado=array();

foreach ($publicaciones as $publicacion) {
	$objTemp = new StdClass();
	$objTemp->texto =cambiadorNulo($publicacion->getTexto());
	$objTemp->imagen =cambiadorNulo($publicacion->getImagen());
	$objTemp->audio =cambiadorNulo($publicacion->getAudio());
	$objTemp->fecha =$publicacion->getFecha();
	$objTemp->nombreAutor =$publicacion->getNombreAutor();
	$listado[] =$objTemp;

}

$myJSON = json_encode($listado);
echo $myJSON;


?>