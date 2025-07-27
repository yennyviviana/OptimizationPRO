<?php
header('Content-Type: application/json');

define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp'); 


try {
    // Consulta para obtener los eventos.....
    $query = "SELECT title, start, end FROM eventos";
    $result = $conn->query($query);

    $events = array();

    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => $row['title'],
            'start' => $row['start'],
            'end' => $row['end']
        ];
    }

    echo json_encode($events); // Retorna los eventos en formato JSON
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
