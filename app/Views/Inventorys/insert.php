<?php

require_once __DIR__ . '/../../Models/InventarioModel.php';
require_once __DIR__ . '/../../Controllers/InventarioController.php';


?>




<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD pedidos</title>
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div class="container py-5">
    <div class="card shadow-lg">
      <div class="card-header bg-dark text-white">
        <h4 class="mb-0"><i class="fa-solid fa-box"></i> Registrar Inventario</h4>
      </div>
      <div class="card-body">
        <form action="insert.php?da=Inventorys-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
          <h2>Inventarios</h2>
          <div class="row">
            <!-- Columna izquierda -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nombre_producto" class="form-label"><i class="fa-solid fa-boxes-stacked"></i> Categoría del producto:</label>
                <select id="nombre_producto" name="nombre_producto" required class="form-select">
                  <option value="Televisor LED">Televisor LED</option>
                  <option value="Lavadora automática">Lavadora automática</option>
                  <!-- más opciones -->
                </select>
                <div class="invalid-feedback">Seleccionar el pedido.</div>
              </div>
              <div class="mb-3">
                <label for="cantidad_stock" class="form-label">Cantidad en Stock:</label>
                <input type="number" class="form-control" id="cantidad_stock" name="cantidad_stock" required>
                <div class="invalid-feedback">Ingrese el número de stock.</div>
              </div>
              <div class="mb-3">
                <label for="precio_unitario" class="form-label">Precio Unitario:</label>
                <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" required>
                <div class="invalid-feedback">Ingrese el precio unitario.</div>
              </div>
              <div class="mb-3">
                <label for="costo_unitario" class="form-label">Costo Unitario:</label>
                <input type="number" class="form-control" id="costo_unitario" name="costo_unitario" required>
                <div class="invalid-feedback">Ingrese el costo unitario.</div>
              </div>
              <div class="mb-3">
                <label for="precio_compra" class="form-label">Precio de Compra:</label>
                <input type="number" class="form-control" id="precio_compra" name="precio_compra" required>
                <div class="invalid-feedback">Ingrese el precio de la compra.</div>
              </div>
              <div class="mb-3">
                <label for="precio_venta" class="form-label">Precio de Venta:</label>
                <input type="number" class="form-control" id="precio_venta" name="precio_venta" required>
                <div class="invalid-feedback">Ingrese el precio de venta.</div>
              </div>
              <div class="mb-3">
                <label for="categoria_productos" class="form-label"><i class="fa-solid fa-tags"></i> Categoría:</label>
                <select id="categoria_productos" name="categoria_productos" required class="form-select">
                  <option value="producto 1">Producto 1</option>
                  <option value="producto 2">Producto 2</option>
                  <!-- más opciones, sin duplicados -->
                </select>
                <div class="invalid-feedback">Ingrese la categoría del producto.</div>
              </div>
              <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required placeholder="Descripción del pedido"></textarea>
                <div class="invalid-feedback">Ingrese la descripción.</div>
              </div>
            </div>
            <!-- Columna derecha -->
            <div class="col-md-6">
              <div class="mb-3">
                <label for="codigo_barras" class="form-label">Código de Barras:</label>
                <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" required>
              </div>
              <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación:</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
              </div>
              <div class="mb-3">
                <label for="estado" class="form-label"><i class="fa-solid fa-toggle-on"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-select">
                  <option value="Disponible">Disponible</option>
                  <option value="No disponible">No disponible</option>
                  <option value="En espera">En espera</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="id_producto" class="form-label">Producto:</label>
                <select class="form-select" id="id_producto" name="id_producto" required>
                  <option value="">Selecciona un Producto</option>
                  <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['id_producto']; ?>"><?php echo $product['nombre_producto']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor:</label>
                <select class="form-select" id="id_proveedor" name="id_proveedor" required>
                  <option value="">Selecciona un Proveedor</option>
                  <?php foreach ($providers as $provider): ?>
                    <option value="<?php echo $provider['id_proveedor']; ?>"><?php echo $provider['nombre_empresa']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="fecha_adquisicion" class="form-label">Fecha de Adquisición:</label>
                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
              </div>
              <div class="mb-3">
                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
              </div>
              <div class="mb-3">
                <label for="tipo_documento" class="form-label">Tipo de Documento:</label>
                <input type="file" class="form-control" id="tipo_documento" name="tipo_documento" required>
              </div>
            </div>
          </div>
          <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Inicializamos CKEditor en el textarea con ID "descripcion"
    CKEDITOR.replace('descripcion');
  </script>
  <!-- Bootstrap 5 (sin jQuery) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
