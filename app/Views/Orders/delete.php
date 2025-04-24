<?php
require_once ("../../Config/database.php");

// Validar parámetros
if (!isset($_GET['lla']) || !isset($_GET['imagen'])) {
    die('Parámetros inválidos.');
}

$llave = intval($_GET['lla']); // Asegura que sea número
$imagen = basename($_GET['imagen']); // Evita path traversal

define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

$mysqli = new mysqli(db_host, db_username, db_password, db_dbname);

if ($mysqli->connect_error) {
    die('Error al conectarse a MySQL: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8');

// Usar consulta preparada (más seguro)
$stmt = $mysqli->prepare("DELETE FROM pedidos WHERE id_pedido = ?");
$stmt->bind_param("i", $llave);

if ($stmt->execute()) {
    $rutaArchivo = "../../public/img/uploads/pedidos/" . $imagen;

    // Verifica si el archivo existe antes de intentar eliminarlo
    if (!empty($imagen) && file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
    }

    echo "Pedido y archivo eliminados correctamente.";
} else {
    echo "Error al eliminar el pedido: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
