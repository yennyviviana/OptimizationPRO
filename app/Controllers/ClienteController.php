<?php
require_once __DIR__ . '/../Models/ClienteModel.php';

session_start(); 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}



$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if($mysqli->connect_error){
    
    die('Error en la conexion' . $mysqli->connect_error);
    
}
// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $codigo_postal = $_POST['codigo_postal'];
    $pais = $_POST['pais'];
    $fecha_creacion = date('Y-m-d H:i:s');
    $fecha_modificacion = $_POST['fecha_modificacion'];

    // Instancia el modelo
    $modelo = new ClienteModel($mysqli);

    //  insertar el cliente usando el método del modelo
    $resultado = $modelo->insertarCliente($nombre, $apellido, $email, $telefono, $direccion, $ciudad, $estado, $codigo_postal, $pais, $fecha_creacion, $fecha_modificacion);

    // Verifica si la inserción fue exitosa
    if ($resultado) {
        // Redirecciona al usuario a la página principal con un mensaje de éxito
        header("Location: create.php?da=2");
        exit();
    } else {
        // En caso de error, muestra un mensaje al usuario
        echo "Error al insertar el pedido.";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($mysqli);
}


