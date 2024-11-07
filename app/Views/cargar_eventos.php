<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}



// Aquí deberías eliminar el evento de tu base de datos
define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

//Conectar a MySQL y seleccionar la base de datos......
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);


if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}


$sql = "SELECT id, titulo, fecha FROM eventos";
$result = $mysqli->query($sql);

$eventos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventos[] = [
            'id' => $row['id'],
            'title' => $row['titulo'],
            'start' => $row['fecha'],
        ];
    }
}

$mysqli->close();
echo json_encode($eventos);
