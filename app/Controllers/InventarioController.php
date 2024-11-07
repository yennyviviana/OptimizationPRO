<?php
require_once __DIR__ . '/../Models/InventarioModel.php';
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

// Fetch products from the database
$sql = "SELECT id_producto, nombre_producto FROM productos";
$result = $mysqli->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = new InventarioModel($mysqli);

    $nombre_producto = $_POST['nombre_producto'];
    $cantidad_stock = $_POST['cantidad_stock'];
    $precio_unitario = $_POST['precio_unitario'];
    $costo_unitario = $_POST['costo_unitario'];
    $precio_compra = $_POST['precio_compra'];
    $precio_venta = $_POST['precio_venta'];
    $categoria_productos = $_POST['categoria_productos'];
    $descripcion = $_POST['descripcion'];
    $codigo_barras = $_POST['codigo_barras'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $id_producto = $_POST['id_producto'];
    $id_proveedor = $_POST['id_proveedor'];
    $fecha_adquisicion = $_POST['fecha_adquisicion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $tipo_documento = $_FILES['tipo_documento'];

    $resultado = $modelo->insertarInventario($nombre_producto, $cantidad_stock, $precio_unitario, $costo_unitario, $precio_compra, $precio_venta, $categoria_productos, $descripcion, $codigo_barras, $ubicacion, $estado, $id_producto, $id_proveedor, $fecha_adquisicion, $fecha_vencimiento, $tipo_documento);

    if ($resultado) {
        header("Location: create.php?da=2");
        exit();
    } else {
        //echo "Error al insertar el inventario.";
    }

    mysqli_close($mysqli);
}

