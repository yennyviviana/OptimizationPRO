<?php
require_once __DIR__ . '/../Models/ProveedorModel.php';
require_once __DIR__ . '/../Config/database.php';

session_start(); // Ensure the session is started

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['boton'])) {
    // Instantiate the model
    $modelo = new ProveedorModel($mysqli);

    // Capture POST data
    $nombre_empresa = $_POST['nombre_empresa'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $lista_productos = $_POST['lista_productos'];
    $condiciones_pago = $_POST['condiciones_pago'];
    $metodo_pago = $_POST['metodo_pago'];
    $descripcion = $_POST['descripcion'];
    $archivo = $_FILES['archivo'];

    
        // Inserta el pedido usando el método correspondiente del modelo
    $resultado = $modelo->insertarProveedor($nombre_empresa, $direccion, $telefono, $correo_electronico, $lista_productos, $condiciones_pago, $metodo_pago, $descripcion,  $archivo);


 // Verifica si la inserción fue exitosa
 if ($resultado) {
    // Redirecciona al usuario a la página principal con un mensaje de éxito
    header("Location: create.php?da=2");
    exit();
} else {
    // En caso de error, muestra un mensaje al usuario
    echo "Error al insertar el proveedor.";
}

// Cierra la conexión a la base de datos
mysqli_close($mysqli);
}


?>
