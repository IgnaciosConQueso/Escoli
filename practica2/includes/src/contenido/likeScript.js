/*
// Asigna un evento de clic a los botones de like y dislike
document.getElementById("boton-like").addEventListener("click", function() {
  enviarSolicitudAJAX(id,likes++);
  });
  
  document.getElementById("boton-dislike").addEventListener("click", function() {
    enviarSolicitudAJAX(id,likes--);
  });
  */
  //realiza una llamada AJAX a la función "gestionaLikes" en el archivo PHP
  function enviarSolicitudAJAX(id, likes) {
    var xmlhttp = new XMLHttpRequest();
    var url = "includes/src/contenido/API_likes.php";
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
    };
    xmlhttp.send("id=" + id + "&likes=" + likes);
  }
  