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
    $nombre_completo = $_POST['nombre_completo'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $fecha_contratacion = date('Y-m-d h:i:s');
    $numero_horas = $_POST['numero_horas'] ?? 0;
    $precio_hora = $_POST['precio_hora'] ?? 0;
    $salario = $_POST['salario'] ?? 0;
    $estado = $_POST['estado'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $documento_identidad = $_POST['documento_identidad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $imagen = $_FILES['imagen'] ?? null;
    $documentacion_archivo = $_FILES['documentacion_archivo'] ?? null;
    $fecha_creacion = date('Y-m-d H:i:s');
    $descripcion_profesional = $_POST['descripcion_profesional'] ?? '';
    
    // Instancia el modelo
    $modelo = new EmpleadoModel($mysqli);

    // Insertar el empleado usando el método del modelo
    $resultado = $modelo->insertarEmpleado($nombre_completo, $cargo, $fecha_contratacion, $numero_horas, $precio_hora, $salario, $estado, $departamento, $documento_identidad, $direccion, $ciudad, $telefono, $pais, $imagen, $documentacion_archivo, $fecha_creacion, $descripcion_profesional);

    // Verifica si la inserción fue exitosa
    if ($resultado) {
        // Redirecciona al usuario a la página principal con un mensaje de éxito
        header("Location: create.php?da=2");
        exit();
    } else {
        // En caso de error, muestra un mensaje al usuario
        echo "Error al insertar el empleado.";
    }

    // Cierra la conexión a la base de datos
    mysqli_close($mysqli);
}

