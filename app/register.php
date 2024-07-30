<?php

date_default_timezone_set("America/Bogota");
require_once('Config/database.php');

if (isset($_REQUEST['nombre_usuario'])) {
    $nombre_usuario = stripslashes($_POST['nombre_usuario']);
    $apellido_usuario = stripslashes($_POST['apellido_usuario']);
    $correo_electronico = stripslashes($_POST['correo_electronico']);
    $contrasena = stripslashes($_POST['contrasena']);
    $tipo_usuario = 9;

    $nombre_usuario = mysqli_real_escape_string($mysqli, $nombre_usuario);
    $apellido_usuario = mysqli_real_escape_string($mysqli, $apellido_usuario);
    $correo_electronico = mysqli_real_escape_string($mysqli, $correo_electronico);
    $contrasena = mysqli_real_escape_string($mysqli, $contrasena);

    $check_query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
    $check_result = mysqli_query($mysqli, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "El usuario ya está registrado. Por favor, elija otro nombre de usuario.";
        $alert_type = "danger";
    } else {
        $query = "INSERT INTO `usuarios` (nombre_usuario, apellido_usuario, correo_electronico, contrasena, tipo_usuario) VALUES ('$nombre_usuario', '$apellido_usuario', '$correo_electronico', '" . sha1($contrasena) . "', '$tipo_usuario')";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $message = "¡Registro exitoso! Ahora serás redirigido a la página de inicio de sesión.";
            $alert_type = "success";
        } else {
            $message = "Error al registrar el usuario. Inténtalo de nuevo.";
            $alert_type = "danger";
        }
    }
} else {
    $message = '';
    $alert_type = '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="fontawesome/css/all.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fed2435e21.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="public/css/style.css" type="text/css" rel="stylesheet">
    <style>
           .responsive {
            max-width: 100%;
            height: auto;
           }
    </style>
</head>
<body>

<div class="form-container">
    <form action="" method="POST">
        <h1><i class="fas fa-users"></i> NUEVO USUARIO</h1>
        <p><b><font size="3" color="#c68615">*Datos obligatorios</font></b></p>
        
        <div class="form-group">
            <label for="nombre_usuario">* Nombre:</label>
            <input type="text" name="nombre_usuario" class="form-control" id="nombre_usuario" required>
        </div>
        <div class="form-group">
            <label for="apellido_usuario">* Apellido:</label>
            <input type="text" name="apellido_usuario" class="form-control" id="apellido_usuario" required>
        </div>
        <div class="form-group">
            <label for="correo_electronico">* Correo Electrónico:</label>
            <input type="email" name="correo_electronico" class="form-control" id="correo_electronico" required>
        </div>
        <div class="form-group">
            <label for="contrasena">* Contraseña:</label>
            <input type="password" name="contrasena" class="form-control" id="contrasena" required>
        </div>
        <div class="form-group">
            <label for="tipo_usuario">* Tipo de Usuario:</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                <option value="9">Administrador</option>
                <option value="2">Cliente</option>
                <option value="3">Usuario</option>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">
            <span class="spinner-border spinner-border-sm"></span>
            REGISTRAR USUARIO
        </button>
        <button type="button" class="btn btn-dark" onclick="window.location.href='index.php';">
            <img src="public/img/atras.png" width="27" height="27" alt="Regresar"> REGRESAR
        </button>
    </form>
</div>

<?php if ($message): ?>
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-<?php echo $alert_type; ?> text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel"><?php echo $alert_type == 'success' ? 'Éxito' : 'Error'; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('resultModal'));
            myModal.show();
            <?php if ($alert_type == 'success'): ?>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 2000); // Redirige después de 2 segundos
            <?php endif; ?>
        });
    </script>
<?php endif; ?>

</body>
</html>
