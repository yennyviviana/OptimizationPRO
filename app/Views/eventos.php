<?php
header('Content-Type: application/json');
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DBNAME', 'sofware_erp');

$mysqli = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DBNAME);
if (!$mysqli) {
    die(json_encode(['success' => false, 'message' => 'Error al conectarse a MySQL: ' . mysqli_connect_error()]));
}
mysqli_set_charset($mysqli, 'utf8');

// Cargar eventos (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $mysqli->query("SELECT id, title, start, end FROM eventos");
    $events = [];

    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start'],
            'end' => $row['end']
        ];
    }

    echo json_encode($events);
    $mysqli->close();
    exit;
}

// Procesar acciones (POST)
$action = $_POST['action'] ?? null;

if ($action === 'create') {
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
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
}

$mysqli->close();
