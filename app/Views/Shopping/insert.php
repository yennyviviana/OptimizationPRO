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
    <!-- CSS de CKEditor -->
   <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
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
   

<
<div class="container">
    <div id="form-background">
        <form action="insert.php?da=2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
           
        <div class="form-group">
                <label for="productos_comprados"><i class="fas fa-users"></i>Productos:</label>
                <select id="productos_comprados" name="productos_comprados" required class="form-control">
                    <option value="Televisor LED">Televisor LED</option>
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

