<?php
require_once __DIR__ . '/../../Models/ClienteModel.php';
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
    die('Error en la conexion' . $mysqli->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos del formulario y valida su existencia
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $documento_identidad = $_POST['documento_identidad'];
    $tipo_documento = $_POST['tipo_documento'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $estado = $_POST['estado'];
    $codigo_postal = $_POST['codigo_postal'];
    $pais = $_POST['pais'];
    $notas = $_POST['notas'];
    $fecha_creacion = date('Y-m-d H:i:s');
    $fecha_modificacion = $_POST['fecha_modificacion'];


    // Escapar los valores para prevenir inyecciones SQL
    $nombre = $mysqli->real_escape_string($nombre);
    $apellido = $mysqli->real_escape_string($apellido);
    $email = $mysqli->real_escape_string($email);
    $documento_identidad = $mysqli->real_escape_string($documento_identidad);
    $tipo_documento = $mysqli->real_escape_string($tipo_documento);
    $telefono = $mysqli->real_escape_string($telefono);
    $direccion = $mysqli->real_escape_string($direccion);
    $ciudad = $mysqli->real_escape_string($ciudad);
    $estado = $mysqli->real_escape_string($estado);
    $codigo_postal = $mysqli->real_escape_string($codigo_postal);
    $pais = $mysqli->real_escape_string($pais);
    $notas = $mysqli->real_escape_string($notas);
    $fecha_creacion = $mysqli->real_escape_string($fecha_creacion);
    $fecha_modificacion = $mysqli->real_escape_string($fecha_modificacion);

    // Crear una instancia del modelo de proveedor
    $clienteModel = new ClienteModel($mysqli);

    try {
        // Actualizar el cliente en la base de datos
        $consulta = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', 
        email='$email', documento_identidad ='$documento_identidad', tipo_documento = '$tipo_documento',
         telefono='$telefono', direccion='$direccion', ciudad='$ciudad', estado='$estado', codigo_postal=
         '$codigo_postal', pais='$pais', notas= '$notas', fecha_creacion='$fecha_creacion', 
         fecha_modificacion='$fecha_modificacion' WHERE id_cliente='$llave'";
        
        $resultado = $mysqli->query($consulta);
        
        if ($resultado) {
            echo "Cliente actualizado correctamente.";
        } else {
            echo "Error al actualizar el cliente.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Obtener los datos del cliente para mostrar en el formulario
    $query = "SELECT * FROM clientes WHERE id_cliente = ?";
    $stmt = $mysqli->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $llave);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
        // Recuperar los datos del cliente como un array asociativo
            $cliente = $result->fetch_assoc();
            $stmt->close();
        } else {
            exit("Error al ejecutar la consulta.");
        }
    } else {
        exit("Error al preparar la consulta.");
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pedidos</title>
    <!-- Estilos de Bootstrap y Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        /* Ajuste de estilos para el editor CKEditor */
        .ck-editor__editable {
            min-height: 150px;
        }
    </style>
</head>
<body>


<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-user-edit"></i> Editar Cliente</h4>
    </div>
    <div class="card-body">
      <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-3">
          <!-- Columna izquierda -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($cliente['cliente'] ?? ''); ?>" required placeholder="Ingresar nombre">
                <div class="invalid-feedback">Por favor ingrese su nombre.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="apellido">Apellido</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo htmlspecialchars($cliente['apellido'] ?? ''); ?>" required placeholder="Ingresar apellido">
                <div class="invalid-feedback">Por favor ingrese su apellido.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>" required placeholder="Ingresar correo electrónico">
                <div class="invalid-feedback">Por favor ingrese su correo electrónico.</div>
              </div>
            </div>


            <div class="form-group">
              <label for="documento_identidad">documento_identidad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="number" id="documento_identidad" name="documento_identidad" class="form-control" value="<?php echo htmlspecialchars($cliente['documento_identidad'] ?? ''); ?>"  required placeholder="Ingresar número de teléfono">
                <div class="invalid-feedback">Por favor ingrese  el documento de identidad.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="tipo_documento">tipo documento</label>
                <select id="tipo_documento" name="tipo_documento" class="form-select" required>
                  <option value="">Seleccione una opción</option>
                  <option value="Cedula" <?php if (isset($cliente['tipo_documento']) && $cliente['tipo_documento'] == 'Cedula') echo 'selected'; ?>>Cedula</option>
                  <option value="Tarjeta_identidad" <?php if (isset($cliente['tipo_documento']) && $cliente['Tarjeta_identidad'] == 'Tarjeta_identidad') echo 'selected'; ?>>Tarjeta de identidad</option>
                  <option value="Passaporte"  <?php if (isset($cliente['tipo_documento']) && $cliente['tipo_documento'] == 'Passaporte') echo 'selected'; ?>>Passaporte</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione su  tipo de documento.</div>
              </div>
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?>" required placeholder="Ingresar número de teléfono">
                <div class="invalid-feedback">Por favor ingrese su número de teléfono.</div>
              </div>
            </div>
          </div>

          <!-- Columna derecha -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="direccion">Dirección</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo htmlspecialchars($cliente['direccion'] ?? ''); ?>" required placeholder="Ingresar dirección">
                <div class="invalid-feedback">Por favor ingrese su dirección.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="ciudad">Ciudad</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-city"></i></span>
                <input type="text" id="ciudad" name="ciudad" class="form-control" value="<?php echo htmlspecialchars($cliente['ciudad'] ?? ''); ?>" required placeholder="Ingresar ciudad">
                <div class="invalid-feedback">Por favor ingrese su ciudad.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="estado">Estado</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-map"></i></span>
                <select id="estado" name="estado" class="form-select" required>
                  <option value="aprobado" <?php if (isset($cliente['estado']) && $cliente['estado'] == 'aprobado') echo 'selected'; ?>>Aprobado</option>
                  <option value="cancelado" <?php if (isset($cliente['estado']) && $cliente['estado'] == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                  <option value="en stock" <?php if (isset($cliente['estado']) && $cliente['estado'] == 'en stock') echo 'selected'; ?>>En stock</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione el estado.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="codigo_postal">Código Postal</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" value="<?php echo htmlspecialchars($cliente['codigo_postal'] ?? ''); ?>" required placeholder="Ingresar código postal">
                <div class="invalid-feedback">Por favor ingrese su código postal.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="pais">País</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-flag"></i></span>
                <select id="pais" name="pais" class="form-select" required>
                  <option value="colombia" <?php if (isset($cliente['pais']) && $cliente['pais'] == 'colombia') echo 'selected'; ?>>Colombia</option>
                  <option value="ecuador" <?php if (isset($cliente['pais']) && $cliente['pais'] == 'ecuador') echo 'selected'; ?>>Ecuador</option>
                  <option value="brazil" <?php if (isset($cliente['pais']) && $cliente['pais'] == 'brazil') echo 'selected'; ?>>Brazil</option>
                  <option value="estados unidos" <?php if (isset($cliente['pais']) && $cliente['pais'] == 'estados unidos') echo 'selected'; ?>>Estados Unidos</option>
                  <option value="españa" <?php if (isset($cliente['pais']) && $cliente['pais'] == 'españa') echo 'selected'; ?>>España</option>
                </select>
                <div class="invalid-feedback">Por favor seleccione su país.</div>
              </div>
            </div>


            <div class="form-group">
                            <label for="notas">Notas</label>
                            <textarea id="notas" name="notas"  value="<?php echo htmlspecialchars($cliente['notas']); ?>" class="form-control" rows="3" required placeholder="notas"></textarea>
                            <div class="invalid-feedback">Ingrese la  nota.</div>
                        </div>
                    </div>

            <div class="form-group">
              <label for="fecha_creacion">Fecha de Creación</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" id="fecha_creacion" name="fecha_creacion" class="form-control" value="<?php echo htmlspecialchars($cliente['fecha_creacion'] ?? ''); ?>" required>
                <div class="invalid-feedback">Por favor ingrese la fecha de creación.</div>
              </div>
            </div>

            <div class="form-group">
              <label for="fecha_modificacion">Fecha de Modificación</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" id="fecha_modificacion" name="fecha_modificacion" class="form-control" value="<?php echo htmlspecialchars($cliente['fecha_modificacion'] ?? ''); ?>">
                <div class="invalid-feedback">Por favor ingrese la fecha de modificación.</div>
              </div>
            </div>
          </div>
        </div>

        <div class="text-end mt-4">
          <button type="submit" name="boton" class="btn btn-success px-4">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
