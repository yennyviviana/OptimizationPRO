<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Obtener datos del usuario desde la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];
$correo_electronico = $_SESSION['correo_electronico'];
$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">
    <style>
        body {
            background: #fff; /* Color de fondo claro por defecto */
            color: #333; /* Color de texto oscuro por defecto */
        }
        .card {
            background: #fff; /* Fondo blanco para las tarjetas */
            border: 1px solid #ddd; /* Borde gris claro */
        }
        .btn-primary {
            background-color: #007bff; /* Color de fondo para el botón primario */
            color: #fff; /* Color de texto blanco para el botón primario */
        }
        .btn-warning {
            background-color: #ffc107; /* Color de fondo para el botón de advertencia */
            color: #000; /* Color de texto negro para el botón de advertencia */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Perfil de Usuario</h1>
        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Datos Personales</h5>
                        <form action="edit.php?da=1" method="POST">
                            <div class="mb-3">
                                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($nombre_usuario); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?php echo htmlspecialchars($correo_electronico); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Datos</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cambiar Contraseña</h5>
                        <form action="edit.php?da=2" method="POST">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <button type="submit" class="btn btn-warning">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
