<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$titulo = $data['titulo'];



// Aquí deberías eliminar el evento de tu base de datos
define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

//Conectar a MySQL y seleccionar la base de datos......
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$sql = "UPDATE eventos SET titulo = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $titulo, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
}

$stmt->close();
$mysqli->close();

