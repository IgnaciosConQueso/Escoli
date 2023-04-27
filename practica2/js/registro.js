$(document).ready(function() {
	vName = false;
	vEmail = false;
	vPass = false;
	vPass2 = false;

	function evaluaButton(){
		if(vName && vEmail && vPass && vPass2){
			document.getElementById("submit").disabled = false;
		} else {
			document.getElementById("submit").disabled = true;
		}
	}

	$("#nombreUsuario").change(function(){//TODO
		//comprobar que el usuario exista en la base de datos
		username = document.getElementById("nombreUsuario").value;
		lon = username.length;

		if(lon <5){
			document.getElementById('validName').innerHTML = "El nombre debe tener una longitud de al menos 5";
			vName = false;
		} else {
			document.getElementById('validName').innerHTML = "";
			vName = true;
		}
		evaluaButton();
	});

	$("#email").change(function(){
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
			vEmail = false;
		} else {
			campo[0].setCustomValidity("");
			//&#x2714;
			document.getElementById('validEmail').innerHTML = "&#x2714;";
			vEmail = true;
		}
		evaluaButton();
	});

	$("#password").change(function(){
		pass = document.getElementById("password").value;
		lon = pass.length;

		if(lon < 5){
			document.getElementById('validPass').innerHTML = "La contraseña debe tener una longitud de al menos 5";
			vPass = false;
		} else {
			document.getElementById('validPass').innerHTML = "";
			vPass = true;
		}
		evaluaButton();
	});

	$("#password2").change(function(){
		pass = document.getElementById("password").value;
		pass2 = document.getElementById("password2").value;

		if(pass != pass2){
			document.getElementById('validPass2').innerHTML = "Las contraseñas no coinciden";
			vPass2 = false;
		} else {
			document.getElementById('validPass2').innerHTML = "";
			vPass2 = true;
		}
		evaluaButton();
	});

	evaluaButton();
})
