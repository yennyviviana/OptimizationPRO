<?php
require_once ("../../Config/database.php");

// Obteniendo los parámetros de la solicitud GET
$llave = $_GET['lla'];
$imagen = $_GET['imagen'];

define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

// Conectar a MySQL y seleccionar la base de datos.
$mysqli = new mysqli(db_host, db_username, db_password, db_dbname);

// Verificar que la conexión sea exitosa
if ($mysqli->connect_error) {
    die('Error al conectarse a MySQL: ' . $mysqli->connect_error);
}

// Establecer juego de caracteres UTF-8
$mysqli->set_charset('utf8');

// Preparar la consulta SQL para eliminar el registro de la base de datos
$borrarConsulta = "DELETE FROM  inventarios WHERE id_inventario = $llave";

// Ejecutar la consulta para eliminar el registro
if ($mysqli->query($borrarConsulta) === TRUE) {
    // Eliminar la imagen asociada al registro si la consulta de eliminación fue exitosa
    if (!empty($imagen)) {
        unlink("../../public/img/TipoDocument/" . $imagen);
    }
    // Imprimir un mensaje de confirmación
    echo "Inventario eliminado correctamente.";
} else {
    // Imprimir mensaje de error si la consulta de eliminación falla
    echo "Error al intentar eliminar el registro: " . $mysqli->error;
}

// Cerrar la conexión
$mysqli->close();
?>
