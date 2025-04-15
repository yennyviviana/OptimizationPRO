<?php

require_once __DIR__ . '/../../Models/FinancieraModel.php';
require_once __DIR__ . '/../../Controllers/FinancieraController.php';



?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Financials - Registro</title>
  <!-- Bootstrap 5 y Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
  <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-money-check-alt"></i> Registro Financiero</h4>
    </div>
    <div class="card-body">
      <form action="insert.php?da=Financials-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-3">
          <!-- Columna Izquierda -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="fecha_transaccion" class="form-label">Fecha Transacción:</label>
              <input type="date" id="fecha_transaccion" name="fecha_transaccion" class="form-control" required>
              <div class="invalid-feedback">Por favor ingrese la fecha de transacción.</div>
            </div>
            <div class="mb-3">
              <label for="monto" class="form-label">Monto:</label>
              <input type="number" id="monto" name="monto" class="form-control" required placeholder="Monto">
              <div class="invalid-feedback">Por favor ingrese el monto.</div>
            </div>
            <div class="mb-3">
              <label for="tipo_transaccion" class="form-label">* Tipo Transacción:</label>
              <select name="tipo_transaccion" id="tipo_transaccion" class="form-select" required>
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
              </select>
              <div class="invalid-feedback">Por favor seleccione el tipo de transacción.</div>
            </div>
            <div class="mb-3">
              <label for="id_proveedor" class="form-label">Proveedor:</label>
              <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                <option value="">Selecciona un Proveedor</option>
                <?php foreach ($providers as $provider): ?>
                  <option value="<?php echo $provider['id_proveedor']; ?>"><?php echo $provider['nombre_empresa']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Por favor seleccione un proveedor.</div>
            </div>
            <div class="mb-3">
              <label for="id_cliente" class="form-label">Cliente:</label>
              <select class="form-select" id="id_cliente" name="id_cliente" required>
                <option value="">Selecciona un Cliente</option>
                <?php foreach ($clients as $client): ?>
                  <option value="<?php echo $client['id_cliente']; ?>"><?php echo $client['nombre']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Por favor seleccione un cliente.</div>
            </div>
            <div class="mb-3">
              <label for="id_pedido" class="form-label">Pedido:</label>
              <select class="form-select" id="id_pedido" name="id_pedido" required>
                <option value="">Selecciona un Pedido</option>
                <?php foreach ($orders as $order): ?>
                  <option value="<?php echo $order['id_pedido']; ?>"><?php echo $order['nombre_pedido']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Por favor seleccione un pedido.</div>
            </div>
          </div>
          <!-- Columna Derecha -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="codigo_inventario" class="form-label">Código de Inventario:</label>
              <select class="form-select" id="codigo_inventario" name="codigo_inventario" required>
                <option value="">Selecciona un Código de Inventario</option>
                <?php foreach ($inventory as $item): ?>
                  <option value="<?php echo $item['codigo_inventario']; ?>"><?php echo $item['nombre_producto']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Por favor seleccione un código de inventario.</div>
            </div>
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
            <div class="mb-3">
              <label for="id_compra" class="form-label">Compra:</label>
              <select class="form-select" id="id_compra" name="id_compra" required>
                <option value="">Selecciona una Compra</option>
                <?php foreach ($purchases as $purchase): ?>
                  <option value="<?php echo $purchase['id_compra']; ?>"><?php echo $purchase['productos_comprados']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Por favor seleccione una compra.</div>
            </div>
            <div class="mb-3">
              <label for="id_proyecto" class="form-label">Proyecto:</label>
              <select class="form-select" id="id_proyecto" name="id_proyecto" required>
                <option value="">Selecciona un Proyecto</option>
                <?php foreach ($projects as $project): ?>
                  <option value="<?php echo $project['id_proyecto']; ?>"><?php echo $project['nombre_proyecto']; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Por favor seleccione un proyecto.</div>
            </div>
          </div>
        </div>
        <div class="text-end mt-4">
          <button type="submit" name="boton" class="btn btn-success px-4">
            <i class="fas fa-save"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Inicializamos CKEditor (si se requiere algún textarea adicional) -->
<script>
  // Si tienes un textarea de detalles o similar, descomenta la siguiente línea y ajusta el ID:
  // CKEDITOR.replace('detalles');
</script>
</body>
</html>
