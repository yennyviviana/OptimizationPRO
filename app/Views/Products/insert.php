<?php

require_once __DIR__ . '/../../Models/ProductoModel.php';
require_once __DIR__ . '/../../Controllers/ProductoController.php';



?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD pedidos</title>
    
    <!-- Bootstrap y FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="fas fa-box"></i> Registrar Producto</h4>
        </div>
        <div class="card-body">
            <form action="insert.php?da=2" method="POST" enctype="multipart/form-data" class="needs-validation row" novalidate>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre_producto"><i class="fas fa-cubes"></i> Producto:</label>
                        <select id="nombre_producto" name="nombre_producto" required class="form-control">
                            <option value="" disabled selected>Seleccione un producto</option>
                            <option>Televisor LED</option>
                            <option>Lavadora automática</option>
                            <option>Smartphone de última generación</option>
                            <option>Ordenador portátil ultradelgado</option>
                            <option>Auriculares inalámbricos</option>
                            <option>Cámara digital profesional</option>
                            <option>Consola de videojuegos de nueva generación</option>
                            <option>Altavoces Bluetooth impermeables</option>
                            <option>Tableta digital para diseño gráfico</option>
                            <option>Impresora multifunción a color</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="precio"><i class="fas fa-dollar-sign"></i> Precio:</label>
                        <input type="number" id="precio" name="precio" class="form-control" required placeholder="Precio">
                        <div class="invalid-feedback">Por favor ingrese el precio.</div>
                    </div>

                    <div class="form-group">
                        <label for="cantidad_stock"><i class="fas fa-boxes"></i> Stock:</label>
                        <input type="number" id="cantidad_stock" name="cantidad_stock" class="form-control" required placeholder="Cantidad en stock">
                        <div class="invalid-feedback">Por favor ingrese el número del stock.</div>
                    </div>

                    <div class="form-group">
                        <label for="categoria_productos"><i class="fas fa-tags"></i> Categoría:</label>
                        <select id="categoria_productos" name="categoria_productos" required class="form-control">
                            <option value="" disabled selected>Seleccione categoría</option>
                            <option>Producto 1</option>
                            <option>Producto 2</option>
                            <option>Producto 3</option>
                            <option>Producto 4</option>
                            <option>Producto 5</option>
                            <option>Producto 6</option>
                            <option>Producto 7</option>
                            <option>Producto 8</option>
                            <option>Producto 9</option>
                            <option>Producto 10</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado"><i class="fas fa-toggle-on"></i> Estado:</label>
                        <select id="estado" name="estado" required class="form-control">
                            <option>Disponible</option>
                            <option>No disponible</option>
                            <option>En espera</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_adquisicion"><i class="fas fa-calendar-plus"></i> Fecha de adquisición:</label>
                        <input type="date" id="fecha_adquisicion" name="fecha_adquisicion" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_vencimiento"><i class="fas fa-calendar-minus"></i> Fecha de vencimiento:</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="detalles"><i class="fas fa-align-left"></i> Descripción detallada:</label>
                        <textarea id="detalles" name="detalles" class="form-control" required placeholder="Detalles del producto"></textarea>
                        <div class="invalid-feedback">Por favor ingrese la descripción.</div>
                    </div>

                    <div class="form-group">
                        <label for="codigo_barras"><i class="fas fa-barcode"></i> Código de barras:</label>
                        <input type="number" id="codigo_barras" name="codigo_barras" class="form-control" required placeholder="Código de barras">
                    </div>

                    <div class="form-group">
                        <label for="archivo"><i class="fas fa-file-upload"></i> Archivo:</label>
                        <input type="file" id="archivo" name="archivo" class="form-control-file" required>
                        <div class="invalid-feedback">Por favor seleccione al menos un archivo.</div>
                    </div>

                    <div class="form-group">
                        <label for="id_proveedor"><i class="fas fa-truck"></i> Proveedor:</label>
                        <select name="id_proveedor" class="form-control" required>
                            <option value="" disabled selected>Seleccione un proveedor</option>
                            <?php foreach ($providers as $provider) { ?>
                                <option value="<?php echo $provider['id_proveedor']; ?>">
                                    <?php echo $provider['nombre_empresa']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 text-right">
                    <button type="submit" name="boton" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Activar CKEditor
    CKEDITOR.replace('detalles');

    // Validación de Bootstrap
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();
</script>

</body>
</html>
