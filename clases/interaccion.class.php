<?php

	class Interaccion{

		//trae el estado de la interaccion
		private static function ejecutarConsulta($query) {
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
			$resu = $conexion->query($query) or die("No se pudo ejecutar la consulta");
			$conexion->close();
			return $resu;
		}

		private static function obtenerEstado($query) {
			$resu = self::ejecutarConsulta($query);
			if ($resu->num_rows > 0) {
				return 1; // hay like,dislike o fav
			} else {
				return 0; // no hay like,dislike o fav
			}
		}
	
        public static function obtenerLike($idPublicacion, $nombreUsuario) {
			$query = "SELECT * FROM likes WHERE idPublicacion = " . $idPublicacion . " AND nombreUsuario = '" . $nombreUsuario . "'";
			return self::obtenerEstado($query);

		}

		public static function obtenerDisLike($idPublicacion, $nombreUsuario) {
			$query = "SELECT * FROM dislike WHERE idPublicacion = " . $idPublicacion . " AND nombreUsuario = '" . $nombreUsuario . "'";
			return self::obtenerEstado($query);
		}

		public static function obtenerFavorito($idPublicacion, $nombreUsuario) {
			$query = "SELECT * FROM favorito WHERE idPublicacion = " . $idPublicacion . " AND nombreUsuario = '" . $nombreUsuario . "'";
			return self::obtenerEstado($query);
		}

		//trae la cantidad de interacciones para las publicaciones propias
		private static function obtenerNroInteracciones($tabla, $idPublicacion) {
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
			$query = "SELECT COUNT(*) AS num_elementos FROM " . $tabla . " WHERE idPublicacion = " . $idPublicacion;
	
			$resultado = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");
	
			$row = $resultado->fetch_assoc();
			$numElementos = $row['num_elementos'];
	
			$resultado->free();
			$conexion->close();
	
			return $numElementos;
		}


		public static function obtenerNroLikes($idPublicacion) {
			return self::obtenerNroInteracciones('likes', $idPublicacion);

		}

		public static function obtenerNroDisLikes($idPublicacion) {
			return self::obtenerNroInteracciones('dislike', $idPublicacion);

		}
		

		public static function obtenerNroFavoritos($idPublicacion) {
			return self::obtenerNroInteracciones('favorito', $idPublicacion);

		}



		// Funcion generica para agregar interacciones
		private static function agregarInteraccion($tabla, $idPublicacion, $nombreUsuario) {
			$query = "INSERT INTO " . $tabla . " (idPublicacion, nombreUsuario) VALUES ('" . $idPublicacion . "', '" . $nombreUsuario . "')";
			$resu = self::ejecutarConsulta($query);
			if ($resu == 1) {
				return "se agrego el " . $tabla . " correctamente";
			} else {
				return "no se agrego el " . $tabla . " correctamente";
			}
		}

		// Funcion generica para eliminar interacciones
		private static function sacarInteraccion($tabla, $idPublicacion, $nombreUsuario) {
			$query = "DELETE FROM " . $tabla . " WHERE " . $tabla . ".idPublicacion=" . $idPublicacion . " AND " . $tabla . ".nombreUsuario='" . $nombreUsuario . "'";
			$resu = self::ejecutarConsulta($query);
			if ($resu == 1) {
				return "se elimino el " . $tabla . " correctamente";
			} else {
				return "no se elimino el " . $tabla . " correctamente";
			}
		}




		public static function agregarLike($idPublicacion, $nombreUsuario) {
			return self::agregarInteraccion('likes', $idPublicacion, $nombreUsuario);
		}
	
		public static function sacarLike($idPublicacion, $nombreUsuario) {
			return self::sacarInteraccion('likes', $idPublicacion, $nombreUsuario);
		}
	
		public static function agregarDislike($idPublicacion, $nombreUsuario) {
			return self::agregarInteraccion('dislike', $idPublicacion, $nombreUsuario);
		}
	
		public static function sacarDislike($idPublicacion, $nombreUsuario) {
			return self::sacarInteraccion('dislike', $idPublicacion, $nombreUsuario);
		}
	
		public static function agregarFavorito($idPublicacion, $nombreUsuario) {
			return self::agregarInteraccion('favorito', $idPublicacion, $nombreUsuario);
		}
	
		public static function sacarFavorito($idPublicacion, $nombreUsuario) {
			return self::sacarInteraccion('favorito', $idPublicacion, $nombreUsuario);
		}
	}
		
?>