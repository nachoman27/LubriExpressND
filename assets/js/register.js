// creamos un objeto partiendo de su id
var formElement = document.getElementById("form");

// escuchamos el evento submit y si surge ejecutamos una función
formElement.addEventListener('submit', function(ev) {

  // deshabilitamos el comportamiento por defecto de submit
    ev.preventDefault();

  // capturamos los datos del formulario
  var formData = new FormData(formElement);

  // Mostramos las [claves, valores] capturados en consola
  for(var pair of formData.entries()) {
    console.log(pair[0]+ ': '+ pair[1]);
  }
});