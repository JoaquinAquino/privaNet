<?php

	class Usuario{
	
		private $nombre;
		private $contrasenia;
        private $correo;
		private $fechaNac;
        private $pais;


		
		function __construct(){
		}
		
		function getNombre(){
			return $this->nombre;
		}
		
		function setNombre($texto){
			$this->nombre=$texto;
		}
		
		function getContrasenia(){
			return $this->contrasenia;
		}
		
		function setContrasenia($contrasenia){
			$this->contrasenia=$contrasenia;
		}
		
        function getCorreo(){
			return $this->correo;
		}
		
		function setCorreo($correo){
			$this->correo=$correo;
		}

        function getFechaNac(){
			return $this->fechaNac;
		}
		
		function setFechaNac($fechaNac){
			$this->fechaNac=$fechaNac;
		}

        function getPais(){
			return $this->pais;
		}
		
		function setPais($pais){
			$this->pais=$pais;
		}

		public static function obtenerNombres(){			
		$listadoUsuarios=array();
		$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
		$query = "SELECT nombre FROM usuario";
		$listado = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");

				while ($reg = $listado->fetch_object()) {
					$usuario= new Usuario();
					$usuario->setNombre($reg->nombre);
					$listadoUsuarios[]=$usuario;
				}
		$listado->free();
		$conexion->close();
		
		return $listadoUsuarios;
		}		

		public static function subirUsuario($nombre,$contrasenia,$correo,$fechaNac, $pais){			
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
			$query = "INSERT INTO usuario (nombre, contrasenia, correo, fechaNacimiento, paisResidencia) VALUES ('".$nombre."', '".$contrasenia."', '".$correo."', '".$fechaNac."', '".$pais."')";	
			$resu = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");
			$conexion->close();
			return $resu;
		}	
		

		public static function userExist($nombre,$contrasenia){			
			$conexion = new mysqli("localhost", "root", "", "privanet") or die("No se pudo conectar al servidor");
			$query = "SELECT * FROM usuario WHERE nombre= '".$nombre."'";
			$resu = $conexion->query($query) or die("No se pudo ejecutar la consulta de selección");
			$conexion->close();

			if($resu->num_rows==0){
				return "1"; /*el nombre no coincide*/
			}else{
				while ($reg = $resu->fetch_object()) {
					$contraseniaHash=($reg->contrasenia);
				}
				if(password_verify($contrasenia,$contraseniaHash)){
					return "2"; /*el nombre y la contrasenia coincide*/
				}else{
					return "3"; /*la contrasenia no coincide*/
				}
			}	
		}	
	}

		
?>