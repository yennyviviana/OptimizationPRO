<?php

require_once __DIR__ . '/../../Models/ProveedorModel.php';
require_once __DIR__ . '/../../Controllers/ProveedorController.php';



?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Proveedor.</title>
    <!-- Agregamos los estilos de Bootstrap para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Incluimos el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <!-- Incluimos el CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
</head>
<body>
 

<style>
/* Estilos personalizados */
body {
    background-color: #000;
    color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

</style>

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-box"></i> Registrar proveedor</h4>
        </div>
        <div class="card-body">
<div class="container py-5">
    <div id="form-background">
        <form action="insert.php?da=Suppliers-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

            <div class="form-group mb-3">
                <label for="nombre_empresa">Empresa</label>
                <input type="text"
                       id="nombre_empresa"
                       name="nombre_empresa"
                       class="form-control"
                       required
                       placeholder="Ingresar nombre de la empresa">
                <div class="invalid-feedback">
                    Por favor ingrese el nombre de la empresa.
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="direccion">Dirección</label>
                <input type="text"
                       id="direccion"
                       name="direccion"
                       class="form-control"
                       required
                       placeholder="Ingresar dirección">
                <div class="invalid-feedback">
                    Por favor ingrese la dirección.
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="telefono">Teléfono</label>
                <input type="tel"
                       id="telefono"
                       name="telefono"
                       class="form-control"
                       required
                       placeholder="Ingresar teléfono">
                <div class="invalid-feedback">
                    Por favor ingrese el teléfono.
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="correo_electronico">Correo Electrónico</label>
                <input type="email"
                       id="correo_electronico"
                       name="correo_electronico"
                       class="form-control"
                       required
                       placeholder="usuario@correo.com">
                <div class="invalid-feedback">
                    Por favor ingrese un correo electrónico válido.
                </div>
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
           

            <div class="form-group mb-3">
                <label for="condiciones_pago">Condición de Pago</label>
                <select id="condiciones_pago"
                        name="condiciones_pago"
                        class="form-select"
                        required>
                    <option value="">Seleccione una opción</option>
                    <option value="Pago anticipado">Pago anticipado</option>
                    <option value="Pago a plazos">Pago a plazos</option>
                    <option value="Pago contra entrega">Pago contra entrega</option>
                </select>
                <div class="invalid-feedback">
                    Por favor seleccione la condición de pago.
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="metodo_pago">Método de Pago</label>
                <select id="metodo_pago"
                        name="metodo_pago"
                        class="form-select"
                        required>
                    <option value="">Seleccione una opción</option>
                    <option value="credito">Crédito</option>
                    <option value="Paypal">Paypal</option>
                    <option value="transferencia">Transferencia</option>
                </select>
                <div class="invalid-feedback">
                    Por favor seleccione el método de pago.
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion"
                          name="descripcion"
                          class="form-control"
                          rows="4"
                          required
                          placeholder="Descripción del proveedor"></textarea>
                <div class="invalid-feedback">
                    Por favor ingrese la descripción.
                </div>
            </div>


            <div class="mb-3">
  <label for="historial_pedidos" class="form-label">Historial de pedidos</label>
  <textarea class="form-control" id="historial_pedidos" name="historial_pedidos" rows="4" placeholder="Ej: Pedido 01/06/2025 - 10 unidades de papel..."></textarea>
</div>

            <div class="form-group mb-4">
                <label for="archivo">Archivo Adjunto</label>
                <input type="file"
                       id="archivo"
                       name="archivo"
                       class="form-control-file"
                       accept=".pdf,.jpg,.png"
                       required>
                <div class="invalid-feedback">
                    Por favor adjunte un archivo (PDF, JPG o PNG).
                </div>
            </div>

            <button type="submit"
                    name="boton"
                    class="btn btn-success"
                    aria-label="Guardar formulario">
                <i class="fas fa-save"></i> Guardar
            </button>
        </form>
    </div>
</div>

<script>
    // Inicializamos CKEditor solo en el textarea existente
    if (CKEDITOR) {
        CKEDITOR.replace('descripcion');
    }
</script>
