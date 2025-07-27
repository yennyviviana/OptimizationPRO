<?php
require_once __DIR__ . '/../Models/ProveedorModel.php';
require_once __DIR__ . '/../Config/database.php';

session_start(); 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['boton'])) {
    // Instantiate the model.....
    $modelo = new ProveedorModel($mysqli);



    
// Fetch products from the database.....
$sqlProducts = "SELECT id_producto, nombre_producto FROM productos";
$resultProducts = $mysqli->query($sqlProducts);

$products = [];
if ($resultProducts->num_rows > 0) {
    while ($row = $resultProducts->fetch_assoc()) {
        $products[] = $row;
    }
}

    // Capture POST data...
    $nombre_empresa = $_POST['nombre_empresa'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $condiciones_pago = $_POST['condiciones_pago'];
    $id_producto = $_POST['id_producto'];
    $metodo_pago = $_POST['metodo_pago'];
    $descripcion = $_POST['descripcion'];
    $historial_pedidos =  $_POST['historial_pedidos'];
    $archivo = $_FILES['archivo'];


    
    
// Inserta el pedido usando el método  del modelo.....
    $resultado = $modelo->insertarProveedor($nombre_empresa, $direccion, $telefono,
    $correo_electronico, $condiciones_pago, $metodo_pago, $descripcion,$id_producto,
     $historial_pedidos, $archivo);


 // Verifica si la inserción fue exitosa.....
 if ($resultado) {
    header("Location: create.php?da=2");
    exit();
} else {
    echo "Error al insertar el proveedor.";
}

// Cierra la conexión a la base de datos.....
mysqli_close($mysqli);

}



