<?php
// Incluir el modelo y el archivo de configuración de la base de datos
require_once __DIR__ . '/../../Models/CompraModel.php';
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

// Fetch providers from the database
$sql = "SELECT id_proveedor, nombre_empresa FROM proveedores";
$result = $mysqli->query($sql);

$providers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}

// Fetch inventory items from the database
$sql = "SELECT codigo_inventario, nombre_producto FROM inventarios";
$result = $mysqli->query($sql);

$inventory = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { 
        $inventory[] = $row;
    }
}

// Inicializar la variable $compra
$compra = null;

// Verificar si se ha enviado un formulario para actualizar el proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos enviados POST
    $productos_comprados = htmlspecialchars($_POST['productos_comprados']);
    $detalles_productos = htmlspecialchars($_POST['detalles_productos']);
    $precio_unitario = floatval($_POST['precio_unitario']);
    $precio_compra = floatval($_POST['precio_compra']);
    $total_compra = floatval($_POST['total_compra']);
    $estado_actual = htmlspecialchars($_POST['estado_actual']);
    $metodo_pago = htmlspecialchars($_POST['metodo_pago']);
    $codigo_inventario = htmlspecialchars($_POST['codigo_inventario']);
    $id_proveedor = intval($_POST['id_proveedor']);
    $archivo = $_FILES['factura'];
    $id_usuario = $_SESSION['id_usuario'];
    $fecha_compra = date('Y-m-d H:i:s');
    $fecha_entrega = $_POST['fecha_entrega'];

    // Convertir las fechas a objetos DateTime
    $fecha_compra_objeto = new DateTime($fecha_compra);
    $fecha_entrega_objeto = new DateTime($fecha_entrega);

    // Calcular la diferencia entre las fechas
    $diferencia = $fecha_compra_objeto->diff($fecha_entrega_objeto);
    $tiempo_entrega_horas = $diferencia->format('%d días y %h horas');

    // Crear una instancia del modelo de compra
    $compraModel = new CompraModel($mysqli);

    try {
        // Actualizar la compra en la base de datos
        $resultado = $compraModel->actualizarCompra($llave, $productos_comprados, $detalles_productos, $precio_unitario, $precio_compra, $total_compra, $estado_actual, $metodo_pago, $fecha_compra, $fecha_entrega, $codigo_inventario, $id_proveedor, $id_usuario, $archivo);
        if ($resultado) {
            echo "Compra actualizada correctamente.";
        } else {
            echo "Error al actualizar el pedido.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Obtener los datos del pedido para mostrar en el formulario
    $query = "SELECT * FROM compras WHERE id_compra = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Vincular el parámetro de 'id_compra' a la consulta preparada
        $stmt->bind_param("i", $llave);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result) {
            // Recuperar los datos del pedido como un array asociativo
            $compra = $result->fetch_assoc();

            // Cerrar la consulta preparada
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
    <title>CRUD pedidos</title>
    <!-- Agregamos los estilos de Bootstrap para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Incluimos el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
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
            <form action="edit.php?da=2&lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="productos_comprados"><i class="fas fa-users"></i> Productos:</label>
                    <select id="productos_comprados" name="productos_comprados" required class="form-control">
                        <option value="Televisor LED" <?php if (($compra['productos_compra'] ?? '') == 'Televisor LED') echo 'selected'; ?>>Televisor LED</option>
                        <option value="Lavadora automática" <?php if (($compra['productos_compra'] ?? '') == 'Lavadora automática') echo 'selected'; ?>>Lavadora automática</option>
                        <option value="Smartphone de última generación" <?php if (($compra['productos_compra'] ?? '') == 'Smartphone de última generación') echo 'selected'; ?>>Smartphone de última generación</option>
                        <option value="Ordenador portátil ultradelgado" <?php if (($compra['productos_compra'] ?? '') == 'Ordenador portátil ultradelgado') echo 'selected'; ?>>Ordenador portátil ultradelgado</option>
                        <option value="Auriculares inalámbricos" <?php if (($compra['productos_compra'] ?? '') == 'Auriculares inalámbricos') echo 'selected'; ?>>Auriculares inalámbricos</option>
                        <option value="Cámara digital profesional" <?php if (($compra['productos_compra'] ?? '') == 'Cámara digital profesional') echo 'selected'; ?>>Cámara digital profesional</option>
                        <option value="Consola de videojuegos de nueva generación" <?php if (($compra['productos_compra'] ?? '') == 'Consola de videojuegos de nueva generación') echo 'selected'; ?>>Consola de videojuegos de nueva generación</option>
                        <option value="Altavoces Bluetooth impermeables" <?php if (($compra['productos_compra'] ?? '') == 'Altavoces Bluetooth impermeables') echo 'selected'; ?>>Altavoces Bluetooth impermeables</option>
                        <option value="Tableta digital para diseño gráfico" <?php if (($compra['productos_compra'] ?? '') == 'Tableta digital para diseño gráfico') echo 'selected'; ?>>Tableta digital para diseño gráfico</option>
                        <option value="Impresora multifunción a color" <?php if (($compra['productos_compra'] ?? '') == 'Impresora multifunción a color') echo 'selected'; ?>>Impresora multifunción a color</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="detalles_productos">Detalles</label>
                    <textarea id="detalles_productos" name="detalles_productos" class="form-control" required><?php echo htmlspecialchars($compra['detalles_productos'] ?? ''); ?></textarea>
                    <script>
                        CKEDITOR.replace('detalles_productos');
                    </script>
                </div>

                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario:</label>
                    <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" class="form-control" value="<?php echo htmlspecialchars($compra['precio_unitario'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="precio_compra">Precio Compra:</label>
                    <input type="number" step="0.01" id="precio_compra" name="precio_compra" class="form-control" value="<?php echo htmlspecialchars($compra['precio_compra'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="total_compra">Total Compra:</label>
                    <input type="number" step="0.01" id="total_compra" name="total_compra" class="form-control" value="<?php echo htmlspecialchars($compra['total_compra'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="estado_actual">Estado Actual:</label>
                    <input type="text" id="estado_actual" name="estado_actual" class="form-control" value="<?php echo htmlspecialchars($compra['estado_actual'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="metodo_pago">Método de Pago:</label>
                    <input type="text" id="metodo_pago" name="metodo_pago" class="form-control" value="<?php echo htmlspecialchars($compra['metodo_pago'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="fecha_entrega">Fecha de Entrega:</label>
                    <input type="datetime-local" id="fecha_entrega" name="fecha_entrega" class="form-control" value="<?php echo htmlspecialchars($compra['fecha_entrega'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="codigo_inventario">Código de Inventario:</label>
                    <select id="codigo_inventario" name="codigo_inventario" class="form-control" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($inventory as $item) : ?>
                            <option value="<?php echo $item['codigo_inventario']; ?>" <?php if (($compra['codigo_inventario'] ?? '') == $item['codigo_inventario']) echo 'selected'; ?>>
                                <?php echo $item['nombre_producto']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_proveedor">Proveedor:</label>
                    <select id="id_proveedor" name="id_proveedor" class="form-control" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($providers as $provider) : ?>
                            <option value="<?php echo $provider['id_proveedor']; ?>" <?php if (($compra['id_proveedor'] ?? '') == $provider['id_proveedor']) echo 'selected'; ?>>
                                <?php echo $provider['nombre_empresa']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="factura">Factura:</label>
                    <input type="file" id="factura" name="factura" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Compra</button>
            </form>
        </div>
    </div>
</body>
</html>
