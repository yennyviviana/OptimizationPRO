<?php
include 'db_conexion.php';

$titulo = $_POST['titulo'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$query = "INSERT INTO eventos (titulo, fecha_inicio, fecha_fin) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $titulo, $fecha_inicio, $fecha_fin);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo guardar el evento"]);
}

$stmt->close();
?>
