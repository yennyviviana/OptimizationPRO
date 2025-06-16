<?php
require_once __DIR__ . '/../Models/CompraModel.php';
require_once __DIR__ . '/../Config/database.php';

session_start(); 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Fetch providers from the database.........
$sql = "SELECT id_proveedor, nombre_empresa FROM proveedores";
$result = $mysqli->query($sql);



$providers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}


// Fetch inventory codes from the database.....
$sqlInventory = "SELECT codigo_inventario, nombre_producto FROM inventarios";
$resultInventory = $mysqli->query($sqlInventory);
$inventory = [];
if ($resultInventory->num_rows > 0) {
    while ($row = $resultInventory->fetch_assoc()) {
        $inventory[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Print POST data for debugging purposes.......
    echo '<pre>';
     print_r($_POST);
     print_r($_FILES);
     echo '</pre>';

    // Validate and capture POST data.....
    $productos_comprados = $_POST['productos_comprados'] ?? '';
    $detalles_productos = $_POST['detalles_productos'] ?? '';
    $precio_unitario = $_POST['precio_unitario'] ?? '';
    $precio_compra = $_POST['precio_compra'] ?? '';
    $total_compra = $_POST['total_compra'] ?? '';
    $estado_actual = $_POST['estado_actual'] ?? '';
    $metodo_pago = $_POST['metodo_pago'] ?? '';
    $fecha_compra = date('Y-m-d H:i:s'); 
    $fecha_entrega = $_POST['fecha_entrega'] ?? '';
    $factura = $_FILES['factura'] ?? '';
    $id_proveedor = $_POST['id_proveedor'] ?? '';
    $id_usuario = $_SESSION['id_usuario'];
    $codigo_inventario = $_POST['codigo_inventario'] ?? '';

    // Instantiate the model.........
    $modelo = new CompraModel($mysqli);

    // Insert product using the corresponding model method.........
    $resultado = $modelo->insertarCompra($productos_comprados, $detalles_productos, 
    $precio_unitario, $precio_compra, $total_compra, $estado_actual, $metodo_pago, $fecha_compra, 
    $fecha_entrega, $codigo_inventario, $id_proveedor, $id_usuario, $factura);

    // Verify if the insertion was successful........
    if ($resultado) {
        header("Location: create.php?da=2");
        exit();
    } else {
        echo "Error al insertar el producto.";
    }

    // Close the database connection........
    mysqli_close($mysqli);
}

