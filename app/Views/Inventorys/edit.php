<?php

require_once __DIR__ . '/../../Models/InventarioModel.php';
require_once __DIR__ . '/../../Controllers/InventarioController.php';
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

// Fetch providers from the database
$sql = "SELECT id_proveedor, nombre_empresa FROM proveedores";
$result = $mysqli->query($sql);

$providers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}


// Fetch products from the database
$sql = "SELECT id_producto, nombre_producto FROM productos";
$result = $mysqli->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}


// Inicializar la variable $inventario
$inventario = null;

// Verificar si se ha enviado un formulario para actualizar el proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos enviados POST
    $nombre_producto = htmlspecialchars($_POST['nombre_producto']);
    $cantidad_stock = htmlspecialchars($_POST['cantidad_stock']);
    $precio_unitario = floatval($_POST['precio_unitario']);
    $costo_unitario = floatval($_POST['costo_unitario']);
    $precio_compra = floatval($_POST['precio_compra']);
    $precio_venta = floatval($_POST['precio_venta']);
    $categoria_producto = htmlspecialchars($_POST['categoria_productos']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $codigo_barras = floatval($_POST['codigo_barras']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $ubicacion = htmlspecialchars($_POST['ubicacion']);
    $estado = htmlspecialchars($_POST['estado']);
    $id_proveedor = intval($_POST['id_proveedor']);
    $id_producto = intval($_POST['id_producto']); 
    $fecha_adquisicion = date('Y-m-d H:i:s');
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $tipo_documento = $_FILES['tipo_documento'];

    // Convertir las fechas a objetos DateTime
    $fecha_compra_objeto = new DateTime($fecha_adquisicion);
    $fecha_entrega_objeto = new DateTime($fecha_vencimiento);

    // Calcular la diferencia entre las fechas
    $diferencia = $fecha_compra_objeto->diff($fecha_entrega_objeto);
    $tiempo_entrega_horas = $diferencia->format('%d días y %h horas');

    // Crear una instancia del modelo de compra
    $inventarioModel = new  InventarioModel($mysqli);

    try {
        // Actualizar la compra en la base de datos
        $resultado = $inventarioModel->actualizarInventario($llave,$nombre_producto, $cantidad_stock, $precio_unitario, $costo_unitario, $precio_compra, $precio_venta, $categoria_productos, $descripcion, $codigo_barras, $ubicacion, $estado, $id_producto, $id_proveedor, $fecha_adquisicion, $fecha_vencimiento, $tipo_documento);
        if ($resultado) {
            echo "Inventario actualizadado correctamente.";
        } else {
             //"Error al actualizar el inventario.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Obtener los datos del  invenatrio para mostrar en el formulario.....
    $query = "SELECT * FROM inventarios WHERE  codigo_inventario = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Vincular el parámetro de 'id_inventario' a la consulta preparada
        $stmt->bind_param("i", $llave);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result) {
            // Recuperar los datos del pedido como un array asociativo
            $inventario = $result->fetch_assoc();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <!-- Incluimos el CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>


<div class="container">
        <div id="form-background">
        <?php if ($inventario): ?>
            <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                <div class="form-group">
                    <label for="nombre_producto"><i class="fas fa-box"></i> Nombre del Producto:</label>
                    <select id="nombre_producto" name="nombre_producto" required class="form-control">
                        <option value="Televisor LED" <?php echo ($inventario['nombre_producto'] == 'Televisor LED') ? 'selected' : ''; ?>>Televisor LED</option>
                        <option value="Lavadora automática" <?php echo ($inventario['nombre_producto'] == 'Lavadora automática') ? 'selected' : ''; ?>>Lavadora automática</option>
                        <option value="Smartphone de última generación" <?php echo ($inventario['nombre_producto'] == 'Smartphone de última generación') ? 'selected' : ''; ?>>Smartphone de última generación</option>
                        <option value="Ordenador portátil ultradelgado" <?php echo ($inventario['nombre_producto'] == 'Ordenador portátil ultradelgado') ? 'selected' : ''; ?>>Ordenador portátil ultradelgado</option>
                        <option value="Auriculares inalámbricos" <?php echo ($inventario['nombre_producto'] == 'Auriculares inalámbricos') ? 'selected' : ''; ?>>Auriculares inalámbricos</option>
                        <option value="Cámara digital profesional" <?php echo ($inventario['nombre_producto'] == 'Cámara digital profesional') ? 'selected' : ''; ?>>Cámara digital profesional</option>
                        <option value="Consola de videojuegos de nueva generación" <?php echo ($inventario['nombre_producto'] == 'Consola de videojuegos de nueva generación') ? 'selected' : ''; ?>>Consola de videojuegos de nueva generación</option>
                        <option value="Altavoces Bluetooth impermeables" <?php echo ($inventario['nombre_producto'] == 'Altavoces Bluetooth impermeables') ? 'selected' : ''; ?>>Altavoces Bluetooth impermeables</option>
                        <option value="Tableta digital para diseño gráfico" <?php echo ($inventario['nombre_producto'] == 'Tableta digital para diseño gráfico') ? 'selected' : ''; ?>>Tableta digital para diseño gráfico</option>
                        <option value="Impresora multifunción a color" <?php echo ($inventario['nombre_producto'] == 'Impresora multifunción a color') ? 'selected' : ''; ?>>Impresora multifunción a color</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cantidad_stock">Cantidad en Stock:</label>
                    <input type="number" class="form-control" id="cantidad_stock" name="cantidad_stock" value="<?php echo $inventario['cantidad_stock']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario:</label>
                    <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" value="<?php echo $inventario['precio_unitario']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="costo_unitario">Costo Unitario:</label>
                    <input type="number" class="form-control" id="costo_unitario" name="costo_unitario" value="<?php echo $inventario['costo_unitario']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="precio_compra">Precio de Compra:</label>
                    <input type="number" class="form-control" id="precio_compra" name="precio_compra" value="<?php echo $inventario['precio_compra']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="precio_venta">Precio de Venta:</label>
                    <input type="number" class="form-control" id="precio_venta" name="precio_venta" value="<?php echo $inventario['precio_venta']; ?>" required>
                </div>

                <label for="categoria_productos"><i class="fas fa-tags"></i> Categoría:</label>
                <select id="categoria_productos" name="categoria_productos" required class="form-control">
                    <option value="categoria 1" <?php echo ($inventario['categoria_productos'] == 'categoria 1') ? 'selected' : ''; ?>>Categoría 1</option>
                    <option value="categoria 2" <?php echo ($inventario['categoria_productos'] == 'categoria 2') ? 'selected' : ''; ?>>Categoría 2</option>
                    <option value="categoria 3" <?php echo ($inventario['categoria_productos'] == 'categoria 3') ? 'selected' : ''; ?>>Categoría 3</option>
                    <option value="categoria 4" <?php echo ($inventario['categoria_productos'] == 'categoria 4') ? 'selected' : ''; ?>>Categoría 4</option>
                    <option value="categoria 5" <?php echo ($inventario['categoria_productos'] == 'categoria 5') ? 'selected' : ''; ?>>Categoría 5</option>
                    <option value="categoria 6" <?php echo ($inventario['categoria_productos'] == 'categoria 6') ? 'selected' : ''; ?>>Categoría 6</option>
                    <option value="categoria 7" <?php echo ($inventario['categoria_productos'] == 'categoria 7') ? 'selected' : ''; ?>>Categoría 7</option>
                    <option value="categoria 8" <?php echo ($inventario['categoria_productos'] == 'categoria 8') ? 'selected' : ''; ?>>Categoría 8</option>
                    <option value="categoria 9" <?php echo ($inventario['categoria_productos'] == 'categoria 9') ? 'selected' : ''; ?>>Categoría 9</option>
                    <option value="categoria 10" <?php echo ($inventario['categoria_productos'] == 'categoria 10') ? 'selected' : ''; ?>>Categoría 10</option>
                </select>

                <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo $inventario['descripcion']; ?></textarea>


                <div class="form-group">
                    <label for="codigo_barras">Código de Barras:</label>
                    <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" value="<?php echo $inventario['codigo_barras']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicación:</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $inventario['ubicacion']; ?>" required>
                </div>


                <div class="form-group">
    <label for="estado"><i class="fas fa-toggle-on"></i> Estado:</label>
    <select id="estado" name="estado" required class="form-control">
        <option value="Disponible" <?php echo ($inventario['estado'] == 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
        <option value="No disponible" <?php echo ($inventario['estado'] == 'No disponible') ? 'selected' : ''; ?>>No disponible</option>
        <option value="En espera" <?php echo ($inventario['estado'] == 'En espera') ? 'selected' : ''; ?>>En espera</option>
    </select>
</div>


<div class="form-group">
    <label for="fecha_adquisicion">Fecha de Adquisición:</label>
    <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required value="<?php echo $inventario['fecha_adquisicion']; ?>">
</div>

<div class="form-group">
    <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required value="<?php echo $inventario['fecha_vencimiento']; ?>">
</div>

<div class="form-group">
    <label for="tipo_documento">Tipo de Documento:</label>
    <input type="file" class="form-control" id="tipo_documento" name="tipo_documento">
    <small class="form-text text-muted">Archivo actual: <?php echo $inventario['tipo_documento']; ?></small>
</div>


               
                <div class="form-group">
    <label for="id_producto">Producto:</label>
    <select class="form-control" id="id_producto" name="id_producto" required>
        <option value="">Selecciona un Producto</option>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo $product['id_producto']; ?>" <?php echo ($product['id_producto'] == $inventario['id_producto']) ? 'selected' : ''; ?>><?php echo $product['nombre_producto']; ?></option>
        <?php endforeach; ?>
    </select>
</div>


                <div class="form-group">
                    <label for="id_proveedor">Proveedor:</label>
                    <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                        <option value="">Selecciona un Proveedor</option>
                        <?php foreach ($providers as $provider): ?>
                            <option value="<?php echo $provider['id_proveedor']; ?>" <?php echo ($provider['id_proveedor'] == $inventario['id_proveedor']) ? 'selected' : ''; ?>><?php echo $provider['nombre_empresa']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_adquisicion">Fecha de Adquisición:</label>
                    <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" value="<?php echo $inventario['fecha_adquisicion']; ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Inventario</button>
            </form>
        <?php else: ?>
            <p>Inventario encontrado.</p>
        <?php endif; ?>
    </div>
</div>



<script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion');
</script>
     
    <!-- Include jQuery and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>