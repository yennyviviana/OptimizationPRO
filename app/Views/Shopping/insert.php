<?php
require_once __DIR__ . '/../../Models/CompraModel.php';
require_once __DIR__ . '/../../Controllers/CompraController.php';

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

        /* Ajuste de estilos para el editor CKEditor */
        .ck-editor__editable {
            min-height: 150px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="form-background">
            <form action="insert.php?da=2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
               
            <div class="form-group">
                <label for="productos_comprados">Productos:</label>
            <select id="productos_comprados" name="productos_comprados" class="form-control" required>
                 <option value="">Selecciona un producto</option>
                   <option value="producto1">Producto 1</option>
                    <option value="producto2">Producto 2</option>
                          <option value="producto3">Producto 3</option>
                       <!--- más opciones según sea necesario --->
                             </select>
             <div class="invalid-feedback">Selecciona un producto.</div>
       </div>

    
                <div class="form-group">
                    <label for="detalles">Detalles</label>
                    <textarea id="detalles" name="detalles" class="form-control" required placeholder="detalles"></textarea>
                    <div class="invalid-feedback">Detalles del producto.</div>
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

                    <label for="metodo_pago"><i class="fas fa-users"></i> Metodo Pago:</label>
                <select id="metodo_pago" name="metodo_pago" required class="form-control">
                    <option value="">Seleccione una opcion</option>
                    <option value="credito">Credito</option>
                    <option value="Paypal">Paypal</option>
                    <option value="transfarencia">Transferencia</option>
                </select>


                <div class="form-group">
        <label for="fecha_compra">Fecha de compra:</label>
        <input type="date" id="fecha_compra" name="fecha_compra" class="form-control" min="0" required>
    </div>

 

<div class="form-group">
    <label for="fecha_entrega">Fecha de entrega:</label>
    <input type="datetime-local" id="fecha_entrega" name="fecha_entrega" class="form-control" required>
</div>

<button type="button" class="btn btn-danger" id="ver_tiempo">Ver Tiempo Transcurrido</button>

    <div class="form-group">
    <label for="archivos">Archivos</label>
    <input type="file" id="factura" name="factura" class="form-control-file"  required>
    <div class="invalid-feedback">seleccione al menos un archivo.</div>
</div>


             
<label for="id_proveedor">Proveedor:</label>
    <select name="id_proveedor" required>
        <?php foreach ($providers as $provider) { ?>
            <option value="<?php echo $provider['id_proveedor']; ?>">
                <?php echo $provider['nombre_empresa']; ?>
            </option>
        <?php } ?>
    </select><br>


    <label for="id_producto">Producto:</label>
<select name="id_producto" id="id_producto" required>
    <?php foreach ($products as $product) { ?>
        <option value="<?php echo $product['id_producto']; ?>">
            <?php echo $product['nombre_producto']; ?>
        </option>
    <?php } ?>
</select><br>

    
    

    <button type="submit" name="boton"  class= "btn-success">Guardar</button>
            </form>
        </div>
    </div>
    </form>

    
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('ver_tiempo').addEventListener('click', function() {
        var fechaEntrega = new Date(document.getElementById('fecha_entrega').value); // Obtener la fecha de entrega seleccionada
        var fechaCompra = new Date(); // Obtener la fecha actual

        // Calcular la diferencia de tiempo en milisegundos
        var tiempo_entrega_milisegundos = fechaEntrega - fechaCompra;

        // Convertir la diferencia de milisegundos a días y horas
        var dias = Math.floor(tiempo_entrega_milisegundos / (1000 * 60 * 60 * 24));
        var horas = Math.floor((tiempo_entrega_milisegundos % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        // Mostrar el tiempo transcurrido en un diálogo de alerta
        alert(dias + " días y " + horas + " horas");
    });
});
</script>



<script>
    document.getElementById('precio_unitario').addEventListener('input', function() {
        calcularTotalCompra();
    });

    document.getElementById('precio_compra').addEventListener('input', function() {
        calcularTotalCompra();
    });

    function calcularTotalCompra() {
        // Obtener el precio unitario y el precio de compra
        var precioUnitario = parseFloat(document.getElementById('precio_unitario').value);
        var precioCompra = parseFloat(document.getElementById('precio_compra').value);

        // Calcular el total de la compra
        var totalCompra = precioUnitario * precioCompra;

        // Mostrar el total de la compra en el campo correspondiente
        document.getElementById('total_compra').value = totalCompra.toFixed(2);
    }
</script>


<script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('detalles');
         // Inicializa CKEditor en el textarea con ID "informacion"
    </script>
