<?php
require_once __DIR__ . '/../Models/CompraModel.php';
require_once __DIR__ . '/../Config/database.php';

session_start(); // Ensure the session is started

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Fetch providers from the database
$sql = "SELECT id_proveedor, nombre_empresa FROM proveedores";
$result = $mysqli->query($sql);

$providers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}

// Fetch products from the database
$sql = "SELECT id_producto, nombre_producto FROM productos";
$result = $mysqli->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

if ($_POST) {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    if (isset($_POST['id_proveedor'])) {
        $id_proveedor = $_POST['id_proveedor'];
    } else {
        echo "id_proveedor no está presente en el POST.";
        exit();
    }

    if (isset($_POST['id_producto'])) {
        $id_producto = $_POST['id_producto'];
    } else {
        echo "id_producto no está presente en el POST.";
        exit();
    }

    // Instantiate the model
    $modelo = new CompraModel($mysqli);

    // Capture POST data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productos_comprados = $_POST['productos_comprados'];
        $detalles = $_POST['detalles'];
        $precio_unitario = $_POST['precio_unitario'];
        $precio_compra = $_POST['precio_compra'];
        $total_compra = $_POST['total_compra'];
        $estado_actual = $_POST['estado_actual'];
        $fecha_compra = date('Y-m-d H:i:s');
        $fecha_entrega = $_POST['fecha_entrega'];
        $factura = $_FILES['factura'];
        $id_usuario = $_SESSION['id_usuario'];

        // Insert product using the corresponding model method
        $resultado = $modelo->insertarCompra($productos_comprados, $detalles, $precio_unitario, $precio_compra, $total_compra, $estado_actual, $fecha_compra, $fecha_entrega, $factura, $id_producto, $id_proveedor, $id_usuario);

        // Verify if the insertion was successful
        if ($resultado) {
            // Redirect the user to the main page with a success message
            header("Location: create.php?da=2");
            exit();
        } else {
            // In case of error, display a message to the user
            echo "Error al insertar el producto.";
        }

        // Close the database connection
        mysqli_close($mysqli);
    }
}
?>
