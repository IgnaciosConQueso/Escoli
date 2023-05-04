$(document).ready(function() {
	const okIcon = "&#x2714;";
	const errorIcon = "&#x26a0;";

    //valores inicializacion
    idUniversidad = 0;
    universidadSeleccionada();

    //eventos
    $("#universidad").change(universidadSeleccionada);
    $("#nombre").change(compruebaNombre);

    //funciones
    function universidadSeleccionada() {
        idUniversidad = $("#universidad").val();
        campoFacultad = document.getElementById("nombre");
        if(idUniversidad==0){
            campoFacultad.disabled = true;
        } else {
            campoFacultad.disabled = false;
        }
    }

	function compruebaNombre() {
			facultad = document.getElementById("nombre").value;
			lon = facultad.length;
			if(lon < 5){
				document.getElementById('validName').innerHTML = "El nombre de la facultad tiene que tener una longitud de al menos 5 caracteres";
				return false;
			} else {
				var url = "comprobarFacultad.php?universidad=" + idUniversidad + "&facultad=" + $("#nombre").val();
				$.get(url, facultadExiste);
			}
	}

	function facultadExiste(response) {
		if (response === "true") {
			//&#x26a0;
			document.getElementById('validName').innerHTML = errorIcon;
			alert("FACULTAD YA EXISTE");
			return false;
		}
		else {
			//&#x2714;
			document.getElementById('validName').innerHTML = okIcon;
		}
	}
})