<?php
require_once __DIR__ . '/../../Models/FinancieraModel.php';
require_once __DIR__ . '/../../Controllers/FinancieraController.php';
require_once __DIR__ . '/../../Config/database.php';

    

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
$financiera = null;


// Verificar si se ha enviado un formulario para actualizar el pedido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fecha_transaccion = date('Y-m-d H:i:s'); // Set this from the form if needed
    $monto = isset($_POST['monto']) ? $_POST['monto'] : '';
    $tipo_transaccion = isset($_POST['tipo_transaccion']) ? $_POST['tipo_transaccion'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : $_SESSION['id_usuario']; // Use session user ID if POST ID is not present
    $id_proveedor = isset($_POST['id_proveedor']) ? $_POST['id_proveedor'] : '';
    $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
    $id_producto = isset($_POST['id_producto']) ? $_POST['id_producto'] : '';
    $id_proyecto = isset($_POST['id_proyecto']) ? $_POST['id_proyecto'] : '';
    $id_pedido = isset($_POST['id_pedido']) ? $_POST['id_pedido'] : '';
    $codigo_inventario = isset($_POST['codigo_inventario']) ? $_POST['codigo_inventario'] : '';
    $id_compra = isset($_POST['id_compra']) ? $_POST['id_compra'] : '';


}


// Crear una instancia del modelo de financiera
$financieraModel = new FinancieraModel($mysqli);

// Asegúrate de que $id_transaccion esté definido antes de usarlo
if (isset($_POST['id_transaccion']) && !empty($_POST['id_transaccion'])) {
    $id_transaccion = intval($_POST['id_transaccion']); // Obtener el ID de la transacción desde el formulario
} else {
    exit("Error: 'id_transaccion' debe ser un valor numérico válido.");
}

try {
    // Llamar a la función actualizarFinanciera con todos los parámetros necesarios
    $resultado = $financieraModel->actualizarFinanciera(
        $id_transaccion, // Primero el id_transaccion
        $fecha_transaccion,
        $monto,
        $tipo_transaccion,
        $descripcion,
        $id_usuario,
        $id_proveedor,
        $id_cliente,
        $id_pedido,
        $codigo_inventario,
        $id_producto,
        $id_compra,
        $id_proyecto
    );

    if ($resultado) {
        echo "Pedido actualizado correctamente.";
    } else {
        echo "Error al actualizar el pedido.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


// Obtener los datos del pedido para mostrar en el formulario
$query = "SELECT * FROM financieras WHERE id_transaccion = ?";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    // Vincular el parámetro de 'id_transaccion' a la consulta preparada
    $stmt->bind_param("i", $id_transaccion); 

    // Ejecutar la consulta preparada
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    if ($result) {
        // Recuperar los datos de la financieras como un array asociativo
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

        .ck-editor__editable {
            min-height: 150px;
        }
    </style>
</head>
<body>
   


<div class="container">
    <div id="form-background">
        <?php if ($financiera): ?>
            <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                <!-- Campo oculto para id_transaccion -->
                <input type="hidden" name="id_transaccion" value="<?php echo $financiera['id_transaccion']; ?>">

                <div class="form-group">
                    <label for="fecha_transaccion">Fecha Transaccion:</label>
                    <input type="date" id="fecha_transaccion" name="fecha_transaccion" class="form-control" value="<?php echo $financiera['fecha_transaccion']; ?>" min="0" required>
                </div>

                <div class="form-group">
                    <label for="monto">Monto</label>
                    <input type="number" id="monto" name="monto" class="form-control" value="<?php echo $financiera['monto']; ?>" required placeholder="Monto">
                    <div class="invalid-feedback">Por favor ingrese el monto</div>
                </div>

                <div class="form-group">
                    <label for="tipo_transaccion">* Tipo transaccion:</label>
                    <select name="tipo_transaccion" id="tipo_transaccion" class="form-control" required>
                        <option value="ingreso" <?php echo ($financiera['tipo_transaccion'] == 'ingreso') ? 'selected' : ''; ?>>Ingreso</option>
                        <option value="egreso" <?php echo ($financiera['tipo_transaccion'] == 'egreso') ? 'selected' : ''; ?>>Egreso</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_proveedor">Proveedor:</label>
                    <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                        <option value="">Selecciona un Proveedor</option>
                        <?php foreach ($providers as $provider): ?>
                            <option value="<?php echo $provider['id_proveedor']; ?>" <?php echo ($financiera['id_proveedor'] == $provider['id_proveedor']) ? 'selected' : ''; ?>>
                                <?php echo $provider['nombre_empresa']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_cliente">Cliente:</label>
                    <select class="form-control" id="id_cliente" name="id_cliente" required>
                        <option value="">Selecciona un Cliente</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id_cliente']; ?>" <?php echo ($financiera['id_cliente'] == $client['id_cliente']) ? 'selected' : ''; ?>>
                                <?php echo $client['nombre']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_pedido">Pedido:</label>
                    <select class="form-control" id="id_pedido" name="id_pedido" required>
                        <option value="">Selecciona un Pedido</option>
                        <?php foreach ($orders as $order): ?>
                            <option value="<?php echo $order['id_pedido']; ?>" <?php echo ($financiera['id_pedido'] == $order['id_pedido']) ? 'selected' : ''; ?>>
                                <?php echo $order['nombre_pedido']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="codigo_inventario">Código de Inventario:</label>
                    <select class="form-control" id="codigo_inventario" name="codigo_inventario" required>
                        <option value="">Selecciona un Código de Inventario</option>
                        <?php foreach ($inventory as $item): ?>
                            <option value="<?php echo $item['codigo_inventario']; ?>" <?php echo ($financiera['codigo_inventario'] == $item['codigo_inventario']) ? 'selected' : ''; ?>>
                                <?php echo $item['nombre_producto']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_producto">Producto:</label>
                    <select class="form-control" id="id_producto" name="id_producto" required>
                        <option value="">Selecciona un Producto</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?php echo $product['id_producto']; ?>" <?php echo ($financiera['id_producto'] == $product['id_producto']) ? 'selected' : ''; ?>>
                                <?php echo $product['nombre_producto']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_compra">Compra:</label>
                    <select class="form-control" id="id_compra" name="id_compra" required>
                        <option value="">Selecciona una Compra</option>
                        <?php foreach ($purchases as $purchase): ?>
                            <option value="<?php echo $purchase['id_compra']; ?>" <?php echo ($financiera['id_compra'] == $purchase['id_compra']) ? 'selected' : ''; ?>>
                                <?php echo $purchase['productos_comprados']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_proyecto">Proyecto:</label>
                    <select class="form-control" id="id_proyecto" name="id_proyecto" required>
                        <option value="">Selecciona un Proyecto</option>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?php echo $project['id_proyecto']; ?>" <?php echo ($financiera['id_proyecto'] == $project['id_proyecto']) ? 'selected' : ''; ?>>
                                <?php echo $project['nombre_proyecto']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
    // Inicializamos CKEditor en el textarea con ID "descripcion"
    CKEDITOR.replace('detalles');
</script>
