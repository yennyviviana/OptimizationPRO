ç<?php
require_once __DIR__ . '/../../Models/ProductoModel.php';
require_once __DIR__ . '/../../Controllers/ProductoController.php';



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
$producto = null;

// Verificar si se ha enviado un formulario para actualizar a prductos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //capturar los datos enviados POST
      $nombre_producto = $_POST['nombre_producto'];
      $precio = $_POST['precio'];
      $cantidad_stock = $_POST['cantidad_stock'];
      $categoria_productos = $_POST['categoria_productos'];
      $estado = $_POST['estado'];
      $fecha_adquisicion = $_POST['fecha_adquisicion'];
      $fecha_vencimiento = $_POST['fecha_vencimiento'];
      $detalles = $_POST['detalles'];
      $codigo_barras = $_POST['codigo_barras'];
      $id_proveedor = $_POST['id_proveedor'];
      $archivo = $_FILES['archivo'];
    

    // Capturar la fecha de entrega proporcionada por el usuario
    $fecha_producto = date('Y-m-d H:i:s');
    $fecha_entrega = $_POST['fecha_entrega'];

    // Convertir las fechas a objetos DateTime.....
    $fecha_producto_objeto = new DateTime($fecha_producto);
    $fecha_entrega_objeto = new DateTime($fecha_entrega);

    // Calcular la diferencia entre las fechas
    $diferencia = $fecha_producto_objeto->diff($fecha_entrega_objeto);

    // Formatear la diferencia en días y horas
    $tiempo_entrega_horas = $diferencia->format('%d días y %h horas');

    // Crear una instancia del modelo de proveedor
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
        // Vincular el parámetro de 'id_proveedor' a la consulta preparada
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
    <title>Editar Producto</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD productos</title>
    
    <!-- Bootstrap y FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container py-5">
     <?php if ($producto): ?>
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-box"></i> Registrar Producto</h4>
        </div>
        <div class="card-body">
            <form action="insert.php?da=2" method="POST" enctype="multipart/form-data" class="needs-validation row" novalidate>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre_producto"><i class="fas fa-cubes"></i> Producto:</label>
                        <select id="nombre_producto" name="nombre_producto" required class="form-control">
                            <option value="" disabled selected>Seleccione un producto</option>
                            <option value="Televisor LED" <?php if ($producto['nombre_producto'] == 'Televisor LED') echo 'selected'; ?>>Televisor LED</option>
                            <option value="Camara fotografica" <?php if ($producto['nombre_producto'] == 'Camara fotografica') echo 'selected'; ?>>Camara fotografica</option>
                            <option value="Smarphone" <?php if ($producto['nombre_producto'] == 'Smarphone') echo 'selected'; ?>>Smarphone</option>
                            <option value="Lavadora automatica" <?php if ($producto['nombre_producto'] == 'Lavadora automatica') echo 'selected'; ?>>Lavadora automatica</option>
                            <option value="Reloj de pared" <?php if ($producto['nombre_producto'] == 'Reloj de pared') echo 'selected'; ?>>Reloj de pared</option>
                           
                           
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" class="form-control" required>
                        <div class="invalid-feedback">Por favor ingrese el precio.</div>
                    </div>
                </div>

                    <div class="form-group">
                        <label for="cantidad_stock"><i class="fas fa-boxes"></i> Stock:</label>
                        <input type="number" id="cantidad_stock" name="cantidad_stock" value="<?php echo htmlspecialchars($producto['cantidad_stock']); ?>" class="form-control" required placeholder="Cantidad en stock">
                        <div class="invalid-feedback">Por favor ingrese el número del stock.</div>
                    </div>

                    <div class="form-group">
                        <label for="categoria_productos"><i class="fas fa-tags"></i> Categoría:</label>
                        <select id="categoria_productos" name="categoria_productos" required class="form-control">
                            <option value="" disabled selected>Seleccione categoría</option>
                            <option value="Producto 1"  <?php if ($producto['categoria_productos'] == 'producto 1') echo 'selected'; ?>>Producto 1</option>
                            <option value="Producto 2"  <?php if ($producto['categoria_productos'] == 'producto 2') echo 'selected'; ?>>Producto 2</option>
                            <option value="Producto 3"  <?php if ($producto['categoria_productos'] == 'producto 3') echo 'selected'; ?>>Producto 3</option>
                            <option value="Producto 4"  <?php if ($producto['categoria_productos'] == 'producto 4') echo 'selected'; ?>>Producto 4</option>
                            <option value="Producto 5"  <?php if ($producto['categoria_productos'] == 'producto 5') echo 'selected'; ?>>Producto 5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado"><i class="fas fa-toggle-on"></i> Estado:</label>
                        <select id="estado" name="estado" required class="form-control">
                            <option  value="Disponible" <?php if ($producto['estado'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
                            <option  value="No disponible" <?php if ($producto['estado'] == ' No disponible') echo 'selected'; ?>>No disponible</option>
                            <option  value="En espera" <?php if ($producto['estado'] == 'En espera') echo 'selected'; ?>>En espera</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_adquisicion"><i class="fas fa-calendar-plus"></i> Fecha de adquisición:</label>
                        <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" value="<?php echo htmlspecialchars($producto['fecha_adquisicion']); ?>"class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_vencimiento"><i class="fas fa-calendar-minus"></i> Fecha de vencimiento:</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento"  value="<?php echo htmlspecialchars($producto['fecha_vencimiento']); ?>"class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="detalles"><i class="fas fa-align-left"></i> Descripción detallada:</label>
                        <textarea id="detalles" name="detalles" class="form-control" required><?php echo htmlspecialchars($producto['detalles']); ?></textarea>
                        <div class="invalid-feedback">Por favor ingrese la descripción.</div>
                    </div>

                    <div class="form-group">
                        <label for="codigo_barras"><i class="fas fa-barcode"></i> Código de barras:</label>
                        <input type="number" id="codigo_barras" name="codigo_barras" class="form-control" required placeholder="Código de barras">
                    </div>

                    <div class="form-group">
                        <label for="archivo"><i class="fas fa-file-upload"></i> Archivo:</label>
                        <input type="file" id="archivo" name="archivo" class="form-control-file" required>
                        <div class="invalid-feedback">Por favor seleccione al menos un archivo.</div>
                    </div>

                    <div class="form-group">
                        <label for="id_proveedor"><i class="fas fa-truck"></i> Proveedor:</label>
                        <select name="id_proveedor" class="form-control" required>
                            <option value="" disabled selected>Seleccione un proveedor</option>
                            <?php foreach ($providers as $provider) { ?>
                                <option value="<?php echo $provider['id_proveedor']; ?>">
                                    <?php echo $provider['nombre_empresa']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 text-right">
                    <button type="submit" name="boton" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Activar CKEditor
    CKEDITOR.replace('detalles');

    // Validación de Bootstrap
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();
</script>

</body>
</html>





<script>
    CKEDITOR.replace('detalles');

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
<?php endif; ?>
</body>
</html>
