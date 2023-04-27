$(document).ready(function() {
	$("#email").change(function(){
		const campo = $("#email");
		campo[0].setCustomValidity("");
			
		// validación html5, porque el campo es <input type="email" ...>
		const esCorreoValido = campo[0].checkValidity();
		if (esCorreoValido) {
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

	$("#password2").change(function(){
		pass = document.getElementById("password").value;
		pass2 = document.getElementById("password2").value;

		if(pass != pass2){
			document.getElementById('validPass').innerHTML = "Las contraseñas no coinciden";
			return false;
		} else {
			document.getElementById('validPass').innerHTML = "";
		}
	});
})
