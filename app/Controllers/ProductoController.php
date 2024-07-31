<?php
require_once __DIR__ . '/../Models/ProductoModel.php';
require_once __DIR__ . '/../Config/database.php';

session_start(); 

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
    echo '</pre>'; //  lines for debugging

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
        $nombre_producto = $_POST['nombre_producto'];
        $precio = $_POST['precio'];
        $cantidad_stock = $_POST['cantidad_stock'];
        $categoria_productos = $_POST['categoria_productos'];
        $estado = $_POST['estado'];
        $fecha_adquisicion = $_POST['fecha_adquisicion'];
        $fecha_vencimiento = $_POST['fecha_vencimiento'];
        $fecha_vencimiento = $_POST['detalles'];
        $detalles= $_POST['detalles'];
        $archivo = $_FILES['archivo'];
        $codigo_barras= $_POST['codigo_barras'];
        // Insert product using the corresponding model method
        $resultado = $modelo->insertarProducto($nombre_producto,$precio,$cantidad_stock,$categoria_productos,$estado,$fecha_adquisicion,$fecha_vencimiento,$id_proveedor,$detalles,$archivo,$codigo_barras);

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
