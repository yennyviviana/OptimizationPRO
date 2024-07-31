<?php
// enviar_recuperacion.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['correo_electronico'];


    define('db_host', 'localhost');
    define('db_username', 'root');
    define('db_password', '');
    define('db_dbname', 'sofware_erp');

    // Conectar a MySQL y seleccionar la base de datos.
    $mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

    // Verificar que la conexión sea exitosa
    if (!$mysqli) {
        die('Error al conectarse a MySQL: ' . mysqli_connect_error());
    }

    // Establecer juego de caracteres UTF-8
    mysqli_set_charset($mysqli, 'utf8');

    // Verificar si el correo electrónico está registrado
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo_electronico = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();


    // Comprobación de errores en la ejecución de la consulta
    if (!$resultados) {
        die("Error al ejecutar la consulta: " . $mysqli->error);
    }


    if ($stmt->num_rows > 0) {
        // Generar token y guardar en la base de datos
        $token = bin2hex(random_bytes(32));
        $stmt = $conn->prepare("UPDATE usuarios SET token_recuperacion = ?, token_expiracion = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE correo_electronico = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Enviar correo electrónico
        $url = "http://tusitio.com/resetear_contrasena.php?token_recuperacion=$token_recuperacion";
        $asunto = "Recuperar Contraseña";
        $mensaje = "Para recuperar tu contraseña, por favor haz clic en el siguiente enlace: $url";
        $cabeceras = "From: no-reply@tusitio.com";

        mail($correo_electronico, $asunto, $mensaje, $cabeceras);

        echo "Se ha enviado un enlace de recuperación a tu correo electrónico.";
    } else {
        echo "No se encontró ningún usuario con ese correo electrónico.";
    }

    $stmt->close();
    $conn->close();
}
?>
