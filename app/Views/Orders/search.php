<?php


// Definición de constantes para la conexión a la base de datos
define('db_host', 'localhost');
define('db_username', 'root');
define('db_password', '');
define('db_dbname', 'sofware_erp');

// Conectar a MySQL y seleccionar la base de datos
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

// Verificar que la conexión sea exitosa
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}




if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $query = "%" . $query . "%";  // Para hacer la búsqueda flexible

    // Consulta SQL para buscar productos
    $sql = "SELECT * FROM productos WHERE nombre_pedido LIKE ? OR  descripcion LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . $row['nombre_pedido'] . " - $" . $row['precio'] . "</p>";
        }
    } else {
        echo "No se encontraron resultados.";
    }

    $stmt->close();
}

$mysqli->close();
?>
