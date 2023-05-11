$(document).ready(function() {

    init();

    //eventos
    $("#pregunta").change(compruebaPregunta);
    $("#opcion1").change(compruebaOpciones);
    $("#opcion2").change(compruebaOpciones);
    $("#opcion3").change(compruebaOpciones);

    //funciones
    function init() {
        compruebaPregunta();
    }

    function compruebaPregunta(){
        msg = "";
        habilitar = true;

        pregunta = document.getElementById("pregunta").value;
        if(pregunta.length <= 0){
            habilitarOpciones(false);
            document.getElementById("validPregunta").innerHTML = "Plantea una pregunta para poder continuar";
            return false;
        } else {
            habilitarOpciones(true);
            document.getElementById("validPregunta").innerHTML = "";
        }
    }

    function habilitarOpciones(habilitar){
        $("#opcion1").prop("disabled", !habilitar);
        $("#opcion2").prop("disabled", !habilitar);
        $("#opcion3").prop("disabled", !habilitar);
    }

    function compruebaOpciones(){
        opcion1 = document.getElementById("opcion1").value;
        opcion2 = document.getElementById("opcion2").value;
        opcion3 = document.getElementById("opcion3").value;

        if(opcion1.length <= 0 || opcion2.length <= 0 || opcion3.length <= 0){
            document.getElementById('validOpciones').innerHTML = "No puede haber opciones vacias";
            return false;
        } else {
            if(opcionesIguales(opcion1,opcion2,opcion3)){
                document.getElementById('validOpciones').innerHTML = "No puede haber opciones iguales";
                return false;
            }
            else {
                document.getElementById('validOpciones').innerHTML = "";
            }
        }
    }

    function opcionesIguales(o1,o2,o3){
        return o1 == o2 || o1 == o3 || o2 == o3;
    }
});