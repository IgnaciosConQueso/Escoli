const BotonesLike = document.getElementsByName("like");
const BotonesDislike = document.getElementsByName("dislike");
	
    BotonesLike.forEach((like) => {
        like.addEventListener("click", function() {

            const idVal = $(this).data("idValoracion");
            const likes = $(this).data("likes");
            const api = $(this).data("api");
            $.ajax({
                url: api,
                method: "POST",
                data: {
                    idVal: idVal,
                    likes: likes,
                    valor: 1
                },
                success: function(data) {  
                    var response = JSON.parse(data);
                    if(!response.success){
                        alert(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
            
        });
    });
    
    BotonesDislike.forEach((dislike) =>{
        dislike.addEventListener("click", function(){

            const idVal = $(this).data("idValoracion");
            const likes = $(this).data("likes");
            const api = $(this).data("api");
            $.ajax({
                url: api,
                method: "POST",
                data: {
                    idVal: idVal,
                    likes: likes,
                    valor: -1
                },
                success: function(data) {  
                    var response = JSON.parse(data);
                    if(!response.success){
                        alert(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
    
        });
    });
   