$(document).ready(function(){
    const okIcon = "&#x2714;";
	const errorIcon = "&#x26a0;";

    idFacultad = getIdFacultad();
    
    $("#nombre").change(compruebaAsignatura);

    function compruebaAsignatura() {
        nombre = document.getElementById("nombre").value;
        lon = nombre.length;
        if(lon <5){
            document.getElementById('validName').innerHTML = "El nombre de la asignatura tiene que tener una longitud de al menos 5 caracteres";
            $("#nombre").attr("invalid", true);
            return false;
        } else {
            var url = "comprobarAsignatura.php?asignatura=" + $("#nombre").val() + "&idFacultad=" + idFacultad;
            $.get(url,asignaturaExiste);
        }
    }

    function asignaturaExiste(response) {
        if (response === "true") {
            document.getElementById('validName').innerHTML = errorIcon;
            $("#nombre").attr("invalid", true);
            alert("La asignatura ya existe en esta facultad");
            return false;
        }
        else {
            document.getElementById('validName').innerHTML = okIcon;
            $("#nombre").removeAttr("invalid");
        }
    }

    function getIdFacultad(){
        var url = window.location.href;//cogemos la url
        var id = url.split("idFacultad=")[1];//partimos la url por el parámetro idFacultad y nos quedamos con la segunda parte
        id = id.split("&")[0];//por si hubiera más parámetros en la url
        return id;
    }
});