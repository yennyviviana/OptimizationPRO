<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$titulo = $data['titulo'];
$fecha = $data['fecha'];

// Aquí deberías guardar el evento en tu base de datos
// Definición de constantes para la conexión a la base de datos
define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

//Conectar a MySQL y seleccionar la base de datos......
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "INSERT INTO eventos (titulo, fecha) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $titulo, $fecha);

if ($stmt->execute()) {
    $last_id = $stmt->insert_id;
    echo json_encode(['id' => $last_id, 'titulo' => $titulo, 'fecha' => $fecha]);
} else {
    http_response_code(500);
}


$stmt->close();
$mysqli->close();

