<?php

	class Publicacion{

		private $idPublicacion;
		private $texto;
		private $imagen;
        private $audio;
		private $fecha;
		private $nombreAutor;


		
		function __construct(){
			
		}
		

		function getidPublicacion(){
			return $this->idPublicacion;
		}
		
		function setidPublicacion($idPublicacion){
			$this->idPublicacion=$idPublicacion;
		}

		function getTexto(){
			return $this->texto;
		}
		
		function setTexto($texto){
			$this->texto=$texto;
		}
		
		function getImagen(){
			return $this->imagen;
		}
		
		function setImagen($imagen){
			$this->imagen=$imagen;
		}

		function getAudio(){
			return $this->audio;
		}
		
		function setAudio($audio){
			$this->audio=$audio;
		}

		function getFecha(){
			return $this->fecha;
		}
		
		function setFecha($fecha){
			$this->fecha=$fecha;
		}

		function getNombreAutor(){
			return $this->nombreAutor;
		}
		
		function setNombreAutor($nombreAutor){
			$this->nombreAutor=$nombreAutor;
		}


		public static function subirPublicacion($texto, $imagen, $audio, $usuario, $fecha) {
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
		
			$query = "INSERT INTO publicacion (usuario, fecha";
		
			// se agregan los campos a la consulta si no están vacíos
			if (!empty($texto)) {
				$query .= ", texto";
			}
			if (!empty($imagen)) {
				$query .= ", imagen";
			}
			if (!empty($audio)) {
				$query .= ", audio";
			}
		
			// se  completan los values la consulta
			$query .= ") VALUES ('$usuario', '$fecha'";
		
			// Agregamos los valores a la consulta si no están vacíos
			if (!empty($texto)) {
				$query .= ", '$texto'";
			}
			if (!empty($imagen)) {
				$query .= ", '$imagen'";
			}
			if (!empty($audio)) {
				$query .= ", '$audio'";
			}
		
			// se finaliza la consulta
			$query .= ")";
		
			$resu = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");
			$conexion->close();
			return $resu;
		}
		
		public static function eliminarPublicacion($idPublicacion) {
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
		
			$query ="DELETE FROM publicacion WHERE publicacion.idPublicacion=".$idPublicacion;

			// Eliminar filas relacionadas en la tabla dislike
			$queryDislike = "DELETE FROM dislike WHERE idPublicacion = $idPublicacion";
			$conexion->query($queryDislike) or die("No se pudo eliminar las filas relacionadas en la tabla dislike");
		
			// Eliminar filas relacionadas en la tabla like
			$queryDislike = "DELETE FROM likes WHERE idPublicacion = $idPublicacion";
			$conexion->query($queryDislike) or die("No se pudo eliminar las filas relacionadas en la tabla dislike");

			// Eliminar filas relacionadas en la tabla favorito
			$queryDislike = "DELETE FROM favorito WHERE idPublicacion = $idPublicacion";
			$conexion->query($queryDislike) or die("No se pudo eliminar las filas relacionadas en la tabla dislike");

			$resu = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");
		
			$conexion->close();
			
			return $resu;
		}

		public static function actualizarPublicacion($idPublicacion, $texto, $imagen, $audio) {
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
		
			// colocar valor nulo para poder subirlo correctamente si es q son nulos
			$textoValidado = is_null($texto)? 'NULL' : "'" . ($texto) . "'";
			$imagenValidado = is_null($imagen) ? 'NULL' : "'" . ($imagen) . "'";
			$audioValidado = is_null($audio) ? 'NULL' : "'" . ($audio) . "'";
		
			$query = "UPDATE publicacion SET texto = $textoValidado, imagen = $imagenValidado, audio = $audioValidado WHERE idPublicacion = $idPublicacion";
		
			$resu = $conexion->query($query) or die("No se pudo ejecutar la consulta de actualización");
		
			$conexion->close();
		
			return $resu;
		}


		private static function obtenerPublicacionesBase($query) {// arma las publicaciones
			$listaPublicaciones = array();
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
	
			$listado = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");
	
			while ($reg = $listado->fetch_object()) {
				$publicacion = new Publicacion();
				$publicacion->setidPublicacion($reg->idPublicacion);
				$publicacion->setTexto($reg->texto);
				$publicacion->setImagen($reg->imagen);
				$publicacion->setAudio($reg->audio);
				$publicacion->setFecha($reg->fecha);
				$publicacion->setNombreAutor($reg->usuario);
				$listaPublicaciones[] = $publicacion;
			}
	
			$listado->free();
			$conexion->close();
	
			return $listaPublicaciones;
		}




		public static function obtenerPublicacionesnoLog($PublicacionesVistas){			
			$query = "SELECT * FROM publicacion  WHERE fecha <= NOW() ORDER BY fecha DESC LIMIT 10 OFFSET " . $PublicacionesVistas;
			return self::obtenerPublicacionesBase($query);
		}	

		public static function obtenerPublicacionesLogParaTi($PublicacionesVistas, $nombre) {  //trae las publicaciones de usuarios  likeadas y faveadas por el usuario//
			$query = "SELECT DISTINCT p1.* 
				FROM publicacion p1 
				WHERE p1.usuario IN (
					SELECT DISTINCT p2.usuario 
					FROM publicacion p2 
					WHERE p2.idPublicacion IN (
						SELECT idPublicacion
						FROM likes
						WHERE  nombreUsuario = '$nombre'
						UNION
						SELECT idPublicacion
						FROM favorito
						WHERE  nombreUsuario = '$nombre'
					)
				)
				AND p1.usuario != '$nombre'  
				AND fecha <= NOW() ORDER BY p1.fecha DESC 
				LIMIT 10 OFFSET $PublicacionesVistas";
  			return self::obtenerPublicacionesBase($query);
		}

		public static function obtenerPublicacionesLogExplorar($PublicacionesVistas, $nombre) { //trae las publicaciones de usuarios no likeadas y faveadas por el usuario//
			$query = "SELECT DISTINCT p.*
			FROM publicacion p
			WHERE p.usuario NOT IN (
				SELECT DISTINCT p2.usuario 
				FROM publicacion p2 
				WHERE p2.idPublicacion IN (
					SELECT idPublicacion
					FROM likes
					WHERE  nombreUsuario = '$nombre'
					UNION
					SELECT idPublicacion
					FROM favorito
					WHERE  nombreUsuario = '$nombre'
				)
			)
			AND p.usuario != '$nombre'  
			AND fecha <= NOW() ORDER BY p.fecha DESC 
			LIMIT 10 OFFSET $PublicacionesVistas";
  			return self::obtenerPublicacionesBase($query);
		}


		public static function obtenerPublicacionesBuscador($letras) {//trae las publicaciones segun lo escrito en el buscador
			if (empty($letras)) {
				return array();
			}
			$query = "SELECT * FROM publicacion WHERE fecha <= NOW() AND texto LIKE '%" . $letras . "%' LIMIT 5";
			return self::obtenerPublicacionesBase($query);
		}
	
		public static function obtenerMisPublicaciones($PublicacionesVistas, $nombre) {//trae las publicaciones subidas por el usuario
			$query = "SELECT * FROM publicacion WHERE usuario = '$nombre' ORDER BY publicacion.fecha DESC LIMIT 10 OFFSET $PublicacionesVistas";
			return self::obtenerPublicacionesBase($query);
		}


		private static function obtenerPublicacionesInteracciones($PublicacionesVistas, $nombre, $tipoInteraccion) { //trae publicaciones segun las interacciones
			$query = "SELECT * FROM `publicacion` 
					INNER JOIN $tipoInteraccion ON $tipoInteraccion.idPublicacion = publicacion.idPublicacion 
					WHERE $tipoInteraccion.nombreUsuario = '$nombre' 
					ORDER BY publicacion.fecha DESC 
					LIMIT 10 OFFSET $PublicacionesVistas";
			return self::obtenerPublicacionesBase($query);
		}
	


		public static function obtenerPublicacionesLikes($PublicacionesVistas, $nombre) {
			return self::obtenerPublicacionesInteracciones($PublicacionesVistas, $nombre, 'likes');
		}
	
		public static function obtenerPublicacionesDisLikes($PublicacionesVistas, $nombre) {
			return self::obtenerPublicacionesInteracciones($PublicacionesVistas, $nombre, 'dislike');
		}
	
		public static function obtenerPublicacionesFavoritos($PublicacionesVistas, $nombre) {
			return self::obtenerPublicacionesInteracciones($PublicacionesVistas, $nombre, 'favorito');
		}


		public static function traerPublicacion($idPublicacion){			
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
			$query = "SELECT * FROM publicacion WHERE idPublicacion= ".$idPublicacion;

			$listado = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");
	
				while ($reg = $listado->fetch_object()) {
					$publicacion= new Publicacion();
					$publicacion->setidPublicacion($reg->idPublicacion);
					$publicacion->setTexto($reg->texto);
					$publicacion->setImagen($reg->imagen);
					$publicacion->setAudio($reg->audio);
					$publicacion->setFecha($reg->fecha);
					$publicacion->setNombreAutor($reg->usuario);
				}

			$listado->free();
			$conexion->close();
			
			return $publicacion;
		}	

		
	}