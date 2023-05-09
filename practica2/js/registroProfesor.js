$(document).ready(function() {
	const okIcon = "&#x2714;";
	const errorIcon = "&#x26a0;";

	$("#nombre").change(compruebaNombre);

	//funciones

	function compruebaNombre() {
			profesor = document.getElementById("nombre").value;
			lon = profesor.length;
			if(lon <5){
				document.getElementById('validName').innerHTML = "El nombre del profesor/a tiene que tener una longitud de al menos 5 caracteres";
				return false;
			} 
	}
})