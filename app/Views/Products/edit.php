<?php
// Incluir el modelo y el archivo de configuración de la base de datos
require_once __DIR__ . '/../../Models/ProductoModel.php';
require_once __DIR__ . '/../../Config/database.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
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

// Validar y obtener el valor de 'da' y 'lla' de $_GET
$llave = isset($_GET['lla']) ? intval($_GET['lla']) : 0;
if ($llave <= 0) {
    exit("Error: 'lla' debe ser un valor numérico válido.");
}

// Inicializar la variable $pedido
$producto = null;

// Verificar si se ha enviado un formulario para actualizar el proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos enviados POST
    $nombre_producto = $_POST['nombre_producto'];
    $precio = $_POST['precio'];
    $cantidad_stock = $_POST['cantidad_stock'];
    $categoria_productos = $_POST['categoria_productos'];
    $estado = $_POST['estado'];
    $fecha_adquisicion = $_POST['fecha_adquisicion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $detalles = $_POST['detalles'];
    $archivo = $_FILES['archivo'];
    $codigo_barras = $_POST['codigo_barras'];
    $id_proveedor = $_POST['id_proveedor'];

    // Convertir las fechas a objetos DateTime
    $fecha_adquisicion_objeto = new DateTime($fecha_adquisicion);
    $fecha_vencimiento_objeto = new DateTime($fecha_vencimiento);

    // Calcular la diferencia entre las fechas
    $diferencia = $fecha_adquisicion_objeto->diff($fecha_vencimiento_objeto);

    // Formatear la diferencia en días y horas
    $tiempo_entrega_horas = $diferencia->format('%d días y %h horas');

    // Crear una instancia del modelo de producto
    $productoModel = new ProductoModel($mysqli);

    try {
        // Actualizar el producto en la base de datos
        $resultado = $productoModel->actualizarProducto($llave, $nombre_producto, $precio, $cantidad_stock, $categoria_productos, $estado, $fecha_adquisicion, $fecha_vencimiento, $id_proveedor, $detalles, $archivo, $codigo_barras);
        if ($resultado) {
            echo "Producto actualizado correctamente.";
        } else {
            echo "Error al actualizar el producto.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Obtener los datos del producto para mostrar en el formulario
    $query = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Vincular el parámetro de 'id_producto' a la consulta preparada
        $stmt->bind_param("i", $llave);

        // Ejecutar la consulta preparada
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        if ($result) {
            // Recuperar los datos del producto como un array asociativo
            $producto = $result->fetch_assoc();

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
    <title>CRUD productos</title>
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
        <?php if ($producto): ?>


        <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="nombre_producto"><i class="fas fa-users"></i> Producto:</label>
                <select id="nombre_producto" name="nombre_producto" required class="form-control">
                    <option value="Televisor LED" <?php if ($producto['nombre_producto'] == 'Televisor LED') echo 'selected'; ?>>Televisor LED</option>
                    <option value="Lavadora automática"<?php if ($producto['nombre_producto'] == 'Lavadora automática') echo 'selected'; ?>>Lavadora automática</option>
                    <option value="Smartphone de última generación" <?php if ($producto['nombre_producto'] == 'Smartphone de última generación') echo 'selected'; ?> >Smartphone de última generación</option>
                    <option value="Ordenador portátil ultradelgado" <?php if ($producto['nombre_producto'] == 'Ordenador portátil ultradelgado') echo 'selected'; ?>>Ordenador portátil ultradelgado</option>
                    <option value="Auriculares inalámbricos" <?php if ($producto['nombre_producto'] == 'Auriculares inalámbricos') echo 'selected'; ?>>Auriculares inalámbricos</option>
                    <option value="Cámara digital profesional" <?php if ($producto['nombre_producto'] == 'Cámara digital profesional') echo 'selected'; ?>>Cámara digital profesional</option>
                    <option value="Consola de videojuegos de nueva generación"  <?php if ($producto['nombre_producto'] == 'Consola de videojuegos de nueva generación') echo 'selected'; ?>>Consola de videojuegos de nueva generación</option>
                    <option value="Altavoces Bluetooth impermeables"  <?php if ($producto['nombre_producto'] == 'Altavoces Bluetooth impermeables') echo 'selected'; ?>>Altavoces Bluetooth impermeables</option>
                    <option value="Tableta digital para diseño gráfico"  <?php if ($producto['nombre_producto'] == 'Tableta digital para diseño gráfico') echo 'selected'; ?>>Tableta digital para diseño gráfico</option>
                </select>
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" class="form-control" required placeholder="Precio">
                <div class="invalid-feedback">Por favor ingrese el precio</div>
            </div>

            <div class="form-group">
                <label for="cantidad_stock">Stock</label>
                <input type="number" id="cantidad_stock" value="<?php echo htmlspecialchars($producto['cantidad_stock']); ?>" name="cantidad_stock" class="form-control" required placeholder="Stock">
                <div class="invalid-feedback">Por favor ingrese el número del stock</div>
            </div>

            <div class="form-group">
                <label for="categoria_productos"><i class="fas fa-tag"></i> Categoría:</label>
                <select id="categoria_productos" name="categoria_productos" required class="form-control">
                    <option value="Electrodomésticos" <?php if ($producto['categoria_productos'] == 'Electrodomésticos') echo 'selected'; ?>>Electrodomésticos</option>
                    <option value="Electrónica" <?php if ($producto['categoria_productos'] == 'Electrónica') echo 'selected'; ?>>Electrónica</option>
                    <option value="Informática" <?php if ($producto['categoria_productos'] == 'Informática') echo 'selected'; ?>>Informática</option>
                    <option value="Audio y video" <?php if ($producto['categoria_productos'] == 'Audio y video') echo 'selected'; ?>>Audio y video</option>
                    <option value="Fotografía" <?php if ($producto['categoria_productos'] == 'Fotografía') echo 'selected'; ?>>Fotografía</option>
                    <option value="Consolas y videojuegos" <?php if ($producto['categoria_productos'] == 'Consolas y videojuegos') echo 'selected'; ?>>Consolas y videojuegos</option>
                    <option value="Móviles y tabletas" <?php if ($producto['categoria_productos'] == 'Móviles y tabletas') echo 'selected'; ?>>Móviles y tabletas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="estado"><i class="fas fa-toggle-on"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="Disponible" <?php if ($producto['estado'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
                    <option value="No disponible" <?php if ($producto['estado'] == 'No disponible') echo 'selected'; ?>>No disponible</option>
                    <option value="En espera" <?php if ($producto['estado'] == 'En espera') echo 'selected'; ?>>En espera</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_adquisicion"><i class="fas fa-calendar-alt"></i> Fecha de adquisición:</label>
                <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" value="<?php echo htmlspecialchars($producto['fecha_adquisicion']); ?>" class="form-control" required placeholder="Fecha de adquisición">
            </div>

            <div class="form-group">
                <label for="fecha_vencimiento"><i class="fas fa-calendar-alt"></i> Fecha de vencimiento:</label>
                <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo htmlspecialchars($producto['fecha_vencimiento']); ?>" class="form-control" required placeholder="Fecha de vencimiento">
            </div>

            <div class="form-group">
                <label for="detalles"><i class="fas fa-info-circle"></i> Detalles:</label>
                <textarea id="detalles" name="detalles" class="form-control" required placeholder="Detalles del producto"><?php echo htmlspecialchars($producto['detalles']); ?></textarea>
                <script>CKEDITOR.replace('detalles');</script>
            </div>

            <div class="form-group">
                <label for="archivo"><i class="fas fa-file-upload"></i> Archivo:</label>
                <input type="file" id="archivo" name="archivo" class="form-control-file" accept=".jpg,.png,.jpeg">
            </div>

            <div class="form-group">
                <label for="codigo_barras">Código de barras</label>
                <input type="text" id="codigo_barras" name="codigo_barras" value="<?php echo htmlspecialchars($producto['codigo_barras']); ?>" class="form-control" required placeholder="Código de barras">
                <div class="invalid-feedback">Por favor ingrese el código de barras</div>
            </div>

            <div class="form-group">
                <label for="id_proveedor"><i class="fas fa-truck"></i> Proveedor:</label>
                <select id="id_proveedor" name="id_proveedor" required class="form-control">
                    <?php foreach ($providers as $provider): ?>
                        <option value="<?php echo $provider['id_proveedor']; ?>" <?php if ($producto['id_proveedor'] == $provider['id_proveedor']) echo 'selected'; ?>><?php echo htmlspecialchars($provider['nombre_empresa']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar cambios</button>
        </form>

       <!-- Modal de éxito -->
    <?php if (!empty($mensaje_exito)): ?>
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Éxito</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Se actualizó correctamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script para mostrar el modal automáticamente -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
                successModal.show();
            });
        </script>
    <?php endif; ?>

<?php else: ?>
    <p>No se encontró el producto.</p>
<?php endif; ?>

<!-- Incluimos el JavaScript de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Validación de formulario con Bootstrap
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
</body>
</html>
