
<?php
include_once("./clases/publicacion.class.php");
include_once("./clases/interaccion.class.php");


$nro = $_POST["publicacionesVistas"];
$nombre = $_POST["nombre"];

function cambiadorNulo($variable){
    if (is_null($variable)){
        return "vacio";
    }else{
        return $variable;
    }
}
$modo=$_POST["modo"];
switch ($modo) {
    case "paraTi":
        $publicaciones = Publicacion::obtenerPublicacionesLogParaTi($nro, $nombre);
        break;
    case "explorar":
        $publicaciones = Publicacion::obtenerPublicacionesLogExplorar($nro, $nombre);
        break;
    case "likes":
        $publicaciones = Publicacion::obtenerPublicacionesLikes($nro, $nombre);
        break;
    case "dislikes":
        $publicaciones = Publicacion::obtenerPublicacionesDisLikes($nro, $nombre);
        break;
    case "favoritos":
        $publicaciones = Publicacion::obtenerPublicacionesFavoritos($nro, $nombre);
        break;
    case "misPublicaciones":
        $publicaciones = Publicacion::obtenerMisPublicaciones($nro, $nombre);
        break;
}

$listado=array();
foreach ($publicaciones as $publicacion) {
	$objTemp = new StdClass();
    $objTemp->idPublicacion =$publicacion->getidPublicacion();
	$objTemp->texto =cambiadorNulo($publicacion->getTexto());
	$objTemp->imagen =cambiadorNulo($publicacion->getImagen());
	$objTemp->audio =cambiadorNulo($publicacion->getAudio());
	$objTemp->fecha =$publicacion->getFecha();
	$objTemp->nombreAutor =$publicacion->getNombreAutor();
    $objTemp->like= Interaccion::obtenerLike($publicacion->getidPublicacion(),$nombre);
    $objTemp->dislike= Interaccion::obtenerDisLike($publicacion->getidPublicacion(),$nombre);
    $objTemp->favorito= Interaccion::obtenerFavorito($publicacion->getidPublicacion(),$nombre);
    if($modo="misPublicaciones"){
        $objTemp->nroLikes= Interaccion::obtenerNroLikes($publicacion->getidPublicacion());
        $objTemp->nroDislikes= Interaccion::obtenerNroDisLikes($publicacion->getidPublicacion());
        $objTemp->nroFavoritos= Interaccion::obtenerNroFavoritos($publicacion->getidPublicacion());
    }

	$listado[] =$objTemp;

}

$myJSON = json_encode($listado);
echo $myJSON;


?>