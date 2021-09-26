function enviarLectura(){

    var editor=document.getElementById('content').value;
 
    $.ajax({
        method: "POST",
        url:"php/funciones.php",
        data:{
            content:editor,   
            action: 1      
        },
    })
    .done(function(msg){
        alert("Data Saved:"+msg)
    })
    .fail( function(xhr, textStatus, errorThrown) {
        alert(xhr.responseText);
    });

}
var boton=document.getElementById('boton');

boton.addEventListener("click",enviarLectura());