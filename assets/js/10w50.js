document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll("button");

    buttons.forEach(button => {
        button.addEventListener("click", function() {
            const productName = this.id; // Obtener el nombre del producto del ID del botón
            addToCart(productName); // Llamar a la función para agregar el producto al carrito
        });
    });

    function addToCart(productName) {
        // Realizar una solicitud POST a carrito.php para guardar el nombre del producto
        fetch('carrito.php', {
            method: 'POST',
            body: JSON.stringify({ product: productName }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                console.log('Producto agregado al carrito: ' + productName);
            } else {
                console.error('Error al agregar el producto al carrito');
            }
        })
        .catch(error => {
            console.error('Error de red:', error);
        });
    }
});
