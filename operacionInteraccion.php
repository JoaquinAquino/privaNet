
<?php
	session_start();

include_once("./clases/interaccion.class.php");


$nombreUsuario= $_SESSION['nombre'];
$idPublicacion = $_POST["idPublicacion"];
$estado = $_POST["estado"];

switch ($_POST["tipoInteraccion"]) {
    case "like":
        if($estado==1){
            $resu=Interaccion::agregarLike($idPublicacion,$nombreUsuario);
        }else{
            $resu=Interaccion::sacarLike($idPublicacion,$nombreUsuario);
        }
        break;
    case "dislike":
        if($estado==1){
            $resu=Interaccion::agregarDislike($idPublicacion,$nombreUsuario);
        }else{
            $resu=Interaccion::sacarDislike($idPublicacion,$nombreUsuario);
        }
        break;
    case "favorito":
        if($estado==1){
            $resu=Interaccion::agregarFavorito($idPublicacion,$nombreUsuario);
        }else{
            $resu=Interaccion::sacarFavorito($idPublicacion,$nombreUsuario);
        }
        break;
}

$myJSON = json_encode($resu);
echo $myJSON;


?>