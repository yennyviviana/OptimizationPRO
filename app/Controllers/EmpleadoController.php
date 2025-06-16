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
    $tipo_contrato = $_POST['tipo_contrato'] ?? '';
    $fecha_contratacion = date('Y-m-d h:i:s');
    $horas_trabajo = $_POST['horas_trabajo'] ?? 0;
    $salario = $_POST['salario'] ?? 0;
    $estado = $_POST['estado'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $documento_identidad = $_POST['documento_identidad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $$fecha_nacimiento = date('Y-m-d H:i:s'); 
    $genero = $_POST['genero'] ?? '';
    $estado_civil = $_POST['estado_civil'] ?? '';
    $imagen = $_FILES['imagen'] ?? null;
    $documentacion= $_FILES['documentacion'] ?? null;
    $descripcion= $_FILES['descripcion'] ?? null;
    $fecha_creacion = date('Y-m-d H:i:s');
    $fecha_modificacion= date('Y-m-d H:i:s');
    
    
    
    // Instancia el modelo.....
    $modelo = new EmpleadoModel($mysqli);

    // Insertar el empleado usando el método del modelo.....
    $resultado = $modelo->insertarEmpleado($nombre, $cargo, $tipo_contrato, $fecha_contratacion, $horas_trabajo, $tarifa_hora, $salario, $estado, $departamento,$tipo_documento, $documento_identidad, $direccion, $ciudad,$pais,  $telefono, $correo, $fecha_nacimiento,$genero, $estado_civil, $Imagen, $documentacion, $descripcion, $$fecha_creacion, $fecha_modificacion);

    // Verifica si la inserción fue exitosa
    if ($resultado) {
        header("Location: create.php?da=2");
        exit();
    } else {
       echo "Error al insertar el empleado.";
    }

    mysqli_close($mysqli);
}

