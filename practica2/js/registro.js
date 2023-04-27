$(document).ready(function() {
	
	$("#nombreUsuario").change(function(){
		username = document.getElementById("nombreUsuario").value;

		if(username.lenght <5){
			document.getElementById('validName').innerHTML = "La contraseña debe tener una longitud de al menos 5";
			return false;
		} else {
			document.getElementById('validName').innerHTML = "";
		}
	});

	$("#email").change(function(){
		const campo = $("#email");
		campo[0].setCustomValidity("");
			
		// validación html5, porque el campo es <input type="email" ...>
		const esCorreoValido = campo[0].checkValidity();
		if (esCorreoValido) {//la cadena vacia le vale xd
			//TODO
			campo[0].setCustomValidity("");
			//&#x2714;
			document.getElementById('validEmail').innerHTML = "&#x2714;";
		} else {
			campo[0].setCustomValidity("Introduce un correo válido");
			//&#x26a0;
			document.getElementById('validEmail').innerHTML = "&#x26a0;";
			return false;
		}
	});

	$("#password").change(function(){
		lon = document.getElementById("password").value.lenght;

		if(lon < 5){
			document.getElementById('validPass').innerHTML = "La contraseña debe tener una longitud de al menos 5";
			return false;
		} else {
			document.getElementById('validPass').innerHTML = "";
		}
	});

	$("#password2").change(function(){
		pass = document.getElementById("password").value;
		pass2 = document.getElementById("password2").value;

		if(pass != pass2){
			document.getElementById('validPass2').innerHTML = "Las contraseñas no coinciden";
			return false;
		} else {
			document.getElementById('validPass2').innerHTML = "";
		}
	});
})
