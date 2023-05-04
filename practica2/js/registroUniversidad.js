$(document).ready(function() {
	const okIcon = "&#x2714;";
	const errorIcon = "&#x26a0;";

	$("#nombre").change(compruebaNombre);

	//funciones

	function compruebaNombre() {
			username = document.getElementById("nombre").value;
			lon = username.length;
			if(lon <5){
				document.getElementById('validName').innerHTML = "El nombre de la universidad tiene que tener una longitud de al menos 5 caracteres";
				return false;
			} else {
				var url = "comprobarUniversidad.php?universidad=" + $("#nombre").val();
				$.get(url,universidadExiste);
			}
	}

	function universidadExiste(response) {
		if (response === "true") {
			//&#x26a0;
			document.getElementById('validName').innerHTML = errorIcon;
			alert("UNIVERSIDAD YA EXISTE");
			return false;
		}
		else {
			//&#x2714;
			document.getElementById('validName').innerHTML = okIcon;
		}
	}
})