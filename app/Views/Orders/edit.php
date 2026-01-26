<?php
require_once __DIR__ . '/../../Config/database.php';
require_once __DIR__ . '/../../Models/PedidoModel.php';

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if ($mysqli->connect_error) {
    die('Error en la conexion: ' . $mysqli->connect_error);
}

$PedidoModel = new PedidoModel($mysqli);

// Validar ID de pedido
$llave = isset($_GET['lla']) ? intval($_GET['lla']) : 0;
$pedido = $llave > 0 ? $PedidoModel->getPedidoById($llave) : null;

// Lista de usuarios
$usuarios = $PedidoModel->getUsuarios();

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pedido) {
    $estado = $_POST['estado'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'] ?? '';
    $informacion_pedido = $_POST['informacion_pedido'] ?? '';
    $fecha_entrega = $_POST['fecha_entrega'] ?? $pedido['fecha_entrega'];
    $id_usuario = $_POST['id_usuario'] ?? $pedido['id_usuario'];

    // Calcular subtotal, impuestos y total desde los productos
    $subtotal = 0;
    if (!empty($_POST['cantidad']) && !empty($_POST['precio'])) {
        for ($i = 0; $i < count($_POST['cantidad']); $i++) {
            $subtotal += (float)$_POST['cantidad'][$i] * (float)$_POST['precio'][$i];
        }
    }
    $impuestos = $subtotal * 0.19;
    $total = $subtotal + $impuestos;

    $updated = $PedidoModel->updatePedido($llave, [
        'estado' => $estado,
        'direccion' => $direccion,
        'descripcion' => $descripcion,
        'informacion_pedido' => $informacion_pedido,
        'subtotal' => $subtotal,
        'impuestos' => $impuestos,
        'total' => $total,
        'fecha_entrega' => $fecha_entrega
    ]);

    if ($updated) {
        $pedido = $PedidoModel->getPedidoById($llave); // recargar datos
        $mensaje = "Pedido actualizado correctamente.";
    } else {
        $mensaje = "Error al actualizar el pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Pedido</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
</head>
<body>
<div class="container py-5">

<?php if ($pedido): ?>
<div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
        <h4><i class="fas fa-edit"></i> Editar Pedido #<?php echo $pedido['id_pedido']; ?></h4>
    </div>
    <div class="card-body">
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form method="POST" class="needs-validation" novalidate>
            <div class="row g-3">

                <div class="col-md-6">
                    <label>Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="">Seleccione</option>
                        <?php
                        $estados = ['pendiente','aprobado','en_proceso','entregado','cancelado'];
                        foreach ($estados as $e) {
                            $selected = ($pedido['estado']==$e) ? 'selected' : '';
                            echo "<option value='$e' $selected>$e</option>";
                        }
                        ?>
                    </select>

                    <label class="mt-2">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3"><?php echo htmlspecialchars($pedido['descripcion']); ?></textarea>

                    <label class="mt-2">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($pedido['direccion']); ?>" required>

                    <label class="mt-2">Observaciones</label>
                    <textarea name="informacion_pedido" class="form-control" rows="3"><?php echo htmlspecialchars($pedido['informacion_pedido']); ?></textarea>

                    <label class="mt-2">Usuario</label>
                    <select name="id_usuario" class="form-select" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($usuarios as $usuario): 
                            $selected = ($pedido['id_usuario']==$usuario['id_usuario'])?'selected':'';
                        ?>
                            <option value="<?php echo $usuario['id_usuario'];?>" <?php echo $selected;?>>
                                <?php echo $usuario['nombre_usuario'];?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label class="mt-2">Fecha de entrega</label>
                    <input type="date" name="fecha_entrega" class="form-control" value="<?php echo date('Y-m-d', strtotime($pedido['fecha_entrega'])); ?>">
                </div>

                <div class="col-md-6">
                    <h5>Detalle de productos</h5>
                    <table class="table table-bordered" id="detallePedido">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Suponiendo que tengas un array de productos, aquí se puede poblar -->
                            <tr>
                                <td>Producto 1</td>
                                <td><input type="number" name="cantidad[]" value="1" class="form-control"></td>
                                <td><input type="number" name="precio[]" value="100" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>

                    <label>Subtotal</label>
                    <input type="number" class="form-control bg-light" value="<?php echo $pedido['subtotal']; ?>" readonly>

                    <label>IVA 19%</label>
                    <input type="number" class="form-control bg-light" value="<?php echo $pedido['impuestos']; ?>" readonly>

                    <label>Total</label>
                    <input type="number" class="form-control bg-light" value="<?php echo $pedido['total']; ?>" readonly>
                </div>

            </div>

            <button type="submit" class="btn btn-success mt-3">Actualizar Pedido</button>
        </form>
    </div>
</div>
<?php else: ?>
    <div class="alert alert-warning text-center">
        Pedido no encontrado o ha sido eliminado.
    </div>
    <div class="text-center">
        <a href="insert.php" class="btn btn-primary mt-2">Volver a la lista de pedidos</a>
    </div>
<?php endif; ?>

</div>
</body>
</html>
