<?php
// Definición de constantes para la conexión a la base de datos
define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];

   // Conectar a MySQL y seleccionar la base de datos
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);
   
  
// Verificar que la conexión sea exitosa
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}


    // Insertar el evento en la base de datos
    $sql = "INSERT INTO eventos (title, start, end) VALUES ('$title', '$start', '$end')";
    if ($mysqli->query($sql) === TRUE) {
        echo 'Evento creado exitosamente.';
    } else {
        echo 'Error: ' . $mysqli->error;
    }

    $mysqli->close();
}
?>


