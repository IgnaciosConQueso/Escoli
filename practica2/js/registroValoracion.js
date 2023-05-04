$(document).ready(function() {
	const okIcon = "&#x2714;";
	//const errorIcon = "&#x26a0;";

    //valores inicializacion
    idProfesor = 0;
    profesorSeleccionado();

    //eventos
    $("#profesor").change(profesorSeleccionado);
    $("#puntuacion").change(compruebaPuntuacion);
    $("#comentario").change(compruebaComentario);

    //funciones
    function profesorSeleccionado() {
        idProfesor = $("#profesor").val();
        puntuacion= document.getElementById("puntuacion");
        comentario = document.getElementById("comentario");
        if(idProfesor==0){
            puntuacion.disabled = true;
            comentario.disabled = true;
        } else {
            puntuacion.disabled = false;
            comentario.disabled = false;
        }
    }

    function compruebaPuntuacion() {
        puntuacion = document.getElementById("puntuacion").value;
        if(puntuacion<0 || puntuacion>5){
            document.getElementById('validPuntuacion').innerHTML = "La puntuacion tiene que estar entre 0 y 5";
            return false;
        } else {
            document.getElementById('validPuntuacion').innerHTML = okIcon;
        }
    }

    function compruebaComentario() {
        comentario = document.getElementById("comentario").value;
        lon = comentario.length;
        if(lon > 1000){
            document.getElementById('validComentario').innerHTML = "El comentario tiene que tener una longitud de máxima de 1000 caracteres";
            return false;
        }
        else if (lon <= 0){
            document.getElementById('validComentario').innerHTML = "El comentario no puede estar vacio";
            return false;
        }
        else {
            document.getElementById('validComentario').innerHTML = okIcon;
        }
    }
})