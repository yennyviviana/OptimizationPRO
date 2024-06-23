<?php
require_once ("../../Config/database.php");

// Obteniendo los parámetros de la solicitud GET
$llave = $_GET['lla'];
$imagen = $_GET['imagen'];



$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    die('Error en la conexion' . $mysqli->connect_error);
}


// Preparar la consulta SQL para eliminar el registro de la base de datos
$borrarConsulta = "DELETE FROM clientes WHERE id_cliente = $llave";

// Ejecutar la consulta para eliminar el registro
if ($mysqli->query($borrarConsulta) === TRUE) {
    // Imprimir un mensaje de confirmación
    echo "Cliente eliminado correctamente.";
} else {
    // Imprimir mensaje de error si la consulta de eliminación falla
    echo "Error al intentar eliminar el registro: " . $mysqli->error;
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>


