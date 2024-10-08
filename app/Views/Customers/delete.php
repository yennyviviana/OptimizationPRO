<?php
require_once("../../Config/database.php");

// Obteniendo los parámetros de la solicitud GET
$llave = $_GET['lla'];
$imagen = $_GET['imagen'];

// Conectar a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    die('Error en la conexión: ' . $mysqli->connect_error);
}

// Verificar que $llave sea un número entero
if (!is_numeric($llave)) {
    die("El ID del cliente no es válido.");
}

// Preparar la consulta SQL para eliminar el registro de la base de datos
$borrarConsulta = $mysqli->prepare("DELETE FROM clientes WHERE id_cliente = ?");
$borrarConsulta->bind_param("i", $llave);

// Ejecutar la consulta para eliminar el registro
if ($borrarConsulta->execute()) {
    // Imprimir un mensaje de confirmación
    echo "Cliente eliminado correctamente.";
} else {
    // Imprimir mensaje de error si la consulta de eliminación falla
    echo "Error al intentar eliminar el registro: " . $borrarConsulta->error;
}

// Cerrar la conexión a la base de datos
$borrarConsulta->close();
$mysqli->close();
?>
