var formulario= document.getElementById("idFormulario");
var select= document.getElementById("idPaises");
var inputFecha= document.getElementById("idFechaNac");
var correo= document.getElementById("idCorreo");
var contrasenia= document.getElementById("idContrasenia");
var contraseniaRepetida= document.getElementById("idContraseniaRepetida");

var nombreCondicion=false;
var paisCondicion= false;
var fechaCondicion= false;
var correoCondicion= false;
var contraseniaCondicion= false;
var contraseniaRepetidaCondicion= false;

var fechaActual = new Date();


const expresiones = {
	password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/,// "La contrasenia debe contener al menos 8 caracteres alfanuméricos, incluyendo al menos un número, una letra mayúscula y una letra minúscula."
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}

function validarNombre(){

	var letras = document.getElementById("idNombreUsuario").value;
	var peticion= new XMLHttpRequest();
	peticion.open("GET","operacionRegistrarse.php?letras="+letras, true);
	peticion.onreadystatechange = devolverResultado;
	peticion.send(null);
	
	function devolverResultado() {
			if (peticion.readyState === 4 && peticion.status === 200) {
				
				var contenedorEstado= document.getElementById("idCampoNombre");
				contenedorEstado.innerHTML = "";
				
				var resultado= JSON.parse(peticion.responseText)

				var texto = document.createElement("p");
				texto.textContent =" **"+resultado;
                texto.style.display="inline";				
				if(resultado == "usuario no valido"){
					texto.style.color = "red";
                    nombreCondicion=false;
				}else{
					texto.style.color = "green";
                    nombreCondicion=true;
				}
				contenedorEstado.appendChild(texto);					
			}	
		}
		
	}


function validarFecha() {
    var contenedor = document.getElementById("idCampoFecha");
    contenedor.innerHTML = "";
    fechaNac= new Date(inputFecha.value);
    var diferencia= fechaActual - fechaNac;  // Calculamos la diferencia en milisegundos entre las fechas
    var edad = diferencia / (1000 * 60 * 60 * 24 * 365.25);   // Convertimos la diferencia en años
    var parrafo = document.createElement("p");
    parrafo.style.display="inline";
    if (edad > 13) {
        parrafo.textContent = "edad correcta";
        parrafo.style.color = "green";
        contenedor.appendChild(parrafo);
        fechaCondicion = true;
    } else {
        parrafo.textContent = "edad incorrecta";
        parrafo.style.color = "red";
        contenedor.appendChild(parrafo);
        fechaCondicion = false;
    }
}

function validarPais() {
    var contenedor = document.getElementById("idCampoPais");
    contenedor.innerHTML = "";
    var parrafo = document.createElement("p");
    parrafo.style.display="inline";
    if (select.value === "0") {
        parrafo.textContent = "selección incorrecta";
        parrafo.style.color = "red";     
        contenedor.appendChild(parrafo);
        paisCondicion = false;
    } else {
        parrafo.textContent = "selección correcta";
        parrafo.style.color = "green";
        contenedor.appendChild(parrafo);
        paisCondicion = true;
    }
}


function validarCorreo() {
    var contenedor = document.getElementById("idCampoCorreo");  
    contenedor.innerHTML="";
    var parrafo = document.createElement("p");
    parrafo.style.display="inline"
    if(expresiones.correo.test(correo.value)){
        parrafo.textContent = "correo correcto";
        parrafo.style.color = "green"; 
        contenedor.appendChild(parrafo);
        correoCondicion=true;
    }else{
        parrafo.textContent = "correo incorrecto";
        parrafo.style.color = "red"; 
    contenedor.appendChild(parrafo);
    correoCondicion=false;

    }
}

function validarContrasenia() {
    var contenedor = document.getElementById("idCampoContrasenia");  
    contenedor.innerHTML="";
    var parrafo = document.createElement("p");
    parrafo.style.display="inline"
    if(expresiones.password.test(contrasenia.value)){
        parrafo.textContent = "contraseña correcta";
        parrafo.style.color = "green"; 
        contenedor.appendChild(parrafo);
        contraseniaCondicion=true;
    }else{
        parrafo.textContent = "contraseña incorrecta";
        parrafo.style.color = "red"; 
        contenedor.appendChild(parrafo);
        contraseniaCondicion=false;
    }
}

function validarContraseniaRepetida() {
    var contenedor = document.getElementById("idCampoContraseniaRepetida");  
    contenedor.innerHTML="";
    var parrafo = document.createElement("p");
    parrafo.style.display="inline"
    if(contraseniaRepetida.value==contrasenia.value){
        parrafo.textContent = "si coincide";
        parrafo.style.color = "green"; 
        contenedor.appendChild(parrafo);
    contraseniaRepetidaCondicion=true;
    }else{
        parrafo.textContent = "no coincide";
        parrafo.style.color = "red"; 
        contenedor.appendChild(parrafo);
        contraseniaRepetidaCondicion=false;
    }
}


/*asignacion de eventos*/
formulario.addEventListener("submit",(e)=>{
    if (!(nombreCondicion && paisCondicion && fechaCondicion  && correoCondicion  && contraseniaCondicion  && contraseniaRepetidaCondicion)){
        e.preventDefault();
    }
});
/*---------------------*/
