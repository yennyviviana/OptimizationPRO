<?php
require_once __DIR__ . '/../../Models/ClienteModel.php';
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

// Validar si se pasó un ID de pedido
$llave = isset($_GET['lla']) ? intval($_GET['lla']) : 0;
$pedido = null;
if ($llave > 0) {
    $pedido = $PedidoModel->getPedidoById($llave);
}

// Obtener lista de usuarios
$usuarios = $PedidoModel->getUsuarios();

// Procesar POST para actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pedido) {
    $estado              = $_POST['estado'];
    $direccion           = $_POST['direccion'];
    $descripcion         = $_POST['descripcion'] ?? '';
    $informacion_pedido  = $_POST['informacion_pedido'] ?? '';
    $numero_seguimiento  = $_POST['numero_seguimiento'] ?? $pedido['numero_seguimiento'];
    $fecha_pedido        = $_POST['fecha_pedido'] ?? $pedido['fecha_pedido'];
    $fecha_entrega       = $_POST['fecha_entrega'] ?? $pedido['fecha_entrega'];
    $id_usuario          = $_POST['id_usuario'] ?? $pedido['id_usuario'];
    $tiempo_entrega_horas = $_POST['tiempo_entrega_horas'] ?? $pedido['tiempo_entrega_horas'];

    $subtotal = $pedido['subtotal'] ?? 0;
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
        $pedido = $PedidoModel->getPedidoById($llave); // recargar datos actualizados
        $mensaje = "Pedido actualizado correctamente";
    } else {
        $mensaje = "Error al actualizar el pedido";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Pedido</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
</head>
<body>
<div class="container py-5">

<?php if ($pedido): ?>
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-user-edit"></i> Editar Pedido #<?php echo $pedido['id_pedido']; ?></h4>
        </div>
        <div class="card-body">
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-info"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            <form method="POST" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado del pedido</label>
                            <select id="estado" name="estado" class="form-select" required>
                                <option value="">Seleccione</option>
                                <?php
                                $estados = ['pendiente','aprobado','en_proceso','entregado','cancelado'];
                                foreach ($estados as $e) {
                                    $selected = ($pedido['estado'] === $e) ? 'selected' : '';
                                    echo "<option value='$e' $selected>$e</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?php echo htmlspecialchars($pedido['descripcion']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección de entrega</label>
                            <input type="text" id="direccion" name="direccion" class="form-control"
                                   value="<?php echo htmlspecialchars($pedido['direccion']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="informacion_pedido">Observaciones</label>
                            <textarea id="informacion_pedido" name="informacion_pedido" class="form-control"
                                      rows="3"><?php echo htmlspecialchars($pedido['informacion_pedido']); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="id_usuario">Usuario:</label>
                            <select class="form-select" id="id_usuario" name="id_usuario" required>
                                <option value="">Selecciona un Usuario</option>
                                <?php foreach ($usuarios as $usuario): 
                                    $selected = ($pedido['id_usuario'] == $usuario['id_usuario']) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $usuario['id_usuario']; ?>" <?php echo $selected; ?>>
                                        <?php echo $usuario['nombre_usuario']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Número de seguimiento</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $pedido['numero_seguimiento']; ?>" readonly>
                            <input type="hidden" name="numero_seguimiento" value="<?php echo $pedido['numero_seguimiento']; ?>">
                        </div>

                        <div class="form-group">
                            <label>Tiempo estimado (horas)</label>
                            <input type="number" class="form-control bg-light" value="<?php echo $pedido['tiempo_entrega_horas']; ?>" readonly>
                            <input type="hidden" name="tiempo_entrega_horas" value="<?php echo $pedido['tiempo_entrega_horas']; ?>">
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Subtotal</label>
                                <input type="number" name="subtotal" class="form-control bg-light" value="<?php echo $pedido['subtotal']; ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Impuestos (IVA 19%)</label>
                                <input type="number" name="impuestos" class="form-control bg-light" value="<?php echo $pedido['impuestos']; ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Total</label>
                                <input type="number" name="total" class="form-control bg-light" value="<?php echo $pedido['total']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Fecha del pedido</label>
                                <input type="date" name="fecha_pedido" class="form-control" value="<?php echo date('Y-m-d', strtotime($pedido['fecha_pedido'])); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Fecha de entrega</label>
                                <input type="date" name="fecha_entrega" class="form-control" value="<?php echo date('Y-m-d', strtotime($pedido['fecha_entrega'])); ?>">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Actualizar pedido</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-warning text-center mt-5">
        Pedido no encontrado o ha sido eliminado.
    </div>
    <div class="text-center">
        <a href="insert.php" class="btn btn-primary mt-3">Volver a la lista de pedidos</a>
    </div>
<?php endif; ?>

</div>
</body>
</html>
