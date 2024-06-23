<?php
// Incluir el modelo y el archivo de configuración de la base de datos
require_once __DIR__ . '/../../Models/PedidoModel.php';
require_once __DIR__ . '/../../Config/database.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

// Validar y obtener el valor de 'da' y 'lla' de $_GET
$llave = isset($_GET['lla']) ? intval($_GET['lla']) : 0;
if ($llave <= 0) {
    exit("Error: 'lla' debe ser un valor numérico válido.");
}

// Conectar a MySQL y seleccionar la base de datos.
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

// Verificar que la conexión sea exitosa
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}

// Establecer juego de caracteres UTF-8
mysqli_set_charset($mysqli, 'utf8');

// Inicializar la variable $pedido
$pedido = null;

// Verificar si se ha enviado un formulario para actualizar el proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //capturar los datos enviados POST
    $nombre_pedido = $_POST['nombre_pedido'];
    $precio = $_POST['precio'];
    $estado = $_POST['estado'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $numero_seguimiento = $_POST['numero_seguimiento'];
    $informacion_pedido = $_POST['informacion_pedido'];
    $metodo_pago = $_POST['metodo_pago'];
    $archivo = $_FILES['archivo'];
    $id_usuario = $_SESSION['id_usuario'];
    $historial_pedidos = $_POST['historial_pedidos'];

    // Capturar la fecha de entrega proporcionada por el usuario
    $fecha_pedido = date('Y-m-d H:i:s');
    $fecha_entrega = $_POST['fecha_entrega'];

    // Convertir las fechas a objetos DateTime
    $fecha_pedido_objeto = new DateTime($fecha_pedido);
    $fecha_entrega_objeto = new DateTime($fecha_entrega);

    // Calcular la diferencia entre las fechas
    $diferencia = $fecha_pedido_objeto->diff($fecha_entrega_objeto);

    // Formatear la diferencia en días y horas
    $tiempo_entrega_horas = $diferencia->format('%d días y %h horas');

    // Crear una instancia del modelo de proveedor
    $pedidoModel = new PedidoModel($mysqli);

    try {
        // Actualizar el pedido en la base de datos
        $resultado = $pedidoModel->actualizarPedido($llave, $nombre_pedido, $precio, $estado, $direccion, $descripcion, $numero_seguimiento, $tiempo_entrega_horas, $informacion_pedido, $metodo_pago, $archivo, $fecha_pedido, $fecha_entrega, $id_usuario, $historial_pedidos);
        if ($resultado) {
            echo "Pedido actualizado correctamente.";
        } else {
            echo "Error al actualizar el pedido.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Obtener los datos del pedido para mostrar en el formulario
    $query = "SELECT * FROM pedidos WHERE id_pedido = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Vincular el parámetro de 'id_proveedor' a la consulta preparada
        $stmt->bind_param("i", $llave);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result) {
            // Recuperar los datos del pedido como un array asociativo
            $pedido = $result->fetch_assoc();

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

// No necesitamos manejar el archivo aquí, ya que lo estamos actualizando por separado en el bloque POST
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD pedidos</title>
    <!-- Agregamos los estilos de Bootstrap para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Incluimos el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Incluimos el CSS de CKEditor -->
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

        /* Ajuste de estilos para el editor CKEditor */
        .ck-editor__editable {
            min-height: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="form-background">
            <?php if ($pedido): ?>
            <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="nombre_pedido">Nombre</label>
                    <input type="text" id="nombre_pedido" name="nombre_pedido" value="<?php echo htmlspecialchars($pedido['nombre_pedido']); ?>" class="form-control" required placeholder="Ingresar nombre pedido">
                    <div class="invalid-feedback">Nombre del pedido.</div>
                </div>

                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($pedido['precio']); ?>" class="form-control" required placeholder="Precio">
                    <div class="invalid-feedback">Por favor ingrese el precio</div>
                </div>

                <label for="estado"><i class="fas fa-users"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="aprobado" <?php if ($pedido['estado'] == 'aprobado') echo 'selected'; ?>>Aprobado</option>
                    <option value="cancelado" <?php if ($pedido['estado'] == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                    <option value="en stock" <?php if ($pedido['estado'] == 'en stock') echo 'selected'; ?>>En stock</option>
                </select>
                
                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($pedido['direccion']); ?>" class="form-control" required placeholder="Ingresar direccion">
                    <div class="invalid-feedback">Por favor ingrese la direccion.</div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripcion"><?php echo htmlspecialchars($pedido['descripcion']); ?></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
                </div>

                <div class="form-group">
                    <label for="numero_seguimiento">Numero seguimiento</label>
                    <input type="number" id="numero_seguimiento" name="numero_seguimiento" value="<?php echo htmlspecialchars($pedido['numero_seguimiento']); ?>" class="form-control" required placeholder="Numero seguimiento">
                    <div class="invalid-feedback">Numero de seguimiento.</div>
                </div>

                <div class="form-group">
                    <label for="informacion_pedido">Información:</label>
                    <textarea id="informacion_pedido" name="informacion_pedido" class="form-control" required placeholder="Información"><?php echo htmlspecialchars($pedido['informacion_pedido']); ?></textarea>
                    <div class="invalid-feedback">Por favor ingrese información.</div>
                </div>

                <label for="metodo_pago"><i class="fas fa-users"></i> Método de pago:</label>
                <select id="metodo_pago" name="metodo_pago" required class="form-control">
                    <option value="credito" <?php if ($pedido['metodo_pago'] == 'credito') echo 'selected'; ?>>Credito</option>
                    <option value="Paypal" <?php if ($pedido['metodo_pago'] == 'Paypal') echo 'selected'; ?>>Paypal</option>
                    <option value="transferencia" <?php if ($pedido['metodo_pago'] == 'transferencia') echo 'selected'; ?>>Transferencia</option>
                </select>

                <div class="form-group">
                    <label for="archivo">Archivos</label>
                    <input type="file" id="archivo" name="archivo" class="form-control-file" multiple required>
                    <div class="invalid-feedback">Por favor seleccione al menos un archivo.</div>
                </div>

                <label for="historial_pedidos"><i class="fas fa-users"></i>Historial:</label>
                <select id="historial_pedidos" name="historial_pedidos" required class="form-control">
                    <option value="producto 1" <?php if ($pedido['historial_pedidos'] == 'producto 1') echo 'selected'; ?>>Producto 1</option>
                    <option value="producto 2" <?php if ($pedido['historial_pedidos'] == 'producto 2') echo 'selected'; ?>>Producto 2</option>
                    <option value="producto 3" <?php if ($pedido['historial_pedidos'] == 'producto 3') echo 'selected'; ?>>Producto 3</option>
                </select>
                <div class="form-group">
                    <label for="fecha_pedido">Fecha del pedido:</label>
                    <input type="date" id="fecha_pedido" name="fecha_pedido" value="<?php echo htmlspecialchars($pedido['fecha_pedido']); ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="fecha_entrega">Fecha de entrega:</label>
                    <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?php echo htmlspecialchars($pedido['fecha_entrega']); ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tiempo transcurrido (Días y Horas):</label>
                    <span id="tiempo_entrega_horas" class="form-control"><?php echo htmlspecialchars($pedido['tiempo_entrega_horas']); ?></span>
                </div>

                <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($pedido['id_pedido']); ?>">
                <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>
            <?php else: ?>
                <div class="alert alert-danger">No se encontraron datos del pedido.</div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion');
        // Inicializa CKEditor en el textarea con ID "informacion_pedido"
        CKEDITOR.replace('informacion_pedido');

        document.getElementById('fecha_entrega').addEventListener('change', function() {
            var fechaEntrega = new Date(this.value); // Obtener la fecha de entrega seleccionada
            var fechaPedido = new Date(); // Obtener la fecha actual
            var tiempoEntregaMilisegundos = fechaEntrega - fechaPedido; // Calcular la diferencia en milisegundos

            // Convertir la diferencia de milisegundos a días y horas
            var dias = Math.floor(tiempoEntregaMilisegundos / (1000 * 60 * 60 * 24));
            var horas = Math.floor((tiempoEntregaMilisegundos % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            // Mostrar el tiempo transcurrido en el span correspondiente
            document.getElementById('tiempo_entrega_horas').textContent = dias + " días y " + horas + " horas";
        });
    </script>
</body>
</html>
<?php
// Cierra la conexión a la base de datos
mysqli_close($mysqli);
?>
