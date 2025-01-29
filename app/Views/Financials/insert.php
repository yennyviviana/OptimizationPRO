<?php

require_once __DIR__ . '/../../Models/FinancieraModel.php';
require_once __DIR__ . '/../../Controllers/FinancieraController.php';



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

        .ck-editor__editable {
            min-height: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="form-background">
            <form action="insert.php?da=Financials-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
               

            <div class="form-group">
        <label for="fecha_transaccion">Fecha Transaccion:</label>
        <input type="date" id="fecha_transaccion" name="fecha_transaccion" class="form-control" min="0" required>
    </div>

                <div class="form-group">
                    <label for="monto">Monto</label>
                    <input type="number" id="monto" name="monto" class="form-control" required placeholder="monto">
                    <div class="invalid-feedback">Por favor ingrese el monto</div>
                </div>

                
             
                <div class="form-group">
                <label for="tipo_transaccion">* Tipo transaccion:</label>
                <select name="tipo_transaccion" id="tipo_transaccion" class="form-control" required>
                    <option value="ingreso">Ingreso</option>
                    <option value="egreso">Egreso</option>
                </select>
            </div>

           
            
            <div class="form-group">
        <label for="id_proveedor">Proveedor:</label>
        <select class="form-control" id="id_proveedor" name="id_proveedor" required>
            <option value="">Selecciona un Proveedor</option>
            <?php foreach ($providers as $provider): ?>
                <option value="<?php echo $provider['id_proveedor']; ?>"><?php echo $provider['nombre_empresa']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_cliente">Cliente:</label>
        <select class="form-control" id="id_cliente" name="id_cliente" required>
            <option value="">Selecciona un Cliente</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo $client['id_cliente']; ?>"><?php echo $client['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
    <label for="id_pedido">Pedido:</label>
    <select class="form-control" id="id_pedido" name="id_pedido" required>
        <option value="">Selecciona un Pedido</option>
        <?php foreach ($orders as $order): ?>
            <option value="<?php echo $order['id_pedido']; ?>"><?php echo $order['nombre_pedido']; ?></option>
        <?php endforeach; ?>
    </select>
</div>


    <div class="form-group">
        <label for="codigo_inventario">Código de Inventario:</label>
        <select class="form-control" id="codigo_inventario" name="codigo_inventario" required>
            <option value="">Selecciona un Código de Inventario</option>
            <?php foreach ($inventory as $item): ?>
                <option value="<?php echo $item['codigo_inventario']; ?>"><?php echo $item['nombre_producto']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_producto">Producto:</label>
        <select class="form-control" id="id_producto" name="id_producto" required>
            <option value="">Selecciona un Producto</option>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo $product['id_producto']; ?>"><?php echo $product['nombre_producto']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_compra">Compra:</label>
        <select class="form-control" id="id_compra" name="id_compra" required>
            <option value="">Selecciona una Compra</option>
            <?php foreach ($purchases as $purchase): ?>
                <option value="<?php echo $purchase['id_compra']; ?>"><?php echo $purchase['productos_comprados']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_proyecto">Proyecto:</label>
        <select class="form-control" id="id_proyecto" name="id_proyecto" required>
            <option value="">Selecciona un Proyecto</option>
            <?php foreach ($projects as $project): ?>
                <option value="<?php echo $project['id_proyecto']; ?>"><?php echo $project['nombre_proyecto']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('detalles');
       
    </script>



</body>