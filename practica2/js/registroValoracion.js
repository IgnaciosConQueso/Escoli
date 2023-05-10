$(document).ready(function() {
	const okIcon = "&#x2714;";
	//const errorIcon = "&#x26a0;";

    //valores inicializacion
    idProfesor = 0;
    profesorSeleccionado();

    //eventos
    $("#profesorAsignatura").change(profesorSeleccionado);
    $("#comentario").change(compruebaComentario);

    //funciones
    function profesorSeleccionado() {
        idProfesor = $("#profesorAsignatura").val();
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

    function compruebaComentario() {
        comentario = document.getElementById("comentario").value;
        lon = comentario.length;
        if(lon > 1000){
            document.getElementById('validComentario').innerHTML = "El comentario no puede superar los 1000 caracteres";
            $("#comentario").attr("invalid", true);
            return false;
        }
        else if (lon <= 0){
            document.getElementById('validComentario').innerHTML = "El comentario no puede estar vacio";
            $("#comentario").attr("invalid", true);
            return false;
        }
        else {
            document.getElementById('validComentario').innerHTML = okIcon;
            $("#comentario").removeAttr("invalid");
        }
    }
})