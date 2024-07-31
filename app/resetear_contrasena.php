<?php
// resetear_contrasena.php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    
//conectar Mysql y selecciona base de datos.
$mysqli = mysqli_connect(db_host,db_username,db_password,db_dbname);

    // Verificar el token
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE token_recuperacion = ? AND token_expiracion > NOW()");
    $stmt->bind_param("s", $token_recuperacion);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Mostrar formulario para cambiar la contraseña
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva_contrasena = $_POST['nueva_contrasena'];
            $id_usuario = $stmt->fetch_assoc()['id'];

            // Actualizar contraseña en la base de datos
            $stmt = $conn->prepare("UPDATE usuarios SET password = ?, token_recuperacion = NULL, token_expiracion = NULL WHERE id_usuario = ?");
            $stmt->bind_param("si", password_hash($nueva_contrasena, PASSWORD_DEFAULT), $id_usuario);
            $stmt->execute();

            echo "La contraseña ha sido actualizada exitosamente.";
        } else {
            echo '
                <form action="" method="post">
                    <label for="nueva_contrasena">Nueva Contraseña:</label>
                    <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
                    <input type="submit" value="Actualizar Contraseña">
                </form>
            ';
        }
    } else {
        echo "El enlace de recuperación es inválido o ha expirado.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Token no proporcionado.";
}
?>
