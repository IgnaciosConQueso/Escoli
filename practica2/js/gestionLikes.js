

document.addEventListener("DOMContentLoaded", () =>{

    const valoraciones = document.querySelectorAll(".valoracion");
        
        valoraciones.forEach((valoracion) => { //cojo todas las valoraciones e itero sobre ellas
            
            const like = valoracion.querySelector(".boton-like"); //cojo los botones
            const dislike = valoracion.querySelector(".boton-dislike");
            var divlikes = valoracion.querySelector(".likes"); //cojo el div donde se imprimen los likes para poder actualizarlo luego
            
            
            like.addEventListener("click", function() { //en cada boton

                const idVal = $(this).data("idval");
                let numlikes = parseInt(this.dataset.likes); //cojo el numero de likes
                const api = $(this).data("api");
                const valor = 1;


                $.ajax({
                    url: api,
                    method: "POST",
                    data: {
                        idValoracion: idVal, //hago un post de los valores que necesito a mi api
                        likes: numlikes,
                        valor: 1
                    },
                    success: function(data) {  
                        var response = JSON.parse(data);
                        if(response.succes === false){ //la api procesa la señal
                            alert(response.message);
                        } else { //si sale bien actualizo el valor de los likes en la pantalla y en los botones, si es un lio.
                            numlikes += valor;
                            divlikes.textContent ="likes: "  + numlikes;
                        }
                        document.cookie = "scrollPos=" + window.scrollY;
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
                
            });
       
            dislike.addEventListener("click", function(){
                // lo mismo que arriba
                const idVal = $(this).data("idval");
                let numlikes = parseInt(this.dataset.likes);
                const api = $(this).data("api");
                const valor = -1; //realmente solo cambia esto y 4 cosas más de los datos y su actualizacion feo pero funciona.

                $.ajax({
                    url: api,
                    method: "POST",
                    data: {
                        idValoracion: idVal,
                        likes: numlikes,
                        valor: -1
                    },
                    success: function(data) {  
                        var response = JSON.parse(data);
                        if(response.succes === false){
                            alert(response.message);
                        } else {
                            numlikes += valor;
                            divlikes.textContent ="likes: "  + numlikes;    
                        }
                        document.cookie = "scrollPos=" + window.scrollY;
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
        
            });
        });
});

window.onload = function() {

    var scrollPos = getCookie("scrollPos");
    if (scrollPos == null || scrollPos == undefined) {
         scrollPos = 0;
    } else {
    scrollPos = parseInt(scrollPos);
    }

    // desplazar la página a la posición guardada
    window.scrollTo(0, scrollPos);
  
}

  
  // función para obtener el valor de una cookie
  function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
  }