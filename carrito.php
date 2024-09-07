<?php
include 'funcion.php'; // Incluir archivo donde tienes la función de contar productos
?>
<?php
// Iniciar la sesión solo si no ha sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Manejar la actualización de la cantidad de un producto
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = intval($_POST['quantity']); // Asegurarse de que sea un número entero

    // Verificar que el producto existe en el carrito
    if (isset($_SESSION['cart'][$product_id])) {
        // Si la cantidad es 0 o menos, eliminamos el producto
        if ($new_quantity <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
        }
    }
}

// Manejar la eliminación de un producto del carrito
if (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Función para verificar si el carrito está vacío
function is_cart_empty()
{
    return empty($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>LubriExpress</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
</head>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="lubriexpress@gmail.com">lubriexpress@gmail.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="tel:2634-522248 - 2634-346714">2634-522248 - 2634-346714</a>
                </div>
                <div>
                    <a class="text-light" href="https://fb.com/lubriexpress" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/lubriexpress" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/lubriexpress" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="index.php">
                LUBRIEXPRESS
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">Sobre nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shop.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar align-self-center d-flex">
                    <a class="nav-icon position-relative text-decoration-none" href="carrito.php">
                        <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                        <?php
                        // Obtenemos la cantidad de productos en el carrito
                        $total_items = count_cart_items();
                        ?>
                        <!-- Mostramos el número solo si hay productos en el carrito -->
                        <?php if ($total_items > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-dark">
                                <?php echo $total_items; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Header -->

    <!-- Carrito de Compras -->
    <div class="container">
        <h1 style="color: green;">Tu Carrito de Compras</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Si el carrito no está vacío, mostrar los productos
                if (!is_cart_empty()) {
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $product_details) {
                        $subtotal = $product_details['price'] * $product_details['quantity'];
                        echo "<tr>
                            <td>{$product_details['name']}</td>
                            <td>\${$product_details['price']}</td>
                            <td>
                                <form action='carrito.php' method='POST' style='display: inline;'>
                                    <input type='number' name='quantity' value='{$product_details['quantity']}' min='1' style='width: 60px;'>
                                    <input type='hidden' name='product_id' value='{$product_id}'>
                                    <input type='submit' name='update_quantity' value='Actualizar' class='btn btn-sm btn-primary'>
                                </form>
                            </td>
                            <td>\${$subtotal}</td>
                            <td>
                                <form action='carrito.php' method='POST' style='display: inline;'>
                                    <input type='hidden' name='product_id' value='{$product_id}'>
                                    <input type='submit' name='remove_product' value='Eliminar' class='btn btn-sm btn-danger'>
                                </form>
                            </td>
                          </tr>";
                        $total += $subtotal;
                    }
                    echo "<tr>
                        <td colspan='3'><strong>Total</strong></td>
                        <td><strong>\${$total}</strong></td>
                        <td></td>
                      </tr>";
                } else {
                    echo "<tr><td colspan='5'>El carrito está vacío.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Start Footer -->
    <footer class="bg-dark" id="tempaltemo_footer">
        <div class="container">
            <div class="row">

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-success border-bottom pb-3 border-light logo">LubriExpress</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none" href="tel:2634-522248 - 2634-346714">2634-522248 - 2634-346714</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none" href="lubriexpress@gmail.com">lubriexpress@gmail.com</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Marcas</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="https://www.shell.com/">SHELL</a></li>
                        <li><a class="text-decoration-none" href="https://www.bardahl.com/">BARDAHL</a></li>
                        <li><a class="text-decoration-none" href="https://www.liquimoly.com/">LIQUI MOLY</a></li>
                        <li><a class="text-decoration-none" href="https://www.ypf.com/">YPF</a></li>
                    </ul>
                </div>
            </div>
            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <div class="col-auto me-auto">
                    <ul class="list-inline text-left footer-icons">
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a rel="nofollow" class="text-light text-decoration-none" target="_blank" href="http://fb.com/lubriexpress"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://www.instagram.com/lubriexpress"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                        </li>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="text-light text-decoration-none" target="_blank" href="https://twitter.com/lubriexpress"><i class="fab fa-twitter fa-lg fa-fw"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="w-100 bg-black py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-left text-light">
                            Copyright &copy; 2023 LUBRIEXPRESS
                            | Hecho por Ferreyra Ignacio y Gonzalez David
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- End Footer -->

    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
</body>

</html>