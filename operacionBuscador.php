
<?php
include_once("./clases/publicacion.class.php");
$letras= $_POST['letras'];
$publicaciones = Publicacion::obtenerPublicacionesBuscador($letras);
$listado=array();


foreach ($publicaciones as $publicacion) {

    $objTemp = new StdClass();
    $objTemp->idPublicacion =$publicacion->getidPublicacion();
    $objTemp->nombreAutor =$publicacion->getNombreAutor();
    $objTemp->texto =$publicacion->getTexto();

    $listado[] = $objTemp; 

}


$myJSON =json_encode($listado);
echo $myJSON;

?>