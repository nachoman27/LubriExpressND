var formElement = document.getElementById("form");    // creamos un objeto partiendo de su id

formElement.addEventListener('submit', function(ev) { // escuchamos el evento submit y si surge ejecutamos una función

ev.preventDefault();                                  // deshabilitamos el comportamiento por defecto de submit

var formData = new FormData(formElement);             // capturamos los datos del formulario

for(var pair of formData.entries()) {                 // Mostramos las [claves, valores] capturados en consola
    console.log(pair[0]+ ': '+ pair[1]);
  }
});
