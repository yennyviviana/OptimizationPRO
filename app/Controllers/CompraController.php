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

if ($_POST) {
    echo '<pre>'; // Add these lines for debugging
    print_r($_POST); // Add these lines for debugging
    echo '</pre>'; // Add these lines for debugging

    if (isset($_POST['id_proveedor'])) {
        $id_proveedor = $_POST['id_proveedor'];
    } else {
        echo "id_proveedor no está presente en el POST.";
        exit();
    }

    // Instantiate the model
    $modelo = new ProductoModel($mysqli);

    // Capture POST data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productos_comprados = $_POST['productos_comprados'];
        $detalles = $_POST['detalles'];
        $precio_unitario= $_POST['precio_unitario'];
        $precio_compra= $_POST['precio_compra'];
        $estado = $_POST['estado'];
        $detalles = $_POST['detalles'];
        $factura = $_FILES['factura'];

        // Insert product using the corresponding model method
        $resultado = $modelo->insertarCompra($productos_comprados, $categoria_productos, $precio, $estado, $detalles, $archivo, $id_proveedor);

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