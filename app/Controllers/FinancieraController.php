<?php
require_once __DIR__ . '/../Models/FinancieraModel.php';
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

// Fetch inventory codes from the database
$sqlInventory = "SELECT codigo_inventario, nombre_producto FROM inventarios";
$resultInventory = $mysqli->query($sqlInventory);
$inventory = [];
if ($resultInventory->num_rows > 0) {
    while ($row = $resultInventory->fetch_assoc()) {
        $inventory[] = $row;
    }
}

// Fetch products from the database
$sqlProducts = "SELECT id_producto, nombre_producto FROM productos";
$resultProducts = $mysqli->query($sqlProducts);

$products = [];
if ($resultProducts->num_rows > 0) {
    while ($row = $resultProducts->fetch_assoc()) {
        $products[] = $row;
    }
}

// Fetch clients from the database
$sqlClients = "SELECT id_cliente, nombre FROM clientes";
$resultClients = $mysqli->query($sqlClients);

$clients = [];
if ($resultClients->num_rows > 0) {
    while ($row = $resultClients->fetch_assoc()) {
        $clients[] = $row;
    }
}

// Fetch projects from the database
$sqlProjects = "SELECT id_proyecto, nombre_proyecto FROM proyectos";
$resultProjects = $mysqli->query($sqlProjects);

$projects = [];
if ($resultProjects->num_rows > 0) {
    while ($row = $resultProjects->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Fetch orders from the database
$sqlOrders = "SELECT id_pedido, nombre_pedido FROM pedidos";
$resultOrders = $mysqli->query($sqlOrders);

$orders = [];
if ($resultOrders->num_rows > 0) {
    while ($row = $resultOrders->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Fetch purchases from the database
$sqlPurchases = "SELECT id_compra, productos_comprados FROM compras";
$resultPurchases = $mysqli->query($sqlPurchases);

$purchases = [];
if ($resultPurchases->num_rows > 0) {
    while ($row = $resultPurchases->fetch_assoc()) {
        $purchases[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Print POST data for debugging purposes
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Instantiate the model
    $modelo = new FinancieraModel($mysqli);

    // Capture POST data with default values
    $fecha_transaccion = date('Y-m-d H:i:s'); // Set this from the form if needed
    $monto = isset($_POST['monto']) ? $_POST['monto'] : '';
    $tipo_transaccion = isset($_POST['tipo_transaccion']) ? $_POST['tipo_transaccion'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['id_usuario']; // Use session user ID if POST ID is not present
    $id_proveedor = isset($_POST['id_proveedor']) ? $_POST['id_proveedor'] : '';
    $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
    $id_producto = isset($_POST['id_producto']) ? $_POST['id_producto'] : '';
    $id_proyecto = isset($_POST['id_proyecto']) ? $_POST['id_proyecto'] : '';
    $id_pedido = isset($_POST['id_pedido']) ? $_POST['id_pedido'] : '';
    $codigo_inventario = isset($_POST['codigo_inventario']) ? $_POST['codigo_inventario'] : '';
    $id_compra = isset($_POST['id_compra']) ? $_POST['id_compra'] : '';

    // Insert data using the model
    $resultado = $modelo->insertarFinanciera(
        $fecha_transaccion,
        $monto,
        $tipo_transaccion,
        $descripcion,
        $id_usuario,
        $id_proveedor,
        $id_cliente,
        $id_pedido,
        $codigo_inventario,
        $id_producto,
        $id_compra,
        $id_proyecto
    );

    // Verify if the insertion was successful
    if ($resultado) {
        header("Location: create.php?da=2");
        exit();
    } else {
        echo "Error al insertar la transacción financiera.";
    }

    // Close the database connection
    $mysqli->close();
}
?>
