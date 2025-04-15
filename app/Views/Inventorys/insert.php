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
    <!-- Agregamos los estilos de Bootstrap para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Incluimos el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6a0b5.js" crossorigin="anonymous"></script>
    <!-- Incluimos el CSS de CKEditor -->
    <script src="https://cdn.ckeditor.com/4.24.0/standard/ckeditor.js"></script>
    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>


<div class="container">
        <div id="form-background">
            <form action="insert.php?da=Inventorys-2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <h2>Inventarios</h2>
            
            
            <div class="form-group">
                <label for="nombre_producto"><i class="fas fa-users"></i> Categoria:</label>
                <select id="nombre_producto" name="nombre_producto" required class="form-control">
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
                    <label for="cantidad_stock">Cantidad en Stock:</label>
                    <input type="number" class="form-control" id="cantidad_stock" name="cantidad_stock" required>
                </div>

                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario:</label>
                    <input type="number" class="form-control" id="precio_unitario" name="precio_unitario" required>
                </div>

                <div class="form-group">
                    <label for="costo_unitario">Costo Unitario:</label>
                    <input type="number" class="form-control" id="costo_unitario" name="costo_unitario" required>
                </div>

                <div class="form-group">
                    <label for="precio_compra">Precio de Compra:</label>
                    <input type="number" class="form-control" id="precio_compra" name="precio_compra" required>
                </div>

                <div class="form-group">
                    <label for="precio_venta">Precio de Venta:</label>
                    <input type="number" class="form-control" id="precio_venta" name="precio_venta" required>
                </div>

               
                <label for="categoria_productos"><i class="fas fa-users"></i> Categoria:</label>
                <select id="categoria_productos" name="categoria_productos" required class="form-control">
                    <option value="producto 1">Producto 1</option>
                    <option value="producto 2">Producto 2</option>
                    <option value="producto 3">Producto 3</option>
                    <option value="producto 4">Producto 4</option>
                    <option value="producto 5">Producto 5</option>
                  <!--- mas opciones -->
                  <option value="producto 5">Producto 5</option>
                  <option value="producto 6">Producto 6</option>
                  <option value="producto 7">Producto 7</option>
                  <option value="producto 8">Producto 8</option>
                  <option value="producto 9">Producto 9</option>
                  <option value="producto 10">Producto 10</option>
                </select>

                <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Descripcion"></textarea>
        <div class="invalid-feedback">Por favor ingrese la descripcion.</div>
    </div>



                <div class="form-group">
                    <label for="codigo_barras">Código de Barras:</label>
                    <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" required>
                </div>

                <div class="form-group">
                    <label for="ubicacion">Ubicación:</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                </div>

               
                
                <div class="form-group">
                <label for="estado"><i class="fas fa-toggle-on"></i> Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="Disponible">Disponible</option>
                    <option value="No disponible">No disponible</option>
                    <option value="En espera">En espera</option>
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
                    <label for="id_proveedor">Proveedor:</label>
                    <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                        <option value="">Selecciona un Proveedor</option>
                        <?php foreach ($providers as $provider): ?>
                            <option value="<?php echo $provider['id_proveedor']; ?>"><?php echo $provider['nombre_empresa']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                
                <div class="form-group">
                    <label for="fecha_adquisicion">Fecha de Adquisición:</label>
                    <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" required>
                </div>

                <div class="form-group">
                    <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                </div>

                <div class="form-group">
                    <label for="tipo_documento">Tipo de Documento:</label>
                    <input type="file" class="form-control" id="tipo_documento" name="tipo_documento" required>
                </div>

                <button type="submit" name="boton" class="btn btn-primary">Guardar</button>
            </form>
        </div>
</div>


<script>
        // Inicializamos CKEditor en el textarea con ID "descripcion"
        CKEDITOR.replace('descripcion');
</script>
     
    <!-- Include jQuery and Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  
</body>
</html>