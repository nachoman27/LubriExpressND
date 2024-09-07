<?php
session_start(); // Asegúrate de iniciar la sesión en este archivo si no lo haces en cada página

function count_cart_items() {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $total_items = 0;
        foreach ($_SESSION['cart'] as $product) {
            $total_items += $product['quantity']; // Sumamos la cantidad de cada producto
        }
        return $total_items;
    }
    return 0; // Si no hay productos, devolvemos 0
}
?>
