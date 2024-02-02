

var publicacionesVistasnoLog=0;
var publicacionesVistasParati=0;
var publicacionesVistasExplorar=0;
var misPublicacionesVistas=0;
var publicacionesVistasLikesDislikesFav=0;
var parati=true;


function crearPublicacion(publicacion,editarEliminar){
	let imagenUsuario = document.createElement("img");
	imagenUsuario.src = "./imagenes/usuario.png"; 
	imagenUsuario.id = "idUsuario";
	imagenUsuario.alt = "usuario";

	var divPublicacion = document.createElement("div");
					divPublicacion.classList.add("publicacion");

					var divEncabezado = document.createElement("div");
					divEncabezado.classList.add("encabezado");

					var nombreUsuario = document.createElement("p");
					nombreUsuario.classList.add("idTexto");
					nombreUsuario.innerHTML=publicacion.nombreAutor;
					
					if (editarEliminar=="si"){
						var editar= document.createElement("p");
						editar.classList.add("editar");
						editar.innerHTML="editar";

						editar.addEventListener('click', function() {
							window.location.href = 'editar.php?id=' + publicacion.idPublicacion;
						});

						var eliminar= document.createElement("p");
						eliminar.classList.add("eliminar");
						eliminar.innerHTML="eliminar";

						eliminar.addEventListener('click', function() {
						window.location.href = 'eliminar.php?id=' + publicacion.idPublicacion;
						});

					}
					divEncabezado.appendChild(imagenUsuario.cloneNode(true));
					divEncabezado.appendChild(nombreUsuario);
					if (editarEliminar=="si"){
					divEncabezado.appendChild(editar);
					divEncabezado.appendChild(eliminar);
					}
					divPublicacion.appendChild(divEncabezado);

					if(publicacion.texto!=="vacio"){
						var contenedorTexto = document.createElement("div");
						contenedorTexto.classList.add("contenedorTexto");
						contenedorTexto.innerHTML = publicacion.texto;
						divPublicacion.appendChild(contenedorTexto);
					}
					if(publicacion.imagen!=="vacio"){
						var contenedorImagen = document.createElement("div");
						contenedorImagen.classList.add("contenedorImagen");
						var imagen = document.createElement("img");
						imagen.src = publicacion.imagen;
						imagen.classList.add("imagenSubida");
						imagen.alt = "imagen de "+publicacion.nombreAutor;
						var contenedorImagen = document.createElement("div");
						contenedorImagen.classList.add("contenedorImagen");
						contenedorImagen.appendChild(imagen);

						if((imagen.width > 600 && imagen.height > 400)){
							var spanTexto = document.createElement("span");
							spanTexto.classList.add("spanTexto");
							spanTexto.innerHTML="Ver tamaño original";
							contenedorImagen.appendChild(spanTexto);
							imagen.classList.add("imagenTamañoOriginal");
							spanTexto.onclick = function () {
								mostrarTamañoOriginal(imagen.src);
							};
						}
						
						divPublicacion.appendChild(contenedorImagen);

					}
					if(publicacion.audio!=="vacio"){
						var contenedorAudio = document.createElement("div");
						contenedorAudio.classList.add("contenedorAudio");
						var audioReproductor = document.createElement("audio");
						audioReproductor.classList.add("audio");
						audioReproductor.src = publicacion.audio; 
						audioReproductor.controls = true; 

						contenedorAudio.appendChild(audioReproductor);
						divPublicacion.appendChild(contenedorAudio);
					}
			
					return divPublicacion;
}


