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
		}
	});
})