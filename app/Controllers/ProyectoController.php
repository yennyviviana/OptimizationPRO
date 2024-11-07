<?php
require_once __DIR__ . '/../Models/ProyectoModel.php';
require_once __DIR__ . '/../Config/database.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura y valida los datos del formulario
    $nombre_proyecto = isset($_POST['nombre_proyecto']) ? $_POST['nombre_proyecto'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : date('Y-m-d H:i:s');
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : date('Y-m-d H:i:s');
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['id_usuario'];
    $imagen_proyecto = isset($_FILES['imagen_proyecto']) ? $_FILES['imagen_proyecto'] : null;

    // Crea la instancia del modelo y llama al método de inserción
    $modelo = new ProyectoModel($mysqli);
    $resultado = $modelo->insertarProyecto($nombre_proyecto, $descripcion, $fecha_inicio, $fecha_fin, $estado, $id_usuario, $imagen_proyecto);

    // Verifica si la inserción fue exitosa
    if ($resultado) {
        header("Location: create.php?da=2");
        exit();
    } else {
        echo "Error al insertar el proyecto.";
    }

    // Cierra la conexión a la base de datos
    $mysqli->close();
} else {
    // Si no es una solicitud POST, redirigir o mostrar un mensaje de error
    echo "Solicitud no válida.";
}
