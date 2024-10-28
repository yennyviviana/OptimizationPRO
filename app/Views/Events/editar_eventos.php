<?php
include 'db_conexion.php';

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$query = "UPDATE eventos SET titulo = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $titulo, $fecha_inicio, $fecha_fin, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo actualizar el evento"]);
}

$stmt->close();
?>
