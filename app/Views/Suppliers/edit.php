<?php
// Incluir el modelo y el archivo de configuración de la base de datos
require_once __DIR__ . '/../../Models/ProveedorModel.php';
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

// Conectar a MySQL y seleccionar la base de datos.
$mysqli = mysqli_connect(db_host, db_username, db_password, db_dbname);

// Verificar que la conexión sea exitosa
if (!$mysqli) {
    die('Error al conectarse a MySQL: ' . mysqli_connect_error());
}

// Establecer juego de caracteres UTF-8
mysqli_set_charset($mysqli, 'utf8');

// Check if form is submitted (POST method)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture POST data
    $nombre_empresa = $_POST['nombre_empresa'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo_electronico = $_POST['correo_electronico'];
    $condiciones_pago = $_POST['condiciones_pago'];
    $metodo_pago = $_POST['metodo_pago'];
    $descripcion = $_POST['descripcion'];
    $historial_pedidos= $_POST['historial_pedidos'];
    $archivo = $_FILES['archivo'];

    // Crear una instancia del modelo de proveedor
    $proveedorModel = new ProveedorModel($mysqli);

    try {
        // Actualizar el pedido en la base de datos
        $resultado = $proveedorModel->actualizarProveedor($llave,$nombre_empresa, $direccion, $telefono, $correo_electronico, $condiciones_pago, $metodo_pago, $descripcion,$id_producto, $historial_pedidos, $archivo);
        if ($resultado) {
            echo "Proveedor actualizado correctamente.";
        } else {
            echo "Error al actualizar el proveedor.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Obtener los datos del proveedor para mostrar en el formulario
    $query = "SELECT * FROM proveedores WHERE id_proveedor = ?";
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
            $proveedor = $result->fetch_assoc();

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

var_dump($_POST);
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
        <form action="edit.php?lla=<?php echo $llave; ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
               
            <div class="form-group">
                    <label for="nombre_empresa">Empresa:</label>
                    <input type="text" id="nombre_empresa" name="nombre_empresa" value="<?php echo htmlspecialchars($proveedor['nombre_empresa'] ?? ''); ?>" class="form-control" required placeholder="Ingresar nombre empresa">
                    <div class="invalid-feedback"> nombre de la empresa.</div>
                </div>
    
                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($proveedor['direccion'] ?? ''); ?>" class="form-control" required placeholder="Ingresar direccion">
                    <div class="invalid-feedback">Por favor ingrese la direccion.</div>
                </div>
    
                <div class="form-group">
                    <label for="direccion">Telefono</label>
                    <input type="text" id="telefono" name="telefono"  value="<?php echo htmlspecialchars($proveedor['telefono'] ?? ''); ?>" class="form-control" required placeholder="Ingresar telefono">
                    <div class="invalid-feedback">Por favor ingrese el telefono.</div>
                
    </div>

    <div class="form-group">
                <label for="correo_electronico">* Correo Electrónico:</label>
                <input type="email" name="correo_electronico" value="<?php echo htmlspecialchars($proveedor['correo_electronico'] ?? ''); ?>" class="form-control" id="correo_electronico" required>
            </div>
               

            
                <label for="condiciones_pago"><i class="fas fa-users"></i> Condicion de Pago:</label>
                <select id="condiciones_pago" name="condiciones_pago" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="Pago anticipado" <?php if (isset($proveedor['condiciones_pago']) && $proveedor['condiciones_pago'] == 'Pago anticipado') echo 'selected'; ?>>Pago anticipado</option>
                    <option value="Pago a plazos" <?php if (isset($proveedor['condiciones_pago']) && $proveedor['condiciones_pago'] == 'Pago a plazos') echo 'selected'; ?>>Pago a plazos</option>
                    <option value="Pago contra entrega" <?php if (isset($proveedor['condiciones_pago']) && $proveedor['condiciones_pago'] == 'Pago contra entrega') echo 'selected'; ?>>Pago contra entrega</option>
                   
                  
                </select>


                <label for="metodo_pago"><i class="fas fa-users"></i> Método de pago:</label>
                <select id="metodo_pago" name="metodo_pago" required class="form-control">
                    <option value="credito" <?php if (isset($pedido['metodo_pago']) && $pedido['metodo_pago'] == 'credito') echo 'selected'; ?>>Credito</option>
                    <option value="Paypal" <?php if (isset($pedido['metodo_pago']) && $pedido['metodo_pago'] == 'Paypal') echo 'selected'; ?>>Paypal</option>
                    <option value="transferencia" <?php if (isset($pedido['metodo_pago']) && $pedido['metodo_pago'] == 'transferencia') echo 'selected'; ?>>Transferencia</option>
                </select>

                
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripcion"></textarea>
                    <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
                </div>

               

            <div class="mb-3">
  <label for="historial_pedidos" class="form-label">Historial de pedidos</label>
  <textarea class="form-control" id="historial_pedidos" name="historial_pedidos" rows="4" placeholder="Ej: Pedido 01/06/2025 - 10 unidades de papel..."></textarea>
</div>
l


    <div class="mb-3">
              <label for="id_producto" class="form-label">Producto:</label>
              <select class="form-select" id="id_producto" name="id_producto" required>
                <option value="">Selecciona un Producto</option>
                <?php foreach ($products as $product): ?>
                  <option value="<?php echo $product['id_producto']; ?>"><?php echo $product['nombre_producto']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Por favor seleccione un producto.</div>
            </div>
           

        <div class="form-group">
    <label for="archivos">archivo</label>
    <input type="file" id="archivo" name="archivo" class="form-control-file" required>
    <div class="invalid-feedback"></div>
</div>




<button type="submit" name="boton" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </div>

<script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion');
         // Inicializa CKEditor en el textarea con ID "informacion"
         CKEDITOR.replace('informacion');
    </script>