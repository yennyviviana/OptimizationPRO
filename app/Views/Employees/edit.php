<?php

require_once __DIR__ . '/../../Models/EmpleadoModel.php';
require_once __DIR__ . '/../../Config/database.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Validar y obtener el valor de 'lla' de $_GET
$llave = isset($_GET['lla']) ? intval($_GET['lla']) : 0;
if ($llave <= 0) {
    exit("Error: 'lla' debe ser un valor numérico válido.");
}

$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    die('Error en la conexión: ' . $mysqli->connect_error);
}

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos del formulario
    $nombre_completo = $_POST['nombre_completo'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $fecha_contratacion = date('Y-m-d H:i:s');
    $numero_horas = $_POST['numero_horas'] ?? 0;
    $precio_hora = $_POST['precio_hora'] ?? 0;
    $salario = $_POST['salario'] ?? 0;
    $estado = $_POST['estado'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $documento_identidad = $_POST['documento_identidad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $fecha_creacion = date('Y-m-d H:i:s');
    $descripcion_profesional = $_POST['descripcion_profesional'] ?? '';

    // Escapar las variables para prevenir inyección SQL
    $nombre_completo = mysqli_real_escape_string($mysqli, $nombre_completo);
    $cargo = mysqli_real_escape_string($mysqli, $cargo);
    $numero_horas = mysqli_real_escape_string($mysqli, $numero_horas);
    $precio_hora = mysqli_real_escape_string($mysqli, $precio_hora);
    $salario = mysqli_real_escape_string($mysqli, $salario);
    $estado = mysqli_real_escape_string($mysqli, $estado);
    $departamento = mysqli_real_escape_string($mysqli, $departamento);
    $documento_identidad = mysqli_real_escape_string($mysqli, $documento_identidad);
    $direccion = mysqli_real_escape_string($mysqli, $direccion);
    $ciudad = mysqli_real_escape_string($mysqli, $ciudad);
    $telefono = mysqli_real_escape_string($mysqli, $telefono);
    $pais = mysqli_real_escape_string($mysqli, $pais);
    $fecha_creacion = mysqli_real_escape_string($mysqli, $fecha_creacion);
    $descripcion_profesional = mysqli_real_escape_string($mysqli, $descripcion_profesional);

    // Crear una instancia del modelo de empleado
    $empleadoModel = new EmpleadoModel($mysqli);

    try {
        // Actualizar el empleado en la base de datos
        $consulta = "UPDATE empleados SET 
            nombre_completo='$nombre_completo',
            cargo='$cargo',
            fecha_contratacion='$fecha_contratacion',
            numero_horas='$numero_horas',
            precio_hora='$precio_hora',
            salario='$salario',
            estado='$estado',
            departamento='$departamento',
            documento_identidad='$documento_identidad',
            direccion='$direccion',
            ciudad='$ciudad',
            telefono='$telefono',
            pais='$pais',
            fecha_creacion='$fecha_creacion',
            descripcion_profesional='$descripcion_profesional' 
            WHERE id_empleado='$llave'";
        
        $resultado = $mysqli->query($consulta);
        
        if ($resultado) {
            echo "Empleado actualizado correctamente.";
        } else {
            echo "Error al actualizar el empleado: " . $mysqli->error;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Obtener los datos del empleado para mostrar en el formulario
    $query = "SELECT * FROM empleados WHERE id_empleado = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Vincular el parámetro de 'id_empleado' a la consulta preparada
        $stmt->bind_param("i", $llave);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result) {
            // Recuperar los datos del empleado como un array asociativo
            $empleado = $result->fetch_assoc();

            // Cerrar la consulta preparada
            $stmt->close();
        } else {
            // Manejar el caso en que no se pudo obtener el resultado de la consulta
            exit("Error al ejecutar la consulta.");
        }
    } else {
        // Manejar el caso en que la consulta preparada no se pudo preparar
        exit("Error al preparar la consulta.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD empleados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <style>
        #form-background {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .ck-editor__editable {
            min-height: 150px;
        }

        #camera-container {
            display: none;
            text-align: center;
        }

        #camera-preview, #captured-image {
            max-width: 100%;
            height: auto;
            display: none;
            margin-top: 10px;
        }

        #delete-photo {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div id="form-background">
        <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <h1>Actualizar Empleado</h1>

            <div class="form-group">
                <label for="nombre_completo">Empleado:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($empleado['nombre_completo'] ?? ''); ?>" class="form-control" required placeholder="Ingresar empleado">
                <div class="invalid-feedback">Por favor ingrese el nombre del empleado.</div>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" id="cargo" name="cargo" value="<?php echo htmlspecialchars($empleado['cargo'] ?? ''); ?>" class="form-control" required placeholder="Ingresar cargo">
                <div class="invalid-feedback">Por favor ingrese el cargo del empleado.</div>
            </div>

            <div class="form-group">
                <label for="numero_horas">Número de Horas (Días y Horas)</label>
                <input type="number" id="numero_horas" name="numero_horas" value="<?php echo htmlspecialchars($empleado['numero_horas'] ?? ''); ?>" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese las horas trabajadas.</div>
            </div>

            <div class="form-group">
                <label for="precio_hora">Precio Hora</label>
                <input type="number" id="precio_hora" name="precio_hora" value="<?php echo htmlspecialchars($empleado['precio_hora'] ?? ''); ?>" class="form-control" required placeholder="Precio por hora">
                <div class="invalid-feedback">Por favor ingrese el precio por hora.</div>
            </div>

            <div class="form-group">
                <label for="salario">Salario</label>
                <input type="number" id="salario" name="salario" value="<?php echo htmlspecialchars($empleado['salario'] ?? ''); ?>" class="form-control" required placeholder="Salario del empleado">
                <div class="invalid-feedback">Por favor ingrese el salario del empleado.</div>
            </div>

            <label for="estado"><i class="fas fa-users"></i> Estado:</label>
            <select id="estado" name="estado" required class="form-control">
                <option value="activo" <?php echo ($empleado['estado'] === 'activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="inactivo" <?php echo ($empleado['estado'] === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
            </select>
            <div class="invalid-feedback">Por favor seleccione el estado.</div>

            <div class="form-group">
                <label for="departamento">Departamento</label>
                <input type="text" id="departamento" name="departamento" value="<?php echo htmlspecialchars($empleado['departamento'] ?? ''); ?>" class="form-control" required placeholder="Ingresar departamento">
                <div class="invalid-feedback">Por favor ingrese el departamento.</div>
            </div>

            <div class="form-group">
                <label for="documento_identidad">Documento de Identidad</label>
                <input type="text" id="documento_identidad" name="documento_identidad" value="<?php echo htmlspecialchars($empleado['documento_identidad'] ?? ''); ?>" class="form-control" required placeholder="Ingresar documento de identidad">
                <div class="invalid-feedback">Por favor ingrese el documento de identidad.</div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($empleado['direccion'] ?? ''); ?>" class="form-control" required placeholder="Ingresar dirección">
                <div class="invalid-feedback">Por favor ingrese la dirección.</div>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($empleado['ciudad'] ?? ''); ?>" class="form-control" required placeholder="Ingresar ciudad">
                <div class="invalid-feedback">Por favor ingrese la ciudad.</div>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($empleado['telefono'] ?? ''); ?>" class="form-control" required placeholder="Ingresar teléfono">
                <div class="invalid-feedback">Por favor ingrese el teléfono.</div>
            </div>

            <div class="form-group">
                <label for="pais">País</label>
                <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($empleado['pais'] ?? ''); ?>" class="form-control" required placeholder="Ingresar país">
                <div class="invalid-feedback">Por favor ingrese el país.</div>
            </div>

            <div class="form-group">
                <label for="descripcion_profesional">Descripción Profesional</label>
                <textarea id="descripcion_profesional" name="descripcion_profesional" class="form-control" required><?php echo htmlspecialchars($empleado['descripcion_profesional'] ?? ''); ?></textarea>
                <div class="invalid-feedback">Por favor ingrese la descripción profesional.</div>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
            <a href="empleados.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</div>

<script>
    // Habilitar validación de formularios de Bootstrap
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

</body>
</html>
