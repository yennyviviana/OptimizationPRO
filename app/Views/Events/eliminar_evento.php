<?php
include 'db_conexion.php';

$id = $_POST['id'];

$query = "DELETE FROM eventos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo eliminar el evento"]);
}

$stmt->close();
?>