function traerPublicacionesNoLog(publicacionesVistas){

	var peticion = new XMLHttpRequest();
	var parametros = "publicacionesVistas="+publicacionesVistas;
    peticion.open("POST", "operacionPublicaciones.php", true);
	peticion.onreadystatechange = devolverResultado;
    peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    peticion.send(parametros);

	function devolverResultado() {
			if (peticion.readyState === 4 && peticion.status === 200) {
				var contenedorCentral= document.getElementById("contenedorCentral");
				contenedorCentral.innerHTML = "";
				
				var publicaciones= JSON.parse(peticion.responseText)
				let imagenUsuario = document.createElement("img");
                imagenUsuario.src = "./imagenes/usuario.png"; 
				imagenUsuario.id = "idUsuario";
				imagenUsuario.alt = "usuario";
				

				publicaciones.forEach(function(publicacion) {
					var divPublicacion = crearPublicacion(publicacion,"no");
					//fecha publicacion//
					var divPiePublicacion = document.createElement("div");
					var fecha = document.createElement("p");
					fecha.innerHTML=publicacion.fecha;
					fecha.classList.add("fechaSola");

					divPiePublicacion.classList.add("piePublicacion");

					divPiePublicacion.appendChild(fecha);
					//fecha publicacion//

					divPublicacion.appendChild(divPiePublicacion);	
					contenedorCentral.appendChild(divPublicacion);
				});

			}	
		}
		
	}


	let likenoDado = document.createElement("img");
	likenoDado.src = "./imagenes/likenoDado.png"; 
	likenoDado.id = "idLikenoDado";
	likenoDado.alt = "likenoDado";

	let likeDado = document.createElement("img");
	likeDado.src = "./imagenes/likeDado.png"; 
	likeDado.id = "idLikeDado";
	likeDado.alt = "likeDado";

	let dislikenoDado = document.createElement("img");
	dislikenoDado.src = "./imagenes/dislikenoDado.png"; 
	dislikenoDado.id = "idDislikenoDado";
	dislikenoDado.alt = "dislikenoDado";

	let dislikeDado = document.createElement("img");
	dislikeDado.src = "./imagenes/dislikeDado.png"; 
	dislikeDado.id = "idDislikeDado";
	dislikeDado.alt = "dislikeDado";

	let favoritoDado = document.createElement("img");
	favoritoDado.src = "./imagenes/favoritoDado.png"; 
	favoritoDado.id = "idFavoritoDado";
	favoritoDado.alt = "favoritoDado";

	let favoritonoDado = document.createElement("img");
	favoritonoDado.src = "./imagenes/favoritonoDado.png"; 
	favoritonoDado.id = "idFavoritonoDado";
	favoritonoDado.alt = "favoritonoDado";

	function crearBotonesInteracciones(publicacion,CondicionNroInteracciones) {

		var divInteracciones = document.createElement("div");
		divInteracciones.classList.add("divContenedorInteracciones");
		var idPublicacion = publicacion.idPublicacion; 

		//boton like//
		var botonLike = document.createElement("button");
		var likeEstado=publicacion.like;
		botonLike.classList.add("boton");
		if(likeEstado==1){
			botonLike.appendChild(likeDado.cloneNode(true));
			likeEstado = 1; 

		}else{
			botonLike.appendChild(likenoDado.cloneNode(true));
			likeEstado = 0; 

		}
		botonLike.addEventListener("click", function() {

			if (likeEstado === 1) {
				botonLike.innerHTML = ""; 
				botonLike.appendChild(likenoDado.cloneNode(true)); 
				likeEstado = 0; //se saca el like//
			} else {
				botonLike.innerHTML = ""; 
				botonLike.appendChild(likeDado.cloneNode(true)); 
				likeEstado = 1; //se da like//
			}

			interaccion(likeEstado,idPublicacion,"like");
		});

		//boton like//

		//boton dislike//
		var botonDisLike = document.createElement("button");
		var DislikeEstado=publicacion.dislike;
		botonDisLike.classList.add("boton");
		if(DislikeEstado==1){
			botonDisLike.appendChild(dislikeDado.cloneNode(true));
			DislikeEstado = 1; 

		}else{
			botonDisLike.appendChild(dislikenoDado.cloneNode(true));
			DislikeEstado = 0; 

		}
		botonDisLike.addEventListener("click", function() {

			if (DislikeEstado === 1) {
				botonDisLike.innerHTML = ""; 
				botonDisLike.appendChild(dislikenoDado.cloneNode(true)); 
				DislikeEstado = 0; //se saca el dislike//
			} else {
				botonDisLike.innerHTML = ""; 
				botonDisLike.appendChild(dislikeDado.cloneNode(true)); 
				DislikeEstado = 1; //se da dislike//
			}

			interaccion(DislikeEstado,idPublicacion,"dislike");
		});

		//boton dislike//


		//boton favorito//
		var botonFavorito = document.createElement("button");
		var favoritoEstado=publicacion.favorito;
		botonFavorito.classList.add("boton");
		if(favoritoEstado==1){
			botonFavorito.appendChild(favoritoDado.cloneNode(true));
			favoritoEstado = 1; 

		}else{
			botonFavorito.appendChild(favoritonoDado.cloneNode(true));
			favoritoEstado = 0; 

		}
		botonFavorito.addEventListener("click", function() {

			if (favoritoEstado === 1) {
				botonFavorito.innerHTML = ""; 
				botonFavorito.appendChild(favoritonoDado.cloneNode(true)); 
				favoritoEstado = 0; //se saca el favorito//
			} else {
				botonFavorito.innerHTML = ""; 
				botonFavorito.appendChild(favoritoDado.cloneNode(true)); 
				favoritoEstado = 1; //se da favorito//
			}

			interaccion(favoritoEstado,idPublicacion,"favorito");
		});

		//boton favorito//
		if (CondicionNroInteracciones=="si"){
			var nroLikes= document.createElement("p");
			nroLikes.classList.add("numerosInteracciones");
			nroLikes.innerHTML=publicacion.nroLikes;

			var nroDisLikes= document.createElement("p");
			nroDisLikes.classList.add("numerosInteracciones");
			nroDisLikes.innerHTML=publicacion.nroDislikes;

			var nroFavoritos= document.createElement("p");
			nroFavoritos.classList.add("numerosInteracciones");
			nroFavoritos.innerHTML=publicacion.nroFavoritos;
		}


		divInteracciones.appendChild(botonLike);
		if (CondicionNroInteracciones=="si"){
			divInteracciones.appendChild(nroLikes);

		}
		divInteracciones.appendChild(botonDisLike);
		if (CondicionNroInteracciones=="si"){
			divInteracciones.appendChild(nroDisLikes);

		}
		divInteracciones.appendChild(botonFavorito);
		if (CondicionNroInteracciones=="si"){
			divInteracciones.appendChild(nroFavoritos);

		}
	

		return divInteracciones;
	}



	function traerPublicacionesLog(publicacionesVistas,nombre,modo){
		console.log(publicacionesVistas);
		var peticion = new XMLHttpRequest();
		var parametros = "publicacionesVistas="+publicacionesVistas+"&nombre="+nombre+"&modo="+modo;
		peticion.open("POST", "operacionPublicacionesLog.php", true);
		peticion.onreadystatechange = devolverResultado;
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion.send(parametros);
	
		function devolverResultado() {
				if (peticion.readyState === 4 && peticion.status === 200) {
					var contenedorCentral= document.getElementById("contenedorCentral");
					contenedorCentral.innerHTML = "";
					console.log(peticion.responseText);

					var publicaciones= JSON.parse(peticion.responseText)

					publicaciones.forEach(function(publicacion) {
						
						var divPublicacion = crearPublicacion(publicacion,"no");
						var divInteracciones = crearBotonesInteracciones(publicacion,"no");

						var divPiePublicacion = document.createElement("div");
						var fecha = document.createElement("p");
						fecha.innerHTML=publicacion.fecha;
						divPiePublicacion.classList.add("piePublicacion");

						divPiePublicacion.appendChild(divInteracciones);	
						divPiePublicacion.appendChild(fecha);

						divPublicacion.appendChild(divPiePublicacion);
						contenedorCentral.appendChild(divPublicacion);			
					});
	
				}	
			}
			
		}


		function traerMisPublicaciones(publicacionesVistas,nombre,modo){
			var peticion = new XMLHttpRequest();
			var parametros = "publicacionesVistas="+publicacionesVistas+"&nombre="+nombre+"&modo="+modo;
			peticion.open("POST", "operacionPublicacionesLog.php", true);
			peticion.onreadystatechange = devolverResultado;
			peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			peticion.send(parametros);
		
			function devolverResultado() {
					if (peticion.readyState === 4 && peticion.status === 200) {
						var contenedorCentral= document.getElementById("contenedorCentral");
						contenedorCentral.innerHTML = "";
						var publicaciones= JSON.parse(peticion.responseText)
					
	
						publicaciones.forEach(function(publicacion) {
							var divPublicacion = crearPublicacion(publicacion,"si");
							var divInteracciones = crearBotonesInteracciones(publicacion,"si");

							var divPiePublicacion = document.createElement("div");
							var fecha = document.createElement("p");
							fecha.innerHTML=publicacion.fecha;
							divPiePublicacion.classList.add("piePublicacion");

							divPiePublicacion.appendChild(divInteracciones);	
							divPiePublicacion.appendChild(fecha);

							divPublicacion.appendChild(divPiePublicacion);
							contenedorCentral.appendChild(divPublicacion);						
						});
		
					}	
				}			
	}

	function crearPublicacionUnica(texto,idPublicacion,audio,imagen,fechaHora,nombreAutor,like,dislike,favorito) {
		var publicacion = {
			texto: texto,
			idPublicacion: idPublicacion,
			audio: audio,
			imagen: imagen,
			fechaHora: fechaHora,
			nombreAutor: nombreAutor,
			like: like,
			dislike: dislike,
			favorito: favorito
		};
		var divPublicacion = crearPublicacion(publicacion,"no");
		var divInteracciones = crearBotonesInteracciones(publicacion,"no");

		var divPiePublicacion = document.createElement("div");
		var fecha = document.createElement("p");

		fecha.innerHTML=publicacion.fechaHora;

		divPiePublicacion.appendChild(divInteracciones);	
		divPiePublicacion.appendChild(fecha);
		divPiePublicacion.classList.add("piePublicacion");

		divPublicacion.appendChild(divPiePublicacion);
		contenedorCentral.appendChild(divPublicacion);		
	}

	function mostrarTamañoOriginal(src){
	window.open(src, "_blank");
	}



	
	function interaccion(estado,idPublicacion,tipoInteraccion){
		var peticion = new XMLHttpRequest();
		var parametros = "estado="+estado+"&idPublicacion="+idPublicacion+"&tipoInteraccion="+tipoInteraccion;
		peticion.open("POST", "operacionInteraccion.php", true);
		peticion.onreadystatechange = devolverResultadodislike;
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		peticion.send(parametros);
	
		function devolverResultadodislike() {
				if (peticion.readyState === 4 && peticion.status === 200) {
					console.log(peticion.responseText);

				}	
			}
	}


		function buscarPublicaciones(){

			var letras = document.getElementById("idBuscador").value;
			var peticion= new XMLHttpRequest();
			var parametros = "letras="+letras;

			peticion.open("POST","operacionBuscador.php", true);
			peticion.onreadystatechange = cargarPublicaciones;
			peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			peticion.send(parametros);

			function cargarPublicaciones() {
				if (peticion.readyState === 4 && peticion.status === 200) {
					contenedor= document.getElementById("resultados");
					contenedor.innerHTML = "";
			
					var publicaciones = JSON.parse(peticion.responseText);
					publicaciones.forEach(function(publicacion) {

						var resultado = document.createElement("div");
						resultado.classList.add("resultadoPublicacion");

						var texto = document.createElement("div");
						texto.classList.add("resultadoTexto");
						texto.innerHTML=publicacion.texto;
						var nombreAutor = document.createElement("div");
						nombreAutor.classList.add("resultadoNombreAutor");
						nombreAutor.innerHTML=publicacion.nombreAutor+":";

						resultado.appendChild(nombreAutor);
						resultado.appendChild(texto);

						resultado.addEventListener('click', function() {
							window.location.href = 'pagina.php?id=' + publicacion.idPublicacion;
						});

						contenedor.appendChild(resultado);

					});
					
				}	
		
			}
			
			}
			
			


			function cambiarParati(nombre){
				publicacionesVistasParati=0;
				traerPublicacionesLog(publicacionesVistasParati,nombre,"paraTi");
				parati=true;
			}
			function cambiarExplorar(nombre){
				publicacionesVistasExplorar=0;
				traerPublicacionesLog(publicacionesVistasExplorar,nombre,"explorar");
				parati=false;
			}

			function avanzar(nombre){//para ti o explorar
				publicacionesVistasExplorar+=10;
				var modo = parati ? "paraTi" : "explorar";
				traerPublicacionesLog(publicacionesVistasExplorar,nombre,modo);
			}
			function volver(nombre){//para ti o explorar
				publicacionesVistasExplorar-=10;
				publicacionesVistasExplorar = publicacionesVistasExplorar<0 ? 0 : publicacionesVistasExplorar;
				var modo = parati ? "paraTi" : "explorar";
				traerPublicacionesLog(publicacionesVistasExplorar,nombre,modo);
			}

			function avanzarNolog(){
				publicacionesVistasnoLog+=10;
				traerPublicacionesNoLog(publicacionesVistasnoLog);
			}
			function volverNolog(){
				publicacionesVistasnoLog-=10;
				publicacionesVistasnoLog = publicacionesVistasnoLog<0 ? 0 : publicacionesVistasnoLog;
				traerPublicacionesNoLog(publicacionesVistasnoLog);
			}

			function avanzarLikesDislikesFav(nombre,modo){
				publicacionesVistasLikesDislikesFav+=10;
				traerPublicacionesLog(publicacionesVistasLikesDislikesFav,nombre,modo);
			}
			function volverLikesDislikesFav(nombre,modo){
				publicacionesVistasLikesDislikesFav-=10;
				publicacionesVistasLikesDislikesFav = publicacionesVistasLikesDislikesFav<0 ? 0 : publicacionesVistasLikesDislikesFav;
				traerPublicacionesLog(publicacionesVistasLikesDislikesFav,nombre,modo);
			}

			function avanzarMisPublicaciones(nombre){
				misPublicacionesVistas+=10;
				traerMisPublicaciones(misPublicacionesVistas,nombre,"misPublicaciones");
			}
			function volverMisPublicaciones(nombre){
				misPublicacionesVistas-=10;
				misPublicacionesVistas = misPublicacionesVistas<0 ? 0 : misPublicacionesVistas;
				traerMisPublicaciones(misPublicacionesVistas,nombre,"misPublicaciones");
			}

