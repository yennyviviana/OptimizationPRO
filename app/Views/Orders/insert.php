<?php

require_once __DIR__ . '/../../Models/PedidoModel.php';
require_once __DIR__ . '/../../Controllers/PedidoController.php';



?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD pedidos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
         

<style>
body {
    background-color: #000;
    color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

</style>

  
<div class="container py-5">
  <div class="card shadow-lg">
    <div class="card-header bg-dark text-white">
      <h4 class="mb-0"><i class="fas fa-user-plus"></i> Registrar pedido</h4>
    </div>
    <div class="card-body">
      <form action="insert.php?da=insert-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-3">
        
          <div class="col-md-6">


    <div class="form-group">
        <label for="estado">Estado del pedido</label>
        <select id="estado" name="estado" class="form-select" required>
            <option value="">Seleccione</option>
            <option value="pendiente">Pendiente</option>
            <option value="aprobado">Aprobado</option>
            <option value="en_proceso">En proceso</option>
            <option value="entregado">Entregado</option>
            <option value="cancelado">Cancelado</option>
        </select>
    </div>

     <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <textarea id="descripcion" name="descripcion"
                  class="form-control" rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="direccion">Dirección de entrega</label>
        <input type="text" id="direccion" name="direccion"
               class="form-control" required>
    </div>

    <div class="form-group">
        <label for="informacion_pedido">Observaciones</label>
        <textarea id="informacion_pedido" name="informacion_pedido"
                  class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
  <label for="id_usuario" class="form-label">Usuario:</label>

  <select class="form-select" id="id_usuario" name="id_usuario" required>
    <option value="">Selecciona un Usuario</option>

    <?php foreach ($usuarios as $usuario): ?>
      <option value="<?php echo $usuario['id_usuario']; ?>">
        <?php echo $usuario['nombre_usuario']; ?>
      </option>
    <?php endforeach; ?>

  </select>

  <div class="invalid-feedback">Por favor seleccione un usuario.</div>
</div>



    <div class="form-group">
    <label>Número de seguimiento</label>
    <input type="text" class="form-control bg-light"
           value="Se genera automáticamente" readonly>

    <!-- valor real que viaja -->
    <input type="hidden" name="numero_seguimiento" id="numero_seguimiento">
</div>


   <div class="form-group">
    <label>Tiempo estimado (horas)</label>
    <input type="number" class="form-control bg-light"
           value="Calculado automáticamente" readonly>

    <!-- valor real que viaja -->
    <input type="hidden" name="tiempo_entrega_horas" id="tiempo_entrega_horas">
</div>


   

    <h5 class="mt-4">Detalle del pedido</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total línea</th>
            </tr>
        </thead>
        <tbody id="detallePedido">
            <!-- Filas dinámicas con JS -->
        </tbody>
    </table>

   
  <div class="row mt-3">
    <div class="col-md-4">
        <label>Subtotal</label>
        <input type="number" id="subtotal" name="subtotal"
               class="form-control bg-light" readonly>
    </div>

    <div class="col-md-4">
        <label>Impuestos (IVA 19%)</label>
        <input type="number" id="impuestos" name="impuestos"
               class="form-control bg-light" readonly>
    </div>

    <div class="col-md-4">
        <label>Total</label>
        <input type="number" id="total" name="total"
               class="form-control bg-light" readonly>
    </div>
</div>


 
    <div class="row mt-3">
        <div class="col-md-6">
            <label>Fecha del pedido</label>
            <input type="date" name="fecha_pedido" class="form-control" required>
        </div>
        <div class="col-md-6">
            <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control">

        </div>
    </div>

   
    <button type="submit" name="boton" class="btn btn-success">
              Guardar pedido
</button>
</div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function () {

    console.log('JS cargado correctamente');

    
    let subtotal = 100000;
    let impuestos = subtotal * 0.19;
    let total = subtotal + impuestos;

    document.getElementById('subtotal').value = subtotal.toFixed(2);
    document.getElementById('impuestos').value = impuestos.toFixed(2);
    document.getElementById('total').value = total.toFixed(2);

    // ======================
    // DATOS AUTOMÁTICOS
    // ======================
    document.getElementById('numero_seguimiento').value =
        'SEG-' + Date.now();

    document.getElementById('tiempo_entrega_horas').value = 24;

    // ======================
    // CALCULAR TIEMPO POR FECHA
    // ======================
    let fechaEntrega = document.getElementById('fecha_entrega');

    if (fechaEntrega) {
        fechaEntrega.addEventListener('change', function () {
            let hoy = new Date();
            let entrega = new Date(this.value);

            let diffMs = entrega - hoy;
            let horas = Math.ceil(diffMs / (1000 * 60 * 60));

            if (horas > 0) {
                document.getElementById('tiempo_entrega_horas').value = horas;
            }
        });
    }

});
</script>


</body>