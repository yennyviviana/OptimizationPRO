<?php

require_once("../../Config/database.php");


if (!isset($_GET['lla'])) {
    die('Parámetro inválido.');
}

$id_pedido = intval($_GET['lla']); 


$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8');


$stmt = $mysqli->prepare(
    "DELETE FROM pedidos WHERE id_pedido = ?"
);

$stmt->bind_param("i", $id_pedido);

if ($stmt->execute()) {
    echo "Pedido eliminado correctamente.";
} else {
    echo "Error al eliminar el pedido: " . $stmt->error;
}


$stmt->close();
$mysqli->close();
