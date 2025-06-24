<?php
require_once __DIR__ . '/../Models/EmpleadoModel.php';

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
    $nombre = $_POST['nombre'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $documento_identidad = $_POST['documento_identidad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
   
    
    
    // Instancia el modelo.....
    $modelo = new EmpleadoModel($mysqli);

    // Insertar el empleado usando el método del modelo.....
    $resultado = $modelo->insertarEmpleado($nombre, $cargo, $estado, $departamento,$tipo_documento, $documento_identidad, $direccion, $ciudad,$pais,  $telefono);

    // Verifica si la inserción fue exitosa
    if ($resultado) {
        header("Location: create.php?da=2");
        exit();
    } else {
       echo "Error al insertar el empleado.";
    }

    mysqli_close($mysqli);
}

