<?php
include 'db_conexion.php'; // Archivo para conectar a la base de datos

$query = "SELECT * FROM eventos";
$result = $conn->query($query);

$eventos = [];
while($row = $result->fetch_assoc()) {
    $eventos[] = [
        'id' => $row['id'],
        'title' => $row['titulo'],
        'start' => $row['fecha_inicio'],
        'end' => $row['fecha_fin']
    ];
}

echo json_encode($eventos);
?>
