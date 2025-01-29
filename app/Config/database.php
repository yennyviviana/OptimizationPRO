<?php

// Definición de constantes para la conexión a la base de datos.....
define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

// Conectar a MySQL y seleccionar la base de datos.....
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

// Verificar que la conexión sea exitosa......
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}

// Establecer el juego de caracteres a UTF-8
mysqli_set_charset($mysqli, 'utf8');


/* Definición de constantes para la conexión a la base de datos
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DBNAME', 'sofware_erp');

try {
    // Crear una instancia de PDO para conectar con la base de datos
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DBNAME . ";charset=utf8", DB_USERNAME, DB_PASSWORD);

    // Establecer el modo de error de PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si llegamos aquí, la conexión fue exitosa
    echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    // En caso de error, mostramos el mensaje de la excepción
    die("Error al conectarse a la base de datos: " . $e->getMessage());
}*/

?>
