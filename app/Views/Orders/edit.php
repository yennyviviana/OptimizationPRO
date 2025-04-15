<?php
// Incluir el modelo y el archivo de configuración de la base de datos
require_once __DIR__ . '/../../Models/OrderModel.php';
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
        $resultado = $pedidoModel->actualizarPedido($llave,$nombre_pedido, $precio, $estado, $direccion, $descripcion, $numero_seguimiento, $tiempo_entrega_horas, $informacion_pedido, $metodo_pago, $archivo, $fecha_pedido, $fecha_entrega, $id_usuario);
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


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Pedido</h4>
        </div>
        <div class="card-body">
            <?php if ($pedido): ?>
            <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombre_pedido">Nombre del Pedido</label>
                        <input type="text" id="nombre_pedido" name="nombre_pedido" value="<?php echo htmlspecialchars($pedido['nombre_pedido']); ?>" class="form-control" required>
                        <div class="invalid-feedback">Por favor ingrese el nombre del pedido.</div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($pedido['precio']); ?>" class="form-control" required>
                        <div class="invalid-feedback">Por favor ingrese el precio.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="aprobado" <?php if ($pedido['estado'] == 'aprobado') echo 'selected'; ?>>Aprobado</option>
                            <option value="cancelado" <?php if ($pedido['estado'] == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                            <option value="en stock" <?php if ($pedido['estado'] == 'en stock') echo 'selected'; ?>>En stock</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="metodo_pago">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago" class="form-control" required>
                            <option value="credito" <?php if ($pedido['metodo_pago'] == 'credito') echo 'selected'; ?>>Crédito</option>
                            <option value="Paypal" <?php if ($pedido['metodo_pago'] == 'Paypal') echo 'selected'; ?>>Paypal</option>
                            <option value="transferencia" <?php if ($pedido['metodo_pago'] == 'transferencia') echo 'selected'; ?>>Transferencia</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($pedido['direccion']); ?>" class="form-control" required>
                    <div class="invalid-feedback">Por favor ingrese la dirección.</div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo htmlspecialchars($pedido['descripcion']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="informacion_pedido">Información del Pedido</label>
                    <textarea id="informacion_pedido" name="informacion_pedido" class="form-control" required><?php echo htmlspecialchars($pedido['informacion_pedido']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="numero_seguimiento">Número de Seguimiento</label>
                    <input type="number" id="numero_seguimiento" name="numero_seguimiento" value="<?php echo htmlspecialchars($pedido['numero_seguimiento']); ?>" class="form-control" required>
                    <div class="invalid-feedback">Por favor ingrese el número de seguimiento.</div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fecha_entrega">Fecha de Entrega</label>
                        <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?php echo htmlspecialchars($pedido['fecha_entrega']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tiempo Transcurrido (Días y Horas)</label>
                        <span id="tiempo_entrega_horas" class="form-control"><?php echo htmlspecialchars($pedido['tiempo_entrega_horas']); ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="archivo">Archivos Adjuntos</label>
                    <input type="file" id="archivo" name="archivo" class="form-control-file" multiple required>
                    <div class="invalid-feedback">Debe seleccionar al menos un archivo.</div>
                </div>

                <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($pedido['id_pedido']); ?>">

                <button type="submit" name="boton" class="btn btn-success"><i class="fas fa-save"></i> Guardar Cambios</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    CKEDITOR.replace('descripcion');
    CKEDITOR.replace('informacion_pedido');

    document.getElementById('fecha_entrega').addEventListener('change', function () {
        const fechaEntrega = new Date(this.value);
        const fechaPedido = new Date();
        const diferencia = fechaEntrega - fechaPedido;

        const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
        const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        document.getElementById('tiempo_entrega_horas').textContent = dias + " días y " + horas + " horas";
    });
</script>
</body>
</html>

<?php
// Cierra la conexión a la base de datos
mysqli_close($mysqli);
?>