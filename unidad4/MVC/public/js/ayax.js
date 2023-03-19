
document.getElementById("botonesFinales").addEventListener("click",siguiente,false);
/**
 * Función para hacer petición asincrona al servidor
 * @param {evento} e 
 */
function siguiente(e){
  //Evitamos que input mande datos
  e.preventDefault();
$(document).ready( function () {
let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //insertamos el archivo de texto que nos devuelve el servidor
       $('#pokemons').append(xhttp.responseText);
    }
};
//Hacemos petición GET al servidor
    xhttp.open("GET", "http://localhost/unidad4/MVC/?controlador=pokemon&metodo=paginarPokemons&source=api&peticion=ayax", true);
    xhttp.send();
},) 
}


    


