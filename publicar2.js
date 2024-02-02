var condicionImagen = false;
var condicionAudio = false;
var condicionProgramarSubida = false;
var condicionFecha = false;
var condicionHora = false;
var expresionR = /^(?:[01]\d|2[0-3]):[0-5]\d$/;
var negritaActiva=false;

function actDesNegrita() {
    negritaActiva = !negritaActiva;
  }
  
  function activarCaracteresEspeciales() {
    var texto = document.getElementById("idTexto");
    var contenido = texto.innerHTML;
  
    if (negritaActiva) {
      // Reemplazamos todos los espacios con etiquetas <strong>
      var contenidoNegrita = contenido.replace(/\s/g, "</strong> <strong>");
      // Agregamos etiquetas <strong> al principio y al final si es necesario
      if (contenidoNegrita !== "") {
        contenidoNegrita = "<strong>" + contenidoNegrita + "</strong>";
      }
      texto.innerHTML = contenidoNegrita;
    }
  }
  

function validarCaracteres() {
    var texto = document.getElementById("idTexto");
    var contenido = texto.value;

    if (contenido.length >= 500) {
        texto.value = contenido.substring(0, 500);
    }
}

function cambiarImagen() {
    var span = document.getElementById("contenedorTextoImagen");
    var inputImagen = document.getElementById("idInputImagen");
    condicionImagen=false;
    var imagenBorrada = document.getElementById("idImagenBorrada"); //esto solo sirve para el editar

    if (inputImagen.files.length == 0) {   
        span.innerHTML = "ninguna imagen seleccionada";
        inputImagen.value = ""; // se elimina la imagen del input
        imagenBorrada.value="si";//solo sirve para editar
    } else {
        var file = inputImagen.files[0];
        var extension = file.name.split('.').pop().toLowerCase();

        // Verificamos la extensión y el tamaño de la imagen
        if (extension !== "jpeg" ) {
            span.innerHTML = "Solo se permiten imágenes JPEG";
            inputImagen.value = ""; // se elimina la imagen del input
            imagenBorrada.value="si";//solo sirve para editar

        } else {
            var img = new Image();
            img.onload = function() {
                if (img.width > 1600 || img.height > 1200) {
                    span.innerHTML = "La imagen supera los 1600x1200 píxeles";
                    inputImagen.value = ""; // se elimina la imagen del input
                    imagenBorrada.value="si";//solo sirve para editar
                } else {
                    span.innerHTML = file.name;
                    condicionImagen=true;

                }
            };
            img.src = URL.createObjectURL(file); // Cargamos la imagen en el objeto Image
        }
    }
}






function cambiarAudio() {
    var span = document.getElementById("contenedorTextoAudio");
    var inputAudio = document.getElementById("idInputAudio");
    var audioBorrado = document.getElementById("idAudioBorrado");
    condicionAudio=false;
    if (inputAudio.files.length == 0) {
        span.innerHTML = "ningún audio seleccionado";
        inputAudio.value="";
        audioBorrado.value="si";//solo sirve para editar

    } else {
        var file = inputAudio.files[0];
        var extension = file.name.split('.').pop().toLowerCase();
        if (extension !== "mp3") {
            span.innerHTML = "el audio no es mp3";
            inputAudio.value="";
            audioBorrado.value="si";//solo sirve para editar
        } else {
            var audio = new Audio(); // Creamos un elemento de audio para obtener la duracion del audio
            audio.addEventListener("loadedmetadata", function() { // se activa cuando los metadatos del audio esten cargado
                if (audio.duration > 30) {
                    span.innerHTML="el audio supera los 30 segundos";
                    inputAudio.value="";
                    audioBorrado.value="si";//solo sirve para editar
                } else {
                    span.innerHTML = inputAudio.files[0].name;
                    condicionAudio=true;
                }
            });
            audio.src = URL.createObjectURL(file); // Cargamos el archivo de audio
        }
    }
}


function activarProgramar() {
    var divs = document.getElementsByClassName("filaOculta");
    if (document.getElementById("idCheck").checked) { // Verificar si el checkbox está marcado
        for (let i = 0; i < divs.length; i++) {
            divs[i].style.display = 'flex'; 
        }
        condicionProgramarSubida=true;
    } else {
        for (let i = 0; i < divs.length; i++) {
            divs[i].style.display = 'none'; 
        }
        condicionProgramarSubida=false;

    }
}


function validarHora(){
    var inputHora = document.getElementById("idHoraInput");

    if (!(expresionR.test(inputHora.value))) {
        condicionHora=false;
    }else{
        condicionHora=true;

    }

}


function validarFecha() {
    var inputFechas = document.getElementById("idFechas");
    if (inputFechas.value === "0") {
        condicionFecha = false;
    } else {
        condicionFecha = true;
    }
}

function borrarImagen(){
    var span = document.getElementById("contenedorTextoImagen");
    var inputImagen = document.getElementById("idInputImagen");
    var imagenBorrada = document.getElementById("idImagenBorrada");

    span.innerHTML="ninguna imagen seleccionada";
    inputImagen.value="";
    imagenBorrada.value="si";
}

function borrarAudio(){
    var span = document.getElementById("contenedorTextoAudio");
    var inputAudio = document.getElementById("idInputAudio");
    var audioBorrado = document.getElementById("idAudioBorrado");

    span.innerHTML="ninguna imagen seleccionada";
    inputAudio.value="";
    audioBorrado.value="si";
}
var formulario= document.getElementById("idFormulario");

function validarTodo() {
    var texto = document.getElementById("idTexto");
    var contenedorTexto = document.getElementById("idError");
    var condicionProgramarSubida = document.getElementById("idCheck").checked;
    var condicionFecha = document.getElementById("idFechas").value !== "0";
    var condicionHora = document.getElementById("idHoraInput").value !== "";
    var condicion = texto.value.trim() !== "" || condicionImagen || condicionAudio;
    console.log("texto: "+texto.innerHTML.trim() !== "" );
    console.log("imagen: "+condicionImagen);
    console.log("audio: "+condicionAudio );
    console.log(condicion);

    if (!condicion) {
        contenedorTexto.innerHTML = "Debe completar al menos con un texto, imagen o audio";
        return false; // Evita el envío del formulario
    } else if (condicionProgramarSubida) {
        if (!(condicionFecha && condicionHora)) {
            contenedorTexto.innerHTML = "Debe completar los campos para programar la subida";
            return false; // Evita el envío del formulario
        }
    }

    // Si se cumple la validación, el formulario se enviará normalmente
    return true;
}

