$(document).ready(function() {
	$("#nombreUsuario").change(function(){//TODO
		//comprobar que el usuario exista en la base de datos
		username = document.getElementById("nombreUsuario").value;
		lon = username.length;

		if(lon <5){
			document.getElementById('validName').innerHTML = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres";
			return false;
		} else {
			document.getElementById('validName').innerHTML = "";
		}
	});

	$("#email").change(function(){//práctica 4
		const campo = $("#email");
		campo[0].setCustomValidity("");
			
		// validación html5, porque el campo es <input type="email" ...>
		const esCorreoValido = campo[0].checkValidity();
		
		//para la comprobación de cadena vacía
		correo = document.getElementById("email").value;
		lon = correo.length;

		if (!esCorreoValido || lon <= 0) {
			campo[0].setCustomValidity("Introduce un correo válido");
			//&#x26a0;
			document.getElementById('validEmail').innerHTML = "&#x26a0;";
			return false;
		} else {
			campo[0].setCustomValidity("");
			//&#x2714;
			document.getElementById('validEmail').innerHTML = "&#x2714;";
		}
	});

	$("#password").change(function(){
		pass = document.getElementById("password").value;
		lon = pass.length;

		if(lon < 5){
			document.getElementById('validPass').innerHTML = "El password tiene que tener una longitud de al menos 5 caracteres";
			return false;
		} else {
			document.getElementById('validPass').innerHTML = "";
		}

	});

	$("#password2").change(function(){
		pass = document.getElementById("password").value;
		pass2 = document.getElementById("password2").value;

		if(pass != pass2){
			document.getElementById('validPass2').innerHTML = "Los passwords deben coincidir";
			return false;
		} else {
			document.getElementById('validPass2').innerHTML = "";
		}
	});
})
