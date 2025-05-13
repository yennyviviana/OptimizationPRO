<?php

require_once __DIR__ . '/../../Models/EmpleadoModel.php';
require_once __DIR__ . '/../../Config/database.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $tipo_contrato = $_POST['tipo_contrato'] ?? '';
    $fecha_contratacion = date('Y-m-d H:i:s');
    $horas_trabajo = $_POST['horas_trabajo'] ?? 0;
    $salario = $_POST['salario'] ?? 0;
    $estado = $_POST['estado'] ?? '';
    $departamento = $_POST['departamento'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $documento_identidad = $_POST['documento_identidad'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? date('Y-m-d');
    $genero = $_POST['genero'] ?? '';
    $estado_civil = $_POST['estado_civil'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_creacion = date('Y-m-d H:i:s');
    $fecha_modificacion = date('Y-m-d H:i:s');

    // Procesar archivos
    $imagen = $_FILES['imagen'] ?? null;
    $documentacion = $_FILES['documentacion'] ?? null;

    $nombreArchivoImagen = procesarArchivo($imagen, 'imagen');
    $nombreArchivoDocumento = procesarArchivo($documentacion, 'documentacion');

    if ($nombreArchivoImagen === false || $nombreArchivoDocumento === false) {
        exit("Error al subir los archivos.");
    }

    // Preparar consulta
    $stmt = $mysqli->prepare("INSERT INTO empleados (
        nombre, cargo, tipo_contrato, fecha_contratacion, horas_trabajo, salario,
        estado, departamento, tipo_documento, documento_identidad, direccion, ciudad, pais,
        telefono, correo, fecha_nacimiento, genero, estado_civil,
        imagen, documentacion, descripcion, fecha_creacion, fecha_modificacion
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        eliminarArchivos($nombreArchivoImagen, $nombreArchivoDocumento);
        die("Error en la consulta: " . $mysqli->error);
    }

    $stmt->bind_param("ssssddsssssssssssssssss",
        $nombre, $cargo, $tipo_contrato, $fecha_contratacion, $horas_trabajo, $salario,
        $estado, $departamento, $tipo_documento, $documento_identidad, $direccion, $ciudad, $pais,
        $telefono, $correo, $fecha_nacimiento, $genero, $estado_civil,
        $nombreArchivoImagen, $nombreArchivoDocumento, $descripcion, $fecha_creacion, $fecha_modificacion
    );

    if ($stmt->execute()) {
        echo "Empleado registrado correctamente.";
    } else {
        eliminarArchivos($nombreArchivoImagen, $nombreArchivoDocumento);
        echo "Error al registrar empleado: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}

function procesarArchivo($archivo, $tipo) {
    if ($archivo === null || !isset($archivo['error']) || !isset($archivo['name']) || !isset($archivo['tmp_name'])) {
        return false;
    }

    $directorioBase = __DIR__ . '/../public/img/uploads/empleados/';
    if (!is_dir($directorioBase)) {
        mkdir($directorioBase, 0777, true);
    }

    if ($archivo['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('empleado_') . '_' . $tipo . '.' . $extension;
        $rutaArchivo = $directorioBase . $nombreArchivo;
        if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
            return $nombreArchivo;
        }
    }

    return false;
}

function eliminarArchivos($imagen, $documento) {
    $ruta = __DIR__ . '/../public/img/uploads/empleados/';
    if ($imagen && file_exists($ruta . $imagen)) unlink($ruta . $imagen);
    if ($documento && file_exists($ruta . $documento)) unlink($ruta . $documento);
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizar Empleado</title>
  <!-- Bootstrap 5 y Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
  <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-user-edit"></i> Actualizar Empleado</h4>
    </div>
    <div class="card-body">
      <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-3">
          <!-- Columna izquierda -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="nombre_completo" class="form-label">Empleado:</label>
              <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo htmlspecialchars($empleado['nombre_completo'] ?? ''); ?>" class="form-control" required placeholder="Ingresar empleado">
              <div class="invalid-feedback">Por favor ingrese el nombre del empleado.</div>
            </div>
            <div class="mb-3">
              <label for="cargo" class="form-label">Cargo</label>
              <input type="text" id="cargo" name="cargo" value="<?php echo htmlspecialchars($empleado['cargo'] ?? ''); ?>" class="form-control" required placeholder="Ingresar cargo">
              <div class="invalid-feedback">Por favor ingrese el cargo del empleado.</div>
            </div>
            <div class="mb-3">
              <label for="numero_horas" class="form-label">Número de Horas</label>
              <input type="number" id="numero_horas" name="numero_horas" value="<?php echo htmlspecialchars($empleado['numero_horas'] ?? ''); ?>" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese las horas trabajadas.</div>
            </div>
            <div class="mb-3">
              <label for="precio_hora" class="form-label">Precio Hora</label>
              <input type="number" id="precio_hora" name="precio_hora" value="<?php echo htmlspecialchars($empleado['precio_hora'] ?? ''); ?>" class="form-control" required placeholder="Precio por hora">
              <div class="invalid-feedback">Por favor ingrese el precio por hora.</div>
            </div>
            <div class="mb-3">
              <label for="salario" class="form-label">Salario</label>
              <input type="number" id="salario" name="salario" value="<?php echo htmlspecialchars($empleado['salario'] ?? ''); ?>" class="form-control" required placeholder="Salario del empleado">
              <div class="invalid-feedback">Por favor ingrese el salario del empleado.</div>
            </div>
            <div class="mb-3">
              <label for="estado" class="form-label"><i class="fas fa-users"></i> Estado:</label>
              <select id="estado" name="estado" required class="form-select">
                <option value="activo" <?php echo ($empleado['estado'] === 'activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="inactivo" <?php echo ($empleado['estado'] === 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
              </select>
              <div class="invalid-feedback">Por favor seleccione el estado.</div>
            </div>
            <div class="mb-3">
              <label for="departamento" class="form-label">Departamento</label>
              <input type="text" id="departamento" name="departamento" value="<?php echo htmlspecialchars($empleado['departamento'] ?? ''); ?>" class="form-control" required placeholder="Ingresar departamento">
              <div class="invalid-feedback">Por favor ingrese el departamento.</div>
            </div>
          </div>
          <!-- Columna derecha -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="documento_identidad" class="form-label">Documento de Identidad</label>
              <input type="text" id="documento_identidad" name="documento_identidad" value="<?php echo htmlspecialchars($empleado['documento_identidad'] ?? ''); ?>" class="form-control" required placeholder="Ingresar documento de identidad">
              <div class="invalid-feedback">Por favor ingrese el documento de identidad.</div>
            </div>
            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($empleado['direccion'] ?? ''); ?>" class="form-control" required placeholder="Ingresar dirección">
              <div class="invalid-feedback">Por favor ingrese la dirección.</div>
            </div>
            <div class="mb-3">
              <label for="ciudad" class="form-label">Ciudad</label>
              <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($empleado['ciudad'] ?? ''); ?>" class="form-control" required placeholder="Ingresar ciudad">
              <div class="invalid-feedback">Por favor ingrese la ciudad.</div>
            </div>
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($empleado['telefono'] ?? ''); ?>" class="form-control" required placeholder="Ingresar teléfono">
              <div class="invalid-feedback">Por favor ingrese el teléfono.</div>
            </div>
            <div class="mb-3">
              <label for="pais" class="form-label">País</label>
              <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($empleado['pais'] ?? ''); ?>" class="form-control" required placeholder="Ingresar país">
              <div class="invalid-feedback">Por favor ingrese el país.</div>
            </div>
            <div class="mb-3">
              <label for="descripcion_profesional" class="form-label">Descripción Profesional</label>
              <textarea id="descripcion_profesional" name="descripcion_profesional" class="form-control" required placeholder="Ingresar descripción profesional"><?php echo htmlspecialchars($empleado['descripcion_profesional'] ?? ''); ?></textarea>
              <div class="invalid-feedback">Por favor ingrese la descripción profesional.</div>
            </div>
          </div>
        </div>
        <div class="text-end mt-4">
          <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save"></i> Actualizar Empleado
          </button>
          <a href="empleados.php" class="btn btn-danger ms-2">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Habilitar validación de formularios de Bootstrap
  (function () {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(function (form) {
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
<!-- Inicializamos CKEditor para el textarea de descripción profesional -->
<script>
  CKEDITOR.replace('descripcion_profesional');
</script>
</body>
</html>
