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
    <title>Crud Compras</title>
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



<div class="container py-5">
    <div class="card shadow-lg">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-box"></i> Editar Compras</h4>
        </div>
        <div class="card-body">
        <form action="insert.php?da=2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
           
        <div class="form-group">
                <label for="productos_comprados"><i class="fas fa-users"></i>Productos:</label>
                <select id="productos_comprados" name="productos_comprados" required class="form-control">
                    <option value="Televisor LED"  <?php if ($compra['productos_comprados'] == 'Televisor LED') echo 'selected'; ?>>Televisor LED</option>
                    <option value="Lavadora automática">Lavadora automática</option>
                    <option value="Smartphone de última generación">Smartphone de última generación</option>
                    <option value="Ordenador portátil ultradelgado">Ordenador portátil ultradelgado</option>
                    <option value="Auriculares inalámbricos">Auriculares inalámbricos</option>
                    <option value="Cámara digital profesional">Cámara digital profesional</option>
                    <option value="Consola de videojuegos de nueva generación">Consola de videojuegos de nueva generación</option>
                    <option value="Altavoces Bluetooth impermeables">Altavoces Bluetooth impermeables</option>
                    <option value="Tableta digital para diseño gráfico">Tableta digital para diseño gráfico</option>
                    <option value="Impresora multifunción a color">Impresora multifunción a color</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <textarea id="detalles_productos" name="detalles_productos" class="form-control" required placeholder="detalles_productos"></textarea>
                <div class="invalid-feedback">Por favor ingrese la detalles productos.</div>
            </div>
            <div class="form-group">
                <label for="precio_unitario">Precio Unitario</label>
                <input type="number" id="precio_unitario" name="precio_unitario" class="form-control" required placeholder="Precio unitario">
                <div class="invalid-feedback">Por favor ingrese el precio unitario</div>
            </div>
            <div class="form-group">
                <label for="precio_compra">Precio Compra</label>
                <input type="number" id="precio_compra" name="precio_compra" class="form-control" required placeholder="Precio compra">
                <div class="invalid-feedback">Por favor ingrese el precio compra</div>
            </div>
            <div class="form-group">
                <label for="total_compra">Total Compra</label>
                <input type="number" id="total_compra" name="total_compra" class="form-control" required placeholder="Total compra">
                <div class="invalid-feedback">Por favor ingrese el total compra</div>
            </div>
            <label for="estado_actual"><i class="fas fa-users"></i> Estado Actual:</label>
            <select id="estado_actual" name="estado_actual" required class="form-control">
                <option value="">Seleccione una opcion</option>
                <option value="aprobado">Aprobado</option>
                <option value="pendiente">Pendiente</option>
                <option value="finalizado">Finalizado</option>
            </select>
            <div class="form-group">
                <label for="metodo_pago">Método de Pago</label>
                <input type="text" id="metodo_pago" name="metodo_pago" class="form-control" required placeholder="Método de pago">
                <div class="invalid-feedback">Por favor ingrese el método de pago</div>
            </div>
            <div class="form-group">
                <label for="fecha_compra">Fecha de compra:</label>
                <input type="date" id="fecha_compra" name="fecha_compra" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fecha_entrega">Fecha de entrega:</label>
                <input type="datetime-local" id="fecha_entrega" name="fecha_entrega" class="form-control" required>
            </div>
            
            
            <div class="form-group">
                <label for="codigo_inventario">Inventario:</label>
                <select class="form-control" id="codigo_inventario" name="codigo_inventario" required>
                    <option value="">Seleccione un Inventario</option>
                    <?php foreach ($inventory as $item): ?>
                        <option value="<?php echo htmlspecialchars($item['codigo_inventario']); ?>"><?php echo htmlspecialchars($item['nombre_producto']); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Por favor seleccione un inventario.</div>
            </div>


            <div class="form-group">
                <label for="id_proveedor">Proveedor:</label>
                <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                    <option value="">Selecciona un Proveedor</option>
                    <?php foreach ($providers as $provider): ?>
                        <option value="<?php echo htmlspecialchars($provider['id_proveedor']); ?>"><?php echo htmlspecialchars($provider['nombre_empresa']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="factura">Factura (Archivo):</label>
                <input type="file" id="factura" name="factura" class="form-control-file" required>
                <div class="invalid-feedback">Seleccione al menos un archivo.</div>
            </div>
            <button type="submit" name="boton" class="btn btn-success">Guardar</button>
        </form>
    </div>
</div>

<script>
   
    // Inicializar CKEditor
    CKEDITOR.replace('detalles_productos');

    // Validar formulario
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Calcular el total de compra
    document.getElementById('precio_unitario').addEventListener('input', calcularTotal);
    document.getElementById('precio_compra').addEventListener('input', calcularTotal);

    function calcularTotal() {
        var precioUnitario = parseFloat(document.getElementById('precio_unitario').value) || 0;
        var precioCompra = parseFloat(document.getElementById('precio_compra').value) || 0;
        var totalCompra = precioUnitario + precioCompra;
        document.getElementById('total_compra').value = totalCompra.toFixed(2);
    }
</script>
</body>
</html>

