<?php
// Conexión a la base de datos.......
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DBNAME', 'sofware_erp');

$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DBNAME);
if (!$mysqli) {
    die(json_encode(['success' => false, 'message' => 'Error al conectarse a MySQL: ' . mysqli_connect_error()]));
}
mysqli_set_charset($mysqli, 'utf8');

// Verifica si hay datos POST y la acción que se quiere realizar
$action = $_POST['action'] ?? null;

if ($action === 'create') {
    // Crear un nuevo evento
    $title = $_POST['title'] ?? '';
    $start = $_POST['start'] ?? '';
    $end = $_POST['end'] ?? '';

    $stmt = $mysqli->prepare("INSERT INTO eventos (title, start, end) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $start, $end);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'eventId' => $mysqli->insert_id]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} elseif ($action === 'edit') {
    // Editar un evento existente
    $id = $_POST['id'] ?? 0;
    $title = $_POST['title'] ?? '';
    $start = $_POST['start'] ?? '';
    $end = $_POST['end'] ?? '';

    $stmt = $mysqli->prepare("UPDATE eventos SET title = ?, start = ?, end = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $start, $end, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} elseif ($action === 'delete') {
    // Eliminar un evento
    $id = $_POST['id'] ?? 0;

    $stmt = $mysqli->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} else {
    // Acción no válida
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
}

$mysqli->close();
