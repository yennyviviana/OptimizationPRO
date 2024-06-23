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

// Check if form is submitted (POST method)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos del formulario y valida su existencia
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $codigo_postal = $_POST['codigo_postal'] ?? '';
    $pais = $_POST['pais'] ?? '';
    $fecha_creacion = date('Y-m-d H:i:s');
    $fecha_modificacion = $_POST['fecha_modificacion'];

    // Escapar los valores para prevenir inyecciones SQL
    $nombre = $mysqli->real_escape_string($nombre);
    $apellido = $mysqli->real_escape_string($apellido);
    $email = $mysqli->real_escape_string($email);
    $telefono = $mysqli->real_escape_string($telefono);
    $direccion = $mysqli->real_escape_string($direccion);
    $ciudad = $mysqli->real_escape_string($ciudad);
    $estado = $mysqli->real_escape_string($estado);
    $codigo_postal = $mysqli->real_escape_string($codigo_postal);
    $pais = $mysqli->real_escape_string($pais);
    $fecha_creacion = $mysqli->real_escape_string($fecha_creacion);
    $fecha_modificacion = $mysqli->real_escape_string($fecha_modificacion);

    // Crear una instancia del modelo de proveedor
    $clienteModel = new ClienteModel($mysqli);

    try {
        // Actualizar el cliente en la base de datos
        $consulta = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', email='$email', telefono='$telefono', direccion='$direccion', ciudad='$ciudad', estado='$estado', codigo_postal='$codigo_postal', pais='$pais', fecha_creacion='$fecha_creacion', fecha_modificacion='$fecha_modificacion' WHERE id_cliente='$llave'";
        
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
        // Vincular el parámetro de 'id_cliente' a la consulta preparada
        $stmt->bind_param("i", $llave);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result) {
            // Recuperar los datos del cliente como un array asociativo
            $cliente = $result->fetch_assoc();

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

        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
       
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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
    
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Cliente</h1>
        <div class="container">
        <div id="form-background">
           
        <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
               

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" id="nombre" name="nombre" class="form-control"  value="<?php echo htmlspecialchars($cliente['cliente'] ?? ''); ?>" required placeholder="Ingresar nombre">
                <div class="invalid-feedback">Por favor ingrese su nombre.</div>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" id="apellido" name="apellido"value="<?php echo htmlspecialchars($cliente['apellido'] ?? ''); ?>" class="form-control" required placeholder="Ingresar apellido">
                <div class="invalid-feedback">Por favor ingrese su apellido.</div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>"class="form-control" required placeholder="Ingresar correo electrónico">
                <div class="invalid-feedback">Por favor ingrese su correo electrónico.</div>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?>"class="form-control" required placeholder="Ingresar número de teléfono">
                <div class="invalid-feedback">Por favor ingrese su número de teléfono.</div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                </div>
                <input type="text" id="direccion" name="direccion" class="form-control" required placeholder="Ingresar dirección">
                <div class="invalid-feedback">Por favor ingrese su dirección.</div>
            </div>

            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                </div>
                <input type="text" id="ciudad" name="ciudad"value="<?php echo htmlspecialchars($proveedor['ciudad'] ?? ''); ?>" class="form-control" required placeholder="Ingresar ciudad">
                <div class="invalid-feedback">Por favor ingrese su ciudad.</div>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map"></i></span>
                </div>

            <label for="estado"><i class="fas fa-users"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="aprobado" <?php if ($cliente['estado'] == 'aprobado') echo 'selected'; ?>>Aprobado</option>
                    <option value="cancelado" <?php if ($cliente['estado'] == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                    <option value="en stock" <?php if ($cliente['estado'] == 'en stock') echo 'selected'; ?>>En stock</option>
                </select>

            <div class="form-group">
                <label for="codigo_postal">Código Postal</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                </div>
                <input type="text" id="codigo_postal" name="codigo_postal"value="<?php echo htmlspecialchars($cliente['codigo_postal'] ?? ''); ?>" class="form-control" required placeholder="Ingresar código postal">
                <div class="invalid-feedback">Por favor ingrese su código postal.</div>
            </div>

            <div class="form-group">
                <label for="pais">País</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-flag"></i></span>
                </div>
                <label for="estado"><i class="fas fa-users"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="colombia" <?php if ($cliente['pais'] == 'colombia') echo 'selected'; ?>>Colombia</option>
                    <option value="ecuador" <?php if ($cliente['pais'] == 'ecuador') echo 'selected'; ?>>Colombia</option>
                    <option value="brazil" <?php if ($cliente['pais'] == 'brazil') echo 'selected'; ?>>Brazil</option>
                    <option value="estados unidos" <?php if ($cliente['pais'] == 'estados unidos') echo 'selected'; ?>>Estados Unidos</option>
                    <option value="España" <?php if ($cliente['pais'] == 'españa') echo 'selected'; ?>>España</option>
                    
                </select>
                <div class="invalid-feedback">Por favor seleccione su país.</div>
            </div>

            <div class="form-group">
                <label for="fecha_creacion">Fecha de Creación</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <input type="date" id="fecha_creacion" name="fecha_creacion"value="<?php echo htmlspecialchars($cliente['fecha_creacion'] ?? ''); ?>" class="form-control" required>
                <div class="invalid-feedback">Por favor ingrese la fecha de creación.</div>
            </div>

            <div class="form-group">
                <label for="fecha_modificacion">Fecha de Modificación</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <input type="date" id="fecha_modificacion" name="fecha_modificacion" value="<?php echo htmlspecialchars($cliente['fecha_modificacion'] ?? ''); ?>" class="form-control">
                <div class="invalid-feedback">Por favor ingrese la fecha de modificación.</div>
            </div>

            <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>