$(document).ready(function() {
	const okIcon = "&#x2714;";
	const errorIcon = "&#x26a0;";

	$("#nombreUsuario").change(compruebaNombre);

	$("#email").change(compruebaEmail);

	$("#password").change(compruebaPassword);

	$("#password2").change(compruebaPassword2);

	//funciones

	function compruebaNombre() {
			username = document.getElementById("nombreUsuario").value;
			lon = username.length;
			if(lon <5){
				document.getElementById('validName').innerHTML = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres";
				return false;
			} else {
				var url = "comprobarUsuario.php?user=" + $("#nombreUsuario").val();
				$.get(url,usuarioExiste);
			}
	}

	function usuarioExiste(response) {
		if (response === "true") {
			//&#x26a0;
			document.getElementById('validName').innerHTML = errorIcon;
			alert("USUARIO YA EXISTE");
			return false;
		}
		else {
			//&#x2714;
			document.getElementById('validName').innerHTML = okIcon;
		}
	}

	function compruebaEmail(){
		const campo = $("#email");
		campo[0].setCustomValidity("");
			
		// validación html5, porque el campo es <input type="email" ...>
		const esCorreoValido = campo[0].checkValidity();//va pocha, funciona con user@user por ejemplo (cosa que luego php no admite)
		
		//para la comprobación de cadena vacía
		correo = document.getElementById("email").value;
		lon = correo.length;

		if (!esCorreoValido || lon <= 0) {
			campo[0].setCustomValidity("Introduce un correo válido");
			//&#x26a0;
			document.getElementById('validEmail').innerHTML = errorIcon;
			return false;
		} else {
			campo[0].setCustomValidity("");
			//&#x2714;
			document.getElementById('validEmail').innerHTML = okIcon;
		}
	}

	function compruebaPassword(){
		pass = document.getElementById("password").value;
		lon = pass.length;

		if(lon < 5){
			document.getElementById('validPass').innerHTML = "El password tiene que tener una longitud de al menos 5 caracteres";
			return false;
		} else {
			document.getElementById('validPass').innerHTML = "";
		}

	}

	function compruebaPassword2(){
		pass = document.getElementById("password").value;
		pass2 = document.getElementById("password2").value;

		if(pass != pass2){
			document.getElementById('validPass2').innerHTML = "Los passwords deben coincidir";
			return false;
		} else {
			document.getElementById('validPass2').innerHTML = "";
		}
	}
})